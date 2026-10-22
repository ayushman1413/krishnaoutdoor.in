<?php

namespace App\Services\Chat;

use App\Models\Campaign;
use App\Models\ChatMessage;
use App\Models\ChatVisitor;
use App\Models\Enquiry;
use Illuminate\Support\Str;

/**
 * Krishna AI: understands what a visitor asks (intent, city, media, goal),
 * remembers it across the conversation and across visits, answers from the
 * knowledge base in config/chatbot.php, brainstorms campaign plans and can
 * save a lead for the team. Runs entirely on this site's own data and the Laravel stack; no external AI service is used.
 */
class ChatEngine
{
    private const PATH_MEDIA = [
        '/hoarding-advertising-ahmedabad' => 'hoarding', '/amts-bus-advertising-ahmedabad' => 'amts',
        '/bus-shelter-advertising-ahmedabad' => 'shelter', '/gsrtc-bus-advertising' => 'gsrtc',
        '/mumbai-local-train-advertising' => 'train', '/best-bus-advertising-mumbai' => 'best',
        '/tmt-bus-advertising-thane' => 'tmt', '/media/digital' => 'dooh',
        '/social-media-marketing-ahmedabad' => 'social', '/social-media-marketing-mumbai' => 'social',
    ];

    private const PATH_CITY = [
        '/outdoor-advertising-agency-mumbai' => 'mumbai', '/mumbai-local-train-advertising' => 'mumbai',
        '/best-bus-advertising-mumbai' => 'mumbai', '/social-media-marketing-mumbai' => 'mumbai',
        '/tmt-bus-advertising-thane' => 'thane', '/hoarding-advertising-ahmedabad' => 'ahmedabad',
        '/amts-bus-advertising-ahmedabad' => 'ahmedabad', '/bus-shelter-advertising-ahmedabad' => 'ahmedabad',
        '/gsrtc-bus-advertising' => 'gujarat', '/social-media-marketing-ahmedabad' => 'ahmedabad',
    ];

    /** @var array<string, float>|null */
    private ?array $idf = null;

