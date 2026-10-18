@extends('web.layouts.app')

@section('body-class', 'inner-page')
@section('nav', 'services')

@section('web-head')
@include('web.common.keyword-page-style')
<script type="application/ld+json">{"@context":"https://schema.org","@type":"Service","serviceType":"TMT Bus Advertising","provider":{"@type":"Organization","name":"Krishna Outdoor"},"areaServed":{"@type":"City","name":"Thane"},"name":"TMT Bus Advertising in Thane","description":"Full and partial branding advertising on TMT buses operated by Thane Municipal Transport across Thane and the greater Mumbai region."}</script>
<script type="application/ld+json">{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[{"@type":"Question","name":"What is TMT bus advertising?","acceptedAnswer":{"@type":"Answer","text":"TMT bus advertising is advertising placed on buses operated by Thane Municipal Transport (TMT), covering routes across Thane and connecting areas of the greater Mumbai region."}},{"@type":"Question","name":"Why advertise on TMT buses instead of Mumbai city buses?","acceptedAnswer":{"@type":"Answer","text":"Thane is a fast-growing residential and commercial market that is less saturated with outdoor advertising than central Mumbai, so a TMT bus campaign often achieves stronger share of attention for a lower cost than competing for space in a more crowded market."}},{"@type":"Question","name":"What formats are available for TMT bus advertising?","acceptedAnswer":{"@type":"Answer","text":"Krishna Outdoor offers both full branding, which wraps the entire bus exterior, and partial branding such as side or back panels, letting brands choose based on budget and desired visibility."}},{"@type":"Question","name":"How many TMT buses does Krishna Outdoor have advertising rights on?","acceptedAnswer":{"@type":"Answer","text":"Krishna Outdoor holds advertising rights on 350+ TMT buses serving Thane and surrounding areas."}}]}</script>
<script type="application/ld+json">{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"https://krishnaoutdoor.in/"},{"@type":"ListItem","position":2,"name":"Transit Media","item":"https://krishnaoutdoor.in/media/transit"},{"@type":"ListItem","position":3,"name":"TMT Bus Advertising Thane","item":"https://krishnaoutdoor.in/tmt-bus-advertising-thane"}]}</script>
@endsection

@section('web-section')
<main>

<section class="hero media-detail-hero media-detail-hero-ooh" id="home">
    <div class="media-detail-hero-bg">
        {{-- TODO: this hero photo is a Mumbai BEST bus; swap for a high-res TMT (Thane) bus photo when one is available. --}}
        <img alt="Branded city bus – transit advertising by Krishna Outdoor" decoding="async" loading="eager" fetchpriority="high" src="{{ asset('assets/images/transit/city-bus-advertising-02.webp') }}"/>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-grid"></div>
    <div class="hero-noise"></div>
    <div class="container hero-inner reveal">
        <h1>
        @if ($seo->h1Override())
            {{ $seo->h1Override() }}
        @else
            TMT BUS ADVERTISING<br/><em>IN THANE</em>
        @endif
        </h1>
    </div>
</section>

