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
        $pages = [
            [
                'route_name' => 'view.home',
                'meta_title' => 'Outdoor Advertising Agency in Ahmedabad',
                'meta_description' => 'Outdoor advertising in Ahmedabad since 1985: 2000+ hoardings, AMTS and GSRTC bus ads, bus shelters and DOOH. Get a free site availability list today.',
            ],
            [
                'route_name' => 'view.about',
                'meta_title' => 'About Krishna Outdoor | OOH Advertising Since 1985',
                'meta_description' => 'Since 1985, Krishna Outdoor has built brand visibility with hoardings, bus and train advertising across Ahmedabad, Gujarat and Mumbai. Meet our team.',
                'skip_title_template' => true,
            ],
            [
                'route_name' => 'view.contact',
                'meta_title' => 'Contact Krishna Outdoor | Ahmedabad & Mumbai Office',
                'meta_description' => 'Get in touch for your next outdoor advertising campaign. Call, email, or visit our Ahmedabad or Mumbai office for a free site availability list.',
                'skip_title_template' => true,
            ],
            [
                'route_name' => 'view.careers',
                'meta_title' => 'Careers at Krishna Outdoor | Join Our OOH Team',
                'meta_description' => 'Explore career opportunities at Krishna Outdoor, a leading outdoor advertising company in Ahmedabad and Mumbai since 1985.',
                'skip_title_template' => true,
            ],
            [
                'route_name' => 'view.services',
                'meta_title' => 'Outdoor, Transit & Social Media Services',
                'meta_description' => 'Hoardings, AMTS and GSRTC bus ads, bus shelters, Mumbai local train and BEST bus branding, plus social media marketing in Ahmedabad and Mumbai.',
            ],
            [
                'route_name' => 'view.projects',
                'meta_title' => 'Our Outdoor Advertising Projects',
                'meta_description' => 'See our completed outdoor advertising projects: hoardings, video walls, bus shelters & train branding across Ahmedabad and Mumbai.',
            ],
            [
                'route_name' => 'view.network',
                'meta_title' => 'Outdoor Media Network: Gujarat, Mumbai, Thane & Jaipur',
                'meta_description' => 'See our network: 2000+ Gujarat hoardings, 7000+ GSRTC buses, AMTS, BEST and TMT buses and Mumbai local trains. Explore media availability today.',
                'skip_title_template' => true,
            ],
            [
                'route_name' => 'view.ooh.media',
                'meta_title' => 'OOH Media in Gujarat: Hoardings, Unipoles & Bus Shelters',
                'meta_description' => 'Explore 2000+ hoarding sites across Gujarat, 300+ own hoardings in Ahmedabad, 400+ backlit bus shelters, unipoles and gantries. Check availability.',
                'skip_title_template' => true,
            ],
            [
                'route_name' => 'view.transit.media',
                'meta_title' => 'Transit Advertising Agency in Mumbai | Bus & Train Ads',
                'meta_description' => 'Transit advertising agency for Mumbai local trains, BEST and TMT buses, plus GSRTC and AMTS buses in Gujarat. Rights on 7000+ buses. Enquire today.',
                'skip_title_template' => true,
            ],
            [
                'route_name' => 'view.digital.media',
                'meta_title' => 'DOOH Advertising Agency Ahmedabad | Digital Billboards',
                'meta_description' => 'Digital out-of-home (DOOH) advertising in Ahmedabad. Reach your audience with dynamic digital billboards and screens across prime city locations.',
                'skip_title_template' => true,
            ],
            [
                'route_name' => 'view.keyword.hoarding.ahmedabad',
                'meta_title' => 'Hoarding Advertising in Ahmedabad',
                'meta_description' => '300+ own hoardings and 2000+ hoarding sites across Ahmedabad and Gujarat. Frontlit, backlit, unipoles and gantries. Get a free site availability list.',
            ],
            [
                'route_name' => 'view.keyword.amts.ahmedabad',
                'meta_title' => 'AMTS Bus Advertising in Ahmedabad',
                'meta_description' => '900+ AMTS bus advertising rights across Ahmedabad. Full wrap, side panel and back panel formats on city buses. Get a free route availability list.',
            ],
            [
                'route_name' => 'view.keyword.bus.shelter.ahmedabad',
                'meta_title' => 'Bus Shelter Advertising in Ahmedabad',
                'meta_description' => '400+ backlit bus shelter advertising rights across Ahmedabad. Eye-level panels at bus stops where commuters wait and read. Get a free location list.',
            ],
            [
                'route_name' => 'view.keyword.gsrtc',
                'meta_title' => 'GSRTC Bus Advertising',
                'meta_description' => '7000+ GSRTC bus advertising rights across Gujarat. Reach every district of the state with full wrap and panel formats on state transport buses.',
            ],
            [
                'route_name' => 'view.keyword.agency.mumbai',
                'meta_title' => 'Outdoor Advertising Agency in Mumbai',
                'meta_description' => 'Krishna Outdoor is an outdoor advertising agency in Mumbai covering local trains, BEST EV buses and TMT buses in Thane. Visit our Andheri West office.',
            ],
            [
                'route_name' => 'view.keyword.local.train.mumbai',
                'meta_title' => 'Mumbai Local Train Advertising',
                'meta_description' => "Display rights on Mumbai local trains across Western and Central Railways. Exterior train branding reaching the city's largest daily commuter base.",
            ],
            [
                'route_name' => 'view.keyword.best.mumbai',
                'meta_title' => 'BEST Bus Advertising in Mumbai',
                'meta_description' => "400+ BEST EV full-wrap bus advertising rights in Mumbai. High-visibility electric bus wraps across Mumbai's BEST bus network.",
            ],
            [
                'route_name' => 'view.keyword.tmt.thane',
                'meta_title' => 'TMT Bus Advertising in Thane',
                'meta_description' => '350+ TMT bus advertising rights in Thane. Full and partial branding on Thane Municipal Transport buses across the greater Mumbai region.',
            ],
            [
                'route_name' => 'view.keyword.social.ahmedabad',
                'meta_title' => 'Social Media Marketing in Ahmedabad',
                'meta_description' => 'Social media marketing in Ahmedabad from Krishna Outdoor — strategy, content and paid social, built to pair with your outdoor advertising campaign.',
            ],
            [
                'route_name' => 'view.keyword.social.mumbai',
                'meta_title' => 'Social Media Marketing in Mumbai',
                'meta_description' => 'Social media marketing in Mumbai from Krishna Outdoor, built to pair with local train and BEST bus campaigns for a connected city-wide presence.',
            ],
        ];

        foreach ($pages as $page) {
            SeoMeta::updateOrCreate(
                ['route_name' => $page['route_name']],
                [
                    'meta_title' => $page['meta_title'],
                    'meta_description' => $page['meta_description'],
                    'skip_title_template' => $page['skip_title_template'] ?? false,
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