    /**
     * @return array{reply: string, links: array, chips: array, lead: bool, intent: string}
     */
    public function handle(ChatVisitor $visitor, string $raw, ?string $path = null, ?string $pageTitle = null): array
    {
        $raw = trim(mb_substr(strip_tags($raw), 0, 600));
        $history = $visitor->messages()->latest('id')->limit(12)->get()->reverse()
            ->map(fn ($m) => ['role' => $m->role, 'content' => $m->body])->values()->all();

        $profile = $visitor->profile ?? [];
        $state = $visitor->state ?? [];
        $norm = Nlp::normalize($raw);

        $this->log($visitor, 'user', $raw, ['page' => $path]);

        // ---- 1. Pull facts out of the message and remember them ----------
        $cities = $this->detectCities($norm);
        $media = $this->detectMedia($norm);
        $goal = Brainstorm::detectGoal($norm);
        $phone = $this->detectPhone($raw);
        $name = $this->detectName($raw);

        $pending = $state['pending'] ?? null;
        if (!$name && in_array($pending, ['name_for_lead', 'phone'], true) && $this->looksLikeName($raw)) {
            $name = $this->cleanName($raw);
        }

        if (!$name && $phone) {
            $rest = trim(preg_replace('/[^A-Za-z ]/', ' ', str_replace(preg_replace('/\D/', '', $phone), ' ', preg_replace('/[\s-]/', '', $raw) === '' ? '' : preg_replace('/\+?91?[\s-]?[6-9][\d\s-]{9,11}/', ' ', $raw))));
            if ($rest !== '' && $this->looksLikeName($rest)) { $name = $this->cleanName($rest); }
        }
        $declined = $pending === 'name_for_lead' && !$name && (bool) preg_match('/\b(no|skip|anonymous|not now|later|dont|don t|do not|rather not)\b/', $norm);

        if ($name) { $profile['name'] = $name; $visitor->name = $name; }
        if ($phone) { $profile['phone'] = $phone; $visitor->phone = $phone; }
        if ($company = $this->detectCompany($raw)) { $profile['company'] = $company; $visitor->company = $company; }
        if ($cities) {
            // A new market means the media we were discussing no longer applies.
            if (($state['last_city'] ?? null) && $state['last_city'] !== $cities[0] && !$media) {
                unset($state['last_media']);
            }
            $profile['city'] = $cities[0];
            $state['last_city'] = $cities[0];
        }
        if ($media) {
            $profile['media'] = array_values(array_unique(array_merge($profile['media'] ?? [], $media)));
            $state['last_media'] = $media[0];
        }
        if ($goal) { $profile['goal'] = $goal; }
        if ($budget = $this->detectBudget($raw)) { $profile['budget'] = $budget; }
        if ($duration = $this->detectDuration($norm)) { $profile['duration'] = $duration; }
        if (preg_match('/\b(?:audience|customers?|target)\s+(?:is|are|=|:)?\s*([a-z ]{4,40})/i', $raw, $m) && !$goal) {
            $profile['audience'] = trim($m[1]);
        }

        // The page the visitor is on is a weak signal about what they want.
        $pageMedia = self::PATH_MEDIA[$path] ?? null;
        $pageCity = self::PATH_CITY[$path] ?? null;
        if (!isset($state['last_media']) && $pageMedia) { $state['last_media'] = $pageMedia; }
        if (!isset($state['last_city']) && $pageCity) { $state['last_city'] = $pageCity; }

        $turn = ($state['turns'] ?? 0) + 1;
        $state['turns'] = $turn;
        $result = null;

        // ---- 2. Decide what the message is --------------------------------
        if ($this->isReset($norm)) {
            $result = $this->forgetReply($visitor);
            $profile = [];
            $state = ['turns' => 0];
        } elseif ($phone || $name && in_array($pending, ['name_for_lead', 'phone'], true) || $declined) {
            $result = $this->leadFlow($visitor, $profile, $state, $name, $phone, $raw);
        } elseif (preg_match('/\bchange (the )?(city|location|market)\b/', $norm) && !$cities) {
            unset($profile['city'], $state['last_city']);
            $result = $this->brainstorm($profile, $state, $path);
        } elseif (preg_match('/^(yes|yeah|yep|sure|continue|go ahead|ok|okay|yes continue|yes please)$/', $norm)) {
            $result = $this->continueReply($profile, $state, $path);
        } elseif ($this->isTakeDetails($norm)) {
            $result = $this->askDetails($profile, $state);
        } elseif ($pending === 'city' && ($cities || $goal)) {
            $result = $this->brainstorm($profile, $state, $path);
        } elseif ($pending === 'goal' && ($goal || $cities)) {
            $result = $this->brainstorm($profile, $state, $path);
        } elseif ($this->isGreeting($norm)) {
            $result = $this->greeting($profile, $state);
        } elseif ($this->isThanks($norm)) {
            $result = $this->r('You are welcome! If you want, I can put together a campaign idea or take your details so the team can send a site list.', [], ['Help me plan a campaign', 'Take my details'], 'thanks');
        } elseif ($this->isBye($norm)) {
            $result = $this->r('Thanks for chatting' . (isset($profile['name']) ? ', ' . $profile['name'] : '') . '. If you need anything else, I am right here, and the team is a call away on +91 98796 16411 (Ahmedabad) or +91 99200 11574 (Mumbai).', [], [], 'bye');
        } elseif ($this->isSmallTalk($norm)) {
            $result = $this->smallTalk($norm, $profile);
        } elseif ($this->isBrainstorm($norm) || (($state['last_intent'] ?? null) === 'plan' && ($cities || $goal) && !$media)) {
            $result = $this->brainstorm($profile, $state, $path);
        } elseif (count($media) >= 2 && preg_match('/\b(vs|versus|or|compare|comparison|difference|better|best|which)\b/', $norm)) {
            $result = $this->compareMedia(array_slice($media, 0, 3), $profile);
        } elseif ($this->isRecall($norm)) {
            $result = $this->recall($profile);
        } elseif ($this->isCampaignQuery($norm)) {
            $result = $this->campaignExamples($media[0] ?? ($state['last_media'] ?? null));
        } elseif (($name || $budget || $duration || !empty($company)) && !$media && !str_contains($raw, '?') && !preg_match('/^(what|how|why|when|which|can|could|do|does|is|are)\b/', $norm)) {
            $result = $this->acknowledge($profile, $state, $path, $name, $budget, $duration);
        } elseif ($cities && !$media && $this->isCityOnly($norm, $cities)) {
            $entry = $this->entryById($cities[0] . '-overview') ?? $this->entryById('mumbai-overview');
            $result = $this->fromEntry($entry, $profile, $state, 'city overview');
        }

        if ($result === null) {
            $result = $this->knowledgeReply($visitor, $norm, $raw, $media, $cities, $profile, $state, $history, $path, $pageMedia);
        }

        // ---- 3. Personalise, persist and return ---------------------------
        if (!empty($profile['name']) && $profile['name'] !== 'Chat visitor' && $turn > 1 && $turn % 5 === 0 && !str_contains($result['reply'], $profile['name'])) {
            $result['reply'] = $profile['name'] . ', ' . lcfirst($result['reply']);
        }

        $state['last_intent'] = $result['intent'];
        $state['last_norm'] = $norm;
        if (($result['pending'] ?? null) !== null) {
            $state['pending'] = $result['pending'];
        } else {
            unset($state['pending']);
        }
        if (!empty($result['entry'])) { $state['last_entry'] = $result['entry']; }
        if (!empty($result['media'])) { $state['last_media'] = $result['media']; }

        $visitor->profile = $profile;
        $visitor->state = $state;
        $visitor->last_seen_at = now();
        $visitor->save();

        $this->log($visitor, 'bot', $result['reply'], ['intent' => $result['intent'], 'entry' => $result['entry'] ?? null]);

        return [
            'reply' => $result['reply'],
            'links' => array_slice($result['links'] ?? [], 0, 4),
            'chips' => array_slice(array_values(array_unique($result['chips'] ?? [])), 0, 4),
            'lead' => (bool) ($result['lead'] ?? false),
            'intent' => $result['intent'],
        ];
    }

