<?php

namespace App\Services\Chat;

/**
 * Campaign brainstorming: turns what the visitor has told us (city, goal,
 * audience) into a media mix with reasons, built only from the formats and
 * facts on the site. It never quotes prices or invents results.
 */
class Brainstorm
{
    public const GOALS = [
        'awareness' => ['awareness', 'visibility', 'brand', 'recall', 'be seen', 'presence', 'reach', 'popular', 'known'],
        'launch' => ['launch', 'new product', 'new brand', 'opening', 'inauguration', 'new store', 'introduce'],
        'footfall' => ['footfall', 'store', 'showroom', 'shop', 'restaurant', 'cafe', 'clinic', 'hospital', 'visits', 'walk in', 'walk-in', 'outlet'],
        'recruitment' => ['recruit', 'admission', 'admissions', 'student', 'students', 'college', 'school', 'hiring', 'enrol', 'enroll', 'course'],
        'statewide' => ['statewide', 'state wide', 'all over gujarat', 'whole state', 'every district', 'all districts', 'across gujarat'],
        'leads' => ['leads', 'sales', 'enquiries', 'inquiries', 'sell', 'conversion', 'real estate', 'property'],
    ];

    public static function detectGoal(string $normalized): ?string
    {
        foreach (self::GOALS as $goal => $words) {
            foreach ($words as $w) {
                if (Nlp::has($normalized, $w)) {
                    return $goal;
                }
            }
        }

        return null;
    }

    public static function goalLabel(?string $goal): string
    {
        return match ($goal) {
            'awareness' => 'brand awareness',
            'launch' => 'a launch',
            'footfall' => 'footfall to a location',
            'recruitment' => 'recruitment or admissions',
            'statewide' => 'state-wide reach',
            'leads' => 'leads and enquiries',
            default => 'your goal',
        };
    }

    /**
     * @return array{text: string, links: array, media: string[]}
     */
    public static function plan(array $profile): array
    {
        $city = $profile['city'] ?? 'ahmedabad';
        $goal = $profile['goal'] ?? 'awareness';
        $audience = $profile['audience'] ?? null;

        $lines = [];
        $links = [];
        $media = [];

        $add = function (string $key, string $why) use (&$lines, &$links, &$media) {
            $m = config('chatbot.media.' . $key);
            $lines[] = "• **{$m['title']}:** {$why}";
            $links[] = [$m['title'], $m['page']];
            $media[] = $key;
        };

        $anchor = $city === 'statewide' ? 'gujarat' : $city;

        if ($goal === 'statewide' || $anchor === 'gujarat') {
            $add('gsrtc', 'the foundation: 7000+ GSRTC buses connect every district, including smaller towns no city format reaches.');
            $add('hoarding', 'prime fixed sites in the big cities (2000+ sites across Gujarat, 300+ own in Ahmedabad) to anchor the message.');
            $add('amts', 'add 900+ AMTS buses if Ahmedabad needs deeper coverage than the state buses give.');
            $phase = "Phase 1: GSRTC buses for state-wide recall. Phase 2: hoardings and AMTS in the cities that matter most to sales.";
        } elseif ($anchor === 'mumbai') {
            $add('train', 'exterior branding on Western and Central Railway trains gives mass daily commuter reach.');
            $add('best', '400+ BEST EV full-wrap buses reach neighbourhoods the rail lines do not.');
            if ($goal === 'leads' || $goal === 'footfall' || $goal === 'launch') {
                $add('social', 'continue the conversation online after the commute with paid social aimed at the same audience.');
            }
            $phase = "Phase 1: train branding for scale. Phase 2: BEST buses on routes near your target areas. Phase 3: social ads echoing the same creative.";
        } elseif ($anchor === 'thane') {
            $add('tmt', '350+ TMT buses serve Thane, a fast-growing market with less outdoor clutter than central Mumbai.');
            $add('best', 'extend into Mumbai with BEST buses if your customers travel between the two.');
            $phase = "Phase 1: TMT buses for Thane. Phase 2: extend to BEST buses or trains if reach into Mumbai is needed.";
        } else { // Ahmedabad
            if ($goal === 'footfall') {
                $add('shelter', '400+ backlit bus shelters near your outlet put your offer in front of people who are waiting and can read it.');
                $add('hoarding', 'a fixed hoarding on the road to your location points people your way.');
                $add('amts', 'AMTS buses carry the message across the neighbourhoods your customers come from.');
            } elseif ($goal === 'recruitment') {
                $add('shelter', 'shelters near colleges and markets reach students and families while they wait, with room for dates, courses and a QR code.');
                $add('amts', 'AMTS buses repeat the message across residential and college areas.');
                $add('social', 'Instagram and Facebook ads reach students and parents directly.');
            } elseif ($goal === 'launch') {
                $add('hoarding', 'big, high-impact fixed sites (frontlit, backlit, unipoles and gantries) make a launch feel unmissable.');
                $add('amts', 'AMTS buses spread the launch across the whole city for weeks.');
                $add('dooh', 'digital screens let you change creative as the launch moves from teaser to offer.');
            } elseif ($goal === 'leads') {
                $add('hoarding', 'prime sites on the roads your buyers use, with a clear call to action.');
                $add('shelter', 'shelter panels hold a longer message, such as an offer or a QR code.');
                $add('social', 'paid social turns street attention into enquiries.');
            } else {
                $add('amts', '900+ city buses cover many neighbourhoods daily and repeat on fixed routes, which builds recall quickly.');
                $add('shelter', '400+ backlit shelters reinforce the message where people stop and read.');
                $add('hoarding', '300+ own hoardings give prime fixed presence on busy roads.');
            }
            $phase = "Phase 1: buses plus shelters for city-wide recall. Phase 2: hoardings on the key roads. Phase 3: social content built around the same creative.";
        }

        $ideas = [
            "Keep one creative idea across every format so people recognise it, then adapt it to each (a bus wrap reads differently from a shelter panel).",
            "Photograph or film the branded bus or hoarding and reuse it in social content.",
        ];
        if (in_array('shelter', $media, true)) {
            $ideas[] = "Use the shelter's dwell time: an offer, a date or a QR code can be read in full.";
        }
        if ($audience) {
            $ideas[] = "Because your audience is {$audience}, choose routes and sites near where they live, study, work or shop.";
        }

        $where = match ($anchor) {
            'mumbai' => 'in Mumbai',
            'thane' => 'in Thane',
            'gujarat' => 'across Gujarat',
            default => 'in Ahmedabad',
        };

        $text = "Here is a starting plan for **" . self::goalLabel($goal) . "** {$where}:\n" . implode("\n", $lines)
            . "\n\n**How I'd stage it:** {$phase}\n\n**Ideas to make it work:**\n• " . implode("\n• ", $ideas)
            . "\n\nI can't quote prices here, but the team can send available sites with rates.";

        return ['text' => $text, 'links' => array_slice($links, 0, 3), 'media' => $media];
    }
}
