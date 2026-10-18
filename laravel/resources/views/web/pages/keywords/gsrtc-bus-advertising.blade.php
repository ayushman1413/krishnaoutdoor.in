@extends('web.layouts.app')

@section('body-class', 'inner-page')
@section('nav', 'services')

@section('web-head')
@include('web.common.keyword-page-style')
<script type="application/ld+json">{"@context":"https://schema.org","@type":"Service","serviceType":"GSRTC Bus Advertising","provider":{"@type":"Organization","name":"Krishna Outdoor"},"areaServed":{"@type":"State","name":"Gujarat"},"name":"GSRTC Bus Advertising","description":"Advertising on GSRTC state transport buses connecting every district of Gujarat, including full wrap and panel formats."}</script>
<script type="application/ld+json">{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[{"@type":"Question","name":"What area does GSRTC bus advertising cover?","acceptedAnswer":{"@type":"Answer","text":"GSRTC buses connect every district of Gujarat, from major cities to small towns and rural routes. This gives brands genuine state-wide coverage that a city-only format like a hoarding or city bus simply cannot match."}},{"@type":"Question","name":"How is GSRTC bus advertising priced?","acceptedAnswer":{"@type":"Answer","text":"Pricing is based on the number of buses booked, the format (full wrap or panel) and campaign duration. Because GSRTC routes span the whole state, campaigns are typically planned around the districts or corridors most relevant to the brand's distribution or audience rather than a single city."}},{"@type":"Question","name":"Is there a minimum campaign size for GSRTC bus advertising?","acceptedAnswer":{"@type":"Answer","text":"Campaigns can start with a small number of buses on specific routes, but most brands booking GSRTC advertising aim for a meaningful fleet size so the campaign reads as state-wide rather than isolated. Share your target districts and budget and we'll recommend a realistic fleet size."}},{"@type":"Question","name":"How many GSRTC buses does Krishna Outdoor have advertising rights on?","acceptedAnswer":{"@type":"Answer","text":"Krishna Outdoor holds advertising rights on 7000+ GSRTC buses across Gujarat, making it one of the largest state transport advertising networks available to brands in the region."}}]}</script>
<script type="application/ld+json">{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"https://krishnaoutdoor.in/"},{"@type":"ListItem","position":2,"name":"Transit Media","item":"https://krishnaoutdoor.in/media/transit"},{"@type":"ListItem","position":3,"name":"GSRTC Bus Advertising","item":"https://krishnaoutdoor.in/gsrtc-bus-advertising"}]}</script>
@endsection

@section('web-section')
<main>

<section class="hero media-detail-hero media-detail-hero-ooh" id="home">
    <div class="media-detail-hero-bg">
        <img alt="GSRTC bus advertising across Gujarat" decoding="async" loading="eager" src="{{ asset('assets/images/transit/ahmedabad-city-bus-advertising-05.png') }}"/>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-grid"></div>
    <div class="hero-noise"></div>
    <div class="container hero-inner reveal">
        <h1>
        @if ($seo->h1Override())
            {{ $seo->h1Override() }}
        @else
            GSRTC BUS ADVERTISING<br/><em>ACROSS GUJARAT</em>
        @endif
        </h1>
    </div>
</section>