    /** Greeting shown when the widget opens (returning visitors are recognised). */
    public function welcome(ChatVisitor $visitor, ?string $path): array
    {
        $profile = $visitor->profile ?? [];
        $name = $profile['name'] ?? null;
        $pageMedia = self::PATH_MEDIA[$path] ?? null;

        if ($visitor->visits > 1 && ($name || !empty($profile['city']) || !empty($profile['media']))) {
            $bits = [];
            if (!empty($profile['media'])) {
                $bits[] = implode(' and ', array_map(fn ($k) => config("chatbot.media.$k.label"), array_slice($profile['media'], 0, 2)));
            }
            if (!empty($profile['city'])) { $bits[] = 'in ' . ucfirst($profile['city']); }
            $text = 'Welcome back' . ($name ? ', ' . $name : '') . '! '
                . ($bits ? 'Last time you were looking at ' . implode(' ', $bits) . '. Want to pick up from there?' : 'Good to see you again. How can I help today?');
            $chips = $bits ? ['Yes, continue', 'Help me plan a campaign', 'Take my details'] : ['Help me plan a campaign', 'What media do you offer?'];
        } elseif ($pageMedia) {
            $label = config("chatbot.media.$pageMedia.label");
            $text = "Hi, I'm Krishna AI. I see you're looking at {$label}. I can answer questions about it, compare it with other formats or help you plan a campaign. What would you like to know?";
            $chips = ['How much does it cost?', 'What formats are available?', 'Help me plan a campaign'];
        } else {
            $text = "Hi, I'm Krishna AI. I know Krishna Outdoor's hoardings, buses, shelters and Mumbai trains, and I can help you plan a campaign or get a free site list. What are you looking to advertise?";
            $chips = ['Help me plan a campaign', 'What media do you offer?', 'Get a free site list', 'Talk to a person'];
        }

        return ['reply' => $text, 'chips' => $chips, 'links' => []];
    }

    public function forget(ChatVisitor $visitor): void
    {
        ChatMessage::where('chat_visitor_id', $visitor->id)->delete();
        $visitor->update(['name' => null, 'company' => null, 'phone' => null, 'profile' => [], 'state' => [], 'lead_saved' => false]);
    }

    // ======================================================================
    // Intents
    // ======================================================================

    private function isReset(string $n): bool
    {
        return (bool) preg_match('/\b(forget me|forget everything|start over|reset( chat)?|clear (my )?(data|chat|memory)|delete my data)\b/', $n);
    }

    private function isGreeting(string $n): bool
    {
        return (bool) preg_match('/^(hi+|hello+|hey+|hii+|namaste|namaskar|good (morning|afternoon|evening)|yo|hola|kem cho|sup)( there| krishna| team| ai)?$/', $n);
    }

    private function isThanks(string $n): bool
    {
        return (bool) preg_match('/^(thanks?|thank you|thx|ty|ok thanks?|okay thanks?|great|awesome|perfect|nice|cool|got it|understood|helpful)( a lot| so much| you| krishna)?$/', $n);
    }

    private function isBye(string $n): bool
    {
        return (bool) preg_match('/^(bye|goodbye|good bye|see you|take care|that is all|that s all|no thanks?|nothing else)/', $n);
    }

    private function isSmallTalk(string $n): bool
    {
        return (bool) preg_match('/\b(how are you|how r u|what s up|whats up|are you there|you there|who made you|are you real|are you ai|do you remember|joke)\b/', $n);
    }

    private function isTakeDetails(string $n): bool
    {
        return (bool) preg_match('/\b(take my details|my details|call me|call back|callback|contact me|get back to me|reach me|send me (the )?(list|details|rates)|share my number|leave (my )?(number|details))\b/', $n);
    }

    private function isBrainstorm(string $n): bool
    {
        return (bool) preg_match('/\b(plan|suggest|suggestion|recommend|brainstorm|ideas?|strategy|help me (choose|decide|plan|pick|select)|which (media|format|one|option)|what should i|best (option|way|media|format|mix)|how (should|do) i (advertise|promote)|(advertise|promote|market) my|want to (advertise|promote)|looking to (advertise|promote)|campaign for|i run a|i own a|i have a (shop|store|business|restaurant|brand|startup|company)|best for (a|my|an)|which (is|one is|would be) (better|best)|what works (for|best)|how (can|do) i (get|reach|attract))\b/', $n)
            || (Brainstorm::detectGoal($n) !== null && preg_match('/\b(advertis|promot|market|best|brand)/', $n));
    }

    private function isRecall(string $n): bool
    {
        return (bool) preg_match('/\b(what do you know about me|what did i (say|tell)|do you remember|my profile|remember me|what have i told)\b/', $n);
    }

    private function isCampaignQuery(string $n): bool
    {
        return (bool) preg_match('/\b(campaigns?|case stud(y|ies)|past work|previous work|examples?|portfolio|work you (did|have done)|brands you)\b/', $n)
            && !preg_match('/\b(plan|suggest|brainstorm|ideas?)\b/', $n);
    }

    private function isCityOnly(string $n, array $cities): bool
    {
        $cityWords = [];
        foreach ($cities as $c) {
            foreach (config("chatbot.cities.$c", [$c]) as $name) {
                foreach (explode(' ', Nlp::normalize($name)) as $w) { $cityWords[Nlp::stem($w)] = true; }
            }
        }
        $rest = array_filter(Nlp::tokens($n), fn ($t) => !isset($cityWords[$t]) && !in_array($t, ['and', 'only', 'now', 'city', 'there', 'too', 'same'], true));

        return count($rest) === 0;
    }

    // ======================================================================
    // Replies
    // ======================================================================

    private function r(string $reply, array $links = [], array $chips = [], string $intent = 'answer', array $extra = []): array
    {
        return ['reply' => $reply, 'links' => $links, 'chips' => $chips, 'intent' => $intent] + $extra;
    }

