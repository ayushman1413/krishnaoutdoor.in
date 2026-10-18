@extends('web.layouts.app')

@section('css-bundle', 'home')

@section('body-class', 'home-page')
@section('nav', 'home')

@section('web-head')
<link rel="preload" as="image" fetchpriority="high" media="(max-width: 760px)" href="{{ \App\Services\Asset::url('assets/images/hero/hero-mobile-poster.webp') }}">
<link rel="preload" as="image" fetchpriority="high" media="(min-width: 761px)" href="{{ \App\Services\Asset::url('assets/images/hero/hero-desktop-poster.webp') }}">
@endsection

@section('web-section')

    <main>
        @php
            \App\Services\SchemaBuilder::addVideo('hero');
            \App\Services\SchemaBuilder::addVideo('showcase');
        @endphp
        <section class="hero" id="home">
            <video aria-hidden="true" muted="" class="hero-media hero-media-desktop js-defer-hero-video" loop=""
                playsinline="" preload="none" poster="{{ \App\Services\Asset::url('assets/images/hero/hero-desktop-poster.webp') }}"
                data-src="{{ \App\Services\Asset::url('assets/videos/hero-desktop.mp4') }}">
            </video>
            <video aria-hidden="true" muted="" class="hero-media hero-media-mobile js-defer-hero-video" loop=""
                playsinline="" preload="none" poster="{{ \App\Services\Asset::url('assets/images/hero/hero-mobile-poster.webp') }}"
                data-src="{{ \App\Services\Asset::url('assets/videos/hero-mobile.mp4') }}">
            </video>
            <div class="hero-overlay"></div>
            <div class="hero-grid"></div>
            <div class="hero-noise"></div>
            <div class="container hero-inner reveal">
                <h1 class="seo-h1">{{ $seo->h1Override() ?: 'Outdoor Advertising Agency in Ahmedabad' }}</h1>
                <p class="seo-h1-slogan">BE WHERE YOUR AUDIENCE IS.</p>
            </div>
        </section>
        <!--<section aria-label="Krishna Outdoor network highlights" class="stats stats-strip">-->
        <!--    <div class="stats-strip-track">-->
        <!--        <div class="stats-item">2000+<span>Hoarding Sites<br />Across Gujarat.</span></div>-->
        <!--        <div class="stats-item">900+<span>Ahmedabad City Bus<br />Advertising Opportunities</span></div>-->
        <!--        <div class="stats-item">400+<span>Backlit Bus Shelter<br />Advertising Opportunities</span></div>-->
        <!--        <div class="stats-item">200+<span>Surat EV Bus<br />Advertising Opportunities</span></div>-->
        <!--        <div class="stats-item">400+<span>BEST EV Bus<br />Advertising Opportunities</span></div>-->
        <!--        <div class="stats-item">350+<span>TMT Bus<br />Advertising Opportunities</span></div>-->
        <!--    </div>-->
        <!--</section>--> 
<section aria-label="Krishna Outdoor network highlights" class="stats stats-strip">
    <div class="stats-strip-track">

        <!-- 1 -->
        <div class="stats-item">
            <strong>2000+</strong>
            <span>
                HOARDINGS SITES<br />
                ACROSS GUJARAT.
                <small>High-visibility hoardings at prime locations across Gujarat for unmatched brand exposure.</small>
            </span>
        </div>

        <!-- 2 -->
        <div class="stats-item">
            <strong>7000+</strong>
            <span>
                ADVERTISING RIGHTS FOR<br />
                GJ STATE BUSES (GSRTC)<br />
                
                <small>Extensive reach across Gujarat via GSRTC buses.</small>
            </span>
        </div>

        <!-- 3 -->
        <div class="stats-item">
            <strong>900+</strong>
            <span>
                ADVERTISING RIGHTS FOR<br />
                AHMEDABAD CITY BUSES (AMTS)<br />
                
                <small>Extensive reach across Ahmedabad via AMTS bus branding.</small>
            </span>
        </div>

        <!-- 4 -->
        <div class="stats-item">
            <strong>400+</strong>
            <span>
                ADVERTISING RIGHTS FOR<br />
                BEST EV BUSES<br />
                (BEST-TATA FULL WRAP)
                <small>City-wide coverage across prime locations and high-traffic routes.</small>
            </span>
        </div>

        <!-- 5 -->
        <div class="stats-item">
            <strong>350+</strong>
            <span>
                ADVERTISING RIGHTS FOR<br />
                THANE CITY BUSES (TMT)<br />
                
                <small>Strong reach across Thane's key routes and growing commuter base.</small>
            </span>
        </div>

        <!-- 6 -->
        <div class="stats-item">
            <strong>DISPLAY RIGHTS FOR<br />MUMBAI LOCAL TRAINS</strong>
            <span>
                (WR &amp; CR)
                <small>Unmatched daily visibility with thousands of commuters across Western &amp; Central Railways.</small>
            </span>
        </div>

    </div>
