@extends('web.layouts.app')

@section('css-bundle', 'media')

@section('body-class', 'inner-page')
@section('nav', 'services')

@section('web-head')
@include('web.common.keyword-page-style')
@endsection

@section('web-section')

<main>

<!-- TRANSIT HERO / BANNER -->
<section class="hero media-detail-hero media-detail-hero-transit" id="home">
    <div class="media-detail-hero-bg">
        <img fetchpriority="high" srcset="{{ asset('assets/images/transit/transit-banner-800w.webp') }} 800w, {{ asset('assets/images/transit/transit-banner.webp') }} 1280w" sizes="100vw"
            alt="Prefr Mushak Loan full-wrap branding on a BEST electric bus in Mumbai – Krishna Outdoor"
            decoding="async"
            loading="eager"
            src="{{ asset('assets/images/transit/transit-banner.webp') }}"
        />
    </div>

    <div class="hero-overlay"></div>
    <div class="hero-grid"></div>
    <div class="hero-noise"></div>

    <div class="container hero-inner reveal">
        <h1 class="seo-h1">{{ $seo->h1Override() ?: 'Transit Advertising Agency in Mumbai & Gujarat' }}</h1>
        <p class="seo-h1-slogan">TRANSIT MEDIA.</p>
    </div>
</section>


<!-- STATS STRIP - IMMEDIATELY BELOW TRANSIT HERO -->
<section aria-label="Krishna Outdoor network highlights" class="stats stats-strip">
    <div class="stats-strip-track">
        
        <div class="stats-item">
            7000+
            <span>
                Advertising Rights for<br/>
                GJ State Buses <br/>
                (GSRTC)
            </span>
        </div>

        <div class="stats-item">
            900+
            <span>
                Advertising Rights for<br/>
                Ahmedabad City Buses<br/>
                (AMTS)
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
                Thane City Buses<br/>
                (TMT)
            </span>
        </div>

        <div class="stats-item">
            110+
            <span>
                Advertising Rights for<br/>
                Jaipur City Buses<br/>
                (JCSTL)
            </span>
        </div>

    </div>
</section>


<!-- TRANSIT CONTENT -->
<section class="section about" id="transit-media">
    <div class="container about-grid">

        <div class="about-copy reveal">
            <div class="tag">TRANSIT MEDIA</div>

            <h2>Visibility That Moves with Your Audience.</h2>

            <p>
                Transit advertising takes a brand into everyday movement.
            </p>

            <ul style="list-style:none;padding:0;margin:0 0 20px;display:flex;flex-direction:column;gap:8px;">
                <li><a href="/mumbai-local-train-advertising">Mumbai Local Train Advertising</a></li>
                <li><a href="/best-bus-advertising-mumbai">BEST Bus Advertising Mumbai</a></li>
                <li><a href="/tmt-bus-advertising-thane">TMT Bus Advertising Thane</a></li>
                <li><a href="/gsrtc-bus-advertising">GSRTC Bus Advertising</a></li>
                <li><a href="/amts-bus-advertising-ahmedabad">AMTS Bus Advertising Ahmedabad</a></li>
            </ul>

            <a class="small-btn" href="{{ route('view.contact') }}">
                Explore Transit Rights <span>→</span>
            </a>
        </div>

        <div class="about-scene reveal">

            <div class="about-frame f1">
                <img srcset="{{ asset('assets/images/transit/mumbai-local-train-cosmos-bank-01-800w.webp') }} 800w, {{ asset('assets/images/transit/mumbai-local-train-cosmos-bank-01.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw"
                    alt="Cosmos Co-operative Bank branding on Mumbai local train coaches – Krishna Outdoor"
                    decoding="async"
                    loading="lazy"
                    src="{{ asset('assets/images/transit/mumbai-local-train-cosmos-bank-01.webp') }}"
                />
            </div>

            <div class="about-frame f2">
                <img srcset="{{ asset('assets/images/home/home-f1-800w.webp') }} 800w, {{ asset('assets/images/home/home-f1.webp') }} 1280w" sizes="(max-width: 760px) 100vw, 50vw"
                    alt="GreatWhite Electricals branding on an electric city bus – Krishna Outdoor"
                    decoding="async"
                    loading="lazy"
                    src="{{ asset('assets/images/home/home-f1.webp') }}"
                />
            </div>

            <div class="year-badge">
                900+
                <span>
                    CITY BUS<br/>
                    ADVERTISING<br/>
                    RIGHTS
                </span>
            </div>

            <div class="about-frame f3">
             <img srcset="{{ asset('assets/images/home/home-360-bus-hd-800w.webp') }} 800w, {{ asset('assets/images/home/home-360-bus-hd.webp') }} 1280w" sizes="(max-width: 760px) 100vw, 50vw"
                  alt="GreatWhite Electricals branding on an electric city bus in Gujarat – Krishna Outdoor"
                  decoding="async"
                  loading="lazy"
                   src="{{ asset('assets/images/home/home-360-bus-hd.webp') }}"
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
        ['q' => 'Which transit media options does Krishna Outdoor offer?', 'a' => 'We offer advertising on Mumbai local trains (Western and Central lines), BEST and TMT buses in Mumbai and Thane, plus GSRTC and AMTS buses across Gujarat.'],
        ['q' => 'How many bus advertising rights does Krishna Outdoor hold?', 'a' => 'We hold rights on 7000+ GSRTC buses, 900+ AMTS buses in Ahmedabad, 400+ BEST buses in Mumbai and 350+ TMT buses in Thane.'],
        ['q' => 'What formats are available for bus and train advertising?', 'a' => 'Formats include full-wrap, side-panel and back-panel bus branding, plus exterior formats on Mumbai local trains, depending on the operator and route.'],
        ['q' => 'How far in advance should I book transit advertising?', 'a' => 'Popular routes and high-visibility buses or trains can book out in advance, so we recommend enquiring a few weeks ahead of your planned campaign start.'],
    ]])
</div></section>

<section class="cta" id="contact">
    <div class="container cta-inner reveal">

        <div>
            <div class="tag light">LET’S CREATE</div>

            <h2>ENQUIRE ABOUT TRANSIT MEDIA</h2>

            <p>
                Ahmedabad City Buses
                Surat EV Buses
                Mumbai Local Train Advertising
                BEST Buses — Mumbai
                TMT Buses — Thane
                Jaipur City Buses
            </p>
        </div>

        <a class="btn white" href="{{ route('view.free.site.list', ['media' => 'transit']) }}">
            Get Free Site List <b>→</b>
        </a>

    </div>
</section>

</main>

@endsection

@section('web-script')

@endsection