@extends('web.layouts.app')

@section('web-title', 'Thank You | Krishna Outdoor')
@section('body-class', '')
@section('nav', '')

@section('web-meta')
<meta name="robots" content="noindex,follow"><meta name="description" content="Thank you for contacting Krishna Outdoor. Our team has received your enquiry and will get back to you shortly.">
@endsection

@section('web-head')
<link rel="stylesheet" href="{{ asset('css/thank-you.css') }}?v={{ @filemtime(public_path('css/thank-you.css')) }}">
@endsection

@section('web-section')


<main>
  <section class="ty-hero">
    <div class="ty-glow ty-glow-one"></div><div class="ty-glow ty-glow-two"></div>
    <div class="container ty-main">
      <div class="ty-copy">
        <div class="ty-check"><span>✓</span></div>
        <div class="kr-kicker">MESSAGE RECEIVED</div>
        <h1>THANK <em>YOU!</em></h1>
        <h2>Your message has been submitted successfully.</h2>
        <p>We’ve received your enquiry and our team will get back to you as soon as possible, usually within one business day.</p>
        <a class="ty-home-btn" href="{{ route('view.home') }}"><span>⌂</span> Back to Home <b>→</b></a>
      </div>
      <div class="ty-visual">
        <img fetchpriority="high" src="{{ asset('assets/images/thankyou-envelope.webp') }}" alt="Message sent successfully" loading="eager">
      </div>
    </div>

    <div class="container ty-info-card">
      <div class="ty-info-item"><span class="ty-icon">☎</span><div><b>Need Immediate Help?</b><p>Call us: <a href="tel:{{ config('business.offices.ahmedabad.phone') }}">{{ config('business.offices.ahmedabad.phone_display') }}</a></p></div></div>
      <div class="ty-divider"></div>
      <div class="ty-info-item"><span class="ty-icon">✉</span><div><b>Email Us</b><p><a href="mailto:{{ config('business.email') }}">{{ config('business.email') }}</a></p></div></div>
      <div class="ty-divider"></div>
      <div class="ty-info-item"><span class="ty-icon">⌖</span><div><b>Our Office</b><p>{{ config('business.offices.ahmedabad.address') }}</p></div></div>
      <div class="ty-divider"></div>
      <div class="ty-info-item"><span class="ty-icon">◷</span><div><b>Business Hours</b><p>Mon – Sat<br>10:00 AM – 6:00 PM</p></div></div>
    </div>
  </section>
</main>


@endsection

@section('web-script')
<script>
// The thank-you page is the conversion page: the lead event (generate_lead) is
// sent with the form redirect; this marks the page view itself for GA4.
window.addEventListener('DOMContentLoaded', function () {
  window.koTrack('thank_you_view', { page_type: 'conversion' });
});
</script>
@endsection
