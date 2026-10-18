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
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
// GA4 events go to gtag when a GA4 ID is set and to the GTM dataLayer when a
// GTM ID is set (both IDs come from SEO settings).
window.koTrack = function (name, params) {
  params = Object.assign({ page_path: window.location.pathname }, params || {});
  if (window.KO_GA4) { gtag('event', name, params); }
  if (window.KO_GTM) { window.dataLayer.push(Object.assign({ event: name }, params)); }
};
function trackConversion(action, label) { window.koTrack(action, { event_label: label }); }
</script>
@if ($seoSettings?->ga4_id)
<script async src="https://www.googletagmanager.com/gtag/js?id={{ urlencode($seoSettings->ga4_id) }}"></script>
<script>window.KO_GA4 = true; gtag('js', new Date()); gtag('config', @json($seoSettings->ga4_id));</script>
@endif
@if ($seoSettings?->gtm_id)
<script>window.KO_GTM = true;(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer',@json($seoSettings->gtm_id));</script>
@endif
@if ($seoSettings?->fb_pixel_code)
{!! $seoSettings->fb_pixel_code !!}
@endif
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
{{-- Web fonts load without blocking first paint (font-display: swap). --}}
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Oswald:wght@500;600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Oswald:wght@500;600;700&display=swap" rel="stylesheet"/></noscript>

{{-- Per-template CSS bundle built by `npm run build:css` (tools/build-css.mjs)
     from css/style.css + css/home-style-sync.css + css/kr-laravel.css. --}}
@php $cssBundle = trim($__env->yieldContent('css-bundle')) ?: 'site'; @endphp
<link rel="stylesheet" href="{{ \App\Services\Asset::url('css/bundle-' . $cssBundle . '.min.css') }}">

<link rel="icon" type="image/png" sizes="64x64" href="{{ url('/favicon.png') }}">
<link rel="shortcut icon" href="{{ url('/favicon.ico') }}">
<link rel="apple-touch-icon" href="{{ url('/favicon.png') }}">

@yield('web-head')
@if ($seoSettings?->head_custom_code)
{!! $seoSettings->head_custom_code !!}
@endif
</head>
<body @if(trim($__env->yieldContent('body-class'))) class="@yield('body-class')" @endif>
@if ($seoSettings?->gtm_id)
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ urlencode($seoSettings->gtm_id) }}" height="0" width="0" style="display:none;visibility:hidden" title="Google Tag Manager"></iframe></noscript>
@endif
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
<script defer="defer" src="{{ \App\Services\Asset::url('js/main.min.js') }}"></script>
<script defer="defer" src="{{ \App\Services\Asset::url('js/kr-laravel.min.js') }}"></script>
<script defer="defer" src="{{ \App\Services\Asset::url('js/tracking.min.js') }}"></script>
@yield('web-script')
@if (session('message'))
<script>
window.addEventListener('DOMContentLoaded', function () {
  window.krToast(@json(session('message')['status'] ?? 'success'), @json(session('message')['title'] ?? ''), @json(session('message')['description'] ?? ''));
});
</script>
@endif
@if (session('track_event'))
@php $trackEvent = session('track_event'); @endphp
<script>
window.addEventListener('DOMContentLoaded', function () {
@if (is_array($trackEvent))
  window.koTrack(@json($trackEvent['name']), { form_name: @json($trackEvent['form_name'] ?? null) });
@else
  trackConversion(@json($trackEvent), window.location.pathname);
@endif
});
</script>
@endif
@if ($seoSettings?->body_custom_code)
{!! $seoSettings->body_custom_code !!}
@endif
</body>
</html>
