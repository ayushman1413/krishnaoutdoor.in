<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Location;
use App\Models\SeoMeta;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Builds sitemap.xml from config/seo_pages.php plus active categories and
 * location cities. The result is cached and flushed whenever a SeoMeta,
 * Category or Location row is saved or deleted (see AppServiceProvider),
 * so the sitemap regenerates on the next request after any change.
 *
 * Only canonical https URLs from APP_URL are ever emitted. A page is left
 * out when it is marked "exclude from sitemap" or set to noindex in the
 * SEO panel. /blog/ is not listed while it is noindexed.
 */
class SitemapService
{
    public const CACHE_KEY = 'seo.sitemap.urls';

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * @return array<int, array{loc: string, lastmod: string}>
     */
    public static function urls(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, fn () => self::build());
    }

    private static function excluded(?SeoMeta $meta): bool
    {
        return $meta !== null && ($meta->exclude_from_sitemap || !$meta->robots_index);
    }

    private static function build(): array
    {
        $urls = [];
        $add = function (string $path, $updatedAt) use (&$urls) {
            $loc = SeoResolver::canonicalFor($path);
            $urls[$loc] = [
                'loc' => $loc,
                'lastmod' => ($updatedAt ?? now())->toAtomString(),
            ];
        };

        $staticMeta = SeoMeta::query()->whereNotNull('route_name')->get()->keyBy('route_name');

        foreach (config('seo_pages') as $routeName => $page) {
            $meta = $staticMeta->get($routeName);
            if (self::excluded($meta)) {
                continue;
            }
            $add($page['path'], $meta?->updated_at);
        }

        $categoryMeta = SeoMeta::query()
            ->where('seoable_type', Category::class)
            ->get()
            ->keyBy('seoable_id');

        Category::query()->where('status', true)->get()->each(function (Category $category) use ($add, $categoryMeta) {
            $meta = $categoryMeta->get($category->id);
            if (self::excluded($meta)) {
                return;
            }
            // Mirrors routes/web.php: top-level categories live at /{slug},
            // child categories at /category/{slug}.
            $path = $category->category_id ? '/category/' . $category->slug : '/' . $category->slug;
            $add($path, max($category->updated_at, $meta?->updated_at));
        });

        $locationCities = Location::query()->where('status', true)->pluck('city')->filter()->unique();
        foreach ($locationCities as $city) {
            $meta = $staticMeta->get(SeoResolver::routeNameForCity($city));
            if (self::excluded($meta)) {
                continue;
            }
            $add('/locations/' . Str::slug($city), $meta?->updated_at);
        }

        return array_values($urls);
    }
}
