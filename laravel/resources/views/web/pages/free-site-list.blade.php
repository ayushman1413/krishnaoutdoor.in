@extends('web.layouts.app')

@section('css-bundle', 'keyword')

@section('body-class', 'inner-page')
@section('nav', '')

@section('web-head')
@include('web.common.keyword-page-style')
@endsection

@section('web-section')
@php
    $office = \App\Services\SeoResolver::officeFor($seo);
    $waMessage = fn (?string $media, ?string $city) => 'Hi, I want a free site list for ' . ($media ?: 'outdoor and transit media') . ($city ? ' in ' . $city : '');
    $waNumbers = [
        'ahmedabad' => preg_replace('/\D+/', '', \App\Services\SeoResolver::whatsappUrl($seo, $seo->settings, null, 'ahmedabad')),
        'mumbai' => preg_replace('/\D+/', '', config('business.offices.mumbai.phone')),
    ];
    $whatsapp = \App\Services\SeoResolver::whatsappUrl($seo, $seo->settings, $waMessage($selectedMedia ? $mediaTypes[$selectedMedia] : null, $selectedCity), $whatsappOffice);
@endphp
<main>

<section class="hero media-detail-hero media-detail-hero-ooh" id="home">
    <div class="media-detail-hero-bg">
        <img srcset="{{ asset('assets/images/media/home-360-outdoor-hoarding-night-01-800w.webp') }} 800w, {{ asset('assets/images/media/home-360-outdoor-hoarding-night-01.webp') }} 1800w" sizes="100vw" alt="" decoding="async" loading="eager" fetchpriority="high" src="{{ asset('assets/images/media/home-360-outdoor-hoarding-night-01.webp') }}"/>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-grid"></div>
    <div class="container hero-inner reveal">
        <h1>{{ $seo->h1Override() ?: 'Get Your Free Site List' }}</h1>
    </div>
</section>

<section class="kw-section"><div class="kw-inner">
    <div class="kw-grid-2 fsl-grid">
        <div>
            <h2 class="kw-h2">Tell us where and how you want to <em>advertise</em></h2>
            <p class="kw-p">Share your city and the media you are interested in. Our team will send you a list of available sites with locations and rates, usually within one business day.</p>
            <ul class="kw-list">
                <li><b>Outdoor:</b> hoardings, unipoles and backlit bus shelters across Ahmedabad and Gujarat.</li>
                <li><b>Transit:</b> AMTS and GSRTC buses in Gujarat, BEST and TMT buses and local trains in Mumbai and Thane.</li>
                <li><b>Digital:</b> DOOH screens in Ahmedabad.</li>
            </ul>
            <div class="fsl-direct">
                <a class="btn red" href="tel:{{ $office['phone'] }}">Call {{ $office['phone_display'] }} <b>→</b></a>
            </div>
        </div>

        <form class="fsl-form" method="POST" action="{{ route('handle.free.site.list') }}" novalidate>
            @csrf
            <h2 class="fsl-form-title">Get Free Site List</h2>

            <div class="fsl-field">
                <label for="fsl_name">Name <span aria-hidden="true">*</span></label>
                <input id="fsl_name" name="name" type="text" autocomplete="name" required maxlength="250" value="{{ old('name') }}" @error('name') aria-invalid="true" aria-describedby="fsl_name_error" @enderror>
                @error('name')<p class="fsl-error" id="fsl_name_error">{{ $message }}</p>@enderror
            </div>

            <div class="fsl-field">
                <label for="fsl_company">Company</label>
                <input id="fsl_company" name="company" type="text" autocomplete="organization" maxlength="250" value="{{ old('company') }}">
            </div>

            <div class="fsl-field">
                <label for="fsl_mobile">Mobile number <span aria-hidden="true">*</span></label>
                <input id="fsl_mobile" name="mobile" type="tel" inputmode="numeric" autocomplete="tel-national" pattern="[0-9]{10}" maxlength="10" required value="{{ old('mobile') }}" aria-describedby="fsl_mobile_hint @error('mobile') fsl_mobile_error @enderror" @error('mobile') aria-invalid="true" @enderror>
                <p class="fsl-hint" id="fsl_mobile_hint">10-digit mobile number</p>
                @error('mobile')<p class="fsl-error" id="fsl_mobile_error">{{ $message }}</p>@enderror
            </div>

            <div class="fsl-field">
                <label for="fsl_city">City <span aria-hidden="true">*</span></label>
                <input id="fsl_city" name="city" type="text" list="fsl_city_options" autocomplete="address-level2" required maxlength="100" value="{{ old('city', $selectedCity) }}" @error('city') aria-invalid="true" aria-describedby="fsl_city_error" @enderror>
                <datalist id="fsl_city_options">
                    <option value="Ahmedabad"><option value="Surat"><option value="Vadodara"><option value="Rajkot"><option value="Mumbai"><option value="Thane"><option value="Jaipur">
                </datalist>
                @error('city')<p class="fsl-error" id="fsl_city_error">{{ $message }}</p>@enderror
            </div>

            <div class="fsl-field">
                <label for="fsl_media">Media type <span aria-hidden="true">*</span></label>
                <select id="fsl_media" name="media" required @error('media') aria-invalid="true" aria-describedby="fsl_media_error" @enderror>
                    <option value="" disabled @selected(!old('media', $selectedMedia))>Select media type</option>
                    @foreach ($mediaTypes as $value => $label)
                        <option value="{{ $value }}" @selected(old('media', $selectedMedia) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('media')<p class="fsl-error" id="fsl_media_error">{{ $message }}</p>@enderror
            </div>

            <div class="fsl-actions">
                <button type="submit" class="btn red fsl-submit">Get Free Site List <b>→</b></button>
                <a class="btn fsl-whatsapp" id="fslWhatsapp" href="{{ $whatsapp }}" target="_blank" rel="noopener">Or chat on WhatsApp <b>→</b></a>
            </div>
        </form>
    </div>
</div></section>

</main>
@endsection

@section('web-script')
<script>
// Keep the WhatsApp button in step with the form: pre-filled message with the
// chosen city and media type, and the Mumbai number for Mumbai/Thane requests.
(function () {
  var link = document.getElementById('fslWhatsapp');
  var city = document.getElementById('fsl_city');
  var media = document.getElementById('fsl_media');
  if (!link || !city || !media) { return; }
  var numbers = @json($waNumbers);
  var mumbaiMedia = @json($mumbaiMedia);
  function update() {
    var label = media.value ? media.options[media.selectedIndex].text : 'outdoor and transit media';
    var where = city.value.trim();
    var mumbai = mumbaiMedia.indexOf(media.value) !== -1 || /^(mumbai|thane)$/i.test(where);
    var text = 'Hi, I want a free site list for ' + label + (where ? ' in ' + where : '');
    link.href = 'https://wa.me/' + (mumbai ? numbers.mumbai : numbers.ahmedabad) + '?text=' + encodeURIComponent(text);
  }
  city.addEventListener('input', update);
  media.addEventListener('change', update);
  update();
})();
</script>
@endsection
