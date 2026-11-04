@extends('web.layouts.app')

@section('css-bundle', 'keyword')

@section('body-class', 'inner-page')
@section('nav', 'services')

@section('web-head')
@include('web.common.keyword-page-style')
@endsection

@section('web-section')
<main>

<section class="hero media-detail-hero media-detail-hero-ooh" id="home">
    <div class="media-detail-hero-bg">
        <img fetchpriority="high" srcset="{{ asset('assets/images/ooh/ahmedabad-hoarding-hero-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-hoarding-hero.webp') }} 1596w" sizes="100vw" alt="Krishna Outdoor hoarding advertising on a main road in Ahmedabad" decoding="async" loading="eager" src="{{ asset('assets/images/ooh/ahmedabad-hoarding-hero.webp') }}"/>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-grid"></div>
    <div class="hero-noise"></div>
    <div class="container hero-inner reveal">
        <h1>
        @if ($seo->h1Override())
            {{ $seo->h1Override() }}
        @else
            HOARDING ADVERTISING<br/><em>IN AHMEDABAD</em>
        @endif
        </h1>
    </div>
</section>

<section class="kw-section"><div class="kw-inner">
    @include('web.common.breadcrumbs', ['seo' => $seo, 'class' => 'kw-crumbs'])
    <p class="kw-lead">Hoarding advertising in Ahmedabad means renting a large billboard on a busy road or junction to show your brand for a fixed period, usually one month or more. <a href="{{ route('view.home') }}">Krishna Outdoor</a>, an outdoor advertising agency in Ahmedabad since 1985, owns 300+ hoardings in the city and offers 2000+ sites across Gujarat in frontlit, backlit, unipole and gantry formats.</p>
    <p class="kw-p">Ask for our <a href="{{ route('view.free.site.list', ['media' => 'hoardings', 'city' => 'Ahmedabad']) }}">free hoarding site list</a> to see available hoardings with photos, sizes and rates, usually within one business day.</p>
    <div class="kw-cta-row">
        <a class="btn red" href="{{ route('view.free.site.list', ['media' => 'hoardings', 'city' => 'Ahmedabad']) }}">Get the free Ahmedabad hoarding site list <b>→</b></a>
        <span class="kw-cta-contact">Call or <a href="{{ \App\Services\SeoResolver::whatsappUrl($seo, $seoSettings ?? null, 'Hi, please share the hoarding site list for Ahmedabad.') }}" target="_blank" rel="noopener">WhatsApp</a> <a href="tel:+919879616411">+91 98796 16411</a></span>
    </div>

    <div class="kw-grid-2">
        <div>
            <h2 class="kw-h2">What is hoarding <em>advertising?</em></h2>
            <p class="kw-p">Hoarding advertising (also called billboard advertising) is a form of outdoor or OOH advertising where a brand rents a large printed board at a high-traffic location. Unlike online ads, a hoarding cannot be skipped, blocked or scrolled past. It is seen every day by the same commuters, which builds strong recall over a campaign.</p>
            <p class="kw-p">In Ahmedabad, hoardings work well for launches, new store openings, real estate projects, education admissions, festive offers and any brand that wants to be known in a specific part of the city.</p>

            <div class="kw-stat-row">
                <div class="kw-stat"><strong>300+</strong><span>Own Hoardings in Ahmedabad</span></div>
                <div class="kw-stat"><strong>2000+</strong><span>Hoarding Sites Across Gujarat</span></div>
            </div>

            <h2 class="kw-h2">Which hoarding formats are available <em>in Ahmedabad?</em></h2>
            <p class="kw-p">Krishna Outdoor offers four main hoarding formats in Ahmedabad. The right one depends on the road, viewing distance and whether your audience sees it mostly by day or by night.</p>

            <div class="kw-table-wrap kw-stack">
                <table class="kw-table">
                    <thead><tr><th>Format</th><th>How it works</th><th>Best for</th></tr></thead>
                    <tbody>
                        <tr><td>Frontlit hoarding</td><td data-label="How it works">Flex print lit by external floodlights</td><td data-label="Best for">Classic, cost-effective visibility on main roads, day and night</td></tr>
                        <tr><td>Backlit hoarding</td><td data-label="How it works">Print lit from behind, so it glows</td><td data-label="Best for">Sharper, brighter night-time presence; premium brands</td></tr>
                        <tr><td>Unipole</td><td data-label="How it works">Single tall pole, usually double-sided</td><td data-label="Best for">Highways and big junctions where traffic comes from both directions</td></tr>
                        <tr><td>Gantry</td><td data-label="How it works">Overhead structure spanning the road</td><td data-label="Best for">Maximum frontal visibility on arterial roads and city entry points</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="kw-media">
            <div class="kw-img">
                <img srcset="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-04-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-hoarding-location-04.webp') }} 1600w" sizes="(max-width: 860px) 100vw, 45vw" alt="Hoarding advertising on a busy road in Ahmedabad by Krishna Outdoor" decoding="async" loading="lazy" src="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-04.webp') }}"/>
            </div>
            <div class="kw-img">
                <img srcset="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-05-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-hoarding-location-05.webp') }} 1600w" sizes="(max-width: 860px) 100vw, 45vw" alt="Unipole hoarding on a main road in Ahmedabad" decoding="async" loading="lazy" src="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-05.webp') }}"/>
            </div>
        </div>
    </div>

    <h2 class="kw-h2">Where are Krishna Outdoor's hoardings <em>in Ahmedabad?</em></h2>
    <p class="kw-p">Krishna Outdoor owns 300+ hoardings across Ahmedabad on arterial roads, major junctions and busy neighbourhood markets. You can pick sites by area, road or audience type.</p>
    <div class="kw-check">
        <span>SG Highway</span>
        <span>Ashram Road</span>
        <span>CG Road / Navrangpura</span>
        <span>Satellite / Prahladnagar</span>
        <span>SP Ring Road / Sindhu Bhavan Road</span>
        <span>Maninagar / East Ahmedabad</span>
    </div>
    <p class="kw-p">Outside Ahmedabad, we offer access to 2000+ hoarding sites across Gujarat, including Surat, Vadodara and Rajkot.</p>

    @php
        // Client-supplied inventory only (Admin > Locations): active Ahmedabad hoardings that have an area.
        $areaSites = \App\Models\Location::where('status', true)
            ->where('media_type', \App\Enums\MediaType::BILLBOARD->value)
            ->whereRaw('LOWER(city) = ?', ['ahmedabad'])
            ->orderBy('area')->orderBy('name')->get()
            ->filter(fn ($site) => mb_strlen(trim((string) $site->area)) >= 3)
            ->groupBy(fn ($site) => trim($site->area));
    @endphp
    @if ($areaSites->isNotEmpty())
    <h3 class="kw-h3">Hoarding sites by area</h3>
    <div class="kw-areas">
