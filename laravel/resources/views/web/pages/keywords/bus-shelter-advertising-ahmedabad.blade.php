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
        <img fetchpriority="high" srcset="{{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-01-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-01.webp') }} 1600w" sizes="100vw" alt="Hoarding at Prem Darwaja, Old City, Ahmedabad – Krishna Outdoor" decoding="async" loading="eager" src="{{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-01.webp') }}"/>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-grid"></div>
    <div class="hero-noise"></div>
    <div class="container hero-inner reveal">
        <h1>
        @if ($seo->h1Override())
            {{ $seo->h1Override() }}
        @else
            BUS SHELTER ADVERTISING<br/><em>IN AHMEDABAD</em>
        @endif
        </h1>
    </div>
</section>

<section class="kw-section"><div class="kw-inner">
    @include('web.common.breadcrumbs', ['seo' => $seo, 'class' => 'kw-crumbs'])
    <p class="kw-lead">Krishna Outdoor holds advertising rights on 400+ backlit bus shelters across Ahmedabad. The panels sit at eye level where commuters wait, so the message is read at a standstill, day and night. Ask for the free site list to see available shelters with locations and rates.</p>

    <div class="kw-grid-2">
        <div>
            <h2 class="kw-h2">Bus shelter advertising in Ahmedabad with <em>Krishna Outdoor</em></h2>
            <p class="kw-p">A moving bus or a passing car gets a few seconds of attention at best. A bus shelter gets minutes. Commuters standing at a stop have nowhere else to look while they wait, which makes backlit bus shelter panels one of the highest dwell-time formats in outdoor advertising. Krishna Outdoor holds advertising rights on 400+ backlit bus shelters across Ahmedabad, positioned at eye level exactly where waiting audiences naturally look.</p>

            <div class="kw-stat-row">
                <div class="kw-stat"><strong>400+</strong><span>Backlit Bus Shelter Sites</span></div>
                <div class="kw-stat"><strong>Eye-Level</strong><span>Placement at Commuter Stops</span></div>
            </div>

            <h3 class="kw-h3">Why dwell time matters more than drive-by exposure</h3>
            <p class="kw-p">Most outdoor formats compete for a glance — a hoarding seen from a moving car, a bus panel seen for a second at a signal. A bus shelter is different: the audience is stationary and has no choice but to wait, often for several minutes. That extra time means a shelter ad can carry more message — a product detail, an offer, a QR code — and still be read in full, something a fast-moving format simply can't support.</p>

            <h3 class="kw-h3">Backlit panels for day and night visibility</h3>
            <p class="kw-p">Bus shelter panels at Krishna Outdoor are backlit, meaning the print is illuminated from behind rather than relying on ambient street light. This keeps the creative sharp and legible after dark, when many shelters see their heaviest footfall from office-goers and students heading home. The panels are printed on durable, weather-resistant material and installed by our team to fit the shelter's existing frame.</p>

            <h3 class="kw-h3">Layering with AMTS bus advertising</h3>
            <p class="kw-p">Bus shelters and AMTS buses work well together precisely because they solve different problems. The buses deliver broad, repeated exposure as they move across the city; the shelters reinforce that same message at fixed points where people actually stop and read. Running both as one city campaign means your brand is seen in motion and seen at rest, across a wider footprint than either format achieves alone — see our <a href="/amts-bus-advertising-ahmedabad">AMTS bus advertising</a> page for details.</p>

            <h3 class="kw-h3">What does bus shelter advertising cost?</h3>
            <p class="kw-p">Pricing depends on the shelter's location, panel size and how long you book it for. A shelter on a high-footfall commercial road or near a college or market costs more than one in a quieter residential lane, simply because of the volume of people walking past and waiting there daily.</p>

            <p class="kw-p">See how brands like these have used our outdoor network: explore our <a href="{{ route('view.projects') }}">campaign case studies</a>.</p>
        </div>

        <div class="kw-img">
            <img srcset="{{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-02-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-02.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="Backlit bus shelter advertising panel in Ahmedabad" decoding="async" loading="lazy" src="{{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-02.webp') }}"/>
        </div>
    </div>

    <h3 class="kw-h3">More Ahmedabad &amp; Gujarat advertising formats</h3>
    <div class="kw-links">
        <a href="/amts-bus-advertising-ahmedabad">AMTS Bus Advertising Ahmedabad</a>
        <a href="/hoarding-advertising-ahmedabad">Hoarding Advertising Ahmedabad</a>
        <a href="/gsrtc-bus-advertising">GSRTC Bus Advertising</a>
        <a href="{{ route('view.ooh.media') }}">All OOH Media in Gujarat</a>
    </div>
</div></section>

<section class="kw-section kw-section-alt"><div class="kw-inner">
    <h2 class="kw-h2">Frequently asked <em>questions</em></h2>
    @include('web.common.faq', ['faqs' => [
        ['q' => 'How much does bus shelter advertising cost in Ahmedabad?', 'a' => 'Bus shelter advertising cost depends on the location of the shelter, panel size and booking duration. Shelters on busy commercial roads or near markets and colleges cost more than quieter residential stops. Share your target area and we\'ll share relevant shelters with indicative rates.'],
        ['q' => 'Which bus shelter locations are available in Ahmedabad?', 'a' => 'Krishna Outdoor has backlit bus shelter advertising rights at 400+ locations across Ahmedabad, spanning commercial corridors, residential neighbourhoods and areas near markets, colleges and offices. Tell us your target audience and we\'ll recommend shelters that match.'],
        ['q' => 'Can I combine bus shelter advertising with AMTS bus advertising?', 'a' => 'Yes. Many brands pair bus shelters with AMTS bus advertising to layer a campaign — the moving buses build broad city-wide recall while the shelters reinforce the message at the exact points where commuters stop and have time to read it.'],
        ['q' => 'Why is bus shelter advertising effective for dwell-time exposure?', 'a' => 'Unlike a bus or car passing in a few seconds, people standing at a bus shelter are a captive audience for several minutes while they wait, giving backlit shelter panels far longer effective viewing time than most other outdoor formats.'],
        ['q' => 'Are bus shelter advertisements visible at night in Ahmedabad?', 'a' => 'Yes. The bus shelter panels are backlit, so the creative stays sharp and legible after dark, when many shelters see heavy footfall from office-goers and students.'],
        ['q' => 'What can a bus shelter ad carry that a hoarding cannot?', 'a' => 'More detail. People wait at a shelter for minutes rather than seconds, so a shelter ad can carry a product detail, an offer or a QR code and still be read in full.'],
        ['q' => 'How do I get the bus shelter location list for Ahmedabad?', 'a' => 'Use the Get Free Site List form with your target area in Ahmedabad. We will share available bus shelters with photos, sizes and rates.'],
    ]])
</div></section>

<section class="cta" id="contact">
    <div class="container cta-inner reveal">
        <div>
            <div class="tag light">LET'S CREATE</div>
            <h2>GET YOUR FREE BUS SHELTER LOCATION LIST</h2>
            <p>Tell us your target area in Ahmedabad and we'll share available bus shelters with photos, sizes and rates.</p>
        </div>
        <a class="btn white" href="{{ route('view.free.site.list', ['media' => 'bus-shelters', 'city' => 'Ahmedabad']) }}">Get Free Site List <b>→</b></a>
    </div>
</section>

</main>
@endsection
