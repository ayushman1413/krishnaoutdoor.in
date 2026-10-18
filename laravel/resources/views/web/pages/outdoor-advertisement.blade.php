@extends('web.layouts.app')

@section('web-section')

<section class="page-header">
    <div class="container">

        <div class="text-center space-y-3 lg:w-6/12 sm:w-full mx-auto">
            <h1 class="lg:text-5xl sm:text-4xl lg:leading-snug sm:leading-snug font-semibold text-black">Outdoor Advertisement</h1>
            <hr class="w-[300px] mx-auto">
            <p class="text-sm text-gray-600">Our comprehensive services encompass hoardings and various outdoor media advertising formats strategically positioned across urban landscapes. This ensures impactful campaigns in high-traffic areas, effectively showcasing the power of Out-of-Home (OOH) Advertising.</p>
        </div>

    </div>
</section>

<section>
    <div class="container py-20 space-y-24">

        <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 lg:gap-20 sm:gap-10 items-center">

            <figure class="space-y-4" data-aos="fade-righ">
                <h1 class="text-4xl leading-snug text-black">
                    <span class="font-bold">Glow sign boards are illuminated outdoor signs, ensuring visibility during day and night.</span>
                </h1>
                <p class="text-lg leading-loose text-gray-500">Versatile in size and design, allowing customization to match brand aesthetics and messaging. The illuminated nature makes glowsign boards impactful for catching the attention of passersby.
                </p>
                <p class="text-lg leading-loose text-gray-500">
                    Effective for promoting products, services, or brand messages. Contributes to brand recognition by providing a consistent and illuminated representation of the company's identity.
                </p>
            </figure>

            <figure data-aos="flip-right">
                <div class="overflow-clip rounded-lg shadow-lg">
                    <img src="{{ asset('web/images/service-img-3.png') }}" alt="Outdoor Billboard & Media Advertising" class="h-auto w-full">
                </div>
            </figure>

        </div>
        
        
    </div>
</section>
@endsection

@section('web-script')
    <script>
        $(document).ready(function () {
            $('#desktop-header').addClass('active');
        });
    </script>
@endsection