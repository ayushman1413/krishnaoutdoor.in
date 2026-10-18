@if ($seo)
    <title>{{ $seo->pageTitle }}</title>
    @if ($seo->description)
        <meta name="description" content="{{ $seo->description }}">
    @endif
    @if ($seo->meta?->meta_keywords)
        <meta name="keywords" content="{{ $seo->meta->meta_keywords }}">
    @endif
    <meta name="robots" content="{{ $seo->robotsContent() }}">
    <link rel="canonical" href="{{ $seo->canonicalUrl }}">

    <meta property="og:type" content="{{ $seo->ogType() }}">
    <meta property="og:title" content="{{ $seo->ogTitle() }}">
    @if ($seo->ogDescription())
        <meta property="og:description" content="{{ $seo->ogDescription() }}">
    @endif
    @if ($seo->ogImage())
        <meta property="og:image" content="{{ $seo->ogImage() }}">
    @endif
    <meta property="og:url" content="{{ $seo->canonicalUrl }}">
    <meta property="og:site_name" content="{{ $seo->settings?->site_name ?? 'Krishna Outdoor' }}">

    <meta name="twitter:card" content="{{ $seo->twitterCard() }}">
    <meta name="twitter:title" content="{{ $seo->twitterTitle() }}">
    @if ($seo->twitterDescription())
        <meta name="twitter:description" content="{{ $seo->twitterDescription() }}">
    @endif
    @if ($seo->twitterImage())
        <meta name="twitter:image" content="{{ $seo->twitterImage() }}">
    @endif

    <script type="application/ld+json">{!! \App\Services\SchemaBuilder::json($seo) !!}</script>

    @if ($seo->schemaJson())
        <script type="application/ld+json">{!! $seo->schemaJson() !!}</script>
    @endif
@else
    <title>@yield('web-title', 'We Are Your One-Stop Shop for Outdoor Advertising!')</title>
    @yield('web-meta')
@endif
