@extends('web.layouts.app')

@section('body-class', 'inner-page')
@section('nav', 'projects')

@section('web-head')
<style>
/* OUR WORK — reference-led page, built from original Krishna assets */
.ow-page{background:#f6f7f8;color:#101216;overflow:hidden}
.ow-hero{position:relative;min-height:520px;background:#0b0e12;color:#fff;display:grid;align-items:end;isolation:isolate}
.ow-hero-media{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:-3;filter:saturate(.9) contrast(1.06)}
.ow-hero-shade{position:absolute;inset:0;z-index:-2;background:linear-gradient(90deg,rgba(6,9,12,.98) 0%,rgba(6,9,12,.9) 31%,rgba(6,9,12,.25) 62%,rgba(6,9,12,.18) 100%),linear-gradient(0deg,rgba(0,0,0,.58),transparent 48%)}
.ow-hero-grid{position:absolute;inset:0;z-index:-1;opacity:.15;background-image:linear-gradient(rgba(255,255,255,.09) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.09) 1px,transparent 1px);background-size:70px 70px;mask-image:linear-gradient(90deg,#000,transparent 78%)}
.ow-hero-inner{width:min(1440px,92%);margin:0 auto;padding:92px 0 54px;display:grid;grid-template-columns:minmax(0,1fr) 280px;gap:50px;align-items:end}
.ow-kicker,.ow-tag{font:700 13px/1 Inter,sans-serif;letter-spacing:.12em;color:#ed2028;text-transform:uppercase;display:flex;align-items:center;gap:13px}.ow-kicker:after,.ow-tag:after{content:"";width:44px;height:2px;background:#ed2028;display:block}
.ow-hero h1{font:700 clamp(56px,7.4vw,104px)/.92 Oswald,sans-serif;letter-spacing:-.035em;text-transform:uppercase;margin:15px 0 20px;max-width:780px}.ow-hero h1 em,.ow-title em{font-style:normal;color:#ed2028}.ow-hero-copy{max-width:560px;font-size:16px;line-height:1.62;color:rgba(255,255,255,.82);margin:0 0 26px}.ow-btn{display:inline-flex;align-items:center;gap:22px;border:1px solid #ed2028;background:#ed2028;color:#fff;padding:14px 19px;font:700 13px Inter,sans-serif;text-decoration:none;transition:.35s ease;box-shadow:0 12px 30px rgba(237,32,40,.22)}.ow-btn span{font-size:20px;transition:.35s}.ow-btn:hover{transform:translateY(-4px);box-shadow:0 18px 36px rgba(237,32,40,.34)}.ow-btn:hover span{transform:translateX(5px)}
.ow-hero-side{align-self:center;justify-self:end;text-align:left;border-left:1px solid rgba(255,255,255,.25);padding-left:25px;display:grid;gap:12px}.ow-hero-side span{font:600 13px/1.15 Oswald,sans-serif;letter-spacing:.12em;color:#fff;text-transform:uppercase;opacity:.7}.ow-hero-side strong{font:700 15px/1.25 Oswald,sans-serif;color:#fff;text-transform:uppercase}.ow-hero-side strong b{color:#ed2028}
.ow-filter{position:relative;background:#fff;border-bottom:1px solid #e2e5e8;box-shadow:0 5px 24px rgba(16,18,22,.05);z-index:4}.ow-filter-inner{width:min(1440px,94%);margin:auto;display:flex;align-items:stretch;overflow:auto;scrollbar-width:none}.ow-filter-inner::-webkit-scrollbar{display:none}.ow-filter button{flex:0 0 auto;border:0;border-right:1px solid #e5e7ea;background:#fff;min-height:74px;padding:0 25px;display:flex;align-items:center;gap:10px;color:#20242a;font:600 12px Inter,sans-serif;cursor:pointer;transition:.3s}.ow-filter button:first-child{border-left:1px solid #e5e7ea}.ow-filter button .ico{width:31px;height:31px;border:1px solid #cfd4da;border-radius:9px;display:grid;place-items:center;font-size:14px}.ow-filter button:hover,.ow-filter button.active{background:#ed2028;color:#fff;border-color:#ed2028}.ow-filter button:hover .ico,.ow-filter button.active .ico{border-color:rgba(255,255,255,.5)}.ow-search{margin-left:auto;flex:0 0 210px;display:flex;align-items:center;padding:0 10px}.ow-search input{width:100%;height:40px;border:1px solid #d9dde2;border-radius:2px;padding:0 12px;font:500 12px Inter,sans-serif;outline:none}.ow-search input:focus{border-color:#ed2028;box-shadow:0 0 0 3px rgba(237,32,40,.1)}
.ow-work{padding:58px 0 74px}.ow-work-inner{width:min(1380px,92%);margin:auto}.ow-section-head{display:flex;justify-content:space-between;align-items:end;gap:25px;margin-bottom:28px}.ow-title{font:700 clamp(38px,5vw,64px)/.94 Oswald,sans-serif;text-transform:uppercase;margin:7px 0 0;letter-spacing:-.02em}.ow-section-head p{max-width:440px;margin:0;color:#68717b;font-size:14px;line-height:1.65}
.ow-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}.ow-card{background:#fff;border:1px solid #e2e5e9;box-shadow:0 10px 25px rgba(20,24,30,.05);transition:.45s cubic-bezier(.2,.8,.2,1);overflow:hidden;position:relative}.ow-card:hover{transform:translateY(-8px);box-shadow:0 22px 45px rgba(20,24,30,.13);border-color:#d4d9de}.ow-card-media{height:250px;overflow:hidden;position:relative;background:#ddd}.ow-card-media img{width:100%;height:100%;object-fit:cover;transition:transform .8s cubic-bezier(.2,.8,.2,1),filter .45s}.ow-card:hover .ow-card-media img{transform:scale(1.08);filter:saturate(1.08)}.ow-card-media:after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,transparent 55%,rgba(0,0,0,.48));pointer-events:none}.ow-loc{position:absolute;left:14px;bottom:13px;color:#fff;font:700 11px Inter,sans-serif;letter-spacing:.04em;z-index:2}.ow-loc:before{content:"●";font-size:9px;color:#ed2028;margin-right:6px}.ow-card-body{padding:17px 17px 18px}.ow-brand{display:flex;align-items:center;justify-content:space-between;gap:12px;border-bottom:1px solid #e7e9ec;padding-bottom:13px;margin-bottom:12px}.ow-brand-info{display:flex;align-items:center;gap:12px}.ow-brand-info img{width:58px;height:28px;object-fit:contain;object-position:left center}.ow-brand-info b{font:800 16px Inter,sans-serif}.ow-brand-info small{display:block;color:#777f89;font-size:11px;margin-top:3px}.ow-meta{display:flex;gap:15px;color:#505862;font:600 10px Inter,sans-serif;text-transform:uppercase;margin-bottom:12px}.ow-meta span:before{color:#ed2028;margin-right:5px}.ow-meta .media:before{content:"▣"}.ow-meta .place:before{content:"⌖"}.ow-desc{font:400 12px/1.55 Inter,sans-serif;color:#69717b;margin:0;min-height:38px}.ow-arrow{width:38px;height:38px;border:1px solid #ed2028;border-radius:50%;display:grid;place-items:center;color:#ed2028;background:#fff;font-size:19px;transition:.35s}.ow-card:hover .ow-arrow{background:#ed2028;color:#fff;transform:translateX(3px)}
.ow-video{margin-top:22px;background:#0a0d10;color:#fff;position:relative;min-height:320px;overflow:hidden}.ow-video video{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.72}.ow-video:after{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(6,8,10,.9),rgba(6,8,10,.25) 65%,rgba(6,8,10,.55))}.ow-video-content{position:relative;z-index:2;padding:46px;max-width:600px}.ow-video h3{font:700 54px/.95 Oswald,sans-serif;text-transform:uppercase;margin:10px 0 15px}.ow-video p{color:#d5d8dc;line-height:1.6;max-width:470px;font-size:13px}.ow-video-badge{position:absolute;right:35px;bottom:30px;z-index:3;border:1px solid rgba(255,255,255,.35);padding:12px 15px;font:700 11px Inter,sans-serif;letter-spacing:.1em}.ow-video-badge i{display:inline-block;width:7px;height:7px;background:#ed2028;border-radius:50%;margin-right:7px;animation:owPulse 1.2s infinite}
.ow-cta{background:#0a0d11;color:#fff;position:relative;overflow:hidden}.ow-cta-bg{position:absolute;inset:0;background:url('{{ asset('assets/images/shared-night-city-background.webp') }}') center/cover;opacity:.52;transform:scale(1.04);animation:owDrift 12s ease-in-out infinite alternate}.ow-cta:after{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(5,7,10,.94),rgba(5,7,10,.5),rgba(5,7,10,.68))}.ow-cta-inner{position:relative;z-index:2;width:min(1380px,92%);margin:auto;min-height:300px;display:flex;align-items:center;justify-content:space-between;gap:30px}.ow-cta h2{font:700 clamp(40px,5vw,68px)/.94 Oswald,sans-serif;text-transform:uppercase;margin:10px 0}.ow-cta p{color:#d1d4d8;margin:0;max-width:500px;font-size:13px}
.ow-reveal{opacity:0;transform:translateY(30px);transition:opacity .8s ease,transform .8s cubic-bezier(.2,.75,.2,1)}.ow-reveal.in{opacity:1;transform:none}.ow-card.ow-reveal:nth-child(2){transition-delay:.06s}.ow-card.ow-reveal:nth-child(3){transition-delay:.12s}.ow-card.ow-reveal:nth-child(4){transition-delay:.18s}.ow-card.ow-reveal:nth-child(5){transition-delay:.24s}.ow-card.ow-reveal:nth-child(6){transition-delay:.3s}
@keyframes owPulse{50%{box-shadow:0 0 0 6px rgba(237,32,40,.05)}}@keyframes owDrift{to{transform:scale(1.1) translate3d(1.5%,0,0)}}
@media(max-width:980px){.ow-hero{min-height:590px}.ow-hero-inner{grid-template-columns:1fr}.ow-hero-side{display:none}.ow-grid{grid-template-columns:repeat(2,1fr)}.ow-search{display:none}.ow-filter button{min-height:66px;padding:0 18px}.ow-card-media{height:220px}.ow-video h3{font-size:44px}}
@media(max-width:640px){.ow-hero{min-height:590px}.ow-hero-inner{width:90%;padding:100px 0 40px}.ow-hero h1{font-size:52px}.ow-hero-copy{font-size:13px}.ow-work{padding:42px 0 55px}.ow-section-head{display:block}.ow-section-head p{margin-top:15px}.ow-grid{grid-template-columns:1fr;gap:15px}.ow-card-media{height:230px}.ow-video-content{padding:35px 24px}.ow-video h3{font-size:38px}.ow-video-badge{right:20px;bottom:20px}.ow-cta-inner{min-height:330px;display:block;padding:55px 0}.ow-cta .ow-btn{margin-top:25px}.ow-filter-inner{width:100%}.ow-filter button{padding:0 15px}.ow-filter button .ico{width:27px;height:27px}.ow-title{font-size:43px}}
@media(prefers-reduced-motion:reduce){.ow-reveal,.ow-card,.ow-card-media img,.ow-btn,.ow-btn span,.ow-arrow,.ow-cta-bg{transition:none!important;animation:none!important}}
</style>
<style id="final-button-banner-cleanup">
.btn,.small-btn,.outline-btn,.kr-btn,.ow-btn,.media-btn,.network-btn,.network-card-link,.kr-office-btn,.about-btn,.footer-campaign,.service-next,.tab,.nav-cta,.experience-link{border-radius:6px!important;clip-path:none!important}
.btn::before,.btn::after,.small-btn::before,.small-btn::after,.outline-btn::before,.outline-btn::after,.kr-btn::before,.kr-btn::after,.ow-btn::before,.ow-btn::after,.media-btn::before,.media-btn::after,.network-btn::before,.network-btn::after,.network-card-link::before,.network-card-link::after,.kr-office-btn::before,.kr-office-btn::after,.about-btn::before,.about-btn::after,.footer-campaign::before,.footer-campaign::after,.nav-cta::before,.nav-cta::after{border-radius:inherit!important;clip-path:none!important}
.btn:hover,.small-btn:hover,.outline-btn:hover,.kr-btn:hover,.ow-btn:hover,.media-btn:hover,.network-btn:hover,.network-card-link:hover,.kr-office-btn:hover,.about-btn:hover,.footer-campaign:hover,.service-next:hover,.tab:hover,.nav-cta:hover,.experience-link:hover{border-radius:6px!important;clip-path:none!important}
.work-scroll-arrow,.client-arrow,.story-dialog>button{border-radius:50%!important;clip-path:none!important}
.about-cta>img,.ow-cta-bg{display:none!important;visibility:hidden!important}
.about-cta,.ow-cta{background:#0c1015!important;background-image:none!important}
</style>
@endsection

@section('web-section')

<main class="ow-page">
<section class="ow-hero">
<img alt="Jewellery brand hoarding above a busy traffic junction – Krishna Outdoor" class="ow-hero-media" decoding="async" loading="eager" src="{{ asset('assets/images/work/ooh-hoarding-campaign-01.webp') }}"/><div class="ow-hero-shade"></div><div class="ow-hero-grid"></div>
<div class="ow-hero-inner ow-reveal"><div><div class="ow-kicker">OUR WORK / CAMPAIGNS</div><h1 class="seo-h1">{{ $seo->h1Override() ?: 'Outdoor Advertising Campaigns by Krishna Outdoor' }}</h1><p class="seo-h1-slogan">VISIBILITY IN <em>ACTION.</em></p><p class="ow-hero-copy">Every campaign begins with a different objective. Some brands want scale. Some want local market visibility. Some want repeated commuter exposure. Others want an integrated campaign across multiple media.</p><p class="ow-hero-copy">Explore selected campaigns and see how brands have used outdoor, transit and integrated media to connect with audiences in the places that matter.</p><a class="ow-btn" href="#campaigns">EXPLORE OUR CAMPAIGNS <span>→</span></a></div>
</section>
<section class="ow-filter" id="campaigns"><div class="ow-filter-inner">
<button class="active" data-filter="all"><span class="ico">⌘</span>All Campaigns</button><button data-filter="outdoor"><span class="ico">▣</span>Outdoor Media</button><button data-filter="transit"><span class="ico">▤</span>Transit Media</button><button data-filter="integrated"><span class="ico">◫</span>Integrated Media</button><button data-filter="gujarat"><span class="ico">⌖</span>Gujarat</button><button data-filter="ahmedabad"><span class="ico">⌖</span>Ahmedabad</button><button data-filter="mumbai"><span class="ico">⌖</span>Mumbai</button><button data-filter="other"><span class="ico">⌖</span>Other Markets</button><div class="ow-search"><input aria-label="Search campaigns" id="owSearch" placeholder="Search campaigns..." type="search"/></div>
</div></section>
<section class="ow-work"><div class="ow-work-inner"><div class="ow-section-head ow-reveal"><div><div class="ow-tag">SELECTED CAMPAIGNS</div><h2 class="ow-title">VISIBILITY IN ACTION.</h2></div><p>Explore selected campaigns and see how brands have used outdoor, transit and integrated media to connect with audiences in the places that matter.</p></div>
<div class="ow-grid" id="owGrid">
@php
    $campaigns = \App\Models\Campaign::where('status', true)->orderBy('created_at', 'desc')->get();
    $mediaLabels = ['outdoor' => 'Outdoor Media', 'transit' => 'Transit Media', 'integrated' => 'Integrated Media'];
@endphp
@forelse ($campaigns as $campaign)
@php
    $cityKey = strtolower(trim($campaign->city));
    $market = in_array($cityKey, ['ahmedabad', 'mumbai']) ? $cityKey : 'other';
    $mediaLabel = $mediaLabels[$campaign->media_type] ?? ucfirst($campaign->media_type);
    $campaignAlt = $campaign->image_alt ?: "{$mediaLabel} campaign in {$campaign->city}";
@endphp
<article class="ow-card ow-reveal" data-market="{{ $market }}" data-type="{{ $campaign->media_type }}" data-search="{{ strtolower($campaign->name.' '.$campaign->tagline.' '.$campaign->media_type.' '.$campaign->city) }}"><div class="ow-card-media">@if ($campaign->image)<img alt="{{ $campaignAlt }}" decoding="async" loading="lazy" src="{{ asset('storage/'.$campaign->image) }}" onerror="this.src='{{ asset('assets/images/work/ooh-hoarding-campaign-01.webp') }}'"/>@else<img alt="{{ $campaignAlt }}" decoding="async" loading="lazy" src="{{ asset('assets/images/work/ooh-hoarding-campaign-01.webp') }}"/>@endif<span class="ow-loc">{{ strtoupper($campaign->city) }}</span></div><div class="ow-card-body"><div class="ow-brand">
    <div class="ow-brand-info">
        <div>
            <b>{{ $campaign->name }}</b>
            <small>{{ $campaign->tagline }}</small>
        </div>
    </div>
</div><div class="ow-meta"><span class="media">{{ $mediaLabel }}</span><span class="place">{{ $campaign->city }}</span></div><p class="ow-desc">{{ $campaign->description }}</p></div></article>
@empty
<p class="ow-desc" style="grid-column:1/-1;text-align:center;padding:40px 0">Campaigns coming soon.</p>
@endforelse

</div>
@php \App\Services\SchemaBuilder::addVideo('showcase'); @endphp
<div class="ow-video ow-reveal"><video autoplay="" loop="" muted="" playsinline="" preload="metadata"><source src="{{ asset('assets/videos/work-showcase.mp4') }}" type="video/mp4"/></video><div class="ow-video-content"><div class="ow-tag">THE WORK IN MOTION</div><h3>REAL MEDIA.<br/><em>REAL MOMENTUM.</em></h3><p>Our portfolio should showcase how brands have used different media opportunities to create visibility across markets and audiences.</p><a class="ow-btn" href="{{ route('view.contact') }}">Talk To Our Team <span>→</span></a></div><div class="ow-video-badge"><i></i> CAMPAIGN SHOWCASE</div></div>
</div></section>
<section class="ow-cta"><div class="ow-cta-bg"></div><div class="ow-cta-inner ow-reveal"><div><div class="ow-tag">LET’S CREATE WHAT’S NEXT</div><h2>VISIBILITY IN ACTION.</h2><p>Explore selected campaigns and see how brands have used outdoor, transit and integrated media to connect with audiences in the places that matter.</p></div><a class="ow-btn" href="{{ route('view.contact') }}">Talk to Our Media Team <span>→</span></a></div></section>
</main>

@endsection

@section('web-script')
<script>
(()=>{
 const buttons=[...document.querySelectorAll('.ow-filter button[data-filter]')], cards=[...document.querySelectorAll('.ow-card')], search=document.getElementById('owSearch');
 let active='all';
 function apply(){const q=(search?.value||'').trim().toLowerCase();cards.forEach(c=>{const marketOk=active==='gujarat'?c.dataset.market==='ahmedabad':c.dataset.type===active||c.dataset.market===active;const ok=(active==='all'||marketOk)&&(q===''||c.dataset.search.includes(q));c.style.display=ok?'':'none';c.classList.toggle('filtered-out',!ok)});}
 buttons.forEach(b=>b.addEventListener('click',()=>{buttons.forEach(x=>x.classList.remove('active'));b.classList.add('active');active=b.dataset.filter;apply()}));
 search?.addEventListener('input',apply);
 const obs=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('in');obs.unobserve(e.target)}}),{threshold:.12});document.querySelectorAll('.ow-reveal').forEach(x=>obs.observe(x));
 document.querySelectorAll('.ow-card-media img').forEach(img=>img.addEventListener('click',()=>{img.closest('.ow-card')?.scrollIntoView({behavior:'smooth',block:'center'})}));
})();
</script>
@endsection