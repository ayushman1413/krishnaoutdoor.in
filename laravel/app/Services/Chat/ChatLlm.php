<?php

namespace App\Services\Chat;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Optional language-model layer. When ANTHROPIC_API_KEY is set, Claude phrases
 * the answer from the retrieved facts and the visitor's memory; the engine's
 * own answer is the fallback on any error, so the bot never goes silent.
 */
class ChatLlm
{
    public static function enabled(): bool
    {
        return (bool) config('chatbot.llm.key');
    }

    /**
     * @param  array<int, array{role: string, content: string}>  $history
     * @param  string[]  $facts
     */
    public static function reply(string $message, array $history, array $facts, array $profile, ?string $page): ?string
    {
        if (!self::enabled()) {
            return null;
        }

        $system = "You are Krishna AI, the assistant on krishnaoutdoor.in, the website of Krishna Outdoor, an outdoor and transit advertising company (since 1985) in Ahmedabad and Mumbai.\n"
            . "Rules:\n- Answer ONLY from the FACTS below and the conversation. If something is not in the facts, say you don't have it and offer the team's phone numbers (Ahmedabad +91 98796 16411, Mumbai +91 99200 11574) or the free site list at /free-site-list.\n"
            . "- Never invent prices, availability, site counts, results, clients or dates. Pricing depends on format, location, quantity and duration.\n"
            . "- Sound like a warm, sharp human sales consultant: short paragraphs, plain words, ask one useful question at the end, use the visitor's name only if known.\n"
            . "- Use the visitor memory to avoid asking again for what they already told you.\n- Maximum 110 words. Use **bold** sparingly and '•' bullets only for lists.\n\n"
            . "VISITOR MEMORY: " . json_encode($profile, JSON_UNESCAPED_UNICODE) . "\nCURRENT PAGE: " . ($page ?: 'unknown') . "\n\nFACTS:\n- " . implode("\n- ", $facts);

        $messages = [];
        foreach (array_slice($history, -10) as $turn) {
            $messages[] = ['role' => $turn['role'] === 'bot' ? 'assistant' : 'user', 'content' => $turn['content']];
        }
        $messages[] = ['role' => 'user', 'content' => $message];

        try {
            $response = Http::timeout((int) config('chatbot.llm.timeout', 12))
                ->withHeaders(['x-api-key' => config('chatbot.llm.key'), 'anthropic-version' => '2023-06-01'])
                ->post('https://api.anthropic.com/v1/messages', [
                    'model' => config('chatbot.llm.model'),
                    'max_tokens' => 350,
                    'system' => $system,
                    'messages' => $messages,
                ]);

            if ($response->successful()) {
                $text = trim((string) data_get($response->json(), 'content.0.text'));

                return $text !== '' ? $text : null;
            }
            Log::warning('Chatbot LLM call failed: ' . $response->status());
        } catch (\Throwable $e) {
            Log::warning('Chatbot LLM error: ' . $e->getMessage());
        }

        return null;
    }
}