<section class="kw-section"><div class="kw-inner">
    <div class="kw-crumbs"><a href="{{ route('view.home') }}">Home</a><span>/</span><a href="{{ route('view.transit.media') }}">Transit Media</a><span>/</span><b>GSRTC Bus Advertising</b></div>

    <div class="kw-grid-2">
        <div>
            <h2 class="kw-h2">GSRTC bus advertising with <em>Krishna Outdoor</em></h2>
            <p class="kw-p">Most outdoor advertising formats are built around a single city. GSRTC (Gujarat State Road Transport Corporation) buses are different — they connect every district of Gujarat, running routes between major cities, smaller towns and rural areas that no hoarding network or city bus service can reach on its own. Krishna Outdoor holds advertising rights on 7000+ GSRTC buses, making this one of the few outdoor formats that can genuinely deliver state-wide reach from a single booking.</p>

            <div class="kw-stat-row">
                <div class="kw-stat"><strong>7000+</strong><span>GSRTC Bus Advertising Rights</span></div>
                <div class="kw-stat"><strong>Gujarat-Wide</strong><span>District-to-District Coverage</span></div>
            </div>

            <h3 class="kw-h3">A rare, defensible asset: true state-wide reach</h3>
            <p class="kw-p">A hoarding in Ahmedabad reaches Ahmedabad. A city bus reaches that city. A GSRTC bus crosses district lines every day, carrying your brand from an urban center through highway stretches and into towns that most outdoor campaigns never touch. For brands whose customers, distributors or job candidates are spread across Gujarat rather than concentrated in one city, this scale of coverage is difficult to replicate with any other single format.</p>

            <h3 class="kw-h3">Formats available</h3>
            <ul class="kw-list">
                <li><b>Full wrap</b> — complete exterior branding for maximum visibility on highway and intercity routes.</li>
                <li><b>Panel formats</b> — side or back panels for brands wanting a strong presence across a larger number of buses at a lower per-bus cost.</li>
            </ul>

            <h3 class="kw-h3">Who GSRTC advertising works best for</h3>
            <p class="kw-p">This format suits brands that need to be visible across the whole state rather than one metro — FMCG companies launching a product statewide, education institutions recruiting from multiple districts, and government or PSU campaigns that are required to reach citizens beyond the major cities. It also works well alongside a city-focused campaign, with GSRTC buses extending a brand's reach into Gujarat's smaller towns while <a href="/hoarding-advertising-ahmedabad">Ahmedabad hoardings</a> or <a href="/amts-bus-advertising-ahmedabad">AMTS buses</a> cover the capital city in depth.</p>

            <h3 class="kw-h3">Process and timelines</h3>
            <ol class="kw-list">
                <li>Share your target districts, budget and campaign goal.</li>
                <li>We recommend a fleet size and route mix matched to your reach requirement.</li>
                <li>You confirm buses and send creative for printing.</li>
                <li>We coordinate printing, mounting and live reporting as the campaign rolls out.</li>
            </ol>

            <p class="kw-p">See how brands like these have used our transit network: explore our <a href="{{ route('view.projects') }}">campaign case studies</a>.</p>
        </div>

        <div class="kw-img">
            <img alt="Branded GSRTC bus on a Gujarat highway route" decoding="async" loading="lazy" src="{{ asset('assets/images/transit/surat-ev-bus-advertising-03.png') }}"/>
        </div>
    </div>

    <h3 class="kw-h3">More Ahmedabad &amp; Gujarat advertising formats</h3>
    <div class="kw-links">
        <a href="/amts-bus-advertising-ahmedabad">AMTS Bus Advertising Ahmedabad</a>
        <a href="/hoarding-advertising-ahmedabad">Hoarding Advertising Ahmedabad</a>
        <a href="{{ route('view.transit.media') }}">All Transit Media</a>
    </div>
</div></section>

<section class="kw-section kw-section-alt"><div class="kw-inner">
    <h2 class="kw-h2">Frequently asked <em>questions</em></h2>
    <div class="kw-faq">
        <details open>
            <summary>What area does GSRTC bus advertising cover?</summary>
            <p>GSRTC buses connect every district of Gujarat, from major cities to small towns and rural routes. This gives brands genuine state-wide coverage that a city-only format like a hoarding or city bus simply cannot match.</p>
        </details>
        <details>
            <summary>How is GSRTC bus advertising priced?</summary>
            <p>Pricing is based on the number of buses booked, the format (full wrap or panel) and campaign duration. Because GSRTC routes span the whole state, campaigns are typically planned around the districts or corridors most relevant to the brand's distribution or audience rather than a single city.</p>
        </details>
        <details>
            <summary>Is there a minimum campaign size for GSRTC bus advertising?</summary>
            <p>Campaigns can start with a small number of buses on specific routes, but most brands booking GSRTC advertising aim for a meaningful fleet size so the campaign reads as state-wide rather than isolated. Share your target districts and budget and we'll recommend a realistic fleet size.</p>
        </details>
        <details>
            <summary>How many GSRTC buses does Krishna Outdoor have advertising rights on?</summary>
            <p>Krishna Outdoor holds advertising rights on 7000+ GSRTC buses across Gujarat, making it one of the largest state transport advertising networks available to brands in the region.</p>
        </details>
    </div>
</div></section>

<section class="cta" id="contact">
    <div class="container cta-inner reveal">
        <div>
            <div class="tag light">LET'S CREATE</div>
            <h2>GET YOUR FREE GSRTC FLEET AVAILABILITY LIST</h2>
            <p>Tell us your target districts in Gujarat and we'll share available GSRTC buses with routes, formats and rates.</p>
        </div>
        <a class="btn white" href="{{ route('view.contact') }}">Get Fleet List <b>→</b></a>
    </div>
</section>

</main>
@endsection
