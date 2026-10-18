<?php

namespace App\Services;

use App\Models\SeoMeta;
use App\Models\SeoSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Resolves the effective SEO values for a static route or a DB-backed
 * model, applying the global settings fallback described in
 * SEO-ADMIN-PANEL-REQUIREMENTS.md section 2 ("if a field is empty, use
 * the meta title, meta description and featured image").
 */
class SeoResolver
{
    public ?SeoMeta $meta;
    public ?SeoSetting $settings;
    public string $pageTitle = '';
    public string $description = '';
    public string $canonicalUrl = '';

    private function __construct(?SeoMeta $meta, string $fallbackTitle = '', string $fallbackDescription = '')
    {
        $this->meta = $meta;
        $this->settings = SeoSetting::query()->first();

        $rawTitle = $meta?->meta_title ?: $fallbackTitle;
        $this->pageTitle = ($meta?->skip_title_template ?? false)
            ? $rawTitle
            : $this->applyTitleTemplate($rawTitle);
        $this->description = $meta?->meta_description ?: $fallbackDescription;
        $this->canonicalUrl = $meta?->canonical_url ?: url()->current();
    }

    public static function forRoute(string $routeName, string $fallbackTitle = '', string $fallbackDescription = ''): self
    {
        $meta = SeoMeta::query()->where('route_name', $routeName)->first();
        return new self($meta, $fallbackTitle, $fallbackDescription);
    }

    public static function forModel(Model $model, string $fallbackTitle = '', string $fallbackDescription = ''): self
    {
        $meta = method_exists($model, 'seo') ? $model->seo : null;
        return new self($meta, $fallbackTitle, $fallbackDescription);
    }

    /**
     * The route_name key used for a Location city's /locations/{city} page.
     * Locations have no individual detail page — only this city-grouped
     * listing is ever rendered — so city is the only thing SEO can
     * meaningfully attach to. Shared by LocationController, SeoController's
     * sitemap, the admin SEO list/export, and SeoMetaSeeder so the key is
     * derived identically everywhere.
     */
    public static function routeNameForCity(string $city): string
    {
        return 'view.locations.city.' . Str::slug($city);
    }

    private function applyTitleTemplate(string $title): string
    {
        if ($title === '') {
            return $this->settings?->site_name ?? 'Krishna Outdoor';
        }

        $template = $this->settings?->title_template ?: '{page_title} | {site_name}';
        $siteName = $this->settings?->site_name ?? 'Krishna Outdoor';

        return str_replace(
            ['{page_title}', '{site_name}'],
            [$title, $siteName],
            $template
        );
    }

    public function robotsContent(): string
    {
        $index = ($this->meta?->robots_index ?? true) ? 'index' : 'noindex';
        $follow = ($this->meta?->robots_follow ?? true) ? 'follow' : 'nofollow';
        return "{$index},{$follow},max-image-preview:large,max-snippet:-1,max-video-preview:-1";
    }

    public function ogTitle(): string
    {
        return $this->meta?->og_title ?: $this->pageTitle;
    }

    public function ogDescription(): string
    {
        return $this->meta?->og_description ?: $this->description;
    }

    public function ogImage(): ?string
    {
        return $this->meta?->og_image ?: $this->settings?->default_og_image;
    }

    public function ogType(): string
    {
        return $this->meta?->og_type ?: 'website';
    }

    public function twitterCard(): string
    {
        return $this->meta?->twitter_card ?: 'summary_large_image';
    }

    public function twitterTitle(): string
    {
        return $this->meta?->twitter_title ?: $this->ogTitle();
    }

    public function twitterDescription(): string
    {
        return $this->meta?->twitter_description ?: $this->ogDescription();
    }

    public function twitterImage(): ?string
    {
        return $this->meta?->twitter_image ?: $this->ogImage();
    }

    public function h1Override(): ?string
    {
        return $this->meta?->h1_override;
    }

    public function schemaJson(): ?string
    {
        return $this->meta?->schema_json;
    }

    public function organizationSchemaJson(): ?string
    {
        return $this->settings?->organization_schema_json;
    }

    /**
     * Site-wide WebSite schema (added for SEO remediation — the audit flagged this
     * as missing entirely). No SearchAction, since the site has no on-site search.
     */
    public function websiteSchemaJson(): ?string
    {
        $siteName = $this->settings?->site_name ?? 'Krishna Outdoor';

        return json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $siteName,
            'url' => url('/'),
        ]);
    }

    /**
     * Automatic Service schema for a Category/Location-backed page (PDF §3:
     * "automatic schema for ... pages"). Returns null for static pages, which
     * rely on the manual JSON-LD box instead.
     */
    public function serviceSchemaJson(): ?string
    {
        $seoable = $this->meta?->seoable;
        if (!$seoable) {
            return null;
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $this->ogTitle(),
            'url' => $this->canonicalUrl,
            'provider' => [
                '@type' => 'Organization',
                'name' => $this->settings?->site_name ?? 'Krishna Outdoor',
            ],
        ];

        if ($this->description !== '') {
            $schema['description'] = $this->description;
        }

        if ($seoable instanceof \App\Models\Location && $seoable->city) {
            $schema['areaServed'] = $seoable->city;
        }

        return json_encode($schema);
    }
}
