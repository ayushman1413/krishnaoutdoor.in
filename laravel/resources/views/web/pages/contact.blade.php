@extends('web.layouts.app')

@section('css-bundle', 'contact')

@section('body-class', '')
@section('nav', 'contact')

@section('web-head')


@endsection


@section('web-section')

<main class="kr-page">

    <!-- ================= ENQUIRY HERO ================= -->

    <section class="kr-enquiry-hero">

        <div class="container inner">

            <div class="kr-enquiry-copy kr-reveal">

                <div class="kr-kicker">
                    ENQUIRE NOW
                </div>

                <h1 class="seo-h1">
                    {{ $seo->h1Override() ?: 'Contact Krishna Outdoor – Ahmedabad & Mumbai' }}
                </h1>

                <p class="seo-h1-slogan">
                    LET'S START WITH A <em>CONVERSATION.</em>
                </p>

                <p>
                    Whether you already know the media you need or are simply exploring possibilities,
                    our team is here to help. Tell us about your brand, your audience and what you want
                    to achieve. We will help you explore the media opportunities that best fit your requirement.
                </p>

                <div class="kr-enquiry-steps">

                    <div class="kr-enquiry-step">
                        <b>01</b>
                        <span>Discuss your goals</span>
                    </div>

                    <div class="kr-enquiry-step">
                        <b>02</b>
                        <span>Explore media options</span>
                    </div>

                    <div class="kr-enquiry-step">
                        <b>03</b>
                        <span>Get expert guidance</span>
                    </div>

                </div>

            </div>


            <div class="kr-enquiry-visual">

                <img srcset="{{ asset('assets/images/media/home-360-outdoor-hoarding-poster-800w.webp') }} 800w, {{ asset('assets/images/media/home-360-outdoor-hoarding-poster.webp') }} 1800w" sizes="(max-width: 760px) 100vw, 50vw"
                    alt="Krishna Outdoor backlit hoarding at night"
                    decoding="async"
                    loading="lazy"
                    src="{{ asset('assets/images/media/home-360-outdoor-hoarding-poster.webp') }}"
                />

            </div>

        </div>

    </section>


    <!-- ================= FORM ================= -->

    <section class="kr-form-area">

        <div class="container kr-form-layout">


            <div class="kr-side-message kr-reveal">

                <div class="side-copy">

                    <div class="kr-kicker">
                        SEND US A MESSAGE
                    </div>

                    <h2>
                        LET'S START WITH A CONVERSATION.
                    </h2>

                    <p>
                        Whether you already know the media you need or are simply exploring possibilities,
                        our team is here to help. Tell us about your brand, your audience and what you want
                        to achieve. We will help you explore the media opportunities that best fit your requirement.
                    </p>

                </div>

                <img srcset="{{ asset('assets/images/shared-night-city-background-800w.webp') }} 800w, {{ asset('assets/images/shared-night-city-background.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw"
                    alt=""
                    decoding="async"
                    loading="lazy"
                    src="{{ asset('assets/images/shared-night-city-background.webp') }}"
                />

                <div class="kr-side-caption">
                    BRANDS<br />
                    TRAVEL FURTHER<br />
                    WITH THE RIGHT<br />
                    <em>CONVERSATIONS.</em>
                </div>

            </div>


            <form
                class="kr-contact-form kr-reveal delay-1"
                id="enquiryForm"
                method="POST"
                action="{{ route('handle.plan.campaign.enquiry') }}"
            >

                @csrf

                <input
                    type="hidden"
                    name="requirement"
                    value=""
                >

                <h2>
                    Start Your Enquiry
                </h2>


                <div class="kr-form-grid">

                    <div class="kr-field">

                        <label for="enquiry_name">
                            Full Name *
                        </label>

                        <input
                            id="enquiry_name"
                            name="name"
                            placeholder="Enter your full name"
                            required
                            value="{{ old('name') }}"
                        />

                    </div>


                    <div class="kr-field">

                        <label for="enquiry_company">
                            Company Name *
                        </label>

                        <input
                            id="enquiry_company"
                            name="company"
                            placeholder="Enter your company name"
                            required
                            value="{{ old('company') }}"
                        />

                    </div>


                    <div class="kr-field">

                        <label for="enquiryPhone">
                            Mobile Number *
                        </label>

                        <input
                            id="enquiryPhone"
                            inputmode="numeric"
                            maxlength="10"
                            name="phone"
                            pattern="[0-9]{10}"
                            placeholder="10-digit mobile number"
                            required
                            value="{{ old('phone') }}"
                        />

                    </div>


                    <div class="kr-field">

                        <label for="enquiry_email">
                            Email Address *
                        </label>

                        <input
                            id="enquiry_email"
                            name="email"
                            placeholder="Enter your email address"
                            required
                            type="email"
                            value="{{ old('email') }}"
                        />

                    </div>


                    <div class="kr-field">

                        <label for="enquiry_city">
                            Target City / Market *
                        </label>

                        <select
                            id="enquiry_city"
                            name="city" required>

                            <option value="">
                                Select city / market
                            </option>

                            <option>
                                Ahmedabad
                            </option>

                            <option>
                                Mumbai
                            </option>

                            <option>
                                Surat
                            </option>

                            <option>
                                Thane
                            </option>

                            <option>
                                Rajasthan
                            </option>

                            <option>
                                Other
                            </option>

                        </select>

                    </div>


                    <div class="kr-field">

                        <label for="enquiry_media">
                            Media or Service Required *
                        </label>

                        <select
                            id="enquiry_media"
                            name="media" required>

                            <option value="">
                                Select media / service
                            </option>

                            <option>
                                OOH Media
                            </option>

                            <option>
                                Transit Media
                            </option>

                            <option>
                                Digital Media
                            </option>

                            <option>
                                Print Media
                            </option>

                            <option>
                                Electronic Media
                            </option>

                            <option>
                                Integrated Campaign
                            </option>

                        </select>

                    </div>


                    <div class="kr-field">

                        <label for="enquiry_duration">
                            Campaign Duration
                        </label>

                        <select
                            id="enquiry_duration"
                            name="duration">

                            <option value="">
                                Select duration
                            </option>

                            <option>
                                1–2 weeks
                            </option>

                            <option>
                                1 month
                            </option>

                            <option>
                                3 months
                            </option>

                            <option>
                                6+ months
                            </option>

                        </select>

                    </div>


                    <div class="kr-field full">

                        <label for="enquiry_user_message">
                            Message
                        </label>

                        <textarea
                            id="enquiry_user_message"
                            name="user_message"
                            placeholder="Tell us about your campaign, audience and any specific requirement..."
                        >{{ old('user_message') }}</textarea>

                    </div>

                </div>


                @if ($errors->planCampaign->any())

                    <div
                        class="kr-note kr-error"
                        role="alert"
                    >

                        @foreach ($errors->planCampaign->all() as $error)

                            <div>
                                {{ $error }}
                            </div>

                        @endforeach

                    </div>

                @endif


                <button
                    class="kr-btn kr-submit"
                    type="submit"
                >
                    Start Your Enquiry →
                </button>


                <div
                    class="kr-note"
                    id="enquiryStatus"
                >
                    We’ll use your information to respond to this enquiry.
                </div>

            </form>


            <div class="kr-guidance kr-reveal delay-2" role="note">


                <div class="kr-guide-item">

                    <span class="kr-guide-icon">
                        ◎
                    </span>

                    <div>

                        <h3>
                            UNDERSTAND
                            <br />
                            YOUR OBJECTIVE
                        </h3>

                        <p>
                            We listen to your goals and understand your market.
                        </p>

                    </div>

                </div>


                <div class="kr-guide-item">

                    <span class="kr-guide-icon">
                        ♧
                    </span>

                    <div>

                        <h3>
                            EXPLORE
                            <br />
                            THE RIGHT OPTIONS
                        </h3>

                        <p>
                            We suggest relevant media opportunities.
                        </p>

                    </div>

                </div>


                <div class="kr-guide-item">

                    <span class="kr-guide-icon">
                        ▤
                    </span>

                    <div>

                        <h3>
                            PLAN WITH
                            <br />
                            EXPERIENCE
                        </h3>

                        <p>
                            We help you bring your campaign to life with the right mix.
                        </p>

                    </div>

                </div>


                <div class="kr-guide-call">

                    <span>
                        ◔
                    </span>

                    <div>

                        <small>
                            Need Immediate Assistance?
                        </small>

                        <b>
                            +91 98796 16411
                        </b>

                    </div>

                </div>

            </div>

        </div>

    </section>


