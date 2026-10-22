<?php

namespace App\Services;

/**
 * Builds the page's JSON-LD as a single @graph:
 *
 *  - Organization  every page (SEO settings JSON box, else config/business.php)
 *  - WebSite       home page
 *  - LocalBusiness Ahmedabad and/or Mumbai office, by the page's region
 *                  (SEO settings JSON box per office, else config/business.php)
 *  - Service       pages with a 'service' entry in config/seo_pages.php
 *  - FAQPage       pages that render the web.common.faq partial, built from
 *                  the same questions and answers shown on the page
 *  - BreadcrumbList every page
 *  - VideoObject   pages that register a video (see addVideo())
 *
 * The per-page "Schema JSON" box in the SEO panel is still output as its
 * own script tag by seo-head.
 */
class SchemaBuilder
{
    /** @var array<int, array{question: string, answer: string}> */
    private static array $faqs = [];

    /** @var array<int, array> */
    private static array $videos = [];

    /** @var array<int, array{name: string, url: string}>|null */
    private static ?array $breadcrumbs = null;

    /**
     * Called by the web.common.faq partial while the page body renders,
     * which happens before the layout's <head> is rendered.
     */
    public static function addFaqs(array $faqs): void
    {
        foreach ($faqs as $faq) {
            self::$faqs[] = ['question' => $faq['q'], 'answer' => $faq['a']];
        }
    }

    public static function addVideo(string $key): void
    {
        $video = config('business.videos.' . $key);
        if ($video) {
            self::$videos[$key] = $video;
        }
    }

    /**
     * Breadcrumb trail for pages not listed in config/seo_pages.php
     * (categories, location cities), as [name, url] pairs after Home.
     */
    public static function setBreadcrumbs(array $trail): void
    {
        self::$breadcrumbs = $trail;
    }

    public static function base(): string
    {
        return rtrim((string) config('app.url'), '/');
    }

    public static function orgId(): string
    {
        return self::base() . '/#organization';
    }

    public static function organization(SeoResolver $seo): array
    {
        $custom = self::decode($seo->settings?->organization_schema_json);
        if ($custom) {
            return ['@id' => self::orgId()] + $custom;
        }

        $offices = config('business.offices');

        return [
            '@type' => 'Organization',
            '@id' => self::orgId(),
            'name' => $seo->settings?->site_name ?: 'Krishna Outdoor',
            'url' => self::base() . '/',
            'logo' => self::base() . '/assets/images/header-logo.webp',
            'email' => config('business.email'),
            'telephone' => $offices['ahmedabad']['phone'],
            'foundingDate' => '1985',
            'sameAs' => config('business.social'),
        ];
    }

    public static function localBusiness(SeoResolver $seo, string $key): array
    {
        $column = 'local_business_' . $key . '_json';
        $custom = self::decode($seo->settings?->{$column});
        $id = self::base() . '/#localbusiness-' . $key;
        if ($custom) {
            return ['@id' => $id] + $custom;
        }

        $office = config('business.offices.' . $key);

        $schema = [
            '@type' => 'LocalBusiness',
            '@id' => $id,
            'name' => $office['schema_name'],
            'url' => self::base() . '/contact',
            'image' => self::base() . '/assets/images/header-logo.webp',
            'logo' => self::base() . '/assets/images/header-logo.webp',
            'telephone' => $office['phone'],
            'email' => config('business.email'),
            'parentOrganization' => ['@id' => self::orgId()],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $office['street'],
                'addressLocality' => $office['locality'],
                'addressRegion' => $office['region'],
                'postalCode' => $office['postal_code'],
                'addressCountry' => 'IN',
            ],
            'areaServed' => self::places($office['area_served']),
            'hasMap' => $office['map_url'],
        ];

        if ($office['geo']) {
            $schema['geo'] = [
                '@type' => 'GeoCoordinates',
                'latitude' => $office['geo']['lat'],
                'longitude' => $office['geo']['lng'],
            ];
        }

        if ($office['opening_hours']) {
            $schema['openingHours'] = $office['opening_hours'];
        }

