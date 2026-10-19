<?php

namespace App\Services\Chat;

/**
 * Small language helpers for the chatbot: normalising, tokenising, light
 * stemming and typo correction against the knowledge-base vocabulary.
 */
class Nlp
{
    private const STOP = ['a', 'an', 'the', 'is', 'are', 'am', 'was', 'be', 'to', 'of', 'in', 'on', 'for', 'and', 'or', 'with', 'at', 'by', 'it', 'its', 'this', 'that', 'do', 'does', 'did', 'you', 'your', 'i', 'me', 'my', 'we', 'our', 'can', 'could', 'would', 'will', 'please', 'pls', 'tell', 'about', 'want', 'need', 'like', 'any', 'some', 'have', 'has', 'get', 'give', 'show', 'there', 'what', 'which', 'how', 'who', 'where', 'when', 'so', 'if', 'then', 'also', 'just', 'ok', 'okay'];

    /** @var array<string, true>|null */
    private static ?array $vocab = null;

    public static function normalize(string $text): string
    {
        $text = mb_strtolower($text);
        $text = str_replace(['₹', '&'], [' rs ', ' and '], $text);
        $text = preg_replace('/[^a-z0-9+\s.\-]/u', ' ', $text);
        $text = preg_replace('/(?<![0-9])[.\-]|[.\-](?![0-9])/', ' ', $text);

        return trim(preg_replace('/\s+/', ' ', $text));
    }

    public static function stem(string $word): string
    {
        if (strlen($word) > 4 && str_ends_with($word, 'ies')) {
            return substr($word, 0, -3) . 'y';
        }
        if (strlen($word) > 3 && str_ends_with($word, 's') && !str_ends_with($word, 'ss')) {
            return substr($word, 0, -1);
        }

        return $word;
    }

    /** @return string[] stemmed, typo-corrected content words (stop words removed) */
    public static function tokens(string $text, bool $keepStop = false): array
    {
        $out = [];
        foreach (explode(' ', self::normalize($text)) as $w) {
            if ($w === '' || (!$keepStop && in_array($w, self::STOP, true))) {
                continue;
            }
            $out[] = self::stem(self::correct($w));
        }

        return $out;
    }

    /** Fixes one-letter typos of known domain words ("hoardng" -> "hoarding"). */
    public static function correct(string $word): string
    {
        if (strlen($word) < 5 || ctype_digit($word)) {
            return $word;
        }
        $vocab = self::vocab();
        if (isset($vocab[$word]) || isset($vocab[self::stem($word)])) {
            return $word;
        }
        foreach (array_keys($vocab) as $known) {
            if (abs(strlen($known) - strlen($word)) <= 1 && strlen($known) >= 5 && levenshtein($known, $word) === 1) {
                return $known;
            }
        }

        return $word;
    }

    private static function vocab(): array
    {
        if (self::$vocab === null) {
            self::$vocab = [];
            $add = function (string $phrase) {
                foreach (explode(' ', self::normalize($phrase)) as $w) {
                    if (strlen($w) >= 4) {
                        self::$vocab[self::stem($w)] = true;
                    }
                }
            };
            foreach (config('chatbot.knowledge') as $entry) {
                foreach ($entry['k'] as $k) {
                    $add($k);
                }
            }
            foreach (config('chatbot.media') as $media) {
                foreach ($media['syn'] as $s) {
                    $add($s);
                }
            }
            foreach (config('chatbot.cities') as $names) {
                foreach ($names as $n) {
                    $add($n);
                }
            }
        }

        return self::$vocab;
    }

    private static function stemText(string $text): string
    {
        return implode(' ', array_map([self::class, 'stem'], explode(' ', $text)));
    }

    /** True when $phrase occurs in $text as whole words. */
    public static function has(string $normalizedText, string $phrase): bool
    {
        $phrase = self::stemText(self::normalize($phrase));
        $text = self::stemText($normalizedText);

        return $phrase !== '' && (bool) preg_match('/(?<![a-z0-9])' . preg_quote($phrase, '/') . '(?![a-z0-9])/', $text);
    }
}
