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
    public ?string $routeName = null;
    public string $pageTitle = '';
    public string $description = '';
    public string $canonicalUrl = '';
    private ?string $featuredImage = null;
    private bool $forceNoindex = false;

    private function __construct(?SeoMeta $meta, string $fallbackTitle = '', string $fallbackDescription = '', ?string $routeName = null, ?string $featuredImage = null)
    {
        $this->meta = $meta;
        $this->settings = SeoSetting::query()->first();
        $this->routeName = $routeName;
        $this->featuredImage = $featuredImage;

        $rawTitle = trim((string) ($meta?->meta_title ?: $fallbackTitle));
        $this->pageTitle = ($meta?->skip_title_template ?? false) && $rawTitle !== ''
            ? $rawTitle
            : $this->applyTitleTemplate($rawTitle);
        $this->description = trim((string) ($meta?->meta_description ?: $fallbackDescription));
        $this->canonicalUrl = $meta?->canonical_url ?: self::canonicalFor(request()->path());
    }

    public static function forRoute(string $routeName, string $fallbackTitle = '', string $fallbackDescription = ''): self
    {
        $meta = SeoMeta::query()->where('route_name', $routeName)->first();
        return new self($meta, $fallbackTitle, $fallbackDescription, $routeName);
    }

    public static function forModel(Model $model, string $fallbackTitle = '', string $fallbackDescription = '', ?string $featuredImage = null): self
    {
        $meta = method_exists($model, 'seo') ? $model->seo : null;
        return new self($meta, $fallbackTitle, $fallbackDescription, null, $featuredImage);
    }

    /**
     * Canonical https://krishnaoutdoor.in/... URL for a request path, built
     * from APP_URL rather than the incoming request so http://, www. or
     * query-string variants never leak into canonicals or the sitemap.
     */
    public static function canonicalFor(string $path): string
    {
        $base = rtrim((string) config('app.url'), '/');
        $path = trim($path, '/');

        return $path === '' ? $base . '/' : $base . '/' . $path;
    }

    /**
     * This page's entry in config/seo_pages.php (breadcrumb, region,
     * service), or [] for DB-backed pages.
     */
    public function page(): array
    {
        // Route names contain dots, so no config('seo_pages.<route>') lookup.
        return $this->routeName ? (config('seo_pages')[$this->routeName] ?? []) : [];
    }

    public function region(): ?string
    {
        return $this->page()['region'] ?? null;
    }

    /**
     * The office whose phone number this page should show (header call
     * link, chat "Call us"): Mumbai for Mumbai/Thane pages, otherwise the
     * Ahmedabad head office.
     */
    public static function officeFor(?self $seo): array
    {
        return config('business.offices.' . self::officeKeyFor($seo));
    }

    /**
     * 'mumbai' for Mumbai/Thane pages, otherwise 'ahmedabad'. A page can name
     * its office explicitly with 'office' in config/seo_pages.php (e.g.
     * /media/transit, whose schema covers both offices but whose enquiries
     * go to Mumbai).
     */
    public static function officeKeyFor(?self $seo): string
    {
        $page = $seo?->page() ?? [];
        return ($page['office'] ?? $seo?->region()) === 'mumbai' ? 'mumbai' : 'ahmedabad';
    }

    /**
     * wa.me link for this page's office: the Mumbai number on Mumbai/Thane
     * pages, otherwise the Ahmedabad number. The office phone numbers double
     * as WhatsApp numbers; a WhatsApp number saved in SEO settings overrides
     * the Ahmedabad one only. $text pre-fills the message.
     */
    public static function whatsappUrl(?self $seo, ?SeoSetting $settings = null, ?string $text = null, ?string $officeKey = null): string
    {
        $officeKey ??= self::officeKeyFor($seo);
        $digits = preg_replace('/\D+/', '', (string) config('business.offices.' . $officeKey . '.phone'));
        if ($officeKey === 'ahmedabad') {
            $override = preg_replace('/\D+/', '', (string) $settings?->whatsapp_number);
            $digits = $override !== '' ? $override : $digits;
        }

        return 'https://wa.me/' . $digits . ($text ? '?text=' . rawurlencode($text) : '');
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

    /** Page-level override: noindex whatever the SEO panel says. */
    public function forceNoindex(): static
    {
        $this->forceNoindex = true;

        return $this;
    }

    public function robotsContent(): string
    {
        $index = ($this->meta?->robots_index ?? true) && !$this->forceNoindex ? 'index' : 'noindex';
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

    /**
     * OG image as an absolute URL: page OG image, then the page's featured
     * image, then the site default OG image from SEO settings.
     */
    public function ogImage(): ?string
    {
        return self::imageUrl($this->meta?->og_image)
            ?? self::imageUrl($this->featuredImage)
            ?? self::imageUrl($this->settings?->default_og_image);
    }

    /**
     * Uploads (og_image, default_og_image, category images) are stored as
     * paths on the public disk, i.e. served from /storage/...; full URLs
     * and /assets/... paths are passed through.
     */
    public static function imageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }
        if (preg_match('#^https?://#', $path)) {
            return $path;
        }
        if (str_starts_with($path, '/')) {
            return url($path);
        }
        return asset('storage/' . $path);
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
        return self::imageUrl($this->meta?->twitter_image) ?? $this->ogImage();
    }

    public function h1Override(): ?string
    {
        return $this->meta?->h1_override;
    }

    public function schemaJson(): ?string
    {
        return $this->meta?->schema_json;
    }
}
