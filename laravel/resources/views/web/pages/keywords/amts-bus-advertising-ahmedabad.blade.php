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
        <img fetchpriority="high" srcset="{{ asset('assets/images/transit/ahmedabad-bus-advertising-01-800w.webp') }} 800w, {{ asset('assets/images/transit/ahmedabad-bus-advertising-01.webp') }} 1600w" sizes="100vw" alt="AMTS bus advertising in Ahmedabad" decoding="async" loading="eager" src="{{ asset('assets/images/transit/ahmedabad-bus-advertising-01.webp') }}"/>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-grid"></div>
    <div class="hero-noise"></div>
    <div class="container hero-inner reveal">
        <h1>
        @if ($seo->h1Override())
            {{ $seo->h1Override() }}
        @else
            AMTS BUS ADVERTISING<br/><em>IN AHMEDABAD</em>
        @endif
        </h1>
    </div>
</section>

<section class="kw-section"><div class="kw-inner">
    <div class="kw-crumbs"><a href="{{ route('view.home') }}">Home</a><span>/</span><a href="{{ route('view.ooh.media') }}">OOH Media</a><span>/</span><b>AMTS Bus Advertising Ahmedabad</b></div>

    <div class="kw-grid-2">
        <div>
            <h2 class="kw-h2">AMTS bus advertising in Ahmedabad with <em>Krishna Outdoor</em></h2>
            <p class="kw-p">AMTS (Ahmedabad Municipal Transport Service) buses run fixed routes across every part of the city, all day, every day. That makes them one of the most dependable transit advertising formats in Ahmedabad — your brand isn't rented for a single moment of attention, it travels through residential colonies, commercial hubs and college areas on a loop that repeats for weeks. Krishna Outdoor holds advertising rights on 900+ AMTS buses, giving brands a genuinely city-wide transit presence rather than a handful of scattered vehicles.</p>

            <div class="kw-stat-row">
                <div class="kw-stat"><strong>900+</strong><span>AMTS Bus Advertising Rights</span></div>
                <div class="kw-stat"><strong>City-wide</strong><span>Route Coverage in Ahmedabad</span></div>
            </div>

            <h3 class="kw-h3">Formats: full wrap, side panel &amp; back panel</h3>
            <ul class="kw-list">
                <li><b>Full wrap</b> — the entire exterior of the bus becomes your brand, impossible to miss in traffic or at a signal.</li>
                <li><b>Side panel</b> — a large printed panel along the bus body, ideal for a strong visual with a clear call to action.</li>
                <li><b>Back panel</b> — faces following traffic directly, which keeps the message in view for longer at every stop and signal.</li>
            </ul>

            <h3 class="kw-h3">Why bus advertising works for Ahmedabad brands</h3>
            <p class="kw-p">A hoarding is fixed to one location; a bus is not. The same AMTS vehicle crosses multiple neighbourhoods, markets and office corridors in a single day, so one booking buys exposure across dozens of micro-markets instead of just one. Because routes repeat daily, the same commuters and shopkeepers see the ad again and again, which builds recall far faster than a single large hoarding in one spot. For brands balancing reach against budget, AMTS buses are typically a more cost-effective way to achieve city-wide visibility than booking several separate hoarding sites.</p>

            <h3 class="kw-h3">Routes and coverage</h3>
            <p class="kw-p">AMTS buses operate across Ahmedabad city, connecting residential, commercial and institutional areas on scheduled routes. Rather than guessing which route suits your audience, share your target neighbourhoods or customer profile with our team and we'll recommend buses whose routes genuinely overlap with where your audience lives, works or shops.</p>

            <h3 class="kw-h3">What does AMTS bus advertising cost?</h3>
            <p class="kw-p">Cost is driven by three things: the format you choose (full wrap, side panel or back panel), how many buses you book, and your campaign duration. A full wrap on a single bus costs more than a side panel, but booking multiple buses with panels can deliver similar overall reach at a lower entry cost. Longer bookings also reduce the effective cost per month since printing and mounting are a one-time cost spread across the campaign.</p>

            <h3 class="kw-h3">How booking works</h3>
            <ol class="kw-list">
                <li>Tell us your target areas, budget and preferred format.</li>
                <li>We share available AMTS buses with route details and rates.</li>
                <li>You confirm buses and send creative for printing.</li>
                <li>We handle mounting and share live photos once your campaign is on the road.</li>
            </ol>

            <p class="kw-p">See how brands like these have used our transit network: explore our <a href="{{ route('view.projects') }}">campaign case studies</a>.</p>
        </div>

        <div class="kw-img">
            <img alt="Branded AMTS bus running an Ahmedabad city route" decoding="async" loading="lazy" src="{{ asset('assets/images/transit/ahmedabad-city-bus-advertising-05.webp') }}"/>
        </div>
    </div>

    <h3 class="kw-h3">More Ahmedabad &amp; Gujarat advertising formats</h3>
    <div class="kw-links">
        <a href="/bus-shelter-advertising-ahmedabad">Bus Shelter Advertising Ahmedabad</a>
        <a href="/hoarding-advertising-ahmedabad">Hoarding Advertising Ahmedabad</a>
        <a href="/gsrtc-bus-advertising">GSRTC Bus Advertising</a>
        <a href="{{ route('view.ooh.media') }}">All OOH Media in Gujarat</a>
    </div>
</div></section>

<section class="kw-section kw-section-alt"><div class="kw-inner">
    <h2 class="kw-h2">Frequently asked <em>questions</em></h2>
    @include('web.common.faq', ['faqs' => [
        ['q' => 'How much does AMTS bus advertising cost in Ahmedabad?', 'a' => 'AMTS bus advertising cost depends on the format (full wrap, side panel or back panel), number of buses booked and campaign duration. Full wraps cost more than single panels but deliver far higher visibility. Share your budget and target routes and our team will share relevant options with indicative rates.'],
        ['q' => 'What is the minimum booking duration for AMTS bus advertising?', 'a' => 'Most AMTS bus advertising campaigns are booked for a minimum of one month, since printing, mounting and route circulation take time to build repeat visibility. Longer bookings of two to three months typically give a better cost-per-impression.'],
        ['q' => 'What formats are available for AMTS bus advertising?', 'a' => 'Krishna Outdoor offers full bus wraps, side panels and back panels on AMTS buses. Full wraps cover the entire exterior for maximum brand recall, while side and back panels are a more budget-friendly way to get onto the AMTS network.'],
        ['q' => 'How many AMTS buses does Krishna Outdoor have advertising rights on?', 'a' => 'Krishna Outdoor holds advertising rights on 900+ AMTS buses operating across Ahmedabad, giving brands a large, city-wide transit network to choose from.'],
    ]])
</div></section>

<section class="cta" id="contact">
    <div class="container cta-inner reveal">
        <div>
            <div class="tag light">LET'S CREATE</div>
            <h2>GET YOUR FREE AMTS BUS ROUTE LIST</h2>
            <p>Tell us your target areas in Ahmedabad and we'll share available AMTS buses with routes, formats and rates.</p>
        </div>
        <a class="btn white" href="{{ route('view.free.site.list', ['media' => 'amts', 'city' => 'Ahmedabad']) }}">Get Free Site List <b>→</b></a>
    </div>
</section>

</main>
@endsection
