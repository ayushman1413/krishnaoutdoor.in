<footer class="footer"><div class="container footer-top"><a class="site-logo" href="{{ route('view.home') }}"><img loading="lazy" decoding="async" alt="Krishna Outdoor" src="{{ asset('assets/images/footer-logo.webp') }}"/></a><nav aria-label="Footer"><a href="{{ route('view.home') }}">Home</a><a href="{{ route('view.about') }}">About Us</a><a href="{{ route('view.services') }}">Media Solutions</a><a href="{{ route('view.network') }}">Our Network</a><a href="{{ route('view.projects') }}">Our Work</a><a href="{{ route('view.careers') }}">Careers</a><a href="https://krishnaoutdoor.in/blog/" target="_blank" rel="noopener">Blog</a><a href="{{ route('view.contact') }}">Contact Us</a></nav><div class="legacy"><small>Integrated media expertise supported by the legacy of</small><img loading="lazy" decoding="async" alt="Rakesh Advertising" src="{{ asset('assets/images/shared-rakesh-advertising-legacy.webp') }}"/></div></div>
<div class="container footer-services">
<div class="footer-services-col"><b>Services in Ahmedabad &amp; Gujarat</b><nav aria-label="Ahmedabad and Gujarat services">
<a href="{{ route('view.keyword.hoarding.ahmedabad') }}">Hoarding Advertising in Ahmedabad</a>
<a href="{{ route('view.keyword.amts.ahmedabad') }}">AMTS Bus Advertising in Ahmedabad</a>
<a href="{{ route('view.keyword.bus.shelter.ahmedabad') }}">Bus Shelter Advertising in Ahmedabad</a>
<a href="{{ route('view.keyword.gsrtc') }}">GSRTC Bus Advertising</a>
<a href="{{ route('view.keyword.social.ahmedabad') }}">Social Media Marketing in Ahmedabad</a>
</nav></div>
<div class="footer-services-col"><b>Services in Mumbai &amp; Thane</b><nav aria-label="Mumbai and Thane services">
<a href="{{ route('view.keyword.agency.mumbai') }}">Outdoor Advertising Agency in Mumbai</a>
<a href="{{ route('view.keyword.local.train.mumbai') }}">Mumbai Local Train Advertising</a>
<a href="{{ route('view.keyword.best.mumbai') }}">BEST Bus Advertising in Mumbai</a>
<a href="{{ route('view.keyword.tmt.thane') }}">TMT Bus Advertising in Thane</a>
<a href="{{ route('view.keyword.social.mumbai') }}">Social Media Marketing in Mumbai</a>
</nav></div>
</div>
<div class="container footer-offices">
@foreach (config('business.offices') as $office)
<address class="footer-office">
<b>{{ $office['label'] }}</b>
<span>{{ $office['address'] }}</span>
<a href="tel:{{ $office['phone'] }}">{{ $office['phone_display'] }}</a>
</address>
@endforeach
</div>
<div class="footer-bottom"><div class="container"><span>© {{ date('Y') }} Krishna Outdoor. All Rights Reserved.</span><span class="social-text">Follow Us <a href="https://www.facebook.com/krishnaoutdoorofficial/" target="_blank" rel="noopener noreferrer" aria-label="Krishna Outdoor on Facebook"><b class="social-icon social-facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M13.5 21v-8h2.7l.4-3h-3.1V8.1c0-.9.3-1.5 1.6-1.5h1.7V4a22 22 0 0 0-2.4-.1c-2.4 0-4 1.5-4 4.1V10H7.7v3H10v8h3.5Z"/></svg></b></a><a href="https://www.linkedin.com/company/krishnaoutdoor/" target="_blank" rel="noopener noreferrer" aria-label="Krishna Outdoor on LinkedIn"><b class="social-icon social-linkedin"><svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M6.5 8.2H3.1V21h3.4V8.2ZM4.8 3A2 2 0 1 0 4.8 7 2 2 0 0 0 4.8 3ZM21 13.7c0-3.8-2-5.6-4.7-5.6-2.2 0-3.2 1.2-3.8 2v-1.9H9.1V21h3.4v-6.3c0-1.7.3-3.4 2.5-3.4 2.1 0 2.1 1.9 2.1 3.5V21H21v-7.3Z"/></svg></b></a><a href="https://www.instagram.com/krishnaoutdoorofficial/" target="_blank" rel="noopener noreferrer" aria-label="Krishna Outdoor on Instagram"><b class="social-icon social-instagram"><svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M7.2 2h9.6A5.2 5.2 0 0 1 22 7.2v9.6a5.2 5.2 0 0 1-5.2 5.2H7.2A5.2 5.2 0 0 1 2 16.8V7.2A5.2 5.2 0 0 1 7.2 2Zm0 2A3.2 3.2 0 0 0 4 7.2v9.6A3.2 3.2 0 0 0 7.2 20h9.6a3.2 3.2 0 0 0 3.2-3.2V7.2A3.2 3.2 0 0 0 16.8 4H7.2Zm9.9 1.5a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/></svg></b></a></span><span>Design &amp; Developed by <a class="footer-dev-link" href="https://tcongsinfotech.com/" target="_blank" rel="noopener noreferrer" aria-label="Tcongs Infotech" style="text-decoration: none;" onclick="window.open(this.href, '_blank'); return false;">Tcongs Infotech</a></span></div></div></footer>