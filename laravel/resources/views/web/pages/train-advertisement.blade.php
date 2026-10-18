@extends('web.layouts.app')

@section('web-section')

<section class="page-header">
    <div class="container">

        <div class="text-center space-y-3 lg:w-6/12 sm:w-full mx-auto">
            <h1 class="lg:text-5xl sm:text-4xl lg:leading-snug sm:leading-snug font-semibold text-black">Train Advertisement</h1>
            <hr class="w-[300px] mx-auto">
            <p class="text-sm text-gray-600">Exclusive Branding rights for all 74 Western local Train in Mumbai City 
                Mumbai Local Train Exterior Panel Advertising:
                Mumbai local trains, a lifeline for millions, offer advertising space on exterior panels for 74 trains. Vital transportation mode ensures extensive reach and visibility to a diverse audience.</p>
        </div>

    </div>
</section>

<section>
    <div class="container py-20 space-y-24">

        <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 lg:gap-20 sm:gap-10 items-center">

            <figure class="space-y-4" data-aos="fade-righ">
                <h1 class="text-4xl leading-snug text-black">
                    <span class="font-bold">Vital transportation mode ensures extensive reach and visibility to a diverse audience.</span>
                </h1>
                <p class="text-lg leading-loose text-gray-500">High-frequency exposure during daily commutes creates awareness and boosts brand recall.
                    Constant train movement maximizes visibility, capturing attention and leaving a lasting impression.
                    
                </p>
                <p class="text-lg leading-loose text-gray-500">
                    An opportunity for businesses to connect with a massive audience, driving potential consumer interest.

                </p>
            </figure>

            <figure data-aos="flip-right">
                <div class="overflow-clip rounded-lg shadow-lg">
                    <img src="{{ asset('web/images/train-advertisement.jpg') }}" alt="Train & Railway Advertising Campaign" class="h-auto w-full">
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