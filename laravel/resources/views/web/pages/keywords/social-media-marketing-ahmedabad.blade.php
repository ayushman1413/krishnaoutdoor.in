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
        <img fetchpriority="high" srcset="{{ asset('assets/images/ooh-media-category-image-800w.webp') }} 800w, {{ asset('assets/images/ooh-media-category-image.webp') }} 1200w" sizes="100vw" alt="" decoding="async" loading="eager" src="{{ asset('assets/images/ooh-media-category-image.webp') }}"/>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-grid"></div>
    <div class="hero-noise"></div>
    <div class="container hero-inner reveal">
        <h1>
        @if ($seo->h1Override())
            {{ $seo->h1Override() }}
        @else
            SOCIAL MEDIA MARKETING<br/><em>IN AHMEDABAD</em>
        @endif
        </h1>
    </div>
</section>

<section class="kw-section"><div class="kw-inner">
    @include('web.common.breadcrumbs', ['seo' => $seo, 'class' => 'kw-crumbs'])
    <p class="kw-lead">Krishna Outdoor runs social media marketing for Ahmedabad brands across Instagram, Facebook, LinkedIn and YouTube, covering strategy, content, paid ads and reporting. It can be booked on its own or paired with a hoarding or bus campaign. Tell us your goals and we will recommend a package.</p>

    <div class="kw-grid-2">
        <div>
            <h2 class="kw-h2">Social media marketing in Ahmedabad with <em>Krishna Outdoor</em></h2>
            <p class="kw-p">Outdoor advertising puts your brand in front of Ahmedabad as people move through the city. Social media marketing meets that same audience again, later, on the screens they check throughout the day. As a service line alongside our outdoor advertising network, Krishna Outdoor helps Ahmedabad brands plan, create and run social media campaigns that stand on their own or work in step with a physical hoarding or bus campaign already on the ground.</p>

            <div class="kw-stat-row">
                <div class="kw-stat"><strong>4</strong><span>Platforms Managed: Instagram, Facebook, LinkedIn, YouTube</span></div>
                <div class="kw-stat"><strong>Standalone or Paired</strong><span>With an Outdoor or Transit Campaign</span></div>
            </div>

            <h3 class="kw-h3">What's in a social media marketing package</h3>
            <ul class="kw-list">
                <li><b>Strategy</b> — defining the audience, platforms and content themes that match your brand's goals in Ahmedabad.</li>
                <li><b>Content</b> — planning and producing posts, reels and graphics built for each platform rather than one asset reused everywhere.</li>
                <li><b>Paid social advertising</b> — running targeted ad campaigns on Instagram, Facebook, LinkedIn and YouTube to reach beyond your existing followers.</li>
                <li><b>Reporting</b> — regular performance updates so you can see what's working and adjust direction.</li>
            </ul>

            <h3 class="kw-h3">The outdoor + social advantage</h3>
            <p class="kw-p">A hoarding on a busy Ahmedabad road or a wrapped AMTS bus builds broad physical visibility across the city. Social content built around that same campaign — photos of the hoarding going up, short videos of the branded bus on its route, or ads that echo the outdoor creative — gives people a second, more personal touchpoint with the brand after they've already seen it on the street. Run together, the two don't compete for attention; they compound it, because familiarity built offline makes the social content land faster, and social reach can push people to notice the outdoor piece they might have otherwise scrolled past mentally.</p>

            <h3 class="kw-h3">Platforms we manage</h3>
            <p class="kw-p">We work across Instagram, Facebook, LinkedIn and YouTube, choosing the platform mix based on where your specific audience in Ahmedabad actually spends time rather than running the same plan on every channel by default. A consumer brand targeting young shoppers leans differently than a B2B or institutional brand, and the platform mix reflects that.</p>

            <h3 class="kw-h3">What does social media marketing cost in Ahmedabad?</h3>
            <p class="kw-p">Cost depends on scope: how many platforms you run, how much original content is produced each month, and your paid advertising budget. A single-platform package with light content and no paid spend costs less than a full multi-platform plan with weekly content and ongoing ad campaigns. Share your goals and current social presence and we'll recommend a package that fits your budget, rather than a one-size offer.</p>

            <p class="kw-p">Interested in pairing social media marketing with an outdoor campaign, or starting with social alone? <a href="{{ route('view.free.site.list', ['media' => 'other', 'city' => 'Ahmedabad']) }}">Get in touch</a> and we'll scope an approach around your goals.</p>
        </div>

        <div class="kw-img">
            <img srcset="{{ asset('assets/images/services-media-category-03-800w.webp') }} 800w, {{ asset('assets/images/services-media-category-03.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="City bus mock-up in Krishna Outdoor livery" decoding="async" loading="lazy" src="{{ asset('assets/images/services-media-category-03.webp') }}"/>
        </div>
    </div>

    <h3 class="kw-h3">More ways to work with Krishna Outdoor</h3>
    <div class="kw-links">
        <a href="{{ route('view.home') }}">Outdoor Advertising in Ahmedabad</a>
        <a href="/social-media-marketing-mumbai">Social Media Marketing Mumbai</a>
        <a href="{{ route('view.services') }}">All Services</a>
        <a href="{{ route('view.free.site.list', ['media' => 'other', 'city' => 'Ahmedabad']) }}">Get Free Site List</a>
    </div>
</div></section>

@include('web.common.social-case-studies', ['city' => 'Ahmedabad'])

<section class="kw-section kw-section-alt"><div class="kw-inner">
    <h2 class="kw-h2">Frequently asked <em>questions</em></h2>
    @include('web.common.faq', ['faqs' => [
        ['q' => 'What\'s included in Krishna Outdoor\'s social media marketing package for Ahmedabad brands?', 'a' => 'Our social media marketing covers strategy and content planning, creative production, paid social media advertising, and performance reporting, tailored to an Ahmedabad brand\'s audience and goals.'],
        ['q' => 'Can social media marketing be combined with an outdoor advertising campaign in Ahmedabad?', 'a' => 'Yes — this is one of the most effective ways brands use us. A hoarding or bus campaign builds physical visibility across the city, while matching social content amplifies and extends that same campaign online, so the two reinforce each other instead of running as separate efforts.'],
        ['q' => 'Which platforms does Krishna Outdoor cover for social media marketing?', 'a' => 'We plan and manage campaigns across Instagram, Facebook, LinkedIn and YouTube, choosing the right mix of platforms based on where a brand\'s specific audience actually spends time.'],
        ['q' => 'Is social media marketing available as a standalone service without an outdoor campaign?', 'a' => 'Yes, social media marketing can be booked on its own as an independent digital service, or combined with outdoor advertising for brands that want a connected offline-online campaign.'],
        ['q' => 'How much does social media marketing cost in Ahmedabad?', 'a' => 'Cost depends on how many platforms you run, how much content is produced each month, and your paid advertising budget. Share your goals and current social presence and we\'ll recommend a package that fits your budget.'],
    ]])
</div></section>

<section class="cta" id="contact">
    <div class="container cta-inner reveal">
        <div>
            <div class="tag light">LET'S CREATE</div>
            <h2>START YOUR SOCIAL MEDIA MARKETING PLAN</h2>
            <p>Tell us about your brand and goals in Ahmedabad and we'll put together a social media approach that fits.</p>
        </div>
        <a class="btn white" href="{{ route('view.free.site.list', ['media' => 'other', 'city' => 'Ahmedabad']) }}">Get Free Site List <b>→</b></a>
    </div>
</section>

</main>
@endsection
