<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class SeoMeta extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'seo_meta';

    protected $guarded = [];

    protected $casts = [
        'related_links' => 'array',
    ];

    /** Fields the SEO panel keeps revisions of (and can restore). */
    public const REVISIONED_FIELDS = [
        'meta_title', 'meta_description', 'meta_keywords', 'focus_keyword',
        'skip_title_template', 'canonical_url', 'robots_index', 'robots_follow', 'h1_override',
        'og_title', 'og_description', 'og_type',
        'twitter_title', 'twitter_description',
        'schema_json', 'page_copy', 'related_links',
    ];

    function seoable()
    {
        return $this->morphTo();
    }

    public function cmsElements()
    {
        return $this->hasMany(CmsElement::class);
    }

    /**
     * Rows of one admin list group: 'pages', 'categories', 'campaigns' or
     * 'locations'. Locations have no detail page, only /locations/{city}, so
     * their SEO is keyed per city (SeoResolver::routeNameForCity).
     */
    public static function forGroup(string $group)
    {
        return match ($group) {
            'categories' => static::where('seoable_type', Category::class)->with('seoable')->get(),
            'campaigns' => static::where('seoable_type', Campaign::class)->with('seoable')->get(),
            'locations' => static::where('route_name', 'like', 'view.locations.city.%')->orderBy('route_name')->get(),
            default => static::whereNotNull('route_name')
                ->where('route_name', 'not like', 'view.locations.city.%')
                ->orderBy('route_name')
                ->get(),
        };
    }

    /** Public path of the page this row belongs to (e.g. "/media/ooh"), or null when it has none. */
    public function publicPath(): ?string
    {
        if ($this->route_name) {
            if (str_starts_with($this->route_name, 'view.locations.city.')) {
                return '/locations/' . substr($this->route_name, strlen('view.locations.city.'));
            }

            return Route::has($this->route_name) ? route($this->route_name, [], false) : null;
        }

        return match (true) {
            $this->seoable instanceof Category => '/' . $this->seoable->slug,
            $this->seoable instanceof Campaign => '/projects/' . $this->seoable->slug,
            default => null,
        };
    }

    /** H1 text as stored: no emphasis markers or trailing full stop; null when empty. */
    public static function normalizeH1(?string $h1): ?string
    {
        $h1 = rtrim(trim(str_replace('*', '', (string) $h1)), ". \t");

        return $h1 !== '' ? $h1 : null;
    }

    /** Human name for admin lists. */
    public function displayName(): string
    {
        if ($this->route_name) {
            return Str::headline(str_replace(['view.', 'locations.city.', '.'], ['', '', ' '], $this->route_name));
        }

        return (string) ($this->seoable->name ?? '-');
    }
}
