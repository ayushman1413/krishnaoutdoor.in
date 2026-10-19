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
        <img fetchpriority="high" srcset="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-02-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-hoarding-location-02.webp') }} 1600w" sizes="100vw" alt="Hoarding advertising in Ahmedabad" decoding="async" loading="eager" src="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-02.webp') }}"/>
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
    <p class="kw-lead">Krishna Outdoor offers hoarding advertising in Ahmedabad on 300+ hoardings it owns directly, with access to 2000+ hoarding sites across Gujarat. Formats include frontlit, backlit, unipole and gantry hoardings. Ask for the free site list to see available locations with photos, sizes and rates.</p>

    <div class="kw-grid-2">
        <div>
            <h2 class="kw-h2">Hoarding advertising in Ahmedabad with <em>Krishna Outdoor</em></h2>
            <p class="kw-p">Krishna Outdoor owns 300+ hoardings directly across Ahmedabad and has access to 2000+ hoarding sites across Gujarat — giving brands real, verifiable locations rather than a generic listing. From high-traffic arterial roads to neighbourhood markets, our hoardings put your brand where Ahmedabad actually looks.</p>

            <div class="kw-stat-row">
                <div class="kw-stat"><strong>300+</strong><span>Own Hoardings in Ahmedabad</span></div>
                <div class="kw-stat"><strong>2000+</strong><span>Hoarding Sites Across Gujarat</span></div>
            </div>

            <h3 class="kw-h3">Frontlit, backlit, unipoles &amp; gantries</h3>
            <ul class="kw-list">
                <li><b>Frontlit hoardings</b> — classic billboard format, externally lit for day and night visibility.</li>
                <li><b>Backlit hoardings</b> — illuminated from behind the print for a brighter, sharper night-time presence.</li>
                <li><b>Unipoles &amp; gantries</b> — single-pole and overhead structures on highways and major junctions for maximum reach.</li>
            </ul>

            <h3 class="kw-h3">What does a hoarding cost in Ahmedabad?</h3>
            <p class="kw-p">Cost depends on the location, hoarding size, format and booking duration. A hoarding on a high-traffic arterial road or major junction costs more than a neighbourhood site, and backlit formats cost more than frontlit. Share your target area and budget and we'll share relevant site options with indicative rates.</p>

            <h3 class="kw-h3">How booking works</h3>
            <ol class="kw-list">
                <li>Tell us your target area, audience and budget.</li>
                <li>We share available hoarding sites with photos, size and rates.</li>
                <li>You confirm the site and send creative for printing.</li>
                <li>We mount the hoarding and share live photos once it's up.</li>
            </ol>

            <p class="kw-p">See how brands like these have used our hoarding network: explore our <a href="{{ route('view.projects') }}">campaign case studies</a>.</p>
        </div>

        <div class="kw-img">
            <img srcset="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-04-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-hoarding-location-04.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="Backlit hoarding on a main road in Ahmedabad" decoding="async" loading="lazy" src="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-04.webp') }}"/>
        </div>
    </div>

    <h3 class="kw-h3">More Ahmedabad &amp; Gujarat advertising formats</h3>
    <div class="kw-links">
        <a href="/amts-bus-advertising-ahmedabad">AMTS Bus Advertising</a>
        <a href="/bus-shelter-advertising-ahmedabad">Bus Shelter Advertising Ahmedabad</a>
        <a href="/gsrtc-bus-advertising">GSRTC Bus Advertising</a>
        <a href="{{ route('view.ooh.media') }}">All OOH Media in Gujarat</a>
    </div>
</div></section>

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
<section class="kw-section kw-section-alt"><div class="kw-inner">
    <h2 class="kw-h2">Our hoarding locations <em>by area</em></h2>
    <div class="kw-areas">
<!--cms:skip-->
        @foreach ($areaSites as $area => $sites)
            <div class="kw-area"><b>{{ $area }}</b><ul>@foreach ($sites as $site)<li>{{ $site->name }}@if ($site->size) <small>({{ $site->size }})</small>@endif</li>@endforeach</ul></div>
        @endforeach
<!--/cms:skip-->
    </div>
</div></section>
@endif

@include('web.common.campaigns-block', ['route' => 'view.keyword.hoarding.ahmedabad'])

<section class="kw-section kw-section-alt"><div class="kw-inner">
    <h2 class="kw-h2">Frequently asked <em>questions</em></h2>
    @include('web.common.faq', ['faqs' => [
        ['q' => 'How much does a hoarding cost in Ahmedabad?', 'a' => 'Hoarding cost in Ahmedabad depends on location, size, format (frontlit, backlit or unipole) and booking duration. High-traffic locations on arterial roads cost more than neighbourhood sites. Share your budget and target area and our team will share relevant site options and indicative rates.'],
        ['q' => 'How many hoarding sites does Krishna Outdoor have in Ahmedabad?', 'a' => 'Krishna Outdoor owns 300+ hoardings directly in Ahmedabad and has access to 2000+ hoarding sites across Gujarat, covering frontlit, backlit, unipole and gantry formats.'],
        ['q' => 'What is the difference between frontlit, backlit and unipole hoardings?', 'a' => 'Frontlit hoardings are lit from external floodlights, backlit hoardings are illuminated from behind the print for a brighter night-time look, and unipoles/gantries are single-pole or overhead structures typically used on highways and major junctions for maximum visibility.'],
        ['q' => 'How long does it take to book a hoarding in Ahmedabad?', 'a' => 'Once a site is confirmed as available and creative is ready, printing and mounting typically takes a few days. Popular locations can get booked out in advance, so early enquiry is recommended.'],
        ['q' => 'Where are Krishna Outdoor\'s hoardings in Ahmedabad?', 'a' => 'Krishna Outdoor owns 300+ hoardings across Ahmedabad, on high-traffic arterial roads and in neighbourhood markets. Share your target area and we will send matching sites with photos, sizes and rates.'],
        ['q' => 'Does Krishna Outdoor offer hoardings outside Ahmedabad?', 'a' => 'Yes. Krishna Outdoor has access to 2000+ hoarding sites across Gujarat, in frontlit, backlit, unipole and gantry formats, in addition to the 300+ hoardings it owns in Ahmedabad.'],
        ['q' => 'How do I get a hoarding site list for Ahmedabad?', 'a' => 'Submit the free site list form with your city and media type, and our team will send available sites with photos, sizes and rates, usually within one business day. You can also call +91 98796 16411.'],
    ]])
</div></section>

<section class="cta" id="contact">
    <div class="container cta-inner reveal">
        <div>
            <div class="tag light">LET'S CREATE</div>
            <h2>GET YOUR FREE HOARDING SITE LIST</h2>
            <p>Tell us your target area in Ahmedabad and we'll share available hoarding sites with photos, sizes and rates.</p>
        </div>
        <a class="btn white" href="{{ route('view.free.site.list', ['media' => 'hoardings', 'city' => 'Ahmedabad']) }}">Get Free Site List <b>→</b></a>
    </div>
</section>

</main>
@endsection
