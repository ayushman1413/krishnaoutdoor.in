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
        <img fetchpriority="high" srcset="{{ asset('assets/images/ooh/ahmedabad-bus-shelter-hero-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-bus-shelter-hero.webp') }} 1590w" sizes="100vw" alt="Backlit bus shelter advertising panel at a bus stop in Ahmedabad" decoding="async" loading="eager" src="{{ asset('assets/images/ooh/ahmedabad-bus-shelter-hero.webp') }}"/>
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
    <p class="kw-lead">Bus shelter advertising in Ahmedabad places your brand on backlit panels at bus stops, at eye level, where commuters wait for several minutes. <a href="{{ route('view.home') }}">Krishna Outdoor</a> holds advertising rights on 400+ backlit bus shelters across Ahmedabad, so you can choose stops by area and audience and get longer viewing time than most outdoor formats.</p>
    <div class="kw-cta-row">
        <a class="btn red" href="{{ route('view.free.site.list', ['media' => 'bus-shelters', 'city' => 'Ahmedabad']) }}">Get the free bus shelter location list <b>→</b></a>
        <span class="kw-cta-contact">Call or <a href="{{ \App\Services\SeoResolver::whatsappUrl($seo, $seoSettings ?? null, 'Hi, please share the bus shelter location list for Ahmedabad.') }}" target="_blank" rel="noopener">WhatsApp</a> <a href="tel:+919879616411">+91 98796 16411</a></span>
    </div>

    <div class="kw-grid-2">
        <div>
            <h2 class="kw-h2">What is bus shelter <em>advertising?</em></h2>
            <p class="kw-p">Bus shelter advertising (also called bus stop or BQS advertising) means displaying an ad on the panels of a bus shelter. The audience is standing still and waiting, so they read the message instead of glancing at it.</p>
            <p class="kw-p">A hoarding seen from a moving car gets a few seconds. A shelter panel gets minutes. That extra time lets a shelter ad carry more detail – a product, an offer, a phone number or a QR code – and still be read in full.</p>

            <h2 class="kw-h2">How many bus shelters does Krishna Outdoor have <em>in Ahmedabad?</em></h2>
            <p class="kw-p">Krishna Outdoor holds advertising rights on 400+ backlit bus shelters across Ahmedabad, on commercial roads, residential areas and stops near markets, colleges and offices.</p>
            <p class="kw-p"><b>Shelter network:</b> Shelters are AMTS and BRTS (Janmarg).</p>

            <div class="kw-stat-row">
                <div class="kw-stat"><strong>400+</strong><span>Backlit Bus Shelter Sites</span></div>
                <div class="kw-stat"><strong>Eye-Level</strong><span>Placement at Commuter Stops</span></div>
            </div>

            <p class="kw-p"><b>Key areas:</b></p>
            <div class="kw-check">
                <span>SG Highway</span>
                <span>Navrangpura</span>
                <span>Satellite</span>
                <span>Vastrapur</span>
                <span>Maninagar</span>
                <span>Naranpura</span>
                <span>Chandkheda</span>
            </div>
        </div>

        <div class="kw-media">
            <div class="kw-img">
                <img srcset="{{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-02-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-02.webp') }} 1600w" sizes="(max-width: 860px) 100vw, 45vw" alt="Bus shelter advertising panel in Ahmedabad by Krishna Outdoor" decoding="async" loading="lazy" src="{{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-02.webp') }}"/>
            </div>
            <div class="kw-img">
                <img srcset="{{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-03-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-03.webp') }} 1600w" sizes="(max-width: 860px) 100vw, 45vw" alt="Commuters waiting at a backlit bus shelter ad in Ahmedabad – Krishna Outdoor" decoding="async" loading="lazy" src="{{ asset('assets/images/ooh/ahmedabad-bus-shelter-original-03.webp') }}"/>
            </div>
        </div>
    </div>

    <h2 class="kw-h2">Why does bus shelter advertising <em>work?</em></h2>
    <p class="kw-p">Bus shelter ads work because the audience is captive. People waiting at a stop have nowhere else to look, often for several minutes, which gives a shelter panel far longer viewing time than drive-by formats.</p>

    <div class="kw-table-wrap kw-stack">
        <table class="kw-table">
            <thead><tr><th>Format</th><th>Typical viewing time</th><th>Message it can carry</th></tr></thead>
            <tbody>
                <tr><td>Hoarding (from a vehicle)</td><td data-label="Typical viewing time">A few seconds</td><td data-label="Message it can carry">Brand name + one line</td></tr>
                <tr><td>Bus panel (at a signal)</td><td data-label="Typical viewing time">A second or two</td><td data-label="Message it can carry">Brand name + visual</td></tr>
                <tr class="kw-hl"><td>Bus shelter panel</td><td data-label="Typical viewing time">Several minutes while waiting</td><td data-label="Message it can carry">Offer, product detail, phone number, QR code</td></tr>
            </tbody>
        </table>
    </div>

    <p class="kw-p">Backlit panels also keep the ad visible in the evening, when many shelters see their heaviest footfall from office-goers and students heading home.</p>

    <h2 class="kw-h2">How much does bus shelter advertising cost <em>in Ahmedabad?</em></h2>
    <p class="kw-p">The price depends on the shelter location, panel size and how long you book it.</p>

    <div class="kw-table-wrap">
        <table class="kw-table">
            <thead><tr><th>Cost factor</th><th>How it affects the price</th></tr></thead>
            <tbody>
                <tr><td>Location</td><td>Shelters on busy commercial roads or near markets and colleges cost more than quiet residential stops</td></tr>
                <tr><td>Number of shelters</td><td>Booking a cluster of shelters in one area usually lowers the per-shelter rate.</td></tr>
                <tr><td>Panel size / panels per shelter</td><td>More display area costs more</td></tr>
                <tr><td>Duration</td><td>Longer bookings usually get a better monthly rate</td></tr>
                <tr><td>Printing &amp; mounting</td><td>Depends on size</td></tr>
            </tbody>
        </table>
    </div>

    <h2 class="kw-h2">How do you book bus shelters <em>in Ahmedabad?</em></h2>
    <ol class="kw-steps">
        <li><b>Share your brief</b> – target areas, audience, dates and budget.</li>
        <li><b>Get the location list</b> – available shelters with photos, sizes and rates.</li>
        <li><b>Confirm and send creative</b> – we print the backlit panel to fit the frame.</li>
        <li><b>Go live</b> – our team installs the panels and shares live photos as proof.</li>
    </ol>
    <ul class="kw-list">
        <li><b>Minimum booking period:</b> bus shelters are usually booked by the month.</li>
        <li><b>Recommended lead time:</b> enquire a few weeks ahead so your preferred stops are available.</li>
    </ul>

    <h2 class="kw-h2">Bus shelters plus AMTS buses: <em>one city campaign</em></h2>
    <p class="kw-p">Bus shelter advertising and <a href="/amts-bus-advertising-ahmedabad">AMTS bus advertising in Ahmedabad</a> solve different problems. Buses give broad, repeated exposure as they move across Ahmedabad; shelters repeat the same message at the exact points where people stop and read. Running both together means your brand is seen in motion and at rest.</p>
    <p class="kw-p">Add <a href="/hoarding-advertising-ahmedabad">hoardings on main roads</a> for a large fixed message, or <a href="/gsrtc-bus-advertising">GSRTC buses</a> to carry the campaign to the rest of Gujarat.</p>

    <p class="kw-h3">More Ahmedabad &amp; Gujarat advertising formats</p>
    <div class="kw-links">
        <a href="/amts-bus-advertising-ahmedabad">AMTS bus advertising in Ahmedabad</a>
        <a href="/hoarding-advertising-ahmedabad">Hoarding advertising in Ahmedabad</a>
        <a href="/gsrtc-bus-advertising">GSRTC bus advertising</a>
        <a href="{{ route('view.ooh.media') }}">All OOH media in Gujarat</a>
    </div>

    <h2 class="kw-h2">Why choose Krishna Outdoor for bus shelter <em>advertising?</em></h2>
    <ul class="kw-list">
        <li><b>40+ years in outdoor advertising</b> – in business since 1985, backed by the Rakesh Advertising legacy.</li>
        <li><b>400+ backlit bus shelters</b> in Ahmedabad, plus 300+ own hoardings and 2000+ sites across Gujarat.</li>
        <li><b>5000+ clients served</b> across 30+ key markets.</li>
        <li><b>Live photo proof</b> once your panels are installed.</li>
        <li><b>Ahmedabad head office</b> in Navrangpura for site visits and planning meetings.</li>
    </ul>
    <p class="kw-p">See how brands have used our outdoor network: explore our <a href="{{ route('view.projects') }}">campaign case studies</a>.</p>
