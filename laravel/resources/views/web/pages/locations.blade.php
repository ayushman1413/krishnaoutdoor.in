@extends('web.layouts.app')

@section('web-title', $city.' Locations | Krishna Outdoor')
@section('body-class', 'inner-page')
@section('nav', 'network')

@section('web-meta')
<meta name="description" content="Explore our available outdoor advertising media - billboards, bus branding, train media and more - across {{ $city }}.">
@endsection

@section('web-section')
<main>
<section class="hero media-detail-hero dyn-hero" id="home">
<div class="media-detail-hero-bg"><img fetchpriority="high" srcset="{{ asset('assets/images/shared-night-city-background-800w.webp') }} 800w, {{ asset('assets/images/shared-night-city-background.webp') }} 1600w" sizes="100vw" alt="" decoding="async" loading="eager" src="{{ asset('assets/images/shared-night-city-background.webp') }}"/></div>
<div class="hero-overlay"></div><div class="hero-grid"></div><div class="hero-noise"></div>
<div class="container hero-inner reveal"><h1>{{ strtoupper($city) }}<br/><em>LOCATIONS</em></h1></div>
</section>
<section class="dyn-section"><div class="container">
@include('web.common.breadcrumbs', ['seo' => $seo, 'class' => 'dyn-crumbs'])
<!--cms:skip--><p class="dyn-intro">{{ $seo->description }}</p><!--/cms:skip-->
<div class="dyn-table-wrap" tabindex="0" role="region" aria-label="{{ $city }} sites (scrollable)">
<table class="dyn-table">
<thead><tr><th>Image</th><th>Location</th><th>Area</th><th>Size</th><th>Media Type</th><th>Availability</th></tr></thead>
<tbody>
<!--cms:skip-->
@foreach ($locations as $location)
<tr>
<td>@if ($location->image)<img src="{{ asset('storage/'.$location->image) }}" alt="{{ $location->image_alt ?: $location->name }}" loading="lazy">@else<span class="dyn-noimg">No image</span>@endif</td>
<td class="name">{{ $location->name }}</td>
<td>{{ $location->area ?? '-' }}</td>
<td>{{ $location->size ?? '-' }}</td>
<td>{{ $media_type::tryFrom($location->media_type)?->label() ?? $location->media_type }}</td>
<td>@if ($location->is_available)<span class="dyn-badge ok">Available</span>@else<span class="dyn-badge no">Booked</span>@endif</td>
</tr>
@endforeach
<!--/cms:skip-->
</tbody>
</table>
</div>
<div class="dyn-cta"><p>Interested in one of these locations?</p><a class="dyn-btn" href="{{ route('view.free.site.list', ['media' => 'other']) }}">Get Free Site List <span>→</span></a></div>
</div></section>
</main>
@endsection
