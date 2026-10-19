<?php

namespace App\Services;

use App\Models\Location;
use App\Models\SeoMeta;
use Illuminate\Support\Collection;

/**
 * A /locations/{city} page is a thin listing, so it may only be indexed (and
 * listed in sitemap.xml) once it has real inventory: every active site needs
 * a photo, a size and an area, and the page needs at least MIN_WORDS words of
 * unique copy (SEO panel > page copy). Anything less is noindex,follow and
 * left out of the sitemap, whatever its SEO row says.
 */
class LocationPageGate
{
    public const MIN_WORDS = 300;

    /**
     * @param  Collection<int, Location>  $locations  the city's active locations
     * @return array<int, string> reasons the page cannot be indexed yet (empty = it can)
     */
    public static function problems(Collection $locations, ?SeoMeta $meta): array
    {
        $problems = [];

        if ($locations->isEmpty()) {
            return ['no active locations'];
        }

        $incomplete = $locations->filter(fn (Location $l) => !self::hasPhoto($l) || mb_strlen(trim((string) $l->area)) < 3 || trim((string) $l->size) === '');
        if ($incomplete->isNotEmpty()) {
            $problems[] = $incomplete->count() . ' of ' . $locations->count() . ' sites lack a real photo, area or size';
        }

        $words = str_word_count(strip_tags((string) $meta?->page_copy));
        if ($words < self::MIN_WORDS) {
            $problems[] = "page copy has {$words} of " . self::MIN_WORDS . ' words';
        }

        return $problems;
    }

    public static function passes(Collection $locations, ?SeoMeta $meta): bool
    {
        return self::problems($locations, $meta) === [];
    }

    private static function hasPhoto(Location $location): bool
    {
        $image = trim((string) $location->image);

        return $image !== '' && !str_contains(strtolower($image), 'bot-icon');
    }
}