</div></section>

<section class="kw-section kw-section-alt"><div class="kw-inner">
    <h2 class="kw-h2">Frequently asked questions about bus shelter advertising <em>in Ahmedabad</em></h2>
    @include('web.common.faq', ['faqs' => [
        ['q' => 'How much does bus shelter advertising cost in Ahmedabad?', 'a' => 'Bus shelter advertising cost in Ahmedabad depends on the shelter location, panel size, number of shelters and booking duration. Shelters on busy commercial roads or near colleges and markets cost more than quiet residential stops. Krishna Outdoor shares indicative rates along with its free location list so you can plan by budget.'],
        ['q' => 'How many bus shelters can I advertise on in Ahmedabad?', 'a' => 'Krishna Outdoor holds advertising rights on 400+ backlit bus shelters across Ahmedabad. You can book a single shelter for a local shop or a cluster across several areas for a city-wide campaign. Share your target areas and audience, and the team will recommend shelters that match.'],
        ['q' => 'Why is bus shelter advertising effective?', 'a' => 'Bus shelter advertising is effective because commuters wait at the stop for several minutes with little else to look at. This longer viewing time lets a shelter panel carry more detail, such as an offer or QR code, than fast-moving formats like hoardings seen from vehicles or panels on moving buses.'],
        ['q' => 'Are bus shelter ads lit at night?', 'a' => 'Yes. Krishna Outdoor\'s bus shelter panels in Ahmedabad are backlit, meaning the print is lit from behind. This keeps the creative bright and readable after dark, when many shelters see their busiest footfall from office-goers and students returning home in the evening.'],
        ['q' => 'Can I combine bus shelter ads with AMTS bus advertising?', 'a' => 'Yes. Many brands pair bus shelters with AMTS bus advertising in Ahmedabad. The buses build city-wide recall as they move across routes, while the shelters repeat the same message at stops where people wait and have time to read it, making the campaign more memorable.'],
        ['q' => 'What is the minimum period for bus shelter advertising?', 'a' => 'Bus shelter advertising in Ahmedabad is usually booked by the month. Longer campaigns of three months or more often get a better monthly rate and build stronger recall among daily commuters who pass the same stops.'],
    ]])
</div></section>

<section class="cta" id="contact">
    <div class="container cta-inner reveal">
        <div>
            <div class="tag light">LET'S CREATE</div>
            <h2>GET YOUR FREE BUS SHELTER LOCATION LIST</h2>
            <p>Tell us your target areas in Ahmedabad and we will send available shelters with photos, sizes and rates. Call / WhatsApp <a href="tel:+919879616411">+91 98796 16411</a>.</p>
        </div>
        <a class="btn white" href="{{ route('view.free.site.list', ['media' => 'bus-shelters', 'city' => 'Ahmedabad']) }}">Get Free Bus Shelter Location List <b>→</b></a>
    </div>
</section>

</main>
@endsection
