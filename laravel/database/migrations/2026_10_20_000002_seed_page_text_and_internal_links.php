<?php

use App\Services\Cms\Cms;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Data migration: starting body text (1-2 paragraphs with internal links) and
 * related-page links for the static pages. Only fills fields that are still
 * empty, so anything an editor already wrote in Admin > Page Content is kept.
 * Re-running changes nothing.
 *
 * AMTS bus advertising gets links only: its body text is client-supplied
 * (routes and areas) and the SEO to-do list watches for it.
 */
return new class extends Migration
{
    public function up(): void
    {
        foreach ($this->pages() as $routeName => $page) {
            $meta = DB::table('seo_meta')->where('route_name', $routeName)->first();
            if (!$meta) {
                continue;
            }

            $update = [];
            if (!empty($page['copy']) && blank($meta->page_copy)) {
                $update['page_copy'] = Cms::pageCopyHtml($page['copy']);
            }
            if (!empty($page['links']) && blank($meta->related_links)) {
                $update['related_links'] = json_encode(
                    array_map(fn ($link) => ['label' => $link[0], 'url' => $link[1]], $page['links']),
                    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
                );
            }
            if ($update) {
                DB::table('seo_meta')->where('id', $meta->id)->update($update);
            }
        }
    }

    public function down(): void
    {
        //
    }

    private function pages(): array
    {
        return [
            'view.home' => [
                'copy' => <<<'HTML'
<p>Krishna Outdoor plans and books outdoor advertising for brands that want to be seen where people travel every day. Since 1985 the team has worked across <a href="/hoarding-advertising-ahmedabad">hoarding advertising in Ahmedabad</a>, <a href="/amts-bus-advertising-ahmedabad">AMTS</a> and <a href="/gsrtc-bus-advertising">GSRTC bus advertising</a> and <a href="/bus-shelter-advertising-ahmedabad">bus shelters</a>, and in Mumbai on <a href="/mumbai-local-train-advertising">local trains</a> and <a href="/best-bus-advertising-mumbai">BEST buses</a>.</p>
<p>Not sure which media suits your goal? Read how <a href="/media/ooh">outdoor</a>, <a href="/media/transit">transit</a> and <a href="/media/digital">digital out-of-home</a> advertising differ, look through our <a href="/projects">campaign case studies</a>, or <a href="/free-site-list">request a free site list</a> and we will send available sites with photos, sizes and rates.</p>
HTML,
                'links' => [['Media solutions', '/services'], ['Our network', '/our-network'], ['Campaign case studies', '/projects'], ['Free site list', '/free-site-list']],
            ],
            'view.about' => [
                'copy' => <<<'HTML'
<p>Krishna Outdoor has worked in outdoor advertising since 1985 for brands in Ahmedabad, Gujarat and Mumbai. Owning hoardings and holding rights on city and state buses lets us plan campaigns around real, verifiable locations instead of a generic listing.</p>
<p>To see what that looks like in practice, browse the <a href="/services">media solutions</a> we offer, check the cities in <a href="/our-network">our network</a>, read our <a href="/projects">campaign case studies</a>, or see the <a href="/careers">open roles</a> if you would like to join the team.</p>
HTML,
                'links' => [['Media solutions', '/services'], ['Our network', '/our-network'], ['Careers', '/careers'], ['Contact us', '/contact']],
            ],
            'view.contact' => [
                'copy' => <<<'HTML'
<p>Krishna Outdoor has offices in Ahmedabad and Mumbai, so an enquiry for Gujarat and one for Mumbai or Thane reach the team that works those markets. Tell us your city, the media you are considering and your timeline, and we will reply with options.</p>
<p>If you would rather start with availability, <a href="/free-site-list">ask for the free site list</a>. To prepare for the conversation, read about <a href="/hoarding-advertising-ahmedabad">hoarding advertising in Ahmedabad</a> or <a href="/outdoor-advertising-agency-mumbai">outdoor advertising in Mumbai</a> first.</p>
HTML,
                'links' => [['Free site list', '/free-site-list'], ['Hoarding advertising in Ahmedabad', '/hoarding-advertising-ahmedabad'], ['Outdoor advertising in Mumbai', '/outdoor-advertising-agency-mumbai']],
            ],
            'view.services' => [
                'copy' => <<<'HTML'
<p>Outdoor advertising covers fixed sites such as hoardings and bus shelters, while transit advertising moves with buses and trains, and each suits a different goal. Our <a href="/media/ooh">OOH media</a> puts a brand in fixed, high-traffic spots, <a href="/media/transit">transit media</a> repeats the message along commuter routes, and <a href="/media/digital">digital out-of-home</a> adds screens whose creative can change quickly.</p>
<p>Campaigns can also be paired with <a href="/social-media-marketing-ahmedabad">social media marketing in Ahmedabad</a> or <a href="/social-media-marketing-mumbai">in Mumbai</a>, so the street and the feed carry the same message. Explore <a href="/our-network">our network</a> to see where each format is available.</p>
HTML,
                'links' => [['OOH media', '/media/ooh'], ['Transit media', '/media/transit'], ['Digital out-of-home', '/media/digital'], ['Free site list', '/free-site-list']],
            ],
            'view.ooh.media' => [
                'copy' => <<<'HTML'
<p>Outdoor media gives a brand a fixed presence in a spot that thousands of people pass every day. In Gujarat that means hoardings, unipoles and gantries on busy roads, and backlit bus shelters where commuters wait. Compare the formats on our pages for <a href="/hoarding-advertising-ahmedabad">hoarding advertising in Ahmedabad</a> and <a href="/bus-shelter-advertising-ahmedabad">bus shelter advertising in Ahmedabad</a>.</p>
<p>If you want the message to travel as well, combine fixed sites with <a href="/media/transit">transit advertising</a> such as <a href="/amts-bus-advertising-ahmedabad">AMTS buses</a> or <a href="/gsrtc-bus-advertising">GSRTC buses</a>. Not sure where to start? <a href="/free-site-list">Get the free site list</a>.</p>
HTML,
                'links' => [['Hoarding advertising in Ahmedabad', '/hoarding-advertising-ahmedabad'], ['Bus shelter advertising in Ahmedabad', '/bus-shelter-advertising-ahmedabad'], ['Transit media', '/media/transit'], ['Digital out-of-home', '/media/digital']],
            ],
            'view.transit.media' => [
                'copy' => <<<'HTML'
<p>Transit advertising puts a brand on the vehicles people ride or follow every day, so one booking reaches many neighbourhoods. Krishna Outdoor handles buses in Gujarat, with <a href="/amts-bus-advertising-ahmedabad">AMTS</a> in Ahmedabad and <a href="/gsrtc-bus-advertising">GSRTC</a> across the state, and in Mumbai and Thane with <a href="/best-bus-advertising-mumbai">BEST buses</a>, <a href="/tmt-bus-advertising-thane">TMT buses</a> and <a href="/mumbai-local-train-advertising">Mumbai local trains</a>.</p>
<p>Transit works best when paired with fixed sites on the same routes. See <a href="/media/ooh">OOH media in Gujarat</a> for hoardings and bus shelters, and <a href="/projects">our campaign case studies</a> for transit work we have delivered.</p>
HTML,
                'links' => [['AMTS bus advertising', '/amts-bus-advertising-ahmedabad'], ['GSRTC bus advertising', '/gsrtc-bus-advertising'], ['BEST bus advertising in Mumbai', '/best-bus-advertising-mumbai'], ['Mumbai local train advertising', '/mumbai-local-train-advertising']],
            ],
            'view.digital.media' => [
                'copy' => <<<'HTML'
<p>Digital out-of-home lets you run different creatives, schedule them by time of day and change them without reprinting. It suits launches, offers and short bursts of activity where a printed hoarding would be too slow to update.</p>
<p>Many brands use DOOH alongside fixed sites. Compare it with <a href="/hoarding-advertising-ahmedabad">hoarding advertising in Ahmedabad</a>, read about <a href="/media/ooh">OOH media</a> more broadly, or <a href="/free-site-list">ask for the free site list</a> to see which screens are available.</p>
HTML,
                'links' => [['OOH media', '/media/ooh'], ['Hoarding advertising in Ahmedabad', '/hoarding-advertising-ahmedabad'], ['Free site list', '/free-site-list']],
            ],
            'view.network' => [
                'copy' => <<<'HTML'
<p>Our network spans Gujarat, Mumbai, Thane and Jaipur, with fixed sites and transit media in the markets where Krishna Outdoor works. Start with the city you want: <a href="/hoarding-advertising-ahmedabad">Ahmedabad hoardings</a>, <a href="/outdoor-advertising-agency-mumbai">outdoor advertising in Mumbai</a> or <a href="/tmt-bus-advertising-thane">Thane buses</a>.</p>
<p>Statewide reach comes from <a href="/gsrtc-bus-advertising">GSRTC buses</a>, and the <a href="/free-site-list">free site list</a> shows which sites are open in each city today.</p>
HTML,
                'links' => [['OOH media', '/media/ooh'], ['Transit media', '/media/transit'], ['Outdoor advertising in Mumbai', '/outdoor-advertising-agency-mumbai'], ['Free site list', '/free-site-list']],
            ],
            'view.projects' => [
                'copy' => <<<'HTML'
<p>Every campaign here started with a goal: local visibility, repeated commuter exposure or scale across a city. The case studies show which media were chosen and why, so you can compare them with your own plan.</p>
<p>To see the formats behind these campaigns, read about <a href="/hoarding-advertising-ahmedabad">hoarding advertising in Ahmedabad</a>, <a href="/best-bus-advertising-mumbai">BEST bus advertising in Mumbai</a> and <a href="/mumbai-local-train-advertising">Mumbai local train advertising</a>, or <a href="/contact">contact us</a> to plan something similar.</p>
HTML,
                'links' => [['OOH media', '/media/ooh'], ['Transit media', '/media/transit'], ['Contact us', '/contact']],
            ],
            'view.careers' => [
                'copy' => <<<'HTML'
<p>Krishna Outdoor works across outdoor, transit, print, electronic and digital media, so the team learns how one campaign moves across formats. If you enjoy planning, sales, operations or creative work around real places and people, we would like to hear from you.</p>
<p>Get to know the business first on the <a href="/about">About</a> page and our <a href="/services">media solutions</a>, or see the work you could be part of in <a href="/projects">our campaign case studies</a>.</p>
HTML,
                'links' => [['About Krishna Outdoor', '/about'], ['Media solutions', '/services'], ['Campaign case studies', '/projects']],
            ],
            'view.keyword.hoarding.ahmedabad' => [
                'copy' => <<<'HTML'
<p>Hoardings suit brands that want a large, fixed message on a busy road. With 300+ own hoardings in Ahmedabad and access to 2000+ sites across Gujarat, Krishna Outdoor can match a site to your audience and budget instead of offering a generic list.</p>
<p>Hoardings also pair well with moving media: add <a href="/amts-bus-advertising-ahmedabad">AMTS bus advertising</a> to cover more of the city, or <a href="/bus-shelter-advertising-ahmedabad">bus shelters</a> for eye-level visibility. See <a href="/media/ooh">all OOH media in Gujarat</a> or <a href="/free-site-list">request the free site list</a>.</p>
HTML,
                'links' => [['AMTS bus advertising', '/amts-bus-advertising-ahmedabad'], ['Bus shelter advertising in Ahmedabad', '/bus-shelter-advertising-ahmedabad'], ['OOH media in Gujarat', '/media/ooh']],
            ],
            // Body text of the AMTS page is client-supplied (routes and areas); links only.
            'view.keyword.amts.ahmedabad' => [
                'links' => [['Hoarding advertising in Ahmedabad', '/hoarding-advertising-ahmedabad'], ['Bus shelter advertising in Ahmedabad', '/bus-shelter-advertising-ahmedabad'], ['GSRTC bus advertising', '/gsrtc-bus-advertising'], ['Transit media', '/media/transit']],
            ],
            'view.keyword.bus.shelter.ahmedabad' => [
                'copy' => <<<'HTML'
<p>A bus shelter puts your message at eye level, where commuters wait with time to read it. Krishna Outdoor offers 400+ backlit shelters in Ahmedabad, so the ad stays visible after dark.</p>
<p>For wider coverage, combine shelters with <a href="/hoarding-advertising-ahmedabad">hoardings</a> on the same corridors or with <a href="/amts-bus-advertising-ahmedabad">AMTS buses</a> that travel the city's routes. All fixed formats are listed under <a href="/media/ooh">OOH media</a>.</p>
HTML,
                'links' => [['Hoarding advertising in Ahmedabad', '/hoarding-advertising-ahmedabad'], ['AMTS bus advertising', '/amts-bus-advertising-ahmedabad'], ['OOH media in Gujarat', '/media/ooh']],
            ],
            'view.keyword.gsrtc' => [
                'copy' => <<<'HTML'
<p>GSRTC buses reach every district of Gujarat, which makes them a good fit for brands that need statewide reach rather than a single city. Krishna Outdoor holds rights on 7000+ buses.</p>
<p>For city-level reach inside Ahmedabad, add <a href="/amts-bus-advertising-ahmedabad">AMTS buses</a> or <a href="/hoarding-advertising-ahmedabad">hoardings</a>. See the full range under <a href="/media/transit">transit media</a> or check <a href="/our-network">our network</a>.</p>
HTML,
                'links' => [['AMTS bus advertising', '/amts-bus-advertising-ahmedabad'], ['Transit media', '/media/transit'], ['Our network', '/our-network']],
            ],
            'view.keyword.agency.mumbai' => [
                'copy' => <<<'HTML'
<p>Krishna Outdoor has a Mumbai office that plans outdoor and transit campaigns for the city and for Thane. The most requested formats are <a href="/mumbai-local-train-advertising">Mumbai local train advertising</a> and <a href="/best-bus-advertising-mumbai">BEST bus advertising</a>, with <a href="/tmt-bus-advertising-thane">TMT buses</a> for Thane.</p>
<p>If you also want online support for a launch, see <a href="/social-media-marketing-mumbai">social media marketing in Mumbai</a>, or learn how we work across cities on <a href="/media/transit">transit media</a>.</p>
HTML,
                'links' => [['Mumbai local train advertising', '/mumbai-local-train-advertising'], ['BEST bus advertising in Mumbai', '/best-bus-advertising-mumbai'], ['TMT bus advertising in Thane', '/tmt-bus-advertising-thane']],
            ],
            'view.keyword.local.train.mumbai' => [
                'copy' => <<<'HTML'
<p>Local trains carry Mumbai commuters on the Western and Central Railway lines every day, so exterior branding is seen repeatedly by the same audience. Pair it with road-level visibility from <a href="/best-bus-advertising-mumbai">BEST buses</a> to cover the commute at both ends.</p>
<p>Planning for Thane too? See <a href="/tmt-bus-advertising-thane">TMT bus advertising</a>, or read the overview of <a href="/outdoor-advertising-agency-mumbai">outdoor advertising in Mumbai</a>.</p>
HTML,
                'links' => [['BEST bus advertising in Mumbai', '/best-bus-advertising-mumbai'], ['TMT bus advertising in Thane', '/tmt-bus-advertising-thane'], ['Outdoor advertising in Mumbai', '/outdoor-advertising-agency-mumbai']],
            ],
            'view.keyword.best.mumbai' => [
                'copy' => <<<'HTML'
<p>BEST buses run Mumbai's busy city routes, and a full-wrap EV bus carries your brand through many neighbourhoods in a day. Krishna Outdoor has rights on 400+ BEST EV buses.</p>
<p>Extend the campaign to Thane with <a href="/tmt-bus-advertising-thane">TMT buses</a> or to the rail network with <a href="/mumbai-local-train-advertising">Mumbai local train advertising</a>. More options are under <a href="/media/transit">transit media</a>.</p>
HTML,
                'links' => [['Mumbai local train advertising', '/mumbai-local-train-advertising'], ['TMT bus advertising in Thane', '/tmt-bus-advertising-thane'], ['Transit media', '/media/transit']],
            ],
            'view.keyword.tmt.thane' => [
                'copy' => <<<'HTML'
<p>TMT buses serve Thane and the routes linking it with the wider Mumbai region, putting your brand in front of daily commuters. Krishna Outdoor has rights on 350+ city buses, with full and partial branding.</p>
<p>Many brands combine Thane with Mumbai: look at <a href="/best-bus-advertising-mumbai">BEST bus advertising</a> and <a href="/mumbai-local-train-advertising">Mumbai local train advertising</a>, or read about our <a href="/outdoor-advertising-agency-mumbai">Mumbai office and services</a>.</p>
HTML,
                'links' => [['BEST bus advertising in Mumbai', '/best-bus-advertising-mumbai'], ['Mumbai local train advertising', '/mumbai-local-train-advertising'], ['Transit media', '/media/transit']],
            ],
            'view.keyword.social.ahmedabad' => [
                'copy' => <<<'HTML'
<p>Social media works best when it supports what people see on the street. For Ahmedabad campaigns we link content and paid ads on Instagram, Facebook and LinkedIn to your outdoor activity, such as a <a href="/hoarding-advertising-ahmedabad">hoarding campaign</a> or <a href="/amts-bus-advertising-ahmedabad">AMTS bus branding</a>.</p>
<p>See how all our media fit together on the <a href="/services">services</a> page, or <a href="/contact">talk to us</a> about a combined plan.</p>
HTML,
                'links' => [['Hoarding advertising in Ahmedabad', '/hoarding-advertising-ahmedabad'], ['AMTS bus advertising', '/amts-bus-advertising-ahmedabad'], ['Media solutions', '/services']],
            ],
            'view.keyword.social.mumbai' => [
                'copy' => <<<'HTML'
<p>Social media works best when it supports what people see on the street. For Mumbai campaigns we link content and paid ads to your outdoor activity, such as <a href="/mumbai-local-train-advertising">local train branding</a> or <a href="/best-bus-advertising-mumbai">BEST bus wraps</a>.</p>
<p>Read about <a href="/outdoor-advertising-agency-mumbai">outdoor advertising in Mumbai</a>, see all <a href="/services">media solutions</a>, or <a href="/contact">talk to us</a> about a combined plan.</p>
HTML,
                'links' => [['Mumbai local train advertising', '/mumbai-local-train-advertising'], ['BEST bus advertising in Mumbai', '/best-bus-advertising-mumbai'], ['Media solutions', '/services']],
            ],
            'view.free.site.list' => [
                'copy' => <<<'HTML'
<p>The site list is free and carries no obligation. Tell us the city and media type and the team replies with available sites, photos, sizes and rates. If you want to understand the options first, read about <a href="/media/ooh">OOH media</a>, <a href="/media/transit">transit media</a> or <a href="/media/digital">digital out-of-home</a>.</p>
HTML,
                'links' => [['OOH media', '/media/ooh'], ['Transit media', '/media/transit'], ['Contact us', '/contact']],
            ],
        ];
    }
};
