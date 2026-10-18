@extends('web.layouts.app')

@section('body-class', 'inner-page')
@section('nav', 'services')

@section('web-head')
@include('web.common.keyword-page-style')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"Service","serviceType":"Outdoor (OOH) Media","provider":{"@type":"Organization","name":"Krishna Outdoor"},"areaServed":{"@type":"State","name":"Gujarat"},"name":"Outdoor (OOH) Media in Gujarat","description":"Hoardings, unipoles, gantries and backlit bus shelters across Ahmedabad and Gujarat."}
</script>
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"https://krishnaoutdoor.in/"},{"@type":"ListItem","position":2,"name":"OOH Media","item":"https://krishnaoutdoor.in/media/ooh"}]}
</script>
<script type="application/ld+json">{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[{"@type":"Question","name":"What types of OOH media does Krishna Outdoor offer in Gujarat?","acceptedAnswer":{"@type":"Answer","text":"We offer frontlit and backlit hoardings, unipoles, gantries and backlit bus shelters across Ahmedabad and Gujarat, with 2000+ hoarding sites and 400+ bus shelter rights."}},{"@type":"Question","name":"How much does OOH advertising cost in Ahmedabad?","acceptedAnswer":{"@type":"Answer","text":"Cost depends on the format, location and booking duration — a hoarding on a high-traffic road costs more than a neighbourhood site, and backlit formats cost more than frontlit. Share your target area and budget for indicative rates."}},{"@type":"Question","name":"Does Krishna Outdoor own its hoarding sites?","acceptedAnswer":{"@type":"Answer","text":"Yes, Krishna Outdoor owns 300+ hoardings directly in Ahmedabad and has access to 2000+ sites across Gujarat, so you get real, verifiable locations rather than a generic listing."}},{"@type":"Question","name":"How long does it take to book OOH media in Gujarat?","acceptedAnswer":{"@type":"Answer","text":"Once a site is confirmed available and creative is ready, printing and mounting typically takes a few days. Popular locations can get booked out in advance, so early enquiry is recommended."}}]}</script>
@endsection

@section('web-section')

<main>

<!-- OOH HERO / BANNER -->
<section class="hero media-detail-hero media-detail-hero-ooh" id="home">

    <div class="media-detail-hero-bg">
        <img
            alt="Outdoor hoarding at night"
            decoding="async"
            loading="eager"
            src="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-02.webp') }}"
        />
    </div>

    <div class="hero-overlay"></div>
    <div class="hero-grid"></div>
    <div class="hero-noise"></div>

    <div class="container hero-inner reveal">
        <h1 class="seo-h1">{{ $seo->h1Override() ?: 'Outdoor (OOH) Media in Gujarat: Hoardings & Bus Shelters' }}</h1>
        <p class="seo-h1-slogan">OUTDOOR (OOH) MEDIA.</p>
    </div>

</section>


<!-- STATS STRIP - IMMEDIATELY BELOW OOH HERO -->
<section aria-label="Krishna Outdoor network highlights" class="stats stats-strip ooh-stats-scroll">
    
    <div class="stats-strip-track">

        <div class="stats-item">
            2000+
            <span>
                Hoardings Sites<br/>
                Across Gujarat.
            </span>
        </div>

        <div class="stats-item">
            300+
            <span>
                Own Hoardings<br/>
                in Ahmedabad<br/>
                
            </span>
        </div>

        <div class="stats-item">
            400+
            <span>
                Advertising Rights for<br/>
                Backlit Bus Shelters in<br/>
                Ahmedabad
            </span>
        </div>

        <div class="stats-item">
            200+
            <span>
                Advertising Rights for<br/>
                Surat City Electric Buses<br/>
                Full Wrap
            </span>
        </div>

        <div class="stats-item">
            400+
            <span>
                Advertising Rights for<br/>
                BEST EV Buses<br/>
                (BEST-TATA) Full Wrap
            </span>
        </div>

        <div class="stats-item">
            350+
            <span>
                Advertising Rights for<br/>
                Thane City Buses (TMT)
            </span>
        </div>
                
            <div class="stats-item">
            
            <span>
                Unipole/Gantries<br/>
                 Across Gujarat
            </span>
        </div>
    </div>