    private function greeting(array $profile, array $state): array
    {
        $name = $profile['name'] ?? null;
        $opener = $name ? "Hello again, {$name}!" : 'Hello!';
        if (!empty($profile['city']) || !empty($profile['media'])) {
            $text = "{$opener} We were talking about " . $this->topicPhrase($profile) . '. Want to continue, or start something new?';

            return $this->r($text, [], ['Yes, continue', 'Help me plan a campaign', 'Take my details'], 'greeting');
        }

        return $this->r("{$opener} I'm Krishna AI. Tell me what you want to advertise and where, and I'll suggest the right media, or ask me anything about our hoardings, buses, shelters and trains.", [], ['Help me plan a campaign', 'What media do you offer?', 'Get a free site list'], 'greeting');
    }

    private function smallTalk(string $n, array $profile): array
    {
        if (preg_match('/remember/', $n)) {
            return $this->recall($profile);
        }
        if (preg_match('/joke/', $n)) {
            return $this->r("I'm better with bus routes than punchlines. A billboard can't run away from its audience though, and that's the whole point. Want me to suggest a campaign?", [], ['Help me plan a campaign'], 'smalltalk');
        }

        return $this->r("Doing well, thanks for asking! I'm here to help with outdoor, transit and digital advertising. What are you planning?", [], ['Help me plan a campaign', 'What media do you offer?'], 'smalltalk');
    }

    private function recall(array $profile): array
    {
        $facts = [];
        if (!empty($profile['name'])) { $facts[] = 'your name is ' . $profile['name']; }
        if (!empty($profile['company'])) { $facts[] = 'your company is ' . $profile['company']; }
        if (!empty($profile['city'])) { $facts[] = 'you are interested in ' . ucfirst($profile['city']); }
        if (!empty($profile['media'])) { $facts[] = 'you asked about ' . implode(', ', array_map(fn ($k) => config("chatbot.media.$k.label"), $profile['media'])); }
        if (!empty($profile['goal'])) { $facts[] = 'your goal is ' . Brainstorm::goalLabel($profile['goal']); }
        if (!empty($profile['budget'])) { $facts[] = 'your budget is around ' . $profile['budget']; }
        if (!empty($profile['duration'])) { $facts[] = 'you are thinking of ' . $profile['duration']; }
        if (!empty($profile['phone'])) { $facts[] = 'I have your mobile number'; }

        if (!$facts) {
            return $this->r("Not much yet, we've only just started. Tell me what you want to advertise and where, and I'll remember it for the rest of the chat and your next visit.", [], ['Help me plan a campaign'], 'recall');
        }

        return $this->r('Here is what I remember: ' . implode('; ', $facts) . '. Say "forget me" any time and I will delete it.', [], ['Help me plan a campaign', 'Take my details'], 'recall');
    }

    private function forgetReply(ChatVisitor $visitor): array
    {
        $this->forget($visitor);

        return $this->r('Done. I have cleared this chat and everything I remembered about you. We can start fresh whenever you like.', [], ['Help me plan a campaign'], 'reset');
    }

    private function campaignExamples(?string $media): array
    {
        $campaigns = Campaign::where('status', true)->whereNotNull('slug')->latest()->limit(40)->get();
        $typeFor = ['train' => 'transit', 'best' => 'transit', 'tmt' => 'transit', 'amts' => 'transit', 'gsrtc' => 'transit', 'hoarding' => 'outdoor', 'shelter' => 'outdoor', 'social' => 'social'];
        $want = $media ? ($typeFor[$media] ?? null) : null;
        $pick = $campaigns->filter(fn ($c) => !$want || $c->media_type === $want)->take(3);
        if ($pick->isEmpty()) {
            $pick = $campaigns->take(3);
        }

        if ($pick->isEmpty()) {
            return $this->r('Our campaigns are on the Our Work page, with BEST bus wraps, Mumbai local trains, TMT buses and hoardings.', [['Our campaigns', '/projects']], ['Get a free site list'], 'campaigns');
        }

        $lines = $pick->map(fn ($c) => "• **{$c->name}** ({$c->mediaLabel()}, {$c->city})")->implode("\n");

        return $this->r("Some campaigns we have run:\n{$lines}\nEach has its own case-study page.", $pick->map(fn ($c) => [$c->name, '/projects/' . $c->slug])->all(), ['Help me plan a campaign', 'Get a free site list'], 'campaigns');
    }

    /** Side-by-side of two or three formats, using each format's own facts. */
    private function compareMedia(array $keys, array $profile): array
    {
        $lines = [];
        $links = [];
        foreach ($keys as $key) {
            foreach (config('chatbot.knowledge') as $e) {
                if (($e['media'] ?? null) === $key && str_ends_with($e['id'], '-what')) {
                    $first = preg_split('/(?<=[.!?])\s+/', trim(strip_tags($e['a'])))[0];
                    $lines[] = "• **" . config("chatbot.media.$key.label") . ':** ' . $first;
                    $links[] = [config("chatbot.media.$key.title"), config("chatbot.media.$key.page")];
                    continue 2;
                }
            }
            $lines[] = "• **" . config("chatbot.media.$key.label") . ':** ' . config("chatbot.media.$key.title") . '.';
            $links[] = [config("chatbot.media.$key.title"), config("chatbot.media.$key.page")];
        }

        $text = "Here is how they compare:\n" . implode("\n", $lines)
            . "\n\nRule of thumb: fixed sites (hoardings, shelters) give a strong presence at one spot, while buses and trains move through many neighbourhoods and repeat daily, so they build reach and recall. Many brands combine them. Tell me your city and goal and I'll suggest the mix.";

        return $this->r($text, $links, ['Plan a campaign for me', 'What affects the cost?'], 'compare');
    }

