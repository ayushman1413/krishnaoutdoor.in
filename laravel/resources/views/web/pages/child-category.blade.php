@extends('web.layouts.app')

@section('web-title', $category->name.' | Krishna Outdoor')
@section('body-class', 'inner-page')
@section('nav', 'services')

@section('web-meta')
<meta name="description" content="{{ $category->summary }}">
@endsection

@section('web-section')
@php $media_items = isset($category_media) ? $category_media : \App\Models\CategoryMedia::where('category_id', $category->id)->get(); @endphp
<main>
<section class="hero media-detail-hero dyn-hero" id="home">
<div class="media-detail-hero-bg"><img alt="{{ $category->cover_image_alt ?: $category->name . ' advertising – Krishna Outdoor' }}" decoding="async" loading="eager" src="{{ $category->cover_image ? asset('storage/'.$category->cover_image) : asset('assets/images/shared-night-city-background.png') }}"/></div>
<div class="hero-overlay"></div><div class="hero-grid"></div><div class="hero-noise"></div>
<div class="container hero-inner reveal"><h1>{{ $seo->h1Override() ?: $category->name }}</h1></div>
</section>
<section class="dyn-section"><div class="container">
@include('web.common.breadcrumbs', ['seo' => $seo, 'class' => 'dyn-crumbs'])
<!--cms:skip-->@if ($category->summary)<p class="dyn-intro">{{ $category->summary }}</p>@endif<!--/cms:skip-->

@if (count($category->child_categories) != 0)
<div class="dyn-grid">
<!--cms:skip-->
@foreach ($category->child_categories as $child_category)
<article class="dyn-card">
@php $thumb = $child_category->thumbnail_image ?: null; @endphp
<div class="dyn-card-media">@if ($thumb)<img src="{{ asset('storage/'.$thumb) }}" alt="{{ $child_category->thumbnail_image_alt ?: $child_category->name . ' advertising – Krishna Outdoor' }}" loading="lazy">@else<img src="{{ asset('assets/images/shared-night-city-background-800w.webp') }}" alt="" loading="lazy">@endif</div>
<div class="dyn-card-body">
<h3><a href="{{ route('view.child.category', ['slug' => $child_category->slug]) }}">{{ $child_category->name }}</a></h3>
<p>{{ $child_category->summary }}</p>
<a class="dyn-btn" href="{{ route('view.child.category', ['slug' => $child_category->slug]) }}">View Projects <span>→</span></a>
</div>
</article>
@endforeach
<!--/cms:skip-->
</div>
@else
<div class="dyn-gallery">
<!--cms:skip-->
@foreach ($media_items as $media)
<figure>
@switch($media->type)
@case('image/jpeg')
@case('image/png')
@case('image/webp')
@case('image/jpg')
<a href="{{ asset('storage/'.$media->path) }}" class="kr-lightbox" data-group="gallery"><img src="{{ asset('storage/'.$media->path) }}" alt="{{ $media->alt_text ?: $category->name . ' advertising site – Krishna Outdoor' }}" title="{{ $media->title_text ?: $category->name }}" loading="lazy"></a>
@break
@case('video/mp4')
<video src="{{ asset('storage/'.$media->path) }}" controls preload="metadata"></video>
@break
@default
<a target="_blank" rel="noopener" class="dyn-btn" href="{{ asset('storage/'.$media->path) }}">Preview Media</a>
@endswitch
@if ($media->name)<figcaption>{{ ucwords($media->name) }}</figcaption>@endif
</figure>
@endforeach
<!--/cms:skip-->
</div>
@endif
</div></section>
</main>
@endsection
