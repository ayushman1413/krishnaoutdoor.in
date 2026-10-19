<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MediaType;
use App\Enums\Permission;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Campaign;
use App\Models\Location;
use App\Models\SeoMeta;
use App\Models\SeoSetting;
use App\Services\LocationPageGate;

/**
 * Admin > SEO > Content TODOs: facts the site needs from the client before
 * the matching content can go live. Nothing here is shown on the public
 * site; each item says where to supply the data.
 */
class SeoTodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $admin = Admin::find(auth()->user()->id);
        if (!$admin->can(Permission::VIEW_SEO->value)) {
            return redirect()->back()->with('message', [
                'status' => 'warning',
                'title' => 'Unauthorized Access',
                'description' => 'You do not have access to this url',
            ]);
        }

        return view('admin.pages.seo.todo-list', ['groups' => $this->groups()]);
    }

    /**
     * @return array<string, array<int, array{todo: string, where: string}>>
     */
    private function groups(): array
    {
        $settings = SeoSetting::query()->first();
        $campaigns = Campaign::where('status', true)->get();
        $business = config('business.offices');

        $groups = [];

        // Campaign brands named for a keyword page that have no campaign yet.
        foreach (config('campaigns.keyword_pages') as $route => $brands) {
            $page = config('seo_pages')[$route]['path'] ?? $route;
            foreach ($brands as $brand) {
                if (!$campaigns->contains(fn (Campaign $c) => $c->matches($brand))) {
                    $groups['Campaigns we have run'][] = [
                        'todo' => "No campaign named \"{$brand}\" yet, so it is not listed on {$page}. Add it with its real photo and brief.",
                        'where' => 'Admin > Our Work > Add Campaign',
                    ];
                }
            }
        }

        foreach (['Ahmedabad', 'Mumbai'] as $city) {
            $count = $campaigns->where('media_type', 'social')->filter(fn ($c) => strtolower($c->city) === strtolower($city))->count();
            if ($count < 2) {
                $groups['Social media case studies'][] = [
                    'todo' => "Social media marketing {$city} needs at least 2 real case studies (has {$count}). Do not publish results the client has not confirmed.",
                    'where' => 'Admin > Our Work > Add Campaign, media type "Social Media", city ' . $city,
                ];
            }
        }

        $hoardings = Location::where('status', true)->whereRaw('LOWER(city) = ?', ['ahmedabad'])
            ->where('media_type', MediaType::BILLBOARD->value)->whereNotNull('area')->count();
        if ($hoardings === 0) {
            $groups['Hoarding and AMTS pages'][] = [
                'todo' => '/hoarding-advertising-ahmedabad has no "locations by area" list: add the Ahmedabad hoardings the client supplies (media type Billboard, city Ahmedabad, with area, size and photo). A map also needs coordinates for each site, which the site does not store yet.',
                'where' => 'Admin > Locations',
            ];
        }
        $amts = SeoMeta::where('route_name', 'view.keyword.amts.ahmedabad')->first();
        if (!filled($amts?->page_copy)) {
            $groups['Hoarding and AMTS pages'][] = [
                'todo' => '/amts-bus-advertising-ahmedabad names no routes or areas. Enter the routes/areas the client supplies (blank line between paragraphs).',
                'where' => 'Admin > SEO > Amts (Pages) > Page Copy',
            ];
        }

        // Location city pages: why each stays noindex.
        Location::where('status', true)->get()->groupBy('city')->each(function ($locations, $city) use (&$groups) {
            $meta = SeoMeta::where('route_name', \App\Services\SeoResolver::routeNameForCity($city))->first();
            $problems = LocationPageGate::problems($locations, $meta);
            if ($problems) {
                $groups['Location pages (kept noindex)'][] = [
                    'todo' => "/locations/" . \Illuminate\Support\Str::slug($city) . ' stays noindex and out of the sitemap: ' . implode('; ', $problems) . '. Needs real inventory (photo, area, size per site) and ~' . LocationPageGate::MIN_WORDS . ' words of unique copy.',
                    'where' => 'Admin > Locations and Admin > SEO > Locations > Page Copy',
                ];
            }
        });

        $groups['Business details'] = array_values(array_filter([
            empty($business['ahmedabad']['opening_hours']) ? ['todo' => 'Opening hours for the Ahmedabad office (needed for LocalBusiness schema).', 'where' => 'laravel/config/business.php'] : null,
            empty($business['mumbai']['opening_hours']) ? ['todo' => 'Opening hours for the Mumbai office (needed for LocalBusiness schema).', 'where' => 'laravel/config/business.php'] : null,
            empty($business['mumbai']['geo']) ? ['todo' => 'Mumbai office map pin (latitude/longitude). The /contact map embed is zoomed out and its centre is not the office.', 'where' => 'laravel/config/business.php'] : null,
            ['todo' => 'Confirm the WhatsApp numbers: Ahmedabad pages use +91 98796 16411 and Mumbai/Thane pages use +91 99200 11574 (the office phone numbers).', 'where' => 'Admin > SEO Settings > WhatsApp number (overrides the Ahmedabad one)'],
            ['todo' => 'Upload dates of the hero and showcase videos (VideoObject schema needs uploadDate).', 'where' => 'laravel/config/business.php > videos'],
        ]));

        if (!filled($settings?->gtm_id)) {
            $groups['Tracking'][] = ['todo' => 'GTM container ID is empty (GA4 is set). Events are sent to GA4 directly until a GTM ID is added.', 'where' => 'Admin > SEO Settings > GTM ID'];
        }
        if (!filled($settings?->ga4_id)) {
            $groups['Tracking'][] = ['todo' => 'GA4 measurement ID is empty, so no events are sent.', 'where' => 'Admin > SEO Settings > GA4 ID'];
        }

        $groups['Media facts'] = [
            ['todo' => 'Number, locations and sizes of the DOOH screens in Ahmedabad (/media/digital states no numbers until supplied).', 'where' => 'resources/views/web/pages/digital-media.blade.php'],
            ['todo' => 'List of Gujarat cities where hoardings, unipoles and gantries are available (/media/ooh only says "Ahmedabad and key cities across Gujarat").', 'where' => 'resources/views/web/pages/ooh-media.blade.php'],
            ['todo' => 'Confirm the booking terms stated in keyword-page FAQs (for example the one-month minimum for AMTS buses and the 3-4 week lead time for Mumbai local trains) are accurate.', 'where' => 'resources/views/web/pages/keywords/'],
        ];

        $groups['Photos'] = [
            ['todo' => 'A real TMT/Thane bus photo for the hero of /tmt-bus-advertising-thane (it still shows a BEST bus) and a higher-resolution version of the small TMT photo.', 'where' => 'resources/views/web/pages/keywords/tmt-bus-advertising-thane.blade.php'],
            ['todo' => 'A Jaipur/Rajasthan bus photo for the Rajasthan card on /our-network (it shows a neutral city backdrop).', 'where' => 'resources/views/web/pages/network.blade.php'],
            ['todo' => 'A photo of a real DOOH screen for /media/digital (it currently reuses a generic image).', 'where' => 'resources/views/web/pages/digital-media.blade.php'],
        ];

        return array_filter($groups);
    }
}