</section>


<!-- OOH CONTENT -->
<section class="section about" id="ooh-media">

    <div class="container about-grid">

        <div class="about-copy reveal">

            <div class="tag">OOH MEDIA</div>

            <h2>Make a Strong Impression in the Real World.</h2>

            <p>
                Outdoor advertising gives brands a physical presence in the places people see every day.
            </p>

            <ul style="list-style:none;padding:0;margin:0 0 20px;display:flex;flex-direction:column;gap:8px;">
                <li><a href="/hoarding-advertising-ahmedabad">Hoarding Advertising in Ahmedabad</a></li>
                <li><a href="/amts-bus-advertising-ahmedabad">AMTS Bus Advertising</a></li>
                <li><a href="/bus-shelter-advertising-ahmedabad">Bus Shelter Advertising</a></li>
                <li><a href="/gsrtc-bus-advertising">GSRTC Bus Advertising</a></li>
            </ul>

            <a class="small-btn" href="{{ route('view.contact') }}">
                Check Site Availability <span>→</span>
            </a>

        </div>


        <div class="about-scene reveal">

            <div class="about-frame f1">
                <img
                    alt="Outdoor billboard at night"
                    decoding="async"
                    loading="lazy"
                    src="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-03.webp') }}"
                />
            </div>

            <div class="about-frame f2">
                <img
                    alt="Krishna Outdoor hoarding"
                    decoding="async"
                    loading="lazy"
                    src="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-04.webp') }}"
                />
            </div>

            <div class="year-badge">
                2000+
                <span>
                    HOARDING<br/>
                    SITES ACROSS<br/>
                    GUJARAT
                </span>
            </div>

            <div class="about-frame f3">
                <img
                    alt="Outdoor advertising format"
                    decoding="async"
                    loading="lazy"
                    src="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-05.webp') }}"
                />
            </div>

            <div class="scan-line"></div>

        </div>

    </div>

</section>


<!-- CTA -->
<section class="kw-section kw-section-alt"><div class="kw-inner">
    <h2 class="kw-h2">Frequently asked <em>questions</em></h2>
    <div class="kw-faq">
        <details open>
            <summary>What types of OOH media does Krishna Outdoor offer in Gujarat?</summary>
            <p>We offer frontlit and backlit hoardings, unipoles, gantries and backlit bus shelters across Ahmedabad and Gujarat, with 2000+ hoarding sites and 400+ bus shelter rights.</p>
        </details>
        <details>
            <summary>How much does OOH advertising cost in Ahmedabad?</summary>
            <p>Cost depends on the format, location and booking duration — a hoarding on a high-traffic road costs more than a neighbourhood site, and backlit formats cost more than frontlit. Share your target area and budget for indicative rates.</p>
        </details>
        <details>
            <summary>Does Krishna Outdoor own its hoarding sites?</summary>
            <p>Yes, Krishna Outdoor owns 300+ hoardings directly in Ahmedabad and has access to 2000+ sites across Gujarat, so you get real, verifiable locations rather than a generic listing.</p>
        </details>
        <details>
            <summary>How long does it take to book OOH media in Gujarat?</summary>
            <p>Once a site is confirmed available and creative is ready, printing and mounting typically takes a few days. Popular locations can get booked out in advance, so early enquiry is recommended.</p>
        </details>
    </div>
</div></section>

<section class="cta" id="contact">

    <div class="container cta-inner reveal">

        <div>

            <div class="tag light">LET’S CREATE</div>

            <h2>ENQUIRE ABOUT OUTDOOR MEDIA</h2>

            <p>
                Explore hoarding opportunities across key cities, roads and high-visibility locations in Gujarat. From focused local campaigns to wider regional visibility, we help brands identify locations that match their audience and objective.
            </p>

        </div>

        <a class="btn white" href="{{ route('view.contact') }}">
            Get Site List <b>→</b>
        </a>

    </div>

</section>

</main>

@endsection

@section('web-script')

@endsection