<!-- ================= OFFICES ================= -->

<section class="kr-section">

    <div class="container">

        <div class="kr-head kr-reveal">

            <div>

                <div class="kr-kicker">
                    OUR OFFICES
                </div>

                <h2>
                    Office Details
                </h2>

            </div>

            <p>
                Display Ahmedabad and Mumbai office information clearly,
                along with direct contact numbers, email addresses and map locations where relevant.
            </p>

        </div>


        <div class="kr-offices">


            <!-- ================= AHMEDABAD ================= -->

            <article class="kr-office kr-reveal">

                <div
                    class="kr-office-map"
                    style="
                        display:block !important;
                        width:100% !important;
                        height:280px !important;
                        overflow:hidden;
                        position:relative;
                        border-bottom:1px solid #e1e4e8;
                    "
                >

                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3671.716520810773!2d72.566672!3d23.0341785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e85576f06b3bd%3A0xd585856682fcd9f7!2sKrishna%20Outdoor%20Ahmedabad%20-%20Outdoor%20Advertising%20Agency!5e0!3m2!1sen!2sin!4v1790680723141!5m2!1sen!2sin"
                        width="100%"
                        height="100%"
                        style="
                            border:0;
                            display:block;
                            width:100%;
                            height:100%;
                            min-height:368px;
                        "
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="strict-origin-when-cross-origin"
                        title="Krishna Outdoor Ahmedabad Office Map"
                    ></iframe>

                </div>


                <div class="kr-office-info">

                    <div class="tag">
                        AHMEDABAD
                    </div>

                    <h3>
                        Head Office
                    </h3>

                    <p>
                        Aakanksha Complex, 403-404, Netaji Rd,
                        <br />
                        nr. Railway Crossing, opposite Andani Hyper Market,
                        <br />
                        Muslim Society, Navrangpura, Ahmedabad, Gujarat – 380009,
                        <br />
                        India.
                    </p>


                    <a href="tel:+919879616411" onclick="trackConversion('phone_click', this.href)">
                        +91 98796 16411
                    </a>


                    <a href="mailto:info@krishnaoutdoor.in">
                        info@krishnaoutdoor.in
                    </a>


                    <a
                        class="kr-office-btn"
                        href="https://share.google/JwW50PksVqUtM5F5v"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        View on Map →
                    </a>

                </div>

            </article>


            <!-- ================= MUMBAI ================= -->

            <article class="kr-office kr-reveal delay-1">

                <div
                    class="kr-office-map"
                    style="
                        display:block !important;
                        width:100% !important;
                        height:280px !important;
                        overflow:hidden;
                        position:relative;
                        border-bottom:1px solid #e1e4e8;
                    "
                >

                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d60308.69418112952!2d72.75524139404298!3d19.138630713595617!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7b71523c2a9f3%3A0xfc30fbd184b87770!2sKrishna%20Outdoor%20Mumbai%20-%20Outdoor%20Advertising%20Agency!5e0!3m2!1sen!2sin!4v1790680391626!5m2!1sen!2sin"
                        width="100%"
                        height="100%"
                        style="
                            border:0;
                            display:block;
                            width:100%;
                            height:100%;
                            min-height:368px;
                        "
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="strict-origin-when-cross-origin"
                        title="Krishna Outdoor Mumbai Office Map"
                    ></iframe>

                </div>


                <div class="kr-office-info">

                    <div class="tag">
                        MUMBAI
                    </div>

                    <h3>
                        Mumbai Office
                    </h3>

                    <p>
                        701, 702 Morya Blue Moon,
                        <br />
                        Next to Moniginis Cake Factory, Off New Link Road,
                        <br />
                        Opp. Citi Mall, Andheri West, Mumbai, Maharashtra – 400053,
                        <br />
                        India.
                    </p>


                    <a href="tel:+919920011574" onclick="trackConversion('phone_click', this.href)">
                        +91 99200 11574
                    </a>


                    <a href="mailto:info.team@krishnaoutdoor.in">
                        info.team@krishnaoutdoor.in
                    </a>


                    <a
                        class="kr-office-btn"
                        href="https://share.google/DroagXflxGbKZiiv2"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        View on Map →
                    </a>

                </div>

            </article>


        </div>

    </div>

