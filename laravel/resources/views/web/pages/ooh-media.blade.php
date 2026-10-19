@extends('web.layouts.app')

@section('css-bundle', 'media')

@section('body-class', 'inner-page')
@section('nav', 'services')

@section('web-head')
@include('web.common.keyword-page-style')
@endsection

@section('web-section')

<main>

<!-- OOH HERO / BANNER -->
<section class="hero media-detail-hero media-detail-hero-ooh" id="home">

    <div class="media-detail-hero-bg">
        <img fetchpriority="high" srcset="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-02-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-hoarding-location-02.webp') }} 1600w" sizes="100vw"
            alt="Hoardings on a city road in Ahmedabad – Krishna Outdoor"
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


<!-- DIRECT ANSWER + FORMATS + CITIES -->
<section class="kw-section"><div class="kw-inner">
    <p class="kw-lead">Krishna Outdoor offers outdoor (OOH) media across Gujarat: 2000+ hoarding sites, including 300+ hoardings it owns in Ahmedabad, plus 400+ backlit bus shelters, unipoles and gantries. Brands can book a single site or a network across Ahmedabad and other cities in Gujarat. Ask for the free site list to see what is available.</p>

    <h2 class="kw-h2">OOH formats we <em>offer</em></h2>
    <ul class="kw-list">
        <li><b>Hoardings</b> — frontlit and backlit hoardings on high-traffic roads and junctions. See <a href="{{ route('view.keyword.hoarding.ahmedabad') }}">hoarding advertising in Ahmedabad</a>.</li>
        <li><b>Unipoles &amp; gantries</b> — single-pole and overhead structures on highways and major junctions for maximum visibility.</li>
        <li><b>Backlit bus shelters</b> — eye-level panels at commuter stops in Ahmedabad. See <a href="{{ route('view.keyword.bus.shelter.ahmedabad') }}">bus shelter advertising in Ahmedabad</a>.</li>
    </ul>

    <h3 class="kw-h3">Cities covered</h3>
    {{-- TODO: client to confirm the list of Gujarat cities where hoardings, unipoles and gantries are available. Only Ahmedabad and "Gujarat" are named on the site today. --}}
    <p class="kw-p">Ahmedabad, with 300+ own hoardings and 400+ backlit bus shelters, and key cities across Gujarat, with 2000+ hoarding sites, unipoles and gantries in total.</p>

    <h3 class="kw-h3">Explore by format</h3>
    <div class="kw-links">
        <a href="{{ route('view.keyword.hoarding.ahmedabad') }}">Hoarding Advertising in Ahmedabad</a>
        <a href="{{ route('view.keyword.bus.shelter.ahmedabad') }}">Bus Shelter Advertising in Ahmedabad</a>
        <a href="{{ route('view.keyword.amts.ahmedabad') }}">AMTS Bus Advertising in Ahmedabad</a>
        <a href="{{ route('view.keyword.gsrtc') }}">GSRTC Bus Advertising</a>
        <a href="{{ route('view.digital.media') }}">Digital (DOOH) Advertising</a>
    </div>
</div></section>

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

            <a class="small-btn" href="{{ route('view.free.site.list', ['media' => 'ooh']) }}">
                Get Free Site List <span>→</span>
            </a>

        </div>


        <div class="about-scene reveal">

            <div class="about-frame f1">
                <img srcset="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-03-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-hoarding-location-03.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw"
                    alt="Hoardings at a road junction in Ahmedabad – Krishna Outdoor"
                    decoding="async"
                    loading="lazy"
                    src="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-03.webp') }}"
                />
            </div>

            <div class="about-frame f2">
                <img srcset="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-04-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-hoarding-location-04.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw"
                    alt="Hoardings above a busy road in Ahmedabad – Krishna Outdoor"
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
                <img srcset="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-05-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-hoarding-location-05.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw"
                    alt="Hoardings at a busy road junction in Ahmedabad – Krishna Outdoor"
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
    @include('web.common.faq', ['faqs' => [
        ['q' => 'What types of OOH media does Krishna Outdoor offer in Gujarat?', 'a' => 'We offer frontlit and backlit hoardings, unipoles, gantries and backlit bus shelters across Ahmedabad and Gujarat, with 2000+ hoarding sites and 400+ bus shelter rights.'],
        ['q' => 'How much does OOH advertising cost in Ahmedabad?', 'a' => 'Cost depends on the format, location and booking duration — a hoarding on a high-traffic road costs more than a neighbourhood site, and backlit formats cost more than frontlit. Share your target area and budget for indicative rates.'],
        ['q' => 'Does Krishna Outdoor own its hoarding sites?', 'a' => 'Yes, Krishna Outdoor owns 300+ hoardings directly in Ahmedabad and has access to 2000+ sites across Gujarat, so you get real, verifiable locations rather than a generic listing.'],
        ['q' => 'How long does it take to book OOH media in Gujarat?', 'a' => 'Once a site is confirmed available and creative is ready, printing and mounting typically takes a few days. Popular locations can get booked out in advance, so early enquiry is recommended.'],
    ]])
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

        <a class="btn white" href="{{ route('view.free.site.list', ['media' => 'ooh']) }}">
            Get Free Site List <b>→</b>
        </a>

    </div>

</section>

</main>

@endsection

@section('web-script')

@endsection