    private function acknowledge(array &$profile, array &$state, ?string $path, ?string $name, ?string $budget, ?string $duration): array
    {
        $noted = [];
        if ($name) { $noted[] = 'your name'; }
        if ($budget) { $noted[] = "your budget (about {$budget})"; }
        if ($duration) { $noted[] = 'a ' . preg_replace('/^(\d+) (\w+?)s?$/', '$1-$2', $duration) . ' run'; }
        $lead = ($name ? "Nice to meet you, {$name}. " : 'Thanks. ') . ($noted ? "I've noted " . implode(' and ', $noted) . '. ' : '');

        if (!empty($profile['city']) && !empty($profile['goal'])) {
            unset($state['plan_sig']);
            $plan = $this->brainstorm($profile, $state, $path);
            $plan['reply'] = $lead . "Here's the plan again with that in mind.\n\n" . $plan['reply'];

            return $plan;
        }
        if (empty($profile['city'])) {
            return $this->r($lead . 'Which market do you want to reach: Ahmedabad, Mumbai, Thane or all of Gujarat?', [], ['Ahmedabad', 'Mumbai', 'Thane', 'All of Gujarat'], 'plan_ask', ['pending' => 'city']);
        }

        return $this->r($lead . 'What is the main goal for ' . ucfirst($profile['city']) . ': awareness, a launch, footfall, recruitment or leads?', [], ['Brand awareness', 'Product launch', 'Footfall to my store', 'Leads and sales'], 'plan_ask', ['pending' => 'goal']);
    }

    private function continueReply(array &$profile, array &$state, ?string $path): array
    {
        if (!empty($profile['city']) && !empty($profile['goal'])) {
            return $this->brainstorm($profile, $state, $path);
        }
        $media = $profile['media'][0] ?? ($state['last_media'] ?? null);
        if ($media) {
            foreach (config('chatbot.knowledge') as $e) {
                if (($e['media'] ?? null) === $media) {
                    return $this->fromEntry($e, $profile, $state, 'answer');
                }
            }
        }

        return $this->brainstorm($profile, $state, $path);
    }

    // ---- Brainstorm ------------------------------------------------------

    private function brainstorm(array &$profile, array &$state, ?string $path): array
    {
        $city = $profile['city'] ?? ($state['last_city'] ?? null);
        $goal = $profile['goal'] ?? null;

        if (!$city) {
            return $this->r("Happy to brainstorm with you. First, which market do you want to reach: **Ahmedabad**, **Mumbai**, **Thane** or **all of Gujarat**?", [], ['Ahmedabad', 'Mumbai', 'Thane', 'All of Gujarat'], 'plan_ask', ['pending' => 'city']);
        }
        $profile['city'] = $city;

        if (!$goal) {
            return $this->r("Good, " . ucfirst($city) . ". What is the main goal: **awareness**, a **launch**, **footfall** to a shop or outlet, **recruitment/admissions**, or **leads**?", [], ['Brand awareness', 'Product launch', 'Footfall to my store', 'Leads and sales'], 'plan_ask', ['pending' => 'goal']);
        }

        $sig = $city . '|' . $goal;
        if (($state['plan_sig'] ?? null) === $sig && ($state['last_intent'] ?? null) === 'plan') {
            return $this->r("That's the plan I built for " . Brainstorm::goalLabel($goal) . ' in ' . ucfirst($city) . ". Want me to add social media, change the city, or have the team send the available sites?", [], ['Add social media', 'Change the city', 'Take my details'], 'plan_repeat');
        }
        $state['plan_sig'] = $sig;

        $plan = Brainstorm::plan($profile);
        $memo = [];
        if (!empty($profile['budget'])) { $memo[] = "your budget of about {$profile['budget']}"; }
        if (!empty($profile['duration'])) { $memo[] = 'a ' . preg_replace('/^(\d+) (\w+?)s?$/', '$1-$2', $profile['duration']) . ' run'; }
        $tail = $memo ? "\n\nI've noted " . implode(' and ', $memo) . " for the team." : '';

        return $this->r(
            $plan['text'] . $tail,
            array_merge($plan['links'], [['Get a free site list', '/free-site-list?' . http_build_query(['media' => $this->listKey($plan['media'][0] ?? 'ooh'), 'city' => ucfirst($city === 'gujarat' ? 'Ahmedabad' : $city)])]]),
            ['Take my details', 'Add social media', 'Change the city', 'What affects the cost?'],
            'plan',
            ['media' => $plan['media'][0] ?? null]
        );
    }

    // ---- Lead ------------------------------------------------------------

    private function askDetails(array $profile, array $state): array
    {
        if (!empty($profile['phone']) && !empty($profile['name'])) {
            return $this->leadResult($profile, $state, false);
        }
        if (!empty($profile['phone'])) {
            return $this->r('I have your number. What name should the team ask for?', [], [], 'lead_ask', ['pending' => 'name_for_lead']);
        }

        if (!empty($profile['name'])) {
            return $this->r("Thanks, {$profile['name']}. What is your 10-digit mobile number?", [], [], 'lead_ask', ['pending' => 'phone']);
        }

        return $this->r("Happy to. Type your **name and 10-digit mobile number** (for example: Rahul, 98XXXXXXXX) and I'll pass them to the team with what we've discussed. They usually reply within one business day.", [], [], 'lead_ask', ['pending' => 'phone']);
    }

