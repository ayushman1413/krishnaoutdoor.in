<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0" /><meta content="#0c0e11" name="theme-color"/>
{{-- No per-request CSRF token in the page HTML: forms fetch one from /csrf-token when first used, so pages stay cacheable. --}}
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
{{-- GA4 and GTM: the dataLayer/gtag stubs above queue events straight away;
     the tag scripts themselves load on the first interaction, or when the
     browser is idle, so they never compete with first paint. --}}
@if ($seoSettings?->ga4_id)
<script>window.KO_GA4 = true; gtag('js', new Date()); gtag('config', @json($seoSettings->ga4_id));</script>
@endif
@if ($seoSettings?->gtm_id)
<script>window.KO_GTM = true; window.dataLayer.push({'gtm.start': new Date().getTime(), event: 'gtm.js'});</script>
@endif
@if ($seoSettings?->ga4_id || $seoSettings?->gtm_id)
<script>
(function () {
  var tags = [];
  @if ($seoSettings?->ga4_id)
  tags.push('https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(@json($seoSettings->ga4_id)));
  @endif
  @if ($seoSettings?->gtm_id)
  tags.push('https://www.googletagmanager.com/gtm.js?id=' + encodeURIComponent(@json($seoSettings->gtm_id)));
  @endif
  var loaded = false;
  function load() {
    if (loaded) { return; }
    loaded = true;
    ['pointerdown', 'keydown', 'scroll', 'touchstart'].forEach(function (e) { window.removeEventListener(e, load, true); });
    tags.forEach(function (src) {
      var s = document.createElement('script'); s.async = true; s.src = src; document.head.appendChild(s);
    });
  }
  ['pointerdown', 'keydown', 'scroll', 'touchstart'].forEach(function (e) { window.addEventListener(e, load, { capture: true, once: true, passive: true }); });
  window.addEventListener('load', function () {
    if ('requestIdleCallback' in window) { requestIdleCallback(load, { timeout: 4000 }); } else { setTimeout(load, 3000); }
  });
})();
</script>
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
