<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
use App\Models\SeoMeta;
use App\Models\SeoSetting;
use App\Services\SeoResolver;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Dynamic sitemap.xml, built from every seo_meta row not excluded,
     * plus live category/location slugs.
     */
    public function sitemap(): Response
    {
        $urls = [];

        $routeMap = [
            'view.home' => '/',
            'view.about' => '/about',
            'view.contact' => '/contact',
            'view.careers' => '/careers',
            'view.services' => '/services',
            'view.projects' => '/projects',
            'view.network' => '/our-network',
            'view.ooh.media' => '/media/ooh',
            'view.transit.media' => '/media/transit',
            'view.digital.media' => '/media/digital',
            'view.keyword.hoarding.ahmedabad' => '/hoarding-advertising-ahmedabad',
            'view.keyword.amts.ahmedabad' => '/amts-bus-advertising-ahmedabad',
            'view.keyword.bus.shelter.ahmedabad' => '/bus-shelter-advertising-ahmedabad',
            'view.keyword.gsrtc' => '/gsrtc-bus-advertising',
            'view.keyword.agency.mumbai' => '/outdoor-advertising-agency-mumbai',
            'view.keyword.local.train.mumbai' => '/mumbai-local-train-advertising',
            'view.keyword.best.mumbai' => '/best-bus-advertising-mumbai',
            'view.keyword.tmt.thane' => '/tmt-bus-advertising-thane',
            'view.keyword.social.ahmedabad' => '/social-media-marketing-ahmedabad',
            'view.keyword.social.mumbai' => '/social-media-marketing-mumbai',
        ];

        $staticMeta = SeoMeta::query()
            ->whereNotNull('route_name')
            ->where('exclude_from_sitemap', false)
            ->get()
            ->keyBy('route_name');

        foreach ($routeMap as $routeName => $path) {
            $meta = $staticMeta->get($routeName);
            if ($meta !== null && $meta->exclude_from_sitemap) {
                continue;
            }
            $urls[] = [
                'loc' => url($path),
                'lastmod' => $meta?->updated_at?->toAtomString() ?? now()->toAtomString(),
            ];
        }

        $categoryMeta = SeoMeta::query()
            ->where('seoable_type', Category::class)
            ->where('exclude_from_sitemap', false)
            ->get()
            ->keyBy('seoable_id');

        Category::query()->where('status', true)->get()->each(function (Category $category) use (&$urls, $categoryMeta) {
            if ($categoryMeta->has($category->id) && $categoryMeta->get($category->id)->exclude_from_sitemap) {
                return;
            }
            $urls[] = [
                'loc' => url('/' . $category->slug),
                'lastmod' => $category->updated_at?->toAtomString() ?? now()->toAtomString(),
            ];
        });

        $locationCities = Location::query()->where('status', true)->pluck('city')->unique();
        $cityMeta = SeoMeta::query()
            ->where('route_name', 'like', 'view.locations.city.%')
            ->get()
            ->keyBy('route_name');

        foreach ($locationCities as $city) {
            $meta = $cityMeta->get(SeoResolver::routeNameForCity($city));
            if ($meta !== null && $meta->exclude_from_sitemap) {
                continue;
            }
            $urls[] = [
                'loc' => url('/locations/' . \Illuminate\Support\Str::slug($city)),
                'lastmod' => $meta?->updated_at?->toAtomString() ?? now()->toAtomString(),
            ];
        }

        $xml = view('web.common.sitemap-xml', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * Dynamic robots.txt, editable from the SEO admin panel.
     */
    public function robots(): Response
    {
        $settings = SeoSetting::query()->first();

        $content = $settings?->robots_txt ?: (
            "User-agent: *\n" .
            "Disallow: /cgi-bin/\n" .
            "Sitemap: " . url('/sitemap.xml') . "\n"
        );

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