    private function leadFlow(ChatVisitor $visitor, array &$profile, array &$state, ?string $name, ?string $phone, string $raw): array
    {
        $pending = $state['pending'] ?? null;
        $phone = $phone ?: ($profile['phone'] ?? null);

        // Declined to give a name: save without one rather than lose the lead.
        if ($pending === 'name_for_lead' && empty($profile['name']) && !$name && !$phone) {
            $profile['name'] = 'Chat visitor';
            $visitor->name = 'Chat visitor';
        }

        if (!$phone) {
            return $this->askDetails($profile, $state);
        }
        if (empty($profile['name'])) {
            return $this->r('Thanks, got the number. What name should the team ask for?', [], [], 'lead_ask', ['pending' => 'name_for_lead']);
        }

        return $this->saveLead($visitor, $profile, $state);
    }

    private function saveLead(ChatVisitor $visitor, array $profile, array $state): array
    {
        if (!$visitor->lead_saved) {
            $enquiry = new Enquiry();
            $enquiry->name = Str::limit($profile['name'], 240, '');
            $enquiry->phone = $profile['phone'];
            $enquiry->company = $profile['company'] ?? null;
            $enquiry->requirement = Str::limit('Chatbot: ' . $this->requirementSummary($profile, $state), 250, '');
            $enquiry->save();
            $visitor->lead_saved = true;
        }

        return $this->leadResult($profile, $state, true);
    }

    private function leadResult(array $profile, array $state, bool $fresh): array
    {
        $summary = $this->requirementSummary($profile, $state);
        $text = ($fresh ? "Thank you, {$profile['name']}! " : "I already have your details, {$profile['name']}. ")
            . "I've passed your number and what we discussed (" . $summary . ") to the team. They usually reply within one business day. If it's urgent you can call Ahmedabad on +91 98796 16411 or Mumbai on +91 99200 11574.";

        return $this->r($text, [['Call the team', 'tel:+919879616411'], ['Free site list form', '/free-site-list']], ['What affects the cost?', 'Help me plan a campaign'], 'lead_saved', ['lead' => $fresh]);
    }

    private function requirementSummary(array $profile, array $state = []): string
    {
        $profile += array_filter(['city' => $state['last_city'] ?? null]);
        if (empty($profile['media']) && !empty($state['last_media'])) {
            $profile['media'] = [$state['last_media']];
        }
        $parts = [];
        if (!empty($profile['media'])) { $parts[] = implode(', ', array_map(fn ($k) => config("chatbot.media.$k.label"), $profile['media'])); }
        if (!empty($profile['city'])) { $parts[] = 'in ' . ucfirst($profile['city']); }
        if (!empty($profile['goal'])) { $parts[] = 'goal: ' . Brainstorm::goalLabel($profile['goal']); }
        if (!empty($profile['budget'])) { $parts[] = 'budget: ' . $profile['budget']; }
        if (!empty($profile['duration'])) { $parts[] = 'duration: ' . $profile['duration']; }

        return $parts ? implode('; ', $parts) : 'general enquiry';
    }

    // ---- Knowledge retrieval ------------------------------------------------

    private function knowledgeReply(ChatVisitor $visitor, string $norm, string $raw, array $media, array $cities, array $profile, array $state, array $history, ?string $path, ?string $pageMedia): array
    {
        $ranked = $this->retrieve($norm, $media, $cities, $state);
        $top = $ranked[0] ?? null;

        // A short, media-less question in a known city: ask which media instead of guessing.
        $cityMedia = ['ahmedabad' => ['hoarding', 'amts', 'shelter'], 'mumbai' => ['train', 'best', 'tmt'], 'thane' => ['tmt', 'best'], 'gujarat' => ['gsrtc', 'hoarding']];
        $ctxCity = $state['last_city'] ?? null;
        if ($top && !$media && !($state['last_media'] ?? null) && $ctxCity && isset($cityMedia[$ctxCity])
            && count(Nlp::tokens($norm)) <= 3 && ($top['entry']['media'] ?? null) && !in_array($top['entry']['media'], $cityMedia[$ctxCity], true)) {
            $labels = array_map(fn ($k) => config("chatbot.media.$k.label"), $cityMedia[$ctxCity]);

            return $this->r('Which ' . ucfirst($ctxCity) . ' media do you mean: ' . implode(', ', $labels) . '?', [], $labels, 'clarify');
        }

        if (!$top || $top['score'] < 2.0) {
            return $this->fallback($ranked, $profile);
        }

        $entry = $top['entry'];
        // Same answer twice in a row: offer the next-best angle instead of repeating.
        if (($state['last_entry'] ?? null) === $entry['id'] && ($state['last_norm'] ?? null) === $norm && isset($ranked[1]) && $ranked[1]['score'] >= 2.0) {
            $entry = $ranked[1]['entry'];
        }

        $result = $this->fromEntry($entry, $profile, $state, 'answer');

        return $result;
    }