<section class="kw-section"><div class="kw-inner">
    <div class="kw-crumbs"><a href="{{ route('view.home') }}">Home</a><span>/</span><a href="{{ route('view.transit.media') }}">Transit Media</a><span>/</span><b>TMT Bus Advertising Thane</b></div>

    <div class="kw-grid-2">
        <div>
            <h2 class="kw-h2">TMT bus advertising in Thane with <em>Krishna Outdoor</em></h2>
            <p class="kw-p">Thane has grown into one of the busiest residential and commercial pockets of the Mumbai Metropolitan Region, yet it still sees far less outdoor advertising clutter than South and central Mumbai. TMT (Thane Municipal Transport) buses run the routes that connect this growing city, and Krishna Outdoor holds advertising rights on 350+ of them — a transit network that lets brands reach Thane's audience directly rather than through overflow visibility from a Mumbai-focused campaign.</p>

            <div class="kw-stat-row">
                <div class="kw-stat"><strong>350+</strong><span>TMT Bus Advertising Rights</span></div>
                <div class="kw-stat"><strong>Thane &amp; Region</strong><span>Route Coverage</span></div>
            </div>

            <h3 class="kw-h3">Full and partial branding formats</h3>
            <ul class="kw-list">
                <li><b>Full branding</b> — the complete bus exterior wrapped for maximum visibility on Thane's busier roads and junctions.</li>
                <li><b>Partial branding</b> — side or back panels for brands wanting a presence across a larger number of buses at a more modest cost.</li>
            </ul>

            <h3 class="kw-h3">Why Thane is a lower-competition transit market</h3>
            <p class="kw-p">Central Mumbai's advertising inventory is in high demand, which pushes up cost and makes it harder for any single brand's message to stand out. Thane, by contrast, has grown rapidly in population and commercial activity without a matching rise in outdoor ad density, so a TMT bus campaign tends to face less visual competition for the same commuter's attention — often at a more accessible price point than comparable Mumbai city formats.</p>

            <h3 class="kw-h3">Routes connecting Thane and the wider region</h3>
            <p class="kw-p">TMT buses serve Thane's residential pockets, commercial centres and connect out toward neighbouring parts of the greater Mumbai region. Share your target localities and audience with our team and we'll point you to routes that genuinely pass through them, rather than a generic citywide spread.</p>

            <h3 class="kw-h3">Cost factors</h3>
            <p class="kw-p">As with other transit formats, cost is driven by the branding type (full or partial), the number of buses booked and the length of the campaign. Because Thane inventory is less contested, brands often find they can book a larger fleet for the same budget compared to an equivalent Mumbai city bus campaign.</p>

            <p class="kw-p">See how brands like these have used our Mumbai-region network: explore our <a href="{{ route('view.projects') }}">campaign case studies</a>.</p>
        </div>

        <div class="kw-img">
            <img alt="Advertising on a TMT city bus in Thane – Krishna Outdoor" decoding="async" loading="lazy" width="301" height="203" src="{{ asset('assets/images/media/tmt-mumbai-bus.webp') }}"/>
        </div>
    </div>

    <h3 class="kw-h3">More Mumbai-region advertising formats</h3>
    <div class="kw-links">
        <a href="/best-bus-advertising-mumbai">BEST Bus Advertising Mumbai</a>
        <a href="/mumbai-local-train-advertising">Mumbai Local Train Advertising</a>
        <a href="/outdoor-advertising-agency-mumbai">Outdoor Advertising Agency Mumbai</a>
        <a href="{{ route('view.transit.media') }}">All Transit Media</a>
    </div>
</div></section>

<section class="kw-section kw-section-alt"><div class="kw-inner">
    <h2 class="kw-h2">Frequently asked <em>questions</em></h2>
    <div class="kw-faq">
        <details open>
            <summary>What is TMT bus advertising?</summary>
            <p>TMT bus advertising is advertising placed on buses operated by Thane Municipal Transport (TMT), covering routes across Thane and connecting areas of the greater Mumbai region.</p>
        </details>
        <details>
            <summary>Why advertise on TMT buses instead of Mumbai city buses?</summary>
            <p>Thane is a fast-growing residential and commercial market that is less saturated with outdoor advertising than central Mumbai, so a TMT bus campaign often achieves stronger share of attention for a lower cost than competing for space in a more crowded market.</p>
        </details>
        <details>
            <summary>What formats are available for TMT bus advertising?</summary>
            <p>Krishna Outdoor offers both full branding, which wraps the entire bus exterior, and partial branding such as side or back panels, letting brands choose based on budget and desired visibility.</p>
        </details>
        <details>
            <summary>How many TMT buses does Krishna Outdoor have advertising rights on?</summary>
            <p>Krishna Outdoor holds advertising rights on 350+ TMT buses serving Thane and surrounding areas.</p>
        </details>
    </div>
</div></section>

<section class="cta" id="contact">
    <div class="container cta-inner reveal">
        <div>
            <div class="tag light">LET'S CREATE</div>
            <h2>GET YOUR FREE TMT BUS FLEET LIST</h2>
            <p>Tell us your target areas in Thane and we'll share available TMT buses with routes and rates.</p>
        </div>
        <a class="btn white" href="{{ route('view.contact') }}">Get Fleet List <b>→</b></a>
    </div>
</section>

</main>
@endsection