</section>

        <section class="experience section" id="experience">
            <div class="container experience-grid">
                <div class="experience-art reveal">
                    <div class="experience-art-glow"></div>
                    <img alt="Krishna Outdoor experience illustration" decoding="async" loading="lazy"
                        src="{{ asset('assets/images/home-illustration.webp') }}" />
                    <span class="experience-dot d1"></span><span class="experience-dot d2"></span><span
                        class="experience-dot d3"></span>
                </div>
                <div class="experience-copy reveal">
                    <div class="since">SINCE 1985</div>
                    <h2>40 Years of Building<br />Brand Visibility.</h2>
                    <p class="experience-quote">Cities have changed. Audiences have changed. Media has
                        changed.<br /><br />But one thing has remained the same — brands need to be where their audiences
                        are.<br /><br />For more than four decades, Krishna Outdoor has helped brands create meaningful
                        visibility across outdoor and transit environments. Today, our wider advertising capabilities also
                        extend across print, electronic, digital, social and branding solutions.<br /><br />From one strong
                        outdoor location to a fully integrated campaign, we help brands explore the opportunities that make
                        the most sense for their objective.</p>
                    <div class="experience-actions"><a class="experience-link" href="{{ route('view.about') }}">Discover Our
                            Story <span>→</span></a><a class="experience-link" href="{{ route('view.contact') }}">Plan Your
                            Campaign <span>→</span></a></div>
                </div>
            </div>
        </section>
        <section class="section about" id="about">
            <div class="container about-grid">
                <div class="about-copy reveal">
                    <div class="tag">KRISHNA OUTDOOR</div>
                    <h2>ONE PARTNER.<br />MULTIPLE MEDIA.<br /><em>ONE CLEAR OBJECTIVE.</em></h2>
                    <p>Your audience does not spend its day in one place or on one platform.<br /><br />They travel through
                        cities. Commute by bus and train. Read newspapers. Listen to radio. Watch television and OTT. Engage
                        with digital and social content.<br /><br />That is why Krishna Outdoor brings together a complete
                        range of advertising and media solutions under one experienced team.</p><a class="small-btn"
                        href="{{ route('view.about') }}">DISCOVER OUR STORY <span>→</span></a>
                </div>
                <div class="about-scene reveal">
                    <div class="about-frame f1"><img srcset="{{ asset('assets/images/home/home-f1-800w.webp') }} 800w, {{ asset('assets/images/home/home-f1.webp') }} 1280w" sizes="(max-width: 760px) 100vw, 50vw" alt="GreatWhite Electricals branding on an electric city bus – Krishna Outdoor" decoding="async" loading="lazy"
                            src="{{ asset('assets/images/home/home-f1.webp') }}" /></div>
                    <div class="about-frame f2"><img srcset="{{ asset('assets/images/home/home-360-f2-800w.webp') }} 800w, {{ asset('assets/images/home/home-360-f2.webp') }} 1280w" sizes="(max-width: 760px) 100vw, 50vw" alt="Birdsong real-estate backlit hoarding at night – Krishna Outdoor" decoding="async"
                            loading="lazy" src="{{ asset('assets/images/home/home-360-f2.webp') }}" />
                    </div>
                    <div class="year-badge">40+<span>YEARS OF<br />BUILDING BRAND<br />VISIBILITY</span></div>
                    <div class="about-frame f3"><img srcset="{{ asset('assets/images/home/home-360-mumbai-train-800w.webp') }} 800w, {{ asset('assets/images/home/home-360-mumbai-train.webp') }} 1280w" sizes="(max-width: 760px) 100vw, 50vw" alt="Cosmos Co-operative Bank branding on a Mumbai local train – Krishna Outdoor" decoding="async"
                        loading="lazy"
                        src="{{ asset('assets/images/home/home-360-mumbai-train.webp') }}" /></div>
                   <div class="scan-line"></div>
                </div>
            </div>
        </section>
        <section class="solutions-360 section" id="solutions">
            <div class="container">
                <div class="section-head reveal">
                    <div class="tag">OUR SOLUTIONS</div>
                    <h2><em>360°</em> SOLUTIONS PREVIEW</h2>
                    <p>ONE PARTNER. MULTIPLE MEDIA. ONE CLEAR OBJECTIVE.</p>
                </div>
                <div class="orbit-layout">
                    <div class="orbit-ring">
                        <div class="orbit-glow"></div>
                        <div class="orbit-center"><span>360°</span><b id="orbitServiceNo">01 / 06</b></div>
                        <button class="orbit-card oc1 active"
                            data-service="Outdoor Advertising"><b>01</b><span>Outdoor</span></button>
                        <button class="orbit-card oc2"
                            data-service="Transit Advertising"><b>02</b><span>Transit</span></button>
                        <button class="orbit-card oc3"
                            data-service="Print Advertising"><b>03</b><span>Print</span></button>
                        <button class="orbit-card oc4"
                            data-service="Electronic Media"><b>04</b><span>Electronic</span></button>
                        <button class="orbit-card oc5"
                            data-service="Digital Marketing"><b>05</b><span>Digital</span></button>
                        <button class="orbit-card oc6"
                            data-service="Branding Solutions"><b>06</b><span>Branding</span></button>
                    </div>
                    <div class="service-panel reveal">
                        <!--<div class="service-count" id="serviceCount">01 / 06</div>-->
                        <!--<div class="tag">SELECTED FORMAT</div>-->
                        <h3 id="serviceTitle">Make a Strong Impression in the Real World.</h3>
                        <p id="serviceText">Outdoor advertising gives brands a physical presence in the places people see
                            every day. Through our network of hoardings, unipoles and gantries, Krishna Outdoor helps brands
                            create high-impact visibility across Ahmedabad, Gujarat and other key markets.</p>
                        <div class="service-meter"><span id="serviceMeter"></span></div>
                        
                        <!--<button class="service-next"id="serviceNext">NEXT FORMAT <span>→</span></button>-->
                    </div>
                </div>
            </div>
        </section>
        <section class="section doc-home-block" id="why-krishna-doc">
            <div class="container doc-home-grid">
                <div class="doc-home-copy">
                    <div class="tag">WHY KRISHNA OUTDOOR</div>
                    <h2>Experience Across Media.<br /><em>Focus on Your Objective.</em></h2>
                    <p>We do not believe every campaign needs the same media.</p>
                    <p>Some brands need scale. Some need frequency. Some need local market visibility. Others need a
                        combination of physical and digital communication.</p>
                    <p>Our role is to understand the objective first and then help identify the media opportunities that can
                        support it.</p>
                    <p>With more than 40 years of experience in advertising, we bring together market understanding, media
                        relationships and execution experience to help make campaign planning simpler and visibility
                        stronger.</p>
                </div>
                <div class="doc-home-panel">
                    <div class="tag light">BRAND THOUGHT</div>
                    <h3>THE RIGHT PLACE CAN CHANGE EVERYTHING.</h3>
                    <p>A strong idea deserves to be seen in the right environment.</p>
                    <p>On the right road. Along the right route. During the daily commute. In a trusted publication. On a
                        screen. In a conversation.</p>
                    <p>The right media placement can turn communication into visibility.</p>
                    <p>And visibility into recall.</p>
                </div>
            </div>
        </section>
        <section class="section doc-home-legacy" id="media-legacy-doc">
            <div class="container">
                <div class="tag">MEDIA LEGACY</div>
                <h2>Built on a Wider Advertising Legacy.</h2>
                <p>Krishna Outdoor's strength is supported by decades of wider advertising experience.</p>
                <p>Beyond outdoor and transit, our integrated media capabilities extend into print, electronic, social and
                    branding solutions — strengthened by the advertising legacy and experience of Rakesh Advertising.</p>
                <p>This allows Krishna Outdoor to offer clients a broader perspective on communication while maintaining one
                    clear and consistent brand experience.</p>
            </div>
        </section>
        <section class="clients" id="clients">
            <div class="clients-bg"></div>
            <div class="container clients-wrap">
                <div class="clients-copy reveal">
                    <div class="tag light">WHO WE WORK WITH</div>
                    <h2>Our Esteemed<br /><em>Clients</em></h2>
                    <p>We partner with brands across outdoor, transit and integrated media to create visibility across the
                        places that matter.</p>
                    <div class="client-drag-hint"><span>DRAG / SWIPE</span><i>↔</i></div>
                </div>
                <div class="client-stage">
                    <div class="client-arc"></div>
                    <div class="client-carousel" id="clientCarousel"></div>
                    <div class="client-reflection"></div>
                    <div class="client-360"><span class="ring"></span><svg fill="none" viewbox="0 0 40 16">
                            <path d="M4 12 A16 12 0 0 1 34 8" stroke="#fff" stroke-width="2"></path>
                            <path d="M29 3 L35 8 L28 10Z" fill="#fff"></path>
                        </svg><b>360°</b></div>
                </div>
            </div>
        </section>
        
        @include('web.common.testimonials')

        <section class="solution-showcase section" id="showcase">
            <div aria-hidden="true" class="showcase-orbit-bg"><span></span><span></span><span></span></div>
            <div class="container showcase-grid showcase-v2">
                <div class="showcase-copy reveal">
                    <div class="tag light">OUR SOLUTIONS</div>
                   <br>
                    <h2>ONE PARTNER.<br /><em id="showcaseTitle">MULTIPLE MEDIA.</em></h2>
                    <p>Your audience is everywhere — on the road, in transit, in print, on screens and across digital
                        platforms.<br />Krishna Outdoor brings together a complete range of advertising and media solutions
                        to help brands build visibility across the touchpoints that matter.</p>
                    <div aria-label="Media solutions" class="showcase-tabs" role="tablist">
                        <button class="tab active" data-panel="ooh" role="tab"><span>01</span><b>OOH
                                Media</b><i>→</i></button>
                        <button class="tab" data-panel="transit" role="tab"><span>02</span><b>Transit
                                Media</b><i>→</i></button>
                        <button class="tab" data-panel="print" role="tab"><span>03</span><b>Print &amp; Electronic
                                Media</b><i>→</i></button>
                    </div>
                  
                </div>
                <div class="showcase-visual-wrap reveal">
                    <div class="showcase-visual-v2" id="showcaseVisual">
                        <div class="visual-topline"><span class="visual-live"><i></i></span></div>
                        <img srcset="{{ asset('assets/images/ooh-media-category-image-800w.webp') }} 800w, {{ asset('assets/images/ooh-media-category-image.webp') }} 1200w" sizes="(max-width: 760px) 100vw, 50vw" alt="Revital branding on a Mumbai local train – Krishna Outdoor" decoding="async" id="showcaseImage"
                            loading="lazy"src="{{ asset('assets/images/ooh-media-category-image.webp') }}" />
                        <div class="showcase-visual-shade"></div>
                        <div class="visual-caption"><small id="showcaseVisualKicker">OOH MEDIA</small><strong
                                id="showcaseVisualTitle">OUTDOOR MEDIA</strong></div>
                        <div class="visual-corner">KRISHNA<br />OUTDOOR</div>
                    </div>
                    
                </div>
            </div>
        </section>
        <section class="section work" id="work">
    <div class="container work-grid">

        <!-- LEFT CONTENT -->
        <div class="work-copy reveal">
            <div class="tag">OUR WORK</div>

            <h2>
                ONE CAMPAIGN.<br />
                <em>MANY<br />POSSIBILITIES.</em>
            </h2>

            <p>
                Every campaign is different. The right solution may be one powerful media format
                or a combination of several. Our job is to help you understand the possibilities
                and build a media approach around your objective, audience and market.
            </p>

            <a class="small-btn" href="{{ route('view.projects') }}">
                View Campaigns <span>→</span>
            </a>
        </div>


        <!-- RIGHT WORK GALLERY -->
        <div class="work-gallery reveal">

            <!-- MAIN VIDEO -->
            <article class="work-video-card">

                <video aria-hidden="true" tabindex="-1" loop muted playsinline preload="none" class="js-defer-inview-video"
                    poster="{{ asset('assets/images/hero/work-showcase-poster.webp') }}"
                    data-src="{{ asset('assets/videos/work-showcase.mp4') }}">
                </video>

                <div class="work-video-shade"></div>

                <div class="work-video-label">
                    <small>KRISHNA OUTDOOR / REAL IMPACT</small>

                    <span>
                        PLAYING <i></i>
                    </span>
                </div>

            </article>


            <!-- BOTTOM IMAGE CARDS -->
            <div class="work-bottom-wrap">

                <button
                    aria-label="Previous work"
                    class="work-scroll-arrow prev"
                    id="workPrev"
                    type="button"
                >
                    ‹
                </button>


                <div class="work-bottom-viewport" id="workViewport" tabindex="0" role="region" aria-label="Campaign gallery (scrollable)">

                    <div class="work-bottom-track" id="workTrack">

                        <!-- IMAGE 1 -->
                        <article class="work-card" onclick="window.open('{{ asset('assets/images/work/brand-billboard-campaign-04.webp') }}', '_blank')" style="cursor: pointer;">

                            <img srcset="{{ asset('assets/images/work/brand-billboard-campaign-04-800w.webp') }} 800w, {{ asset('assets/images/work/brand-billboard-campaign-04.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw"
                                src="{{ asset('assets/images/work/brand-billboard-campaign-04.webp') }}"
                                alt="Roadside hoardings above city traffic – Krishna Outdoor"
                                decoding="async"
                                loading="lazy"
                            />

                            <div>
                                <small>OUTDOOR / AHMEDABAD</small>
                                <b>↗</b>
                            </div>

                        </article>


                        <!-- IMAGE 2 -->
                        <article class="work-card" onclick="window.open('{{ asset('assets/images/work/digital-billboard-campaign-03.webp') }}', '_blank')" style="cursor: pointer;">

                            <img srcset="{{ asset('assets/images/work/digital-billboard-campaign-03-800w.webp') }} 800w, {{ asset('assets/images/work/digital-billboard-campaign-03.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw"
                                src="{{ asset('assets/images/work/digital-billboard-campaign-03.webp') }}"
                                alt="Car brand hoarding above city traffic in Gujarat – Krishna Outdoor"
                                decoding="async"
                                loading="lazy"
                            />

                            <div>
                                <small>DIGITAL / AHMEDABAD</small>
                                <b>↗</b>
                            </div>

                        </article>


                        <!-- IMAGE 3 -->
                        <article class="work-card" onclick="window.open('{{ asset('assets/images/work/ooh-hoarding-campaign-01.webp') }}', '_blank')" style="cursor: pointer;">

                            <img srcset="{{ asset('assets/images/work/ooh-hoarding-campaign-01-800w.webp') }} 800w, {{ asset('assets/images/work/ooh-hoarding-campaign-01.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw"
                                src="{{ asset('assets/images/work/ooh-hoarding-campaign-01.webp') }}"
                                alt="Jewellery brand hoarding above a busy traffic junction – Krishna Outdoor"
                                decoding="async"
                                loading="lazy"
                            />

                            <div>
                                <small>OOH / AHMEDABAD</small>
                                <b>↗</b>
                            </div>

                        </article>


                        <!-- IMAGE 4 -->
                        <article class="work-card" onclick="window.open('{{ asset('assets/images/work/outdoor-campaign-02.webp') }}', '_blank')" style="cursor: pointer;">

                            <img srcset="{{ asset('assets/images/work/outdoor-campaign-02-800w.webp') }} 800w, {{ asset('assets/images/work/outdoor-campaign-02.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw"
                                src="{{ asset('assets/images/work/outdoor-campaign-02.webp') }}"
                                alt="Samsung Galaxy rooftop hoarding above a city road – Krishna Outdoor"
                                decoding="async"
                                loading="lazy"
                            />

                            <div>
                                <small>OUTDOOR / AHMEDABAD</small>
                                <b>↗</b>
                            </div>

                        </article>


                        <!-- IMAGE 5 -->
                        <article class="work-card" onclick="window.open('{{ asset('assets/images/work/transit-bus-campaign-06.webp') }}', '_blank')" style="cursor: pointer;">

                            <img srcset="{{ asset('assets/images/work/transit-bus-campaign-06-800w.webp') }} 800w, {{ asset('assets/images/work/transit-bus-campaign-06.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw"
                                src="{{ asset('assets/images/work/transit-bus-campaign-06.webp') }}"
                                alt="Godrej 3D washing machine hoarding at a busy market at night – Krishna Outdoor"
                                decoding="async"
                                loading="lazy"
                            />

                            <div>
                                <small>TRANSIT / AHMEDABAD</small>
                                <b>↗</b>
                            </div>

                        </article>

                    </div>

                </div>


                <button
                    aria-label="Next work"
                    class="work-scroll-arrow next"
                    id="workNext"
                    type="button"
                >
                    ›
                </button>

            </div>

        </div>

    </div>
