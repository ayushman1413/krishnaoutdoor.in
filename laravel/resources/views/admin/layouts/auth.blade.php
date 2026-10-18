<!DOCTYPE html>
<html lang="en">

<head>

    {{-- Meta Tags --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('favicon.png') }}">

    {{-- Stylesheets --}}
    <link rel="stylesheet" href="{{ asset('admin/css/app.css') }}">

    {{-- Title --}}
    <title>Admin Panel </title>

</head>

<body>

    {{-- Main (Start) --}}
    <main class="relative h-screen w-full flex items-center justify-center">

        <div style="background-image: url('{{ asset('web/images/front-carousel/img-3.jpeg') }}')"
            class="bg-cover bg-center bg-no-repeat absolute inset-0 h-full w-full"></div>
        <div class="absolute inset-0 h-full w-full bg-ascent-dark bg-opacity-40"></div>

        <div class="relative z-10 w-full flex flex-col items-center lg:py-16 sm:py-10 px-4 space-y-8">

            <div class="text-center space-y-1">
                <div class="w-fit h-fit mx-auto p-3 bg-white rounded-lg shadow-lg">
                    <img src="{{ asset('web/images/logo-header.png') }}" alt="Krishna Outdoor" class="w-[150px] h-auto">
                </div>
            </div>

            <div class="w-full lg:max-w-[420px] md:max-w-[420px] sm:max-w-full">
                @yield('auth-section')
            </div>

            <p class="text-xs text-slate-300 text-center">&copy; {{ date('Y') }} Krishna Communication (Outdoor). All rights reserved.</p>

        </div>

    </main>
    {{-- Main (End) --}}

    {{-- Script --}}
    <script src="{{ asset('admin/js/app.js') }}"></script>

    @if (session('message'))
        <script defer>
            swal({
                icon: "{{ session('message')['status'] }}",
                title: "{{ session('message')['title'] }}",
                text: "{{ session('message')['description'] }}",
            });
        </script>
    @endif

</body>

</html>
