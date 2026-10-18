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