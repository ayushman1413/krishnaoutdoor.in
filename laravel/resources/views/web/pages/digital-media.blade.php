@extends('web.layouts.app')

@section('body-class', 'inner-page')
@section('nav', 'services')

@section('web-head')

@include('web.common.keyword-page-style')




@endsection


@section('web-section')

<main>

    <!-- =========================
         HERO
    ========================== -->
    <section class="hero media-detail-hero media-detail-hero-digital" id="home">

        <div class="media-detail-hero-bg">
            <img
                alt="Birdsong real-estate illuminated billboard at night – Krishna Outdoor"
                decoding="async"
                loading="eager"
                fetchpriority="high"
                src="{{ asset('assets/images/home/work-1.webp') }}"
            />
        </div>

        <div class="hero-overlay"></div>
        <div class="hero-grid"></div>
        <div class="hero-noise"></div>

        <div class="container hero-inner reveal">
            <h1 class="seo-h1">{{ $seo->h1Override() ?: 'Digital Out-of-Home (DOOH) Advertising in Ahmedabad' }}</h1>
            <p class="seo-h1-slogan">DIGITAL OUT-OF-HOME.</p>
        </div>

    </section>


    <!-- =========================
         DIGITAL MEDIA INTRO
    ========================== -->
    <section class="section about" id="digital-media">

        <div class="container about-grid">

            <div class="about-copy reveal">

                <div class="tag">
                    DIGITAL MEDIA
                </div>

                <h2>
                    Keep the Conversation Going.
                </h2>

                <p>
                    Today's audience moves between the physical and digital worlds throughout the day.
                </p>

                <a class="small-btn" href="{{ route('view.free.site.list', ['media' => 'dooh']) }}">
                    Get Free Site List
                    <span>→</span>
                </a>

            </div>


            <div class="about-scene reveal">

                <div class="about-frame f1">
                    <img
                        alt="Backlit Airtel 5G Plus ad panels at a Mumbai railway station – Krishna Outdoor"
                        decoding="async"
                        loading="lazy"
                        src="{{ asset('assets/images/shared-mumbai-local-train-advertising.webp') }}"
                    />
                </div>

                <div class="about-frame f2">
                    <img
                        alt="Godrej 3D washing machine hoarding at a busy market at night – Krishna Outdoor"
                        decoding="async"
                        loading="lazy"
                        src="{{ asset('assets/images/media/home-360-outdoor-hoarding-night-01.webp') }}"
                    />
                </div>

                <div class="year-badge">
                    DOOH
                    <span>
                        DYNAMIC<br/>
                        SCREENS,<br/>
                        REAL-TIME REACH
                    </span>
                </div>

                <div class="about-frame f3">
                    <img
                        alt="Illuminated large-format billboard at night – Krishna Outdoor"
                        decoding="async"
                        loading="lazy"
                        src="{{ asset('assets/images/home/home-360-f2.webp') }}"
                    />
                </div>

                <div class="scan-line"></div>

            </div>

        </div>

    </section>


    <!-- =========================
         OUR SOLUTIONS
    ========================== -->
    <section class="solution-showcase section" id="showcase">

        <div aria-hidden="true" class="showcase-orbit-bg">
            <span></span>
            <span></span>
            <span></span>
        </div>


        <div class="container showcase-grid showcase-v2">


            <!-- LEFT CONTENT -->
            <div class="showcase-copy reveal">

                <div class="tag light">
                    OUR SOLUTIONS
                </div>

                <br>

                <h2>
                    Our<br/>
                    <em id="showcaseTitle">Outdoor Media</em>
                </h2>

                <p>
                    We help brands strengthen their online presence and support campaign objectives through relevant digital communication and performance-focused activity.
                </p>


                <!-- SOLUTION TABS -->
                <div
                    aria-label="Media solutions"
                    class="showcase-tabs"
                    role="tablist"
                >

                    <!-- OOH MEDIA -->
                    <button
                        class="tab active"
                        data-panel="ooh"
                        role="tab"
                        type="button"
                    >
                        <span>01</span>
                        <b>OOH Media</b>
                        <i>→</i>
                    </button>


                    <!-- TRANSIT MEDIA -->
                    <button
                        class="tab"
                        data-panel="transit"
                        role="tab"
                        type="button"
                    >
                        <span>02</span>
                        <b>Transit Media</b>
                        <i>→</i>
                    </button>


                    <!-- PRINT & ELECTRONIC MEDIA -->
                    <button
                        class="tab"
                        data-panel="print"
                        role="tab"
                        type="button"
                    >
                        <span>03</span>
                        <b>Print &amp; Electronic Media</b>
                        <i>→</i>
                    </button>

                </div>


                <!-- SELECTED FORMAT COUNTER HIDDEN -->
                <!--<div class="showcase-meta">
                    <span>SELECTED FORMAT</span>
                    <strong id="showcaseIndex">01 — 03</strong>
                </div>-->

            </div>


            <!-- RIGHT VISUAL -->
            <div class="showcase-visual-wrap reveal">

                <div
                    class="showcase-visual-v2"
                    id="showcaseVisual"
                >

                    <!-- TOP LINE HIDDEN -->
                    <!--<div class="visual-topline">
                        <span>360° MEDIA</span>
                        <span class="visual-live">
                            <i></i> LIVE FORMAT
                        </span>
                    </div>-->


                    <!-- MAIN IMAGE -->
                    <img
                        alt="Hoardings at a road junction in Ahmedabad – Krishna Outdoor"
                        decoding="async"
                        id="showcaseImage"
                        loading="lazy"
                        src="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-03.jpeg') }}"
                    />


                    <div class="showcase-visual-shade"></div>


                    <!-- IMAGE CAPTION -->
                    <div class="visual-caption">

                        <small id="showcaseVisualKicker">
                            OOH MEDIA
                        </small>

                        <strong id="showcaseVisualTitle">
                            OUTDOOR MEDIA
                        </strong>

                    </div>


                    <div class="visual-corner">
                        KRISHNA<br/>
                        OUTDOOR
                    </div>

                </div>


                <div class="showcase-orbit-line"></div>


                <!-- NEXT CARD HIDDEN -->
                <!--<div class="showcase-next-card">
                    <span>NEXT</span>
                    <b>FORMAT</b>
                    <i>↗</i>
                </div>-->

            </div>

        </div>

    </section>


    <!-- =========================
         FAQ
    ========================== -->
    <section class="kw-section kw-section-alt"><div class="kw-inner">
        <h2 class="kw-h2">Frequently asked <em>questions</em></h2>
        @include('web.common.faq', ['faqs' => [
            ['q' => 'What is DOOH advertising?', 'a' => 'Digital Out-of-Home (DOOH) advertising displays content on digital billboards and screens, allowing dynamic creative, scheduled campaigns and real-time updates instead of a single static print.'],
            ['q' => 'Where are Krishna Outdoor\'s DOOH screens located in Ahmedabad?', 'a' => 'Our digital billboards and screens are placed across prime, high-traffic locations in Ahmedabad for maximum audience reach.'],
            ['q' => 'What are the benefits of DOOH over traditional hoardings?', 'a' => 'DOOH allows dynamic creative changes, dayparting (different ads at different times), faster campaign turnaround and the ability to run multiple brands or messages on the same screen.'],
            ['q' => 'How do I book a DOOH campaign in Ahmedabad?', 'a' => 'Share your target locations, campaign dates and creative requirements, and our team will share available screens with rates and specifications.'],
        ]])
    </div></section>


    <!-- =========================
         CTA
    ========================== -->
    <section class="cta" id="contact">

        <div class="container cta-inner reveal">

            <div>

                <div class="tag light">
                    LET’S CREATE
                </div>

                <h2>
                    Outdoor + Digital
                </h2>

                <p>
                    One of the strongest opportunities for modern campaigns is connecting physical visibility with digital communication — creating attention in the real world and continuing the conversation online.
                </p>

            </div>


            <a
                class="btn white"
                href="{{ route('view.contact') }}"
            >
                Enquire Now
                <b>→</b>
            </a>

        </div>

    </section>

</main>

@endsection


@section('web-script')

@endsection