<!--cms:skip-->
        @foreach ($areaSites as $area => $sites)
            <div class="kw-area"><b>{{ $area }}</b><ul>@foreach ($sites as $site)<li>{{ $site->name }}@if ($site->size) <small>({{ $site->size }})</small>@endif</li>@endforeach</ul></div>
        @endforeach
<!--/cms:skip-->
    </div>
    @endif

    <h2 class="kw-h2">How much does hoarding advertising cost <em>in Ahmedabad?</em></h2>
    <p class="kw-p">Hoarding rates in Ahmedabad usually depend on location, size, format and booking duration. A backlit hoarding on a main arterial road costs more than a frontlit board in a neighbourhood market.</p>

    <div class="kw-table-wrap">
        <table class="kw-table">
            <thead><tr><th>Cost factor</th><th>How it affects the price</th></tr></thead>
            <tbody>
                <tr><td>Location</td><td>Busy roads and junctions with heavy traffic cost the most</td></tr>
                <tr><td>Size</td><td>Larger boards (more sq ft) cost more per month</td></tr>
                <tr><td>Format</td><td>Backlit and gantry cost more than frontlit</td></tr>
                <tr><td>Duration</td><td>Longer bookings usually get a better monthly rate</td></tr>
                <tr><td>Printing &amp; mounting</td><td>Confirm whether flex printing and mounting are included or charged separately</td></tr>
            </tbody>
        </table>
    </div>

    <p class="kw-p">Share your target area and budget and we will send matching sites with indicative rates.</p>

    <h2 class="kw-h2">How do you book a hoarding <em>in Ahmedabad?</em></h2>
    <p class="kw-p">Booking a hoarding with Krishna Outdoor takes four steps and usually a few days from confirmation to live display.</p>
    <ol class="kw-steps">
        <li><b>Share your brief</b> – target area, audience, campaign dates and budget.</li>
        <li><b>Get the site list</b> – available hoardings with photos, size, format and rates.</li>
        <li><b>Confirm and send creative</b> – we print the flex to the exact size.</li>
        <li><b>Go live</b> – we mount the hoarding and share live photos as proof of display.</li>
    </ol>
    <p class="kw-p">Popular locations get booked out early, especially before Navratri, Diwali and the wedding season, so enquire in advance.</p>

    <h2 class="kw-h2">Why choose Krishna Outdoor for outdoor advertising <em>in Ahmedabad?</em></h2>
    <p class="kw-p">Krishna Outdoor is an Ahmedabad-based outdoor advertising agency with more than 40 years in the business, backed by the legacy of Rakesh Advertising.</p>
    <ul class="kw-list">
        <li><b>Since 1985:</b> 40+ years of outdoor and media experience in Gujarat.</li>
        <li><b>Own inventory:</b> 300+ hoardings owned directly in Ahmedabad, plus 2000+ sites across Gujarat.</li>
        <li><b>Scale:</b> 5000+ clients served across 30+ key markets.</li>
        <li><b>Leadership:</b> led by Rakesh Gandhi (Chairman &amp; MD) and Kevin Gandhi (Director).</li>
        <li><b>Proof of display:</b> live photos once your hoarding is mounted.</li>
        <li><b>One team for the full mix:</b> hoardings, AMTS buses, bus shelters, GSRTC buses and social media.</li>
        <li><b>Local office:</b> Aakanksha Complex, Netaji Road, Navrangpura, Ahmedabad.</li>
    </ul>

    <h2 class="kw-h2">Combine hoardings with other <em>Ahmedabad media</em></h2>
    <p class="kw-p">Hoardings give a large fixed message on one road. Pair them with <a href="/amts-bus-advertising-ahmedabad">AMTS bus advertising</a> to move across the city, <a href="/bus-shelter-advertising-ahmedabad">bus shelter advertising</a> for eye-level dwell time, or <a href="/gsrtc-bus-advertising">GSRTC bus advertising</a> to reach the rest of Gujarat.</p>

    <p class="kw-h3">More Ahmedabad &amp; Gujarat advertising formats</p>
    <div class="kw-links">
        <a href="/amts-bus-advertising-ahmedabad">AMTS bus advertising in Ahmedabad</a>
        <a href="/bus-shelter-advertising-ahmedabad">Bus shelter advertising in Ahmedabad</a>
        <a href="/gsrtc-bus-advertising">GSRTC bus advertising across Gujarat</a>
        <a href="{{ route('view.ooh.media') }}">All OOH media in Gujarat</a>
    </div>
