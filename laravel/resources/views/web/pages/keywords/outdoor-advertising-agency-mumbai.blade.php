@extends('web.layouts.app')

@section('body-class', 'inner-page')
@section('nav', 'services')

@section('web-head')
@include('web.common.keyword-page-style')
@endsection

@section('web-section')
<main>

<section class="hero media-detail-hero media-detail-hero-ooh" id="home">
    <div class="media-detail-hero-bg">
        <img alt="Backlit Airtel 5G Plus ad panels at a Mumbai railway station – Krishna Outdoor" decoding="async" loading="eager" src="{{ asset('assets/images/shared-mumbai-local-train-advertising.jpg') }}"/>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-grid"></div>
    <div class="hero-noise"></div>
    <div class="container hero-inner reveal">
        <h1>
        @if ($seo->h1Override())
            {{ $seo->h1Override() }}
        @else
            OUTDOOR ADVERTISING AGENCY<br/><em>IN MUMBAI</em>
        @endif
        </h1>
    </div>
</section>

<section class="kw-section"><div class="kw-inner">
    <div class="kw-crumbs"><a href="{{ route('view.home') }}">Home</a><span>/</span><a href="{{ route('view.network') }}">Our Network</a><span>/</span><b>Outdoor Advertising Agency Mumbai</b></div>

    <div class="kw-grid-2">
        <div>
            <h2 class="kw-h2">Outdoor advertising agency in Mumbai — <em>Krishna Outdoor</em></h2>
            <p class="kw-p">Mumbai is a city that moves on rail and road in equal measure, and an outdoor campaign here only works if it moves with it. Krishna Outdoor runs a Mumbai transit media portfolio built around exactly that reality: advertising rights on Mumbai local trains across Western and Central Railways, 400+ BEST EV full-wrap buses, and 350+ TMT buses serving Thane and the wider metropolitan region. Instead of booking formats one at a time through different vendors, brands work with a single agency that already holds the rights and relationships across all three.</p>

            <div class="kw-stat-row">
                <div class="kw-stat"><strong>400+</strong><span>BEST EV Full-Wrap Bus Rights</span></div>
                <div class="kw-stat"><strong>350+</strong><span>TMT Bus Rights in Thane</span></div>
            </div>

            <h3 class="kw-h3">Our Mumbai media portfolio</h3>
            <ul class="kw-list">
                <li><b>Mumbai local train advertising</b> — exterior branding on trains running the Western and Central Railway lines, reaching the city's largest daily commuter base.</li>
                <li><b>BEST bus advertising</b> — full-wrap EV buses operated by Brihanmumbai Electric Supply and Transport, covering routes across Mumbai.</li>
                <li><b>TMT bus advertising</b> — Thane Municipal Transport buses serving Thane and neighbouring areas, a less saturated transit market compared to central Mumbai.</li>
            </ul>

            <h3 class="kw-h3">How we plan a Mumbai campaign</h3>
            <p class="kw-p">Every Mumbai campaign starts with your audience, not our inventory. We look at where your customers actually travel — a specific rail corridor, a set of BEST bus routes, or the Thane belt — and recommend a format mix that puts your brand in front of them repeatedly rather than once. For many brands that means combining formats: a local train wrap for mass daily visibility plus BEST or TMT buses to extend reach into neighbourhoods the rail network doesn't directly serve.</p>

            <h3 class="kw-h3">Visit our Mumbai office</h3>
            <p class="kw-p">Our Mumbai team operates out of 701, 702 Morya Blue Moon, Next to Moniginis Cake Factory, Off New Link Road, Opp. Citi Mall, Andheri West, Mumbai, Maharashtra – 400053. You're welcome to visit in person to see site photos and discuss your campaign, or call us directly on <a href="tel:+919920011574" onclick="trackConversion('phone_click', this.href)">+91 99200 11574</a>.</p>

            <p class="kw-p">See how brands like these have used our Mumbai network: explore our <a href="{{ route('view.projects') }}">campaign case studies</a>.</p>
        </div>

        <div class="kw-img">
            <img alt="Branded BEST bus and Mumbai local train advertising" decoding="async" loading="lazy" src="{{ asset('assets/images/media/home-360-mumbai-train.webp') }}"/>
        </div>
    </div>

    <h3 class="kw-h3">Explore our Mumbai transit formats</h3>
    <div class="kw-links">
        <a href="/mumbai-local-train-advertising">Mumbai Local Train Advertising</a>
        <a href="/best-bus-advertising-mumbai">BEST Bus Advertising Mumbai</a>
        <a href="/tmt-bus-advertising-thane">TMT Bus Advertising Thane</a>
        <a href="{{ route('view.contact') }}">Talk To Our Mumbai Team</a>
    </div>
</div></section>

<section class="kw-section kw-section-alt"><div class="kw-inner">
    <h2 class="kw-h2">Frequently asked <em>questions</em></h2>
    @include('web.common.faq', ['faqs' => [
        ['q' => 'What outdoor advertising formats does Krishna Outdoor offer in Mumbai?', 'a' => 'Krishna Outdoor\'s Mumbai portfolio covers Mumbai local train advertising on Western and Central Railways, BEST EV full-wrap bus advertising, and TMT bus advertising in Thane, giving brands a connected transit presence across the Mumbai Metropolitan Region.'],
        ['q' => 'Where is Krishna Outdoor\'s Mumbai office located?', 'a' => 'Our Mumbai office is at 701, 702 Morya Blue Moon, Next to Moniginis Cake Factory, Off New Link Road, Opp. Citi Mall, Andheri West, Mumbai, Maharashtra 400053. You can reach us there or call +91 99200 11574.'],
        ['q' => 'How does Krishna Outdoor plan a Mumbai outdoor advertising campaign?', 'a' => 'We start by understanding your target audience and budget, then recommend a mix across local trains, BEST buses and TMT buses based on where that audience actually travels. Once formats are confirmed, we handle creative coordination, printing, mounting and reporting.'],
        ['q' => 'Can Krishna Outdoor run a campaign across multiple Mumbai transit formats at once?', 'a' => 'Yes. Many brands combine local train branding with BEST or TMT bus advertising to build layered reach across rail and road commuters in the same campaign window.'],
    ]])
</div></section>

<section class="cta" id="contact">
    <div class="container cta-inner reveal">
        <div>
            <div class="tag light">LET'S CREATE</div>
            <h2>PLAN YOUR MUMBAI OUTDOOR CAMPAIGN</h2>
            <p>Tell us your target audience in Mumbai and we'll recommend the right mix of trains, buses and routes.</p>
        </div>
        <a class="btn white" href="{{ route('view.free.site.list', ['media' => 'transit']) }}">Get Free Site List <b>→</b></a>
    </div>
</section>

</main>
@endsection
