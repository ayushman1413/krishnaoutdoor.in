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
    <link rel="stylesheet" href="{{asset('admin/css/app.css?v=11')}}">

    {{-- Title --}}
    <title>Admin Panel </title>

    @yield('panel-head')

</head>

<body>

    @if (auth()->user()->status)

        {{-- Main (Start) --}}
        <main>

            {{-- Sidebar --}}
            @include('admin.common.sidebar')

            {{-- Panel (Start) --}}
            <section id="panel-section">
                <div class="panel-container">
                    <header class="panel-header">
                        <div class="lg:px-0 md:px-0 sm:px-2">
                            @yield('panel-header')
                        </div>
                        <div>
                            @include('admin.common.header-menu')
                        </div>
                    </header>
                    <section class="panel-body">
                        @yield('panel-body')
                    </section>
                </div>
            </section>
            {{-- Panel (End) --}}

        </main>
        {{-- Main (End) --}}

        {{-- Logout Form --}}
        <form action="{{route('admin.handle.logout')}}" id="logout-form" method="POST">@csrf</form>

        {{-- Script --}}
        <script src="{{asset('admin/js/app.js?v=9')}}"></script>
        <script>
            // Label every table cell with its column heading; the stacked card layout on small screens shows it (see admin app.css).
            document.querySelectorAll('.panel-card-table table').forEach(function (table) {
                var heads = Array.prototype.map.call(table.querySelectorAll('thead th'), function (th) { return th.textContent.trim(); });
                table.querySelectorAll('tbody tr').forEach(function (row) {
                    Array.prototype.forEach.call(row.children, function (cell, i) { if (heads[i]) cell.setAttribute('data-label', heads[i]); });
                });
            });
        </script>

        <script>
            function toggleSeoMenu() {
                var menu = document.getElementById('seo-submenu');
                var chevron = document.getElementById('seo-chevron');
                if (menu.classList.contains('hidden')) {
                    menu.classList.remove('hidden');
                    menu.classList.add('flex');
                    chevron.style.transform = 'rotate(180deg)';
                } else {
                    menu.classList.add('hidden');
                    menu.classList.remove('flex');
                    chevron.style.transform = 'rotate(0deg)';
                }
            }
            // Auto-open SEO menu if on an SEO page
            (function() {
                var seoRoutes = ['/seo', '/seo-settings', '/redirect', '/404-log', '/seo-todos'];
                var path = window.location.pathname;
                if (seoRoutes.some(function(r){ return path.indexOf(r) !== -1; })) {
                    var menu = document.getElementById('seo-submenu');
                    var chevron = document.getElementById('seo-chevron');
                    if (menu) { menu.classList.remove('hidden'); menu.classList.add('flex'); }
                    if (chevron) { chevron.style.transform = 'rotate(180deg)'; }
                }
            })();
        </script>

        @yield('panel-script')
        
        @if (session('message'))
        <script defer>
            swal({
                icon: "{{session('message')['status']}}",
                title: "{{session('message')['title']}}",
                text: "{{session('message')['description']}}",
            });
        </script>
        @endif
    
    @else
    <main class="h-screen w-full flex items-center justify-center">
        <h1 class="text-2xl font-semibold text-admin-ascent">Your Access is Blocked</h1>
    </main>
    @endif

</body>

</html>