</div></section>

@include('web.common.campaigns-block', [
    'route' => 'view.keyword.hoarding.ahmedabad',
    'intro' => 'See how brands have used our hoarding network: read the <a href="' . route('view.project.show', ['slug' => 'torrent-powers-outdoor-billboard-campaign']) . '">Torrent Power billboard case study</a>.',
])

<section class="kw-section kw-section-alt"><div class="kw-inner">
    <h2 class="kw-h2">Frequently asked questions about hoarding advertising <em>in Ahmedabad</em></h2>
    @include('web.common.faq', ['faqs' => [
        ['q' => 'How much does a hoarding cost in Ahmedabad?', 'a' => 'Hoarding rates in Ahmedabad depend on location, size, format and duration. Backlit hoardings on busy arterial roads cost more than frontlit boards in neighbourhood markets. Krishna Outdoor shares indicative rates with its free site list, so you can compare options by area and budget before booking. Call +91 98796 16411 for current rates.'],
        ['q' => 'How many hoardings does Krishna Outdoor have in Ahmedabad?', 'a' => 'Krishna Outdoor directly owns 300+ hoardings across Ahmedabad and offers access to 2000+ hoarding sites across Gujarat. Formats include frontlit, backlit, unipole and gantry hoardings on arterial roads, major junctions and busy neighbourhood markets, so brands can choose sites by area, road and audience.'],
        ['q' => 'What is the difference between frontlit and backlit hoardings?', 'a' => 'A frontlit hoarding is a flex print lit by floodlights from the front, while a backlit hoarding is lit from behind so the whole image glows. Backlit hoardings look sharper and brighter at night and usually cost more. Frontlit hoardings are the more economical choice for strong day and night visibility.'],
        ['q' => 'How long does it take to put up a hoarding in Ahmedabad?', 'a' => 'Once a hoarding site is confirmed and your creative is ready, printing and mounting usually take a few days. Krishna Outdoor shares live photos after mounting as proof of display. Popular sites get booked early before festivals and the wedding season, so it is best to enquire a few weeks ahead.'],
        ['q' => 'What is the minimum booking period for a hoarding?', 'a' => 'Most hoardings in Ahmedabad are booked by the month. Longer bookings of three, six or twelve months often get a better monthly rate and build stronger recall because the same commuters see the brand every day.'],
        ['q' => 'Which is the best outdoor advertising agency in Ahmedabad?', 'a' => 'Look for an agency that owns its sites, shares photos and rates upfront and gives proof of display. Krishna Outdoor has worked in outdoor advertising since 1985, owns 300+ hoardings in Ahmedabad, offers 2000+ sites across Gujarat and also handles bus, bus shelter and social media campaigns.'],
        ['q' => 'Can I book hoardings outside Ahmedabad in Gujarat?', 'a' => 'Yes. Along with its 300+ own hoardings in Ahmedabad, Krishna Outdoor offers access to 2000+ hoarding sites across Gujarat in frontlit, backlit, unipole and gantry formats. Share the cities or highways you want to cover and the team will send matching sites with photos, sizes and indicative rates.'],
    ]])
</div></section>

<section class="cta" id="contact">
    <div class="container cta-inner reveal">
        <div>
            <div class="tag light">LET'S CREATE</div>
            <h2>GET YOUR FREE HOARDING SITE LIST FOR AHMEDABAD</h2>
            <p>Tell us your target area and budget. We will send available sites with photos, sizes and rates, usually within one business day. Call / WhatsApp <a href="tel:+919879616411">+91 98796 16411</a>.</p>
        </div>
        <a class="btn white" href="{{ route('view.free.site.list', ['media' => 'hoardings', 'city' => 'Ahmedabad']) }}">Get Free Hoarding Site List <b>→</b></a>
    </div>
</section>

</main>
@endsection
