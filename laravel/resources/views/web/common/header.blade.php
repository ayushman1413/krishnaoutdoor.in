@php
    $nav = trim($__env->yieldContent('nav'));
    $navCategories = \App\Models\Category::where('category_id', null)->get();
@endphp

<div class="page-progress" id="pageProgress"></div>

<header class="header" id="header">
    <div class="container nav-wrap">

        <!-- Mobile Menu Button -->
        <button
            aria-expanded="false"
            aria-label="Toggle menu"
            class="nav-toggle"
            id="navToggle"
            type="button"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Logo -->
        <a class="site-logo" href="{{ route('view.home') }}">
            <img
                src="{{ asset('assets/images/header-logo.webp') }}"
                alt="Krishna Outdoor"
            />
        </a>

        <!-- Navigation -->
        <nav class="nav" id="nav">

            <!-- Home -->
            <a
                @if ($nav === 'home') aria-current="page" class="active" @endif
                href="{{ route('view.home') }}"
            >
                Home
            </a>

            <!-- About -->
            <a
                @if ($nav === 'about') aria-current="page" class="active" @endif
                href="{{ route('view.about') }}"
            >
                About Us
            </a>

            <!-- Media Solutions -->
            <div class="nav-dropdown">

                <a
                    @if ($nav === 'services') aria-current="page" class="active" @endif
                    href="{{ route('view.services') }}"
                >
                    Media Solutions
                </a>

                <button
                    class="nav-arrow"
                    type="button"
                    aria-label="Open Media Solutions menu"
                    aria-expanded="false"
                ></button>

                <div class="nav-menu">

                    @forelse ($navCategories as $item)

                        <a href="{{ route('view.parent.category', ['slug' => $item->slug]) }}">
                            {{ $item->name }}
                        </a>

                    @empty

                        <a href="{{ route('view.ooh.media') }}">
                            OOH Media
                        </a>

                        <a href="{{ route('view.transit.media') }}">
                            Transit Media
                        </a>

                        <a href="{{ route('view.digital.media') }}">
                            Digital Media
                        </a>

                    @endforelse

                </div>
            </div>

            <!-- Our Network -->
            <a
                @if ($nav === 'network') aria-current="page" class="active" @endif
                href="{{ route('view.network') }}"
            >
                Our Network
            </a>

            <!-- Our Work -->
            <a
                @if ($nav === 'projects') aria-current="page" class="active" @endif
                href="{{ route('view.projects') }}"
            >
                Our Work
            </a>

            <!-- Contact Us -->
            <a
                @if ($nav === 'contact') aria-current="page" class="active" @endif
                href="{{ route('view.contact') }}"
            >
                Contact Us
            </a>


            <!-- Mobile Enquire Now -->
            <div class="nav-cta-drawer-box">
                <button
                    type="button"
                    class="nav-cta-drawer enquiry-popup-trigger"
                >
                    Enquire Now
                    <span>→</span>
                </button>
            </div>

        </nav>

        <!-- Call / WhatsApp (Mumbai number on Mumbai-region pages) -->
        @php
            $headerOffice = \App\Services\SeoResolver::officeFor($seo ?? null);
            $headerWhatsapp = \App\Services\SeoResolver::whatsappUrl($seoSettings ?? null);
        @endphp
        <div class="nav-contact">
            <a class="nav-contact-link nav-contact-call" href="tel:{{ $headerOffice['phone'] }}" aria-label="Call Krishna Outdoor on {{ $headerOffice['phone_display'] }}">
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1A17 17 0 0 1 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1l-2.3 2.2Z"/></svg>
                <span>{{ $headerOffice['phone_display'] }}</span>
            </a>
            @if ($headerWhatsapp)
                <a class="nav-contact-link nav-contact-whatsapp" href="{{ $headerWhatsapp }}" target="_blank" rel="noopener" aria-label="Chat with Krishna Outdoor on WhatsApp">
                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Zm0 18.2c-1.5 0-3-.4-4.3-1.2l-.3-.2-3 .8.8-2.9-.2-.3A8.2 8.2 0 1 1 12 20.2Zm4.5-6.1c-.2-.1-1.5-.7-1.7-.8-.2-.1-.4-.1-.6.1l-.8 1c-.1.2-.3.2-.5.1a6.7 6.7 0 0 1-3.3-2.9c-.2-.4.2-.4.7-1.3.1-.2 0-.3 0-.4l-.8-1.9c-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.4.1-.7.3-.2.3-.9.9-.9 2.2 0 1.3.9 2.5 1.1 2.7.1.2 1.8 2.8 4.4 3.9 1.6.7 2.3.8 3.1.6.5-.1 1.5-.6 1.7-1.2.2-.6.2-1.1.2-1.2-.1-.1-.3-.2-.5-.3Z"/></svg>
                    <span class="sr-only">WhatsApp</span>
                </a>
            @endif
        </div>

        <!-- Desktop Enquire Now -->
        <button
            type="button"
            class="nav-cta enquiry-popup-trigger"
        >
            Enquire Now
            <span>→</span>
        </button>

    </div>
</header>

@include('web.common.enquiry-popup')