@extends('web.layouts.app')

@section('web-section')
<section class="page-header dark" style="background-image: linear-gradient(rgba(0,0,0,0.4),rgba(0,0,0,0.4)),url('{{ $category->cover_image ? asset('storage/'.$category->cover_image) : asset('assets/images/shared-night-city-background.png') }}')">
    <div class="container">

        <div class="page-title">
            <h1>{{$category->name}}</h1>
            <!--cms:skip--><p>{{$category->summary}}</p><!--/cms:skip-->
            <hr>
            <ul class="breadcrumb">
                <li><a href="{{route('view.home')}}">Home</a></li>
                <li><i data-feather="chevron-right"></i></li>
                <li><a href="{{route('view.home')}}" class="active">{{$category->name}}</a></li>
            </ul>
        </div>

    </div>
</section>
<section>
    <div class="container py-20 space-y-24">

        <div class="grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-5 popup-gallery">
<!--cms:skip-->
        @foreach ($category_media as $media)
            <figure class="p-3 border-b-4 border-b-web-ascent border shadow-lg" data-aos="zoom-in">
                <div class="h-[300px] overflow-clip flex items-center justify-center">
                    @switch($media->type)
                        @case('image/jpeg')
                        @case('image/png')
                        @case('image/webp')
                        @case('image/jpg')
                        <a href="{{asset('storage/'.$media->path)}}" class="preview-gallery-image">
                        <img src="{{ asset('storage/' . $media->path) }}" alt="{{ $media->alt_text ?: $category->name . ' advertising site – Krishna Outdoor' }}"
                            title="{{ $media->title_text ?: $category->name }}" loading="lazy" class="w-full h-auto">
                        </a>
                        @break
                    
                        @case('video/mp4')
                        <video src="{{ asset('storage/' . $media->path) }}" controls class="h-full w-auto"></video>
                        @break
                    
                        @default
                        <a target="_blank" href="{{ asset('storage/' . $media->path) }}" class="btn-secondary-md">Preview Media</a>
                    @endswitch
                </div>
                <div class="pt-3 text-center">
                    <h1>{{ucwords($media->name)}}</h1>
                </div>
            </figure>
        @endforeach
<!--/cms:skip-->
        </div>
        
    </div>
</section>
@endsection

@section('web-script')
    <script>
        $(document).ready(function () {
            $('#desktop-header').addClass('active');

            // $('.preview-gallery-image').magnificPopup({
            //     type: 'image'
            // });

            $('.popup-gallery').magnificPopup({
                delegate: 'a',
                type: 'image',
		        closeOnContentClick: false,
		        closeBtnInside: false,
                tLoading: 'Loading image #%curr%...',
                mainClass: 'preview-gallery-image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1] // Will preload 0 - before current, and 1 after the current image
                },
                zoom: {
                    enabled: true,
                    duration: 300, // don't foget to change the duration also in CSS
                    opener: function(element) {
                        return element.find('img');
                    }
                }
            });
        });
    </script>
@endsection