{{-- "Campaigns we have run": existing campaigns (Admin > Our Work) that this
     keyword page proves, each linking to its case-study page. Renders nothing
     when none of the configured campaigns exist in the database yet.
     $route: this page's route name (see config/campaigns.php). --}}
@php $pageCampaigns = \App\Models\Campaign::forKeywordPage($route); @endphp
@if ($pageCampaigns->isNotEmpty())
<section class="kw-section"><div class="kw-inner">
    <h2 class="kw-h2">Campaigns we have <em>run</em></h2>
    <div class="kw-campaigns">
        @foreach ($pageCampaigns as $item)
            <a class="kw-campaign" href="{{ $item->url() }}">
                @if ($item->image)<img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->imageAlt() }}" decoding="async" loading="lazy"/>@endif
                <div><strong>{{ $item->name }}</strong><span>{{ $item->mediaLabel() }} · {{ $item->city }}</span><em>View case study →</em></div>
            </a>
        @endforeach
    </div>
</div></section>
@endif