        return $schema;
    }

    /**
     * @return array<int, array> the @graph nodes for this page
     */
    public static function graph(SeoResolver $seo): array
    {
        $page = $seo->page();
        $graph = [self::organization($seo)];

        if ($seo->routeName === 'view.home') {
            $graph[] = [
                '@type' => 'WebSite',
                '@id' => self::base() . '/#website',
                'name' => $seo->settings?->site_name ?: 'Krishna Outdoor',
                'url' => self::base() . '/',
                'publisher' => ['@id' => self::orgId()],
                'inLanguage' => 'en-IN',
            ];
        }

        $region = $seo->region();
        if ($region === 'ahmedabad' || $region === 'both') {
            $graph[] = self::localBusiness($seo, 'ahmedabad');
        }
        if ($region === 'mumbai' || $region === 'both') {
            $graph[] = self::localBusiness($seo, 'mumbai');
        }

        if (!empty($page['service'])) {
            $graph[] = [
                '@type' => 'Service',
                '@id' => $seo->canonicalUrl . '#service',
                'name' => $page['service']['name'],
                'serviceType' => $page['service']['type'],
                'description' => $seo->description,
                'url' => $seo->canonicalUrl,
                'provider' => ['@id' => self::orgId()],
                'areaServed' => self::places($page['service']['area']),
            ];
        }

        if (self::$faqs) {
            $graph[] = [
                '@type' => 'FAQPage',
                '@id' => $seo->canonicalUrl . '#faq',
                'mainEntity' => array_map(fn ($faq) => [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
                ], self::$faqs),
            ];
        }

        foreach (self::$videos as $video) {
            $node = [
                '@type' => 'VideoObject',
                'name' => $video['name'],
                'description' => $video['description'],
                'thumbnailUrl' => self::base() . $video['thumbnail'],
                'contentUrl' => self::base() . $video['content'],
            ];
            if (!empty($video['upload_date'])) {
                $node['uploadDate'] = $video['upload_date'];
            }
            $graph[] = $node;
        }

        $graph[] = self::breadcrumbList($seo);

        return $graph;
    }

    public static function json(SeoResolver $seo): string
    {
        return json_encode(
            ['@context' => 'https://schema.org', '@graph' => self::graph($seo)],
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG
        );
    }

    /**
     * The breadcrumb trail for this page as [name, url] pairs, Home first.
     * Used for the BreadcrumbList schema and for the visible breadcrumb
     * (web.common.breadcrumbs), so the two always match.
     *
     * @return array<int, array{name: string, url: string}>
     */
    public static function trail(SeoResolver $seo): array
    {
        $trail = [];
        $pages = config('seo_pages');

        if ($seo->routeName && isset($pages[$seo->routeName])) {
            $route = $seo->routeName;
            while ($route !== null) {
                array_unshift($trail, [
                    'name' => $pages[$route]['label'],
                    'url' => SeoResolver::canonicalFor($pages[$route]['path']),
                ]);
                $route = $pages[$route]['parent'];
            }
        } else {
            $trail[] = ['name' => 'Home', 'url' => self::base() . '/'];
            foreach (self::$breadcrumbs ?? [] as $crumb) {
                $trail[] = $crumb;
            }
            if (self::$breadcrumbs === null) {
                $trail[] = ['name' => $seo->meta?->meta_title ?: $seo->pageTitle, 'url' => $seo->canonicalUrl];
            }
        }

        return $trail;
    }

    private static function breadcrumbList(SeoResolver $seo): array
    {
        $trail = self::trail($seo);

        return [
            '@type' => 'BreadcrumbList',
            '@id' => $seo->canonicalUrl . '#breadcrumb',
            'itemListElement' => array_map(fn ($crumb, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $crumb['name'],
                'item' => $crumb['url'],
            ], $trail, array_keys($trail)),
        ];
    }

    private static function places(array $names): array
    {
        $states = ['Gujarat', 'Maharashtra', 'Rajasthan'];

        return array_map(fn (string $name) => [
            '@type' => in_array($name, $states, true) ? 'State' : 'City',
            'name' => $name,
        ], $names);
    }

    private static function decode(?string $json): ?array
    {
        if (!$json) {
            return null;
        }
        $data = json_decode($json, true);
        if (!is_array($data)) {
            return null;
        }
        unset($data['@context']);

        return $data;
    }
}