    private function fromEntry(array $entry, array $profile, array $state, string $intent): array
    {
        $text = $entry['a'];
        $links = $entry['links'] ?? [];
        $chips = $entry['next'] ?? [];

        // Memory: tie generic answers back to what the visitor told us.
        if (in_array($entry['id'], ['pricing', 'booking', 'site-list'], true)) {
            $media = $profile['media'][0] ?? ($state['last_media'] ?? null);
            $city = $profile['city'] ?? ($state['last_city'] ?? null);
            if ($media || $city) {
                $label = $media ? config("chatbot.media.$media.label") : null;
                $scope = $label ? $label . ($city ? ' in ' . ucfirst($city) : '') : ucfirst((string) $city);
                $text .= "\n\nFor " . $scope . ', the quickest route is the free site list, and I can fill it in from this chat.';
                array_unshift($links, ['Free site list for ' . $scope, '/free-site-list?' . http_build_query(array_filter(['media' => $media ? $this->listKey($media) : null, 'city' => $city ? ucfirst($city) : null]))]);
            }
        }

        if ($entry['id'] === 'pricing' && !empty($profile['budget'])) {
            $text .= "\n\nYou mentioned a budget of about {$profile['budget']}. I can't say what that buys without site details, but the team can match options to it.";
        }

        if (in_array($entry['id'], ['pricing', 'booking', 'site-list'], true)) {
            $chips[] = 'Take my details';
        }

        $text = $this->opener($entry['id'], $text);

        return $this->r($text, $links, $chips, $intent, ['entry' => $entry['id'], 'media' => $entry['media'] ?? null]);
    }

    /** A short human lead-in on some answers (stable per entry so it never feels random). */
    private function opener(string $id, string $text): string
    {
        $openers = ['', 'Sure. ', 'Good question. ', 'Happy to help. ', ''];
        $o = $openers[crc32($id) % count($openers)];

        return $o . $text;
    }

    private function fallback(array $ranked, array $profile): array
    {
        $chips = [];
        foreach (array_slice($ranked, 0, 3) as $r) {
            if (!empty($r['entry']['next'][0]) && $r['score'] > 0.8) {
                $chips[] = $r['entry']['next'][0];
            }
        }
        $chips = array_merge($chips, ['Help me plan a campaign', 'Talk to a person']);

        return $this->r("I want to get this right, and I'm not sure I understood. I can help with hoardings, AMTS, GSRTC, BEST and TMT buses, bus shelters, Mumbai local trains, digital screens and social media, or plan a campaign for you. Could you tell me a bit more, or would you like the team to call you?", [['Call the team', 'tel:+919879616411']], $chips, 'fallback');
    }

    /** @return array<int, array{score: float, entry: array}> */
    private function retrieve(string $norm, array $media, array $cities, array $state): array
    {
        $tokens = array_flip(Nlp::tokens($norm));
        $entries = config('chatbot.knowledge');
        $ctxMedia = $state['last_media'] ?? null;
        $out = [];

        foreach ($entries as $entry) {
            $hits = [];
            foreach ($entry['k'] as $phrase) {
                $np = Nlp::normalize($phrase);
                $words = array_values(array_unique(array_filter(Nlp::tokens($np))));
                if ($np === '' || !$words) {
                    continue;
                }
                if (Nlp::has($norm, $np)) {
                    $hits[] = 2.0 + 1.5 * max(0, count($words) - 1);
                    continue;
                }
                $matched = array_filter($words, fn ($w) => isset($tokens[$w]));
                if (count($matched) === count($words)) {
                    $hits[] = 2.0 + 1.0 * (count($words) - 1);   // all content words present, any order
                } elseif (count($words) > 1 && $matched) {
                    $hits[] = 0.5 * array_sum(array_map(fn ($w) => $this->idf($w), $matched)) / 2;
                }
            }
            rsort($hits);
            // The best matching phrase counts in full; extra matches add a little.
            $score = $hits ? $hits[0] + 0.4 * array_sum(array_slice($hits, 1)) : 0.0;

            if ($score <= 0) {
                continue; // context only helps entries that already match the words
            }

            if (str_ends_with($entry['id'], '-overview')) {
                $score = min($score, 4.0);
            }

            if (in_array($entry['id'], ['pricing', 'booking'], true) && preg_match($entry['id'] === 'pricing' ? '/\b(cost|price|pricing|rate|rates|how much|charges|budget|quote)\b/' : '/\b(book|booking|how to start|process)\b/', $norm)) {
                $score += 7.0;
            }

            $em = $entry['media'] ?? null;
            if ($em && $media) {
                $score += in_array($em, $media, true) ? 3.0 : -1.5;
            } elseif ($em && !$media && $ctxMedia === $em) {
                $score += 2.2;
            } elseif (!$em && $media) {
                $score -= 0.5;
            }

            $ec = $entry['city'] ?? null;
            if ($ec && $cities) {
                $score += in_array($ec, $cities, true) ? 1.5 : -1.2;
            }

            if ($score > 0) {
                $out[] = ['score' => $score, 'entry' => $entry];
            }
        }
        usort($out, fn ($a, $b) => $b['score'] <=> $a['score']);

        return $out;
    }

    private function idf(string $word): float
    {
        if ($this->idf === null) {
            $df = [];
            $entries = config('chatbot.knowledge');
            foreach ($entries as $e) {
                $seen = [];
                foreach ($e['k'] as $phrase) {
                    foreach (Nlp::tokens($phrase) as $t) { $seen[$t] = true; }
                }
                foreach (array_keys($seen) as $t) { $df[$t] = ($df[$t] ?? 0) + 1; }
            }
            $n = count($entries);
            $this->idf = array_map(fn ($c) => log(1 + $n / $c), $df);
        }

        return $this->idf[$word] ?? 1.0;
    }

