<?php

namespace App\Services;

use App\Models\SeoMeta;

/**
 * Checks an indexable page's title and description against the rules the
 * site follows: never empty, title 30-60 characters, description 140-160.
 * Used by the SEO panel (warnings) and by the sitemap (an indexable page
 * with an empty title or description is skipped and logged, never silent).
 */
class SeoHealth
{
    /** @return array{errors: string[], warnings: string[]} */
    public static function check(?SeoMeta $meta): array
    {
        $errors = [];
        $warnings = [];
        $title = trim((string) $meta?->meta_title);
        $description = trim((string) $meta?->meta_description);

        if ($title === '') {
            $errors[] = 'Meta title is empty';
        } elseif (mb_strlen($title) > 60 || mb_strlen($title) < 30) {
            $warnings[] = 'Title is ' . mb_strlen($title) . ' characters (aim for 30-60)';
        }

        if ($description === '') {
            $errors[] = 'Meta description is empty';
        } elseif (mb_strlen($description) > 160 || mb_strlen($description) < 140) {
            $warnings[] = 'Description is ' . mb_strlen($description) . ' characters (aim for 140-160)';
        }

        return ['errors' => $errors, 'warnings' => $warnings];
    }
}