</section>


    <!-- ================= CAREERS ================= -->

    <section
        aria-label="Careers at Krishna Outdoor"
        class="kr-career-cta"
    >

        <div class="container">

            <div class="kr-career-cta-copy">

                <div class="kr-kicker">
                    CAREERS / LIFE AT KRISHNA
                </div>

                <h2>
                    BUILD THE
                    <em>NEXT CHAPTER.</em>
                </h2>

                <p>
                    Great outdoor campaigns are built by people who understand places,
                    people and possibilities. Join a team that turns ideas into real-world visibility.
                </p>

            </div>


            <a
                class="kr-btn"
                href="{{ route('view.careers') }}"
            >
                EXPLORE CAREERS
                <span>→</span>
            </a>

        </div>

    </section>


    <!-- ================= FINAL CTA ================= -->

    <section class="kr-final-cta">

        <div class="container">

            <div>

                <div class="kr-kicker">
                    READY TO GET STARTED?
                </div>

                <h2>
                    LET'S PUT YOUR BRAND IN THE RIGHT PLACE.
                </h2>

            </div>


            <a
                class="kr-btn"
                href="#enquiryForm"
            >
                PLAN YOUR CAMPAIGN
            </a>

        </div>

    </section>

</main>

@endsection


@section('web-script')

<script>

(function () {

    var f = document.getElementById('enquiryForm');

    if (!f) {
        return;
    }


    f.addEventListener('submit', function () {

        var g = function (n) {

            var e = f.elements[n];

            return e
                ? String(e.value).trim()
                : '';

        };


        var parts = [
            g('media'),
            g('city'),
            g('duration'),
            g('email'),
            g('user_message')
        ].filter(Boolean);


        f.elements['requirement'].value =
            parts.join(' | ').slice(0, 250);

    });


    /* Mobile phone: numbers only */

    var phone = document.getElementById('enquiryPhone');

    if (phone) {

        phone.addEventListener('input', function () {

            this.value = this.value
                .replace(/\D/g, '')
                .slice(0, 10);

        });

    }

})();

</script>

@endsection