@extends('web.layouts.app')

@section('web-section')

<section class="page-header">
    <div class="container">

        <div class="text-center space-y-3 lg:w-6/12 sm:w-full mx-auto">
            <h1 class="lg:text-5xl sm:text-4xl lg:leading-snug sm:leading-snug font-semibold text-black">Bus Advertisement</h1>
            <hr class="w-[300px] mx-auto">
            <p class="text-sm text-gray-600">Sole rights for display Advertisement on TMT- Thane City Buses Exclusive rights for advertising, totaling around 400 buses for 5 years. Extensive service covering Thane, Mumbai, and neighboring areas for broad reach.TMT, the primary bus service in Thane, ensures strategic and widespread visibility.</p>
        </div>

    </div>
</section>

<section>
    <div class="container py-20 space-y-24">

        <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 lg:gap-20 sm:gap-10 items-center">

            <figure class="space-y-4" data-aos="fade-righ">
                <h1 class="text-4xl leading-snug text-black">
                    <span class="font-bold">Exclusive Branding rights for Surat City EV Buses : </span>
                </h1>
                <p class="text-lg leading-loose text-gray-500">Electric buses in Surat ensure attention from both commuters and passersby for broad exposure.
                    Operating in high footfall areas guarantees maximum visibility, making them an ideal advertising platform. Advertisements on bus exteriors feature vibrant displays capturing attention on the move.
                </p>
                <p class="text-lg leading-loose text-gray-500">
                    Constant Movement Advantage: Buses traverse various routes and areas, reaching diverse audiences across the city.
                </p>
            </figure>

            <figure data-aos="flip-right">
                <div class="overflow-clip rounded-lg shadow-lg">
                    <img src="{{ asset('web/images/bus.webp') }}" alt="Bus & Transit Media Advertising Campaign" class="h-auto w-full">
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