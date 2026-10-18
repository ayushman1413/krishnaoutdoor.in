<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0" /><meta content="#0c0e11" name="theme-color"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('web.common.seo-head', ['seo' => $seo ?? null])
@php $seoSettings = $seo?->settings ?? \App\Models\SeoSetting::query()->first(); @endphp
@if ($seoSettings?->gsc_verification_code)
<meta name="google-site-verification" content="{{ $seoSettings->gsc_verification_code }}">
@endif
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H76CYYJE3S"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'G-H76CYYJE3S');
@if ($seoSettings?->ga4_id)
gtag('config', @json($seoSettings->ga4_id));
@endif
function trackConversion(action, label) {
    if (window.gtag) {
        gtag('event', action, { event_category: 'engagement', event_label: label });
    }
}
</script>
@if ($seoSettings?->gtm_id)
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer',@json($seoSettings->gtm_id));</script>
@endif
@if ($seoSettings?->fb_pixel_code)
{!! $seoSettings->fb_pixel_code !!}
@endif
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Oswald:wght@500;600;700&display=swap" rel="stylesheet"/>

<link rel="stylesheet" href="{{ url('/css/style.css') }}">
<link rel="stylesheet" href="{{ url('/css/home-style-sync.css') }}">
<link rel="stylesheet" href="{{ url('/css/kr-laravel.css') }}">

<link rel="icon" type="image/png" sizes="64x64" href="{{ url('/favicon.png') }}">
<link rel="shortcut icon" href="{{ url('/favicon.ico') }}">
<link rel="apple-touch-icon" href="{{ url('/favicon.png') }}">

@yield('web-head')
@if ($seoSettings?->head_custom_code)
{!! $seoSettings->head_custom_code !!}
@endif
<body @if(trim($__env->yieldContent('body-class'))) class="@yield('body-class')" @endif>
@include('web.common.header')
@yield('web-section')
@include('web.common.footer')
@include('web.common.chatbot')
<script>
window.KR_ROUTES = {
  home: @json(route('view.home')), about: @json(route('view.about')), services: @json(route('view.services')),
  ooh: @json(route('view.ooh.media')), transit: @json(route('view.transit.media')), digital: @json(route('view.digital.media')),
  network: @json(route('view.network')), location: @json(route('view.network').'#presence'),
  campaign: @json(route('view.projects').'#campaigns'), work: @json(route('view.projects')),
  careers: @json(route('view.careers')), enquire: @json(route('view.contact'))
};
</script>
<script defer="defer" src="{{ asset('js/main.js') }}?v={{ @filemtime(public_path('js/main.js')) }}"></script>
<script defer="defer" src="{{ asset('js/kr-laravel.js') }}?v={{ @filemtime(public_path('js/kr-laravel.js')) }}"></script>
@yield('web-script')
@if (session('message'))
<script>
window.addEventListener('DOMContentLoaded', function () {
  window.krToast(@json(session('message')['status'] ?? 'success'), @json(session('message')['title'] ?? ''), @json(session('message')['description'] ?? ''));
});
</script>
@endif
@if (session('track_event'))
<script>
window.addEventListener('DOMContentLoaded', function () {
  trackConversion(@json(session('track_event')), window.location.pathname);
});
</script>
@endif
@if ($seoSettings?->body_custom_code)
{!! $seoSettings->body_custom_code !!}
@endif
</body>
</html>
