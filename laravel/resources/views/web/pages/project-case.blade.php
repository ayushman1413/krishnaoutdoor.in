@extends('web.layouts.app')

@section('css-bundle', 'keyword')

@section('body-class', 'inner-page')
@section('nav', 'projects')

@section('web-head')
@include('web.common.keyword-page-style')
@endsection

@section('web-section')
@php
    $mainImage = $campaign->image ? asset('storage/' . $campaign->image) : asset('assets/images/work/ooh-hoarding-campaign-01.webp');
    $gallery = collect($campaign->gallery ?? [])->filter(fn ($item) => !empty($item['path']))->values();
    $mumbai = in_array(strtolower(trim($campaign->city)), ['mumbai', 'thane'], true);
@endphp
<main>

<section class="hero media-detail-hero media-detail-hero-ooh" id="home">
    <div class="media-detail-hero-bg">
        <img srcset="{{ asset('assets/images/shared-night-city-background-800w.webp') }} 800w, {{ asset('assets/images/shared-night-city-background.webp') }} 1600w" sizes="100vw" alt="" decoding="async" loading="eager" fetchpriority="high" src="{{ asset('assets/images/shared-night-city-background.webp') }}"/>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-grid"></div>
    <div class="container hero-inner reveal">
        <h1>{{ $seo->h1Override() ?: $campaign->name . ' – ' . $campaign->mediaLabel() . ' Campaign in ' . $campaign->city }}</h1>
        <!--cms:skip-->@if ($campaign->tagline)<p class="seo-h1-slogan">{{ $campaign->tagline }}</p>@endif<!--/cms:skip-->
    </div>
</section>

<section class="kw-section"><div class="kw-inner">
    @include('web.common.breadcrumbs', ['seo' => $seo, 'class' => 'kw-crumbs'])

    <div class="kw-grid-2">
        <div>
            <h2 class="kw-h2">The <em>brief</em></h2>
            @if (filled($campaign->description))
                <!--cms:skip--><p class="kw-p">{{ $campaign->description }}</p><!--/cms:skip-->
            @endif

            <h3 class="kw-h3">Campaign at a glance</h3>
            <ul class="kw-list">
                <li><b>Brand:</b> {{ $campaign->name }}</li>
                <li><b>Media used:</b> {{ $campaign->mediaLabel() }}</li>
                <li><b>City:</b> {{ $campaign->city }}</li>
            </ul>

            @if ($keywordRoute && $keywordPage)
                <p class="kw-p">See the media behind this campaign: <a href="{{ route($keywordRoute) }}">{{ \Illuminate\Support\Str::before($keywordPage['title'], ' |') }}</a>.</p>
            @endif
        </div>

        <div class="kw-img">
            <img src="{{ $mainImage }}" alt="{{ $campaign->imageAlt() }}" decoding="async" loading="lazy"/>
        </div>
    </div>

    @if ($gallery->isNotEmpty())
        <h3 class="kw-h3">Gallery</h3>
        <div class="kw-gallery">
<!--cms:skip-->
            @foreach ($gallery as $i => $item)
                <figure><img src="{{ asset('storage/' . $item['path']) }}" alt="{{ $item['alt'] ?? ($campaign->name . ' ' . $campaign->mediaLabel() . ' campaign in ' . $campaign->city . ' – photo ' . ($i + 1)) }}" decoding="async" loading="lazy"/></figure>
            @endforeach
<!--/cms:skip-->
        </div>
    @endif

    @if ($related->isNotEmpty())
        <h3 class="kw-h3">More campaigns</h3>
        <div class="kw-links">
<!--cms:skip-->
            @foreach ($related as $item)
                <a href="{{ $item->url() }}">{{ $item->name }} – {{ $item->city }}</a>
            @endforeach
<!--/cms:skip-->
            <a href="{{ route('view.projects') }}">All campaigns</a>
        </div>
    @endif
</div></section>

<section class="cta" id="contact">
    <div class="container cta-inner reveal">
        <div>
            <div class="tag light">LET'S CREATE</div>
            <h2>PLAN YOUR NEXT CAMPAIGN</h2>
            <p>Tell us your city and media type and we'll send the available sites.</p>
        </div>
        <a class="btn white" href="{{ route('view.free.site.list', array_filter(['media' => $campaign->media_type === 'transit' ? 'transit' : 'ooh', 'city' => $campaign->city])) }}">Get Free Site List <b>→</b></a>
    </div>
</section>

</main>
@endsection
