@extends('web.layouts.app')

@section('css-bundle', 'services')

@section('body-class', 'inner-page')
@section('nav', 'services')

@section('web-head')
@include('web.common.keyword-page-style')
@endsection

@section('web-section')

<main class="media-page">
<section class="media-hero" id="home">
<div class="media-hero-bg"><img fetchpriority="high" srcset="{{ asset('assets/images/media/home-360-outdoor-hoarding-night-01-800w.webp') }} 800w, {{ asset('assets/images/media/home-360-outdoor-hoarding-night-01.webp') }} 1800w" sizes="100vw" alt="Godrej 3D washing machine hoarding at a busy market at night – Krishna Outdoor" decoding="async" loading="eager" src="{{ asset('assets/images/media/home-360-outdoor-hoarding-night-01.webp') }}"/></div>
<div class="media-hero-overlay"></div>
<div class="media-hero-grid"></div>
<div class="container media-hero-inner reveal">
<div class="media-hero-copy">
<div class="tag light">360° ADVERTISING &amp; MEDIA SOLUTIONS</div>
<h1 class="seo-h1">{{ $seo->h1Override() ?: 'Outdoor, Transit & Social Media Marketing Services' }}</h1>
<p class="seo-h1-slogan">ONE PARTNER. MULTIPLE MEDIA. <em>ONE CLEAR OBJECTIVE.</em></p>
<p>Your audience is everywhere — on the road, in transit, in print, on screens and across digital platforms.</p>
<p>Krishna Outdoor brings together a complete range of advertising and media solutions to help brands build visibility across the touchpoints that matter.</p>
<p>From high-impact outdoor and transit media to print, electronic, digital, social and branding solutions, we help brands explore the right mix of media for the right objective.</p>
<div class="media-quote">“ WHEREVER YOUR AUDIENCE IS,<br/><span>YOUR BRAND SHOULD HAVE A PRESENCE.</span> ”</div>
</div>
<div aria-hidden="true" class="media-hero-markers"></div>
</div>
</section>
<section class="media-format-rail">
<div class="container"><div class="media-format-track">
<a href="#ooh"><span>▣</span><b>Outdoor Media</b></a><a href="#transit"><span>▤</span><b>Transit Media</b></a><a href="#print"><span>▧</span><b>Print Media</b></a><a href="#electronic"><span>▥</span><b>Electronic Media</b></a><a href="#digital"><span>◉</span><b>Digital &amp; Social Media</b></a><a href="#branding"><span>◇</span><b>Branding Solutions</b></a><div class="media-360-badge"><strong>360°</strong><small>MEDIA SOLUTIONS</small></div>
</div></div>
</section>
<section class="media-section media-ooh" id="ooh">
<div class="container media-two-col">
<div class="media-copy reveal"><div class="media-number">01 <i></i></div><div class="tag">OUTDOOR MEDIA</div><h2>Make a Strong Impression in the Real World.</h2><p>Outdoor advertising gives brands a physical presence in the places people see every day.</p><p>Through our network of hoardings, unipoles and gantries, Krishna Outdoor helps brands create high-impact visibility across Ahmedabad, Gujarat and other key markets.</p><a class="btn red media-btn" href="{{ route('view.ooh.media') }}">Enquire About Outdoor Media <b>→</b></a></div>
<div class="media-ooh-grid reveal">
<article class="media-card"><img srcset="{{ asset('assets/images/media/home-360-outdoor-hoarding-night-01-800w.webp') }} 800w, {{ asset('assets/images/media/home-360-outdoor-hoarding-night-01.webp') }} 1800w" sizes="(max-width: 760px) 100vw, 50vw" alt="Godrej 3D washing machine hoarding at a busy market at night – Krishna Outdoor" decoding="async" loading="lazy" src="{{ asset('assets/images/media/home-360-outdoor-hoarding-night-01.webp') }}"/></article>
<article class="media-card"><img srcset="{{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-02-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-02.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="Real-estate hoarding above a bus stop in Ahmedabad – Krishna Outdoor" decoding="async" loading="lazy" src="{{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-02.webp') }}"/></article>
<article class="media-card"><img srcset="{{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-03-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-03.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="Saya backlit bus shelter advertising in Ahmedabad – Krishna Outdoor" decoding="async" loading="lazy" src="{{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-03.webp') }}"/></article>
<article class="media-card"><img srcset="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-06-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-hoarding-location-06.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="Hoarding beside a main road in Ahmedabad – Krishna Outdoor" decoding="async" loading="lazy" src="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-06.webp') }}"/></article>
</div>
</div>
<div aria-label="Outdoor media details" class="media-doc-detail-grid reveal">
<article><b>Hoardings Across Gujarat</b><p>Explore hoarding opportunities across key cities, roads and high-visibility locations in Gujarat. From focused local campaigns to wider regional visibility, we help brands identify locations that match their audience and objective.</p></article>
<article><b>Own Hoardings in Ahmedabad</b><p>Our strong presence in Ahmedabad gives brands access to prominent outdoor opportunities across important parts of the city. These locations can support product launches, local market visibility and long-term brand building.</p></article>
<article><b>Ahmedabad Bus Shelters</b><p>Bus shelters offer a high-attention environment where people pause and wait. Backlit shelter advertising helps brands maintain a visible presence at important urban touchpoints.</p></article>
<article><b>Unipoles &amp; Gantries</b><p>Large-format structures such as unipoles and gantries can create a strong visual presence in high-traffic environments, making them ideal for campaigns that require scale and impact.</p></article>
</div>
</section>
<section class="media-section media-transit" id="transit">
<div class="container transit-layout">
<div class="transit-image reveal"><img srcset="{{ asset('assets/images/media/media-05-800w.webp') }} 800w, {{ asset('assets/images/media/media-05.webp') }} 1280w" sizes="(max-width: 760px) 100vw, 50vw" alt="Fashionism full-wrap advertising on a city bus – Krishna Outdoor" decoding="async" loading="lazy" src="{{ asset('assets/images/media/media-05.webp') }}"/><span>BRANDS<br/><em>MOVE WITH<br/>PEOPLE</em></span></div>
<div class="media-copy reveal"><div class="media-number">02 <i></i></div><div class="tag">TRANSIT MEDIA</div><h2>Visibility That Moves with Your Audience.</h2><p>Transit advertising takes a brand into everyday movement. From Ahmedabad city buses and bus shelters to Surat EV buses, Mumbai local trains, BEST buses and TMT buses, Krishna Outdoor helps brands create repeated visibility across urban routes and commuter environments.</p><a class="btn red media-btn" href="{{ route('view.transit.media') }}">Enquire About Transit Media <b>→</b></a>
<div class="transit-strip" tabindex="0" role="region" aria-label="Transit media formats (scrollable)"><article><img srcset="{{ asset('assets/images/transit/ahmedabad-bus-advertising-01-800w.webp') }} 800w, {{ asset('assets/images/transit/ahmedabad-bus-advertising-01.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="Panel advertising on an AMTS bus in Ahmedabad – Krishna Outdoor" decoding="async" loading="lazy" src="{{ asset('assets/images/transit/ahmedabad-bus-advertising-01.webp') }}"/><b>Ahmedabad<br/>City Buses</b></article><article><img srcset="{{ asset('assets/images/transit/surat-ev-bus-advertising-03-800w.webp') }} 800w, {{ asset('assets/images/transit/surat-ev-bus-advertising-03.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="Uber branding on a Surat EV city bus – Krishna Outdoor" decoding="async" loading="lazy" src="{{ asset('assets/images/transit/surat-ev-bus-advertising-03.webp') }}"/><b>Surat<br/>EV Buses</b></article><article><img srcset="{{ asset('assets/images/transit/mumbai-local-train-cosmos-bank-01-800w.webp') }} 800w, {{ asset('assets/images/transit/mumbai-local-train-cosmos-bank-01.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="Cosmos Co-operative Bank branding on Mumbai local train coaches – Krishna Outdoor" decoding="async" loading="lazy" src="{{ asset('assets/images/transit/mumbai-local-train-cosmos-bank-01.webp') }}"/><b>Mumbai Local<br/>Train Advertising</b></article><article><img srcset="{{ asset('assets/images/transit/best-bus-advertising-04-800w.webp') }} 800w, {{ asset('assets/images/transit/best-bus-advertising-04.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="Panel advertising on an intercity bus – Krishna Outdoor" decoding="async" loading="lazy" src="{{ asset('assets/images/transit/best-bus-advertising-04.webp') }}"/><b>BEST Buses</b></article><article><img srcset="{{ asset('assets/images/transit/city-bus-advertising-02-800w.webp') }} 800w, {{ asset('assets/images/transit/city-bus-advertising-02.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="Frooti full-wrap branding on a BEST double-decker bus in Mumbai – Krishna Outdoor" decoding="async" loading="lazy" src="{{ asset('assets/images/transit/city-bus-advertising-02.webp') }}"/><b>TMT Buses</b></article></div>
</div>
<div aria-label="Transit media details" class="media-doc-detail-grid media-doc-detail-grid-6 reveal">
<article><b>Ahmedabad City Buses</b><p>City bus advertising allows brands to move through the places where people live, work and travel, creating visibility across different neighbourhoods and busy urban routes throughout the day.</p></article>
<article><b>Surat EV Buses</b><p>Surat's electric city buses provide a modern transit environment that moves through everyday routes and public spaces, helping brands connect with urban audiences through repeated visibility.</p></article>
<article><b>Mumbai Local Train Advertising</b><p>Mumbai's local railway network is central to the rhythm of the city. Local train exterior advertising gives brands the opportunity to travel alongside one of the country's most active commuter audiences.</p></article>
<article><b>BEST Buses — Mumbai</b><p>BEST buses are an iconic part of Mumbai's streetscape. Advertising on these moving formats allows brands to stay visible across roads, neighbourhoods and the everyday journeys that connect the city.</p></article>
<article><b>TMT Buses — Thane</b><p>TMT bus advertising provides brands with moving visibility across Thane's urban and commuter routes and helps maintain a physical presence across important local markets.</p></article>
<article><b>Jaipur City Buses</b><p>Selected transit opportunities in Jaipur help extend visibility into another important urban market through high-frequency city movement.</p></article>
</div>
</div>
</section>
<section class="media-section media-print" id="print">
<div class="container print-layout">
<div class="media-copy reveal"><div class="media-number">03 <i></i></div><div class="tag">PRINT MEDIA</div><h2>Put Your Message in a Medium People Trust.</h2><p>Newspaper advertising remains an important communication platform for brands looking for market reach, credibility and strong regional communication.</p><p>Krishna Outdoor's wider advertising expertise includes print capabilities strengthened by the legacy and experience of Rakesh Advertising. Through experienced media planning and INS agency capabilities, we help brands explore relevant newspaper opportunities based on market, readership, campaign objective and budget.</p><a class="btn red media-btn" href="{{ route('view.free.site.list', ['media' => 'other']) }}">Get Free Site List <b>→</b></a></div>
<div class="print-visual reveal"><img loading="lazy" decoding="async" srcset="{{ asset('assets/images/print/newspaper-800w.webp') }} 800w, {{ asset('assets/images/print/newspaper.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="Newspaper print media advertising" src="{{ asset('assets/images/print/newspaper.webp') }}"/><div class="print-paper"><img loading="lazy" decoding="async" srcset="{{ asset('assets/images/print/press-release-800w.webp') }} 800w, {{ asset('assets/images/print/press-release.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" class="print-press-thumb" src="{{ asset('assets/images/print/press-release.webp') }}" alt="Press release media communication"/><span>IDEAS</span><strong>REACH<br/>FURTHER</strong><small>KRISHNA OUTDOOR</small></div></div>
<div class="media-side-list reveal"><b>Wide Reach</b><span>Across Key Markets</span><b>Credible Platform</b><span>Trusted Communication</span><b>Regional Expertise</b><span>Local Market Understanding</span><b>Strategic Media Planning</b><span>Right Message. Right Medium.</span></div>
</div>
</section>
<section class="media-section media-electronic" id="electronic">
<div class="container electronic-layout">
<div class="electronic-visual reveal"><img srcset="{{ asset('assets/images/work/digital-billboard-campaign-03-800w.webp') }} 800w, {{ asset('assets/images/work/digital-billboard-campaign-03.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="Car brand hoarding above city traffic in Gujarat – Krishna Outdoor" decoding="async" loading="lazy" src="{{ asset('assets/images/work/digital-billboard-campaign-03.webp') }}"/></div>
<div class="media-copy reveal"><div class="media-number">04 <i></i></div><div class="tag">ELECTRONIC MEDIA</div><h2>Sound. Sight. Storytelling.</h2><p>Electronic media gives brands the opportunity to communicate through powerful combinations of audio, visual storytelling and audience reach.</p><div class="electronic-cards"><article><span>◉</span><b>Radio Advertising</b><small>Radio can help brands connect through sound, frequency and local relevance, making it useful for market-focused campaigns and repeated promotional communication.</small></article><article><span>▣</span><b>Television Advertising</b><small>Television remains a powerful medium for building awareness through sight, sound and storytelling. We help brands explore relevant advertising opportunities based on campaign and audience objectives.</small></article><article><span>◌</span><b>OTT Advertising</b><small>OTT platforms are an increasingly important part of modern media consumption. OTT advertising can help brands reach audiences through digital entertainment environments and complement wider campaigns.</small></article></div><a class="btn red media-btn" href="{{ route('view.free.site.list', ['media' => 'other']) }}">Get Free Site List <b>→</b></a></div>
</div>
</section>
<section class="media-section media-digital" id="digital">
<div class="container digital-layout">
<div class="media-copy reveal"><div class="media-number">05 <i></i></div><div class="tag">DIGITAL MARKETING</div><h2>Keep the Conversation Going.</h2><p>Today's audience moves between the physical and digital worlds throughout the day.</p><p>Our digital and social media services help brands support wider campaign objectives through relevant online communication, targeted promotion and audience engagement.</p><div class="doc-digital-items"><article><b>Digital Marketing</b><p>We help brands strengthen their online presence and support campaign objectives through relevant digital communication and performance-focused activity.</p></article><article><b>Social Media Advertising</b><p>Social media advertising allows brands to communicate with audiences through targeted promotion and campaign-led content across relevant platforms.</p></article><article><b>Outdoor + Digital</b><p>One of the strongest opportunities for modern campaigns is connecting physical visibility with digital communication — creating attention in the real world and continuing the conversation online.</p></article></div><a class="btn red media-btn" href="{{ route('view.free.site.list', ['media' => 'other']) }}">Get Free Site List <b>→</b></a></div>
<div class="digital-visual reveal"><img srcset="{{ asset('assets/images/media/home-360-outdoor-hoarding-poster-800w.webp') }} 800w, {{ asset('assets/images/media/home-360-outdoor-hoarding-poster.webp') }} 1800w" sizes="(max-width: 760px) 100vw, 50vw" alt="Krishna Outdoor backlit hoarding at night" decoding="async" loading="lazy" src="{{ asset('assets/images/media/home-360-outdoor-hoarding-poster.webp') }}"/><div class="digital-floating"><span>Digital<br/>Marketing</span><span>Social<br/>Media</span><span>Outdoor +<br/>Digital</span></div></div>
</div>
</section>
<section class="media-section media-branding" id="branding">
<div class="container branding-layout">
<div class="branding-visual reveal"><img srcset="{{ asset('assets/images/work/outdoor-campaign-02-800w.webp') }} 800w, {{ asset('assets/images/work/outdoor-campaign-02.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="Samsung Galaxy rooftop hoarding above a city road – Krishna Outdoor" decoding="async" loading="lazy" src="{{ asset('assets/images/work/outdoor-campaign-02.webp') }}"/><div class="branding-overlay"><strong>Krishna</strong><span>OUTDOOR</span></div></div>
<div class="media-copy reveal"><div class="media-number">06 <i></i></div><div class="tag">BRANDING SOLUTIONS</div><h2>Build a Brand People Recognise.</h2><p>Advertising can create attention, but a clear and consistent brand identity helps turn attention into recognition.</p><p>Our branding solutions help businesses shape the way they communicate through clear identity, campaign communication, creative direction and marketing support.</p><div class="branding-items"><span>Brand Communication</span><span>Campaign Creative</span><span>Marketing Support</span></div><div aria-label="Branding solution details" class="branding-detail-grid reveal">
<article><b>Brand Communication</b><p>We help businesses bring greater consistency to how they communicate their identity, message and value.</p></article>
<article><b>Campaign Creative</b><p>A campaign needs communication that works within the environment where it will be seen. From outdoor creatives to integrated campaign communication, our focus is on clarity, relevance and consistency.</p></article>
<article><b>Marketing Support</b><p>We support brands with communication and creative requirements that help maintain a consistent presence across different advertising platforms.</p></article>
</div>
<a class="btn red media-btn" href="{{ route('view.free.site.list', ['media' => 'other']) }}">Get Free Site List <b>→</b></a></div>
</div>
</section>
<section class="kw-section kw-section-alt" aria-labelledby="services-by-city"><div class="kw-inner">
<h2 class="kw-h2" id="services-by-city">Advertising services in <em>Ahmedabad, Gujarat &amp; Mumbai</em></h2>
<h3 class="kw-h3">Ahmedabad &amp; Gujarat</h3>
<div class="kw-links">
<a href="{{ route('view.keyword.hoarding.ahmedabad') }}">Hoarding Advertising in Ahmedabad</a>
<a href="{{ route('view.keyword.amts.ahmedabad') }}">AMTS Bus Advertising in Ahmedabad</a>
<a href="{{ route('view.keyword.bus.shelter.ahmedabad') }}">Bus Shelter Advertising in Ahmedabad</a>
<a href="{{ route('view.keyword.gsrtc') }}">GSRTC Bus Advertising</a>
<a href="{{ route('view.keyword.social.ahmedabad') }}">Social Media Marketing in Ahmedabad</a>
</div>
<h3 class="kw-h3">Mumbai &amp; Thane</h3>
<div class="kw-links">
<a href="{{ route('view.keyword.agency.mumbai') }}">Outdoor Advertising Agency in Mumbai</a>
<a href="{{ route('view.keyword.local.train.mumbai') }}">Mumbai Local Train Advertising</a>
<a href="{{ route('view.keyword.best.mumbai') }}">BEST Bus Advertising in Mumbai</a>
<a href="{{ route('view.keyword.tmt.thane') }}">TMT Bus Advertising in Thane</a>
<a href="{{ route('view.keyword.social.mumbai') }}">Social Media Marketing in Mumbai</a>
</div>
</div></section>
<section class="media-final-cta"><div class="container media-final-inner reveal"><div><div class="tag light">ONE CAMPAIGN.</div><h2>ONE CAMPAIGN. MANY POSSIBILITIES.</h2><p>Every campaign is different. The right solution may be one powerful media format or a combination of several. Our job is to help you understand the possibilities and build a media approach around your objective, audience and market.<br/><br/>From physical visibility to digital engagement, Krishna Outdoor brings multiple advertising capabilities together under one experienced team.</p></div><a class="btn white media-btn" href="{{ route('view.free.site.list', ['media' => 'other']) }}">Get Free Site List <b>→</b></a></div></section>
</main>

@endsection

@section('web-script')

@endsection