    private function entryById(string $id): ?array
    {
        foreach (config('chatbot.knowledge') as $e) {
            if ($e['id'] === $id) { return $e; }
        }

        return null;
    }

    // ======================================================================
    // Entity detection
    // ======================================================================

    /** @return string[] */
    private function detectCities(string $norm): array
    {
        $found = [];
        foreach (config('chatbot.cities') as $key => $names) {
            foreach ($names as $name) {
                if (Nlp::has($norm, $name)) { $found[] = $key === 'rajasthan' ? 'gujarat' : $key; break; }
            }
        }
        // "navi mumbai" etc. should not add Thane by accident; keep first-mentioned order roughly
        return array_values(array_unique($found));
    }

    /** @return string[] */
    private function detectMedia(string $norm): array
    {
        $scored = [];
        foreach (config('chatbot.media') as $key => $m) {
            foreach ($m['syn'] as $syn) {
                if ($syn === 'best' && !preg_match('/\b(bus|mumbai|ev|electric)\b/', $norm)) { continue; }
                if (in_array($syn, ['led', 'print', 'design', 'creative'], true) && strlen($norm) > 0 && !Nlp::has($norm, $syn)) { continue; }
                if (Nlp::has($norm, $syn)) {
                    $scored[$key] = max($scored[$key] ?? 0, strlen($syn));
                }
            }
        }
        arsort($scored);

        return array_keys($scored);
    }

    private function detectPhone(string $raw): ?string
    {
        if (preg_match('/(?<!\d)(?:\+?91[\s-]?)?0?([6-9]\d{4}[\s-]?\d{5})(?!\d)/', $raw, $m)) {
            return preg_replace('/\D/', '', $m[1]);
        }

        return null;
    }

    private function detectName(string $raw): ?string
    {
        if (preg_match('/\b(?:my name is|name is|i am|i\'m|im|this is|call me|myself)\s+([A-Za-z][A-Za-z.\'-]{1,20}(?:\s+[A-Za-z][A-Za-z.\'-]{1,20}){0,2})/i', $raw, $m)) {
            $name = preg_split('/\s+(?:from|and|looking|interested|at|of|in|here|calling|owner|manager|ji|speaking|wants?|with|for|planning|trying)\b/i', $m[1])[0];
            $name = $this->cleanName($name);
            if ($name && $this->looksLikeName($name)) { return $name; }
        }

        return null;
    }

    private function looksLikeName(string $text): bool
    {
        $t = trim($text);
        if ($t === '' || preg_match('/\d|\?/', $t) || str_word_count($t) > 3 || strlen($t) > 40) { return false; }
        $first = strtolower(strtok($t, ' '));
        $blocked = ['looking', 'interested', 'planning', 'trying', 'from', 'here', 'not', 'a', 'an', 'the', 'just', 'new', 'wondering', 'no', 'yes', 'ok', 'okay', 'hi', 'hello', 'how', 'what', 'why', 'when', 'where', 'which', 'who', 'can', 'could', 'do', 'does', 'is', 'are', 'my', 'your', 'skip', 'later', 'cost', 'price', 'rate'];

        return !in_array($first, $blocked, true);
    }

    private function cleanName(string $name): string
    {
        return Str::title(trim(preg_replace('/[^A-Za-z.\' -]/', '', $name)));
    }

    private function detectCompany(string $raw): ?string
    {
        if (preg_match('/\bmy (?:company|brand|business|firm|startup|agency)(?: name)? (?:is|called)\s+([A-Za-z0-9&][A-Za-z0-9&.\' -]{1,40})/i', $raw, $m)) {
            return Str::title(trim(preg_split('/[,.;]/', $m[1])[0]));
        }

        return null;
    }

    private function detectBudget(string $raw): ?string
    {
        if (preg_match('/(?:rs\.?|₹|inr)\s*([\d,.]+)\s*(lakhs?|lacs?|crores?|k|thousand)?/i', $raw, $m)
            || preg_match('/([\d,.]+)\s*(lakhs?|lacs?|crores?|thousand)\b/i', $raw, $m)) {
            return trim('Rs ' . $m[1] . ' ' . ($m[2] ?? ''));
        }

        return null;
    }

    private function detectDuration(string $norm): ?string
    {
        if (preg_match('/\b(\d{1,2})\s*(day|week|month|year)s?\b/', $norm, $m)) {
            return $m[1] . ' ' . $m[2] . ($m[1] > 1 ? 's' : '');
        }

        return null;
    }

    private function topicPhrase(array $profile): string
    {
        $bits = [];
        if (!empty($profile['media'])) { $bits[] = config('chatbot.media.' . $profile['media'][0] . '.label'); }
        if (!empty($profile['city'])) { $bits[] = 'in ' . ucfirst($profile['city']); }

        return $bits ? implode(' ', $bits) : 'your campaign';
    }

    private function listKey(string $media): string
    {
        return config("chatbot.media.$media.list", 'other');
    }

    private function log(ChatVisitor $visitor, string $role, string $body, array $meta = []): void
    {
        ChatMessage::create(['chat_visitor_id' => $visitor->id, 'role' => $role, 'body' => $body, 'meta' => $meta, 'created_at' => now()]);
    }
}
