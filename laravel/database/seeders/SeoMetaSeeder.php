<?php

namespace Database\Seeders;

use App\Enums\City;
use App\Models\SeoMeta;
use App\Models\SeoSetting;
use App\Services\SeoResolver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SeoMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Same values as the 2026_10_18_000001 data migration; see
        // config/seo_pages.php.
        foreach (config('seo_pages') as $routeName => $page) {
            SeoMeta::updateOrCreate(
                ['route_name' => $routeName],
                [
                    'meta_title' => $page['title'],
                    'meta_description' => $page['description'],
                    'skip_title_template' => true,
                ]
            );
        }

        // One SEO entry per city for /locations/{city} — Locations have no
        // individual detail page, so city is the only thing SEO can attach to.
        foreach (City::cases() as $city) {
            SeoMeta::updateOrCreate(
                ['route_name' => SeoResolver::routeNameForCity($city->value)],
                [
                    'meta_title' => $city->value . ' Locations',
                    'meta_description' => "Explore our available outdoor advertising media - billboards, bus branding, train media and more - across {$city->value}.",
                ]
            );
        }

        $organizationSchemaJson = '{"@context":"https://schema.org","@type":"Organization","name":"Krishna Outdoor","url":"https://krishnaoutdoor.in","logo":"https://krishnaoutdoor.in/assets/images/header-logo.webp","email":"info@krishnaoutdoor.in","telephone":"+91 98796 16411","foundingDate":"1985","areaServed":["Ahmedabad","Mumbai","Thane","Gujarat","Rajasthan"],"sameAs":["https://www.facebook.com/krishnaoutdoorofficial/","https://www.linkedin.com/company/krishnaoutdoor/","https://www.instagram.com/krishnaoutdoorofficial/"]}';

        $robotsTxtPath = public_path('robots.txt');
        $robotsTxt = File::exists($robotsTxtPath)
            ? File::get($robotsTxtPath)
            : "User-agent: *\nDisallow: /cgi-bin/\nSitemap: https://krishnaoutdoor.in/sitemap.xml\n";

        SeoSetting::firstOrCreate([], [
            'site_name' => 'Krishna Outdoor',
            'title_template' => '{page_title} | {site_name}',
            'organization_schema_json' => $organizationSchemaJson,
            'robots_txt' => $robotsTxt,
        ]);
    }
}
