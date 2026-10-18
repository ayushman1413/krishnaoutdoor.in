@extends('web.layouts.app')

@section('web-title', $category->name.' | Krishna Outdoor')
@section('body-class', 'inner-page')
@section('nav', 'services')

@section('web-meta')
<meta name="description" content="{{ $category->summary }}">
@endsection

@section('web-section')
<main>
<section class="hero media-detail-hero dyn-hero" id="home">
<div class="media-detail-hero-bg"><img alt="{{ $category->name }}" decoding="async" loading="eager" src="{{ $category->cover_image ? asset('storage/'.$category->cover_image) : asset('assets/images/shared-night-city-background.png') }}"/></div>
<div class="hero-overlay"></div><div class="hero-grid"></div><div class="hero-noise"></div>
<div class="container hero-inner reveal"><h1>{{ $seo->h1Override() ?: $category->name }}</h1></div>
</section>
<section class="dyn-section"><div class="container">
<div class="dyn-crumbs"><a href="{{ route('view.home') }}">Home</a><span>/</span><b>{{ $category->name }}</b></div>
@if ($category->summary)<p class="dyn-intro">{{ $category->summary }}</p>@endif
<div class="dyn-grid two">
@foreach ($category->child_categories as $child_category)
<article class="dyn-card">
<div class="dyn-card-media">
@if (pathinfo((string) $child_category->cover_image, PATHINFO_EXTENSION) == 'mp4')
<video src="{{ asset('storage/'.$child_category->cover_image) }}" autoplay muted loop playsinline></video>
@else
<img src="{{ asset('storage/'.$child_category->cover_image) }}" alt="{{ $child_category->name }} Cover Image" loading="lazy">
@endif
</div>
<div class="dyn-card-body">
<h3><a href="{{ route('view.child.category', ['slug' => $child_category->slug]) }}">{{ $child_category->name }}</a></h3>
<p>{{ $child_category->summary }}</p>
<a class="dyn-btn" href="{{ route('view.child.category', ['slug' => $child_category->slug]) }}">View Projects <span>→</span></a>
</div>
</article>
@endforeach
</div>
</div></section>
</main>
@endsection
