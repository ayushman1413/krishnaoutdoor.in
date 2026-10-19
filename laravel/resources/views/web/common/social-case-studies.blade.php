{{-- Social media case studies for a city (Admin > Our Work, media type "Social
     Media"). Renders nothing until real case studies exist; results are never
     filled in for the client. $city: 'Ahmedabad' or 'Mumbai'. --}}
@php $socialCases = \App\Models\Campaign::where('status', true)->where('media_type', 'social')->whereRaw('LOWER(city) = ?', [strtolower($city)])->latest()->get(); @endphp
@if ($socialCases->isNotEmpty())
<section class="kw-section"><div class="kw-inner">
    <h2 class="kw-h2">Social media <em>case studies</em></h2>
    <div class="kw-campaigns">
<!--cms:skip-->
        @foreach ($socialCases as $item)
            <a class="kw-campaign" href="{{ $item->url() }}">
                @if ($item->image)<img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->imageAlt() }}" decoding="async" loading="lazy"/>@endif
                <div><strong>{{ $item->name }}</strong><span>{{ $item->mediaLabel() }} · {{ $item->city }}</span><em>View case study →</em></div>
            </a>
        @endforeach
<!--/cms:skip-->
    </div>
</div></section>
@endif