</section>

        <section class="cta" id="contact">
            <div class="container cta-inner reveal">
                <div>
                    <div class="tag light">LET’S CREATE</div>
                    <h2>LET'S PUT YOUR BRAND IN THE RIGHT PLACE.</h2>
                    <p>Whether you are launching a new product, entering a new market, building brand awareness or planning
                        a large-scale campaign, our team is ready to help you explore the right opportunities.</p>
                </div><a class="btn white" href="{{ route('view.contact') }}">TALK TO OUR TEAM <b>→</b></a>
            </div>
        </section>
    </main>

@endsection

@section('web-script')
<script>
// Hero video: the poster image is the LCP element. Only the video that is
// actually displayed (desktop or mobile) is fetched, and only once the page
// has loaded and the browser is idle. Visitors who prefer reduced motion or
// have Save-Data on keep the poster.
window.addEventListener('load', function () {
    var conn = navigator.connection || {};
    if (conn.saveData || /(^|-)2g$/.test(conn.effectiveType || '') ||
        (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches)) {
        return;
    }
    var start = function () {
        document.querySelectorAll('.js-defer-hero-video').forEach(function (video) {
            var src = video.getAttribute('data-src');
            if (!src || video.offsetParent === null || getComputedStyle(video).display === 'none') return;
            var source = document.createElement('source');
            source.src = src;
            source.type = 'video/mp4';
            video.appendChild(source);
            video.removeAttribute('data-src');
            video.load();
            video.play().catch(function () {});
        });
    };
    if ('requestIdleCallback' in window) {
        requestIdleCallback(start, { timeout: 3000 });
    } else {
        setTimeout(start, 1500);
    }
});
</script>
@endsection
