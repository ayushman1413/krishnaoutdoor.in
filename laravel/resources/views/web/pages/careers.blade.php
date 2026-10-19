@extends('web.layouts.app')

@section('css-bundle', 'careers')

@section('web-head')
@endsection

@section('web-section')

<style>
/* Careers page CSS kept locally in this Blade.
   Source: existing style.css + home-style-sync.css career rules. */
.kr-page{overflow:hidden;background:#f7f8fa;color:#101319}

.kr-hero{position:relative;min-height:78vh;display:flex;align-items:flex-end;overflow:hidden;background:#0b0d10;color:#fff}

.kr-hero .hero-media{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}

.kr-hero:after{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(5,8,11,.94) 0%,rgba(5,8,11,.72) 38%,rgba(5,8,11,.1) 78%),linear-gradient(0deg,rgba(0,0,0,.72),transparent 48%);z-index:1}

.kr-hero .hero-grid{position:absolute;inset:0;z-index:2;opacity:.16;background-image:linear-gradient(rgba(255,255,255,.15) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.15) 1px,transparent 1px);background-size:80px 80px;mask-image:linear-gradient(to right,black,transparent 80%)}

.kr-hero-inner{position:relative;z-index:3;padding:110px 0 70px;max-width:820px}

.kr-kicker{font:700 13px/1.2 Inter,sans-serif;letter-spacing:.16em;color:#ef2027;text-transform:uppercase;margin-bottom:16px;display:flex;align-items:center;gap:12px}

.kr-kicker:after{content:"";width:58px;height:2px;background:#ef2027}

.kr-hero h1{font-family:Oswald,sans-serif;font-size:clamp(59px,7vw,113px);line-height:.91;letter-spacing:-.03em;text-transform:uppercase;margin:0;max-width:760px}

.kr-hero h1 em{color:#ef2027;font-style:normal}

.kr-hero p{max-width:620px;font-size:20px;line-height:1.7;color:rgba(255,255,255,.82);margin:24px 0 30px}

.kr-actions{display:flex;gap:12px;flex-wrap:wrap}

.kr-btn{display:inline-flex;align-items:center;gap:12px;padding:15px 20px;background:#ef2027;color:#fff;border-radius:2px;font-weight:800;text-decoration:none;box-shadow:0 12px 28px rgba(239,32,39,.22);transition:.35s}

.kr-btn:hover{transform:translateY(-4px);box-shadow:0 18px 38px rgba(239,32,39,.32)}

.kr-btn.alt{background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.28);box-shadow:none}

.kr-btn.alt:hover{background:#fff;color:#111}

.kr-ticker{background:#fff;border-bottom:1px solid #e6e8eb;display:grid;grid-template-columns:repeat(4,1fr);box-shadow:0 12px 35px rgba(0,0,0,.06);position:relative;z-index:4}

.kr-ticker .item{padding:22px 28px;border-right:1px solid #e4e5e8}

.kr-ticker .item:last-child{border:0}

.kr-ticker b{font:700 29px Oswald,sans-serif;display:block}

.kr-ticker span{font-size:14px;font-weight:700;letter-spacing:.08em;color:#6d737b;text-transform:uppercase}

.kr-section{padding:100px 0;position:relative}

.kr-section.dark{background:#0c0f13;color:#fff}

.kr-head{display:flex;justify-content:space-between;align-items:end;gap:30px;margin-bottom:45px}

.kr-head h2{font:700 clamp(40px,5vw,70px)/.95 Oswald,sans-serif;text-transform:uppercase;margin:0;letter-spacing:-.02em}

.kr-head h2 em{color:#ef2027;font-style:normal}

.kr-head p{max-width:460px;color:#6b727b;line-height:1.7}

.dark .kr-head p{color:#aeb5bd}

.kr-career-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:56px;align-items:center}

.kr-image-stack{position:relative;min-height:530px}

.kr-image-stack .pic{position:absolute;border-radius:4px;overflow:hidden;box-shadow:0 30px 70px rgba(0,0,0,.16);transform:translateZ(0);transition:transform .7s cubic-bezier(.2,.8,.2,1)}

.kr-image-stack .pic img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .9s}

.kr-image-stack .pic:hover img{transform:scale(1.07)}

.kr-image-stack .p1{width:67%;height:390px;left:0;top:0}

.kr-image-stack .p2{width:48%;height:250px;right:0;bottom:0}

.kr-image-stack .p3{width:38%;height:180px;left:32%;bottom:42px;border:7px solid #fff}

.kr-badge{position:absolute;right:22%;top:34px;width:116px;height:116px;border-radius:50%;background:#ef2027;color:#fff;display:grid;place-items:center;text-align:center;font:700 25px/1 Oswald,sans-serif;box-shadow:0 15px 35px rgba(239,32,39,.35);animation:krFloat 4s ease-in-out infinite}

.kr-badge span{display:block;font:700 8px/1.3 Inter,sans-serif;letter-spacing:.1em;margin-top:5px}

.kr-copy h3,.kr-copy .kr-copy-title{font:700 clamp(38px,4vw,60px)/.98 Oswald,sans-serif;text-transform:uppercase;margin:0 0 22px}

.kr-copy h3 em,.kr-copy .kr-copy-title em{color:#ef2027;font-style:normal}

.kr-copy p{line-height:1.8;color:#646b74;margin:0 0 25px}

.kr-points{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin:25px 0}

.kr-point{padding:18px;background:#fff;border:1px solid #e6e7ea;position:relative;overflow:hidden;transition:.35s}

.kr-point:before{content:"";position:absolute;left:0;top:0;width:3px;height:100%;background:#ef2027;transform:scaleY(0);transform-origin:bottom;transition:.35s}

.kr-point:hover{transform:translateY(-5px);box-shadow:0 15px 35px rgba(0,0,0,.08)}

.kr-point:hover:before{transform:scaleY(1)}

.kr-point b{display:block;font-size:17px;margin-bottom:6px}

.kr-point span{font-size:14px;color:#5f666e}

.kr-roles{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}

.kr-role{background:#12161b;border:1px solid #2a3037;padding:27px;position:relative;overflow:hidden;min-height:190px;transition:.45s}

.kr-role:after{content:"↗";position:absolute;right:20px;top:18px;color:#ef2027;font-size:25px}

.kr-role:before{content:"";position:absolute;width:130px;height:130px;border-radius:50%;right:-50px;bottom:-70px;background:rgba(239,32,39,.18);filter:blur(2px);transition:.5s}

.kr-role:hover{transform:translateY(-8px);border-color:#ef2027;box-shadow:0 25px 50px rgba(0,0,0,.28)}

.kr-role:hover:before{transform:scale(1.5)}

.kr-role small{color:#ef2027;font-weight:800;letter-spacing:.12em}

.kr-role h3{font:600 29px Oswald,sans-serif;text-transform:uppercase;margin:28px 0 10px}

.kr-role p{font-size:15px;color:#aab1b9;line-height:1.6;margin:0}

.kr-steps{display:grid;grid-template-columns:repeat(4,1fr);gap:0;border:1px solid #262b31}

.kr-step{padding:28px;border-right:1px solid #262b31;position:relative;overflow:hidden}

.kr-step:last-child{border:0}

.kr-step .num{font:700 44px Oswald;color:#ef2027}

.kr-step h3{font:700 18px Inter;margin:20px 0 8px}

.kr-step p{font-size:15px;color:#8f969f;line-height:1.6}

.kr-step:after{content:"";position:absolute;left:0;bottom:0;width:100%;height:3px;background:#ef2027;transform:scaleX(0);transform-origin:left;transition:.5s}

.kr-step:hover:after{transform:scaleX(1)}

.kr-application{background:#fff;border:1px solid #e2e4e8;box-shadow:0 25px 70px rgba(16,19,25,.09);display:grid;grid-template-columns:.8fr 1.2fr;overflow:hidden}

.kr-app-intro{background:#0d1116;color:#fff;padding:48px}

.kr-app-intro h2{font:700 50px/.95 Oswald;text-transform:uppercase;margin:15px 0}

.kr-app-intro h2 em{color:#ef2027;font-style:normal}

.kr-app-intro p{color:#aeb5bd;line-height:1.7}

.kr-app-intro .mini{margin-top:50px;padding-top:18px;border-top:1px solid #30363d;font-size:14px;color:#8f969f}

.kr-form{padding:42px}

.kr-form-grid{display:grid;grid-template-columns:1fr 1fr;gap:15px}

.kr-field{display:flex;flex-direction:column;gap:7px}

.kr-field.full{grid-column:1/-1}

.kr-field label{font-size:13px;font-weight:800;letter-spacing:.08em;text-transform:uppercase}

.kr-field input,
.kr-field select,
.kr-field textarea{border:1px solid #dfe2e6;padding:13px 14px;font:500 13px Inter;background:#fafbfc;outline:0;transition:.25s}

.kr-field textarea{min-height:105px;resize:vertical}

.kr-field input:focus,
.kr-field select:focus,
.kr-field textarea:focus{border-color:#ef2027;box-shadow:0 0 0 3px rgba(239,32,39,.08);background:#fff}

.kr-submit{margin-top:16px;width:100%;border:0;cursor:pointer;justify-content:center}

.kr-note{font-size:13px;color:#818891;margin-top:10px}

.kr-enquiry-hero{position:relative;overflow:hidden;background:#0c0f13;color:#fff}

.kr-enquiry-hero .inner{display:grid;grid-template-columns:.88fr 1.12fr;min-height:62vh}

.kr-enquiry-copy{padding:95px 0 70px;position:relative;z-index:2}

.kr-enquiry-copy h1{font:700 clamp(50px,6vw,92px)/.9 Oswald;text-transform:uppercase;margin:15px 0 22px}

.kr-enquiry-copy h1 em{color:#ef2027;font-style:normal}

.kr-enquiry-copy p{max-width:520px;color:#c5cbd1;line-height:1.7}

.kr-enquiry-visual{position:relative;min-height:62vh;overflow:hidden}

.kr-enquiry-visual img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transform:scale(1.03);animation:krKenburns 16s ease-in-out infinite alternate}

.kr-enquiry-visual:before{content:"";position:absolute;inset:0;z-index:1;background:linear-gradient(90deg,#0c0f13 0%,rgba(12,15,19,.2) 30%,transparent 65%)}

.kr-enquiry-visual:after{content:"REAL LOCATIONS.\A REAL AUDIENCES.\A REAL IMPACT.";white-space:pre;position:absolute;right:50px;bottom:50px;z-index:2;font:600 18px/1.25 Oswald;letter-spacing:.08em}

.kr-enquiry-steps{display:grid;grid-template-columns:repeat(3,1fr);gap:0;margin-top:40px;border-top:1px solid #3a4048}

.kr-enquiry-step{padding:20px 22px;border-right:1px solid #3a4048}

.kr-enquiry-step:last-child{border:0}

.kr-enquiry-step b{display:block;color:#ef2027;font-size:27px;margin-bottom:8px}

.kr-enquiry-step span{font-size:14px;color:#b8bec6}

.kr-form-area{padding:80px 0;background:#f4f6f8}

.kr-form-layout{display:grid;grid-template-columns:.72fr 1.28fr;gap:28px;align-items:stretch}

.kr-side-message{background:#0d1116;color:#fff;padding:44px;position:relative;overflow:hidden;min-height:500px}

.kr-side-message:after{content:"";position:absolute;inset:auto -30% -30% auto;width:280px;height:280px;border-radius:50%;background:rgba(239,32,39,.15);filter:blur(10px)}

.kr-side-message h2{font:700 50px/.95 Oswald;text-transform:uppercase;margin:15px 0}

.kr-side-message h2 em{color:#ef2027;font-style:normal}

.kr-side-message p{color:#aeb5bd;line-height:1.7}

.kr-side-message img{position:absolute;left:0;right:0;bottom:0;width:100%;height:220px;object-fit:cover;opacity:.35;mix-blend-mode:screen}

.kr-side-message .side-copy{position:relative;z-index:2}

.kr-contact-form{background:#fff;padding:42px;border:1px solid #e0e3e7;box-shadow:0 25px 70px rgba(0,0,0,.07)}

.kr-contact-form h2{font:700 34px Oswald;text-transform:uppercase;margin:0 0 24px}

.kr-office-head{padding:90px 0 35px}

.kr-offices{display:grid;grid-template-columns:1fr 1fr;gap:18px}

.kr-office{background:#fff;border:1px solid #e1e4e8;display:grid;grid-template-columns:.85fr 1.15fr;overflow:hidden;transition:.4s}

.kr-office:hover{transform:translateY(-7px);box-shadow:0 25px 55px rgba(0,0,0,.1)}

.kr-office img{width:100%;height:100%;min-height:260px;object-fit:cover}

.kr-office-info{padding:26px}

.kr-office-info .tag{margin-bottom:12px}

.kr-office-info h3{font:700 28px Oswald;text-transform:uppercase;margin:0 0 14px}

.kr-office-info p{font-size:15px;line-height:1.7;color:#676e76}

.kr-office-info a{display:block;color:#111;text-decoration:none;margin-top:8px;font-weight:700;font-size:15px}

.kr-office-btn{display:inline-flex!important;border:1px solid #ef2027;padding:10px 14px;color:#ef2027!important;width:max-content;margin-top:18px!important;transition:.3s}

.kr-office-btn:hover{background:#ef2027;color:#fff!important}

.kr-final-cta{padding:80px 0;background:#0c1015;color:#fff;position:relative;overflow:hidden}

.kr-final-cta:before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(12,16,21,.95),rgba(12,16,21,.35)),url("../assets/images/shared-night-city-background.webp") center/cover;opacity:.9}

.kr-final-cta .container{position:relative;z-index:1;display:flex;justify-content:space-between;align-items:center;gap:30px}

.kr-final-cta h2{font:700 clamp(40px,5vw,70px)/.95 Oswald;text-transform:uppercase;margin:10px 0}

.kr-final-cta h2 em{color:#ef2027;font-style:normal}

.kr-reveal{opacity:0;transform:translateY(32px);transition:opacity .8s ease,transform .8s cubic-bezier(.2,.8,.2,1)}

.kr-reveal.is-visible{opacity:1;transform:none}

.kr-reveal.delay-1{transition-delay:.1s}

.kr-reveal.delay-2{transition-delay:.2s}

.kr-reveal.delay-3{transition-delay:.3s}

.kr-hero h1{font-size:clamp(63px,6vw,87px)!important;line-height:.9!important;max-width:650px!important;letter-spacing:-.025em!important}

.kr-hero p{max-width:520px!important;font-size:16px!important;line-height:1.6!important;margin:20px 0 25px!important}

.kr-enquiry-copy h1{font-size:clamp(57px,5.6vw,81px)!important;line-height:.9!important;max-width:610px!important;letter-spacing:-.025em!important;margin:12px 0 18px!important}

.kr-enquiry-copy p{max-width:470px!important;font-size:16px!important;line-height:1.58!important}

.kr-btn{position:relative;overflow:hidden;isolation:isolate;transition:transform .28s cubic-bezier(.2,.8,.2,1),box-shadow .28s ease,background .28s ease,color .28s ease!important}

.kr-btn::before{content:"";position:absolute;z-index:-1;top:-40%;left:-85%;width:48%;height:180%;background:linear-gradient(105deg,transparent 10%,rgba(255,255,255,.06) 38%,rgba(255,255,255,.62) 50%,rgba(255,255,255,.06) 62%,transparent 90%);transform:skewX(-18deg);transition:left .65s cubic-bezier(.2,.7,0,1);pointer-events:none}

.kr-btn:hover::before{left:145%}

.kr-btn:hover{transform:translateY(-3px)!important;box-shadow:0 0 0 1px #ff4148,0 10px 32px #e51b2345,0 0 22px #e51b2328!important}

.kr-btn span{transition:transform .3s ease}

.kr-btn:hover span{transform:translateX(5px)}

.kr-enquiry-hero .inner{min-height:405px!important;grid-template-columns:.9fr 1.1fr!important}

.kr-enquiry-copy{padding:58px 0 38px!important}

.kr-enquiry-copy .kr-kicker{font-size:13px!important;letter-spacing:.08em!important}

.kr-enquiry-copy h1{font-size:clamp(51px,4.8vw,69px)!important;line-height:.92!important;max-width:520px!important;letter-spacing:-.02em!important;margin:10px 0 15px!important}

.kr-enquiry-copy p{max-width:445px!important;font-size:15px!important;line-height:1.52!important;margin:0!important;color:#c9ced4!important}

.kr-enquiry-steps{margin-top:27px!important}

.kr-enquiry-step{padding:14px 16px!important}

.kr-enquiry-step b{font-size:22px!important;margin-bottom:5px!important}

.kr-enquiry-step span{font-size:13px!important}

.kr-enquiry-visual{min-height:405px!important}

.kr-enquiry-visual:after{right:35px!important;bottom:30px!important;font-size:16px!important}

.kr-form-area{padding:58px 0!important;background:#f3f5f7!important}

.kr-form-layout{grid-template-columns:.72fr 1.38fr .72fr!important;gap:16px!important;align-items:stretch!important}

.kr-side-message{min-height:510px!important;padding:34px 30px!important}

.kr-side-message h2{font-size:47px!important;line-height:.94!important}

.kr-side-message p{font-size:15px!important;line-height:1.55!important}

.kr-side-message img{height:255px!important;opacity:.28!important}

.kr-side-caption{position:absolute;left:30px;bottom:28px;z-index:3;font:700 20px/1.02 Oswald;text-transform:uppercase;letter-spacing:.01em}

.kr-side-caption em{font-style:normal;color:#ef2027}

.kr-contact-form{padding:30px!important;box-shadow:0 20px 50px rgba(0,0,0,.07)!important}

.kr-contact-form h2{font-size:31px!important;margin-bottom:18px!important}

.kr-form-grid{gap:12px!important}

.kr-field{gap:5px!important}

.kr-field label{font-size:11px!important}

.kr-field input,
.kr-field select,
.kr-field textarea{padding:11px 12px!important;font-size:14px!important}

.kr-field textarea{min-height:94px!important}

.kr-guidance{background:#fff;padding:28px 24px;display:flex;flex-direction:column;justify-content:space-between;border:1px solid #e1e4e8;box-shadow:0 18px 45px rgba(0,0,0,.04)}

.kr-guide-item{display:grid;grid-template-columns:46px 1fr;gap:12px;padding:4px 0 24px;border-bottom:1px solid #e4e6e9}

.kr-guide-item+.kr-guide-item{padding-top:22px}

.kr-guide-icon{width:38px;height:38px;border:2px solid #ef2027;border-radius:50%;display:grid;place-items:center;color:#ef2027;font-size:26px;font-weight:700}

.kr-guide-item h3{font:700 17px/1.02 Oswald;text-transform:uppercase;margin:0 0 8px}

.kr-guide-item p{font-size:13px;line-height:1.45;color:#687078;margin:0}

.kr-guide-call{display:flex;align-items:center;gap:12px;padding-top:22px}

.kr-guide-call>span{font-size:36px;color:#ef2027}

.kr-guide-call small{display:block;color:#555;font-size:11px;margin-bottom:3px}

.kr-guide-call b{display:block;font:700 20px Oswald}

.kr-office{transition:transform .45s cubic-bezier(.2,.8,.2,1),box-shadow .45s ease!important}

.kr-office:hover{transform:translateY(-8px)!important;box-shadow:0 24px 55px rgba(0,0,0,.12)!important}

.kr-office img{transition:transform .7s cubic-bezier(.2,.8,.2,1),filter .4s ease!important}

.kr-office:hover img{transform:scale(1.045);filter:saturate(1.05)}

.kr-final-cta{padding:62px 0!important}

.kr-final-cta h2{font-size:clamp(42px,4.3vw,65px)!important}

.kr-enquiry-hero{background:#0b0f14!important}

.kr-enquiry-hero .inner{min-height:410px!important;grid-template-columns:46% 54%!important;max-width:100%!important;width:100%!important}

.kr-enquiry-copy{padding:55px 5.2vw 38px!important;display:flex;flex-direction:column;justify-content:center!important;background:linear-gradient(105deg,#0b0f14 0%,#10151b 78%,#151a20 100%)!important;position:relative!important;overflow:hidden!important}

.kr-enquiry-copy:after{content:"";position:absolute;right:-90px;top:-40%;width:190px;height:180%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.035),transparent);transform:rotate(15deg);animation:enqSweep 7s ease-in-out infinite}

.kr-enquiry-copy h1{font-size:clamp(47px,4.5vw,73px)!important;line-height:.92!important;max-width:610px!important;letter-spacing:-.018em!important;margin:10px 0 16px!important}

.kr-enquiry-copy p{max-width:510px!important;font-size:15px!important;line-height:1.55!important}

.kr-enquiry-steps{margin-top:26px!important;max-width:540px!important}

.kr-enquiry-step{padding:13px 15px!important}

.kr-enquiry-step b{font-size:21px!important}

.kr-enquiry-step span{font-size:10.5px!important}

.kr-enquiry-visual{min-height:410px!important}

.kr-enquiry-visual img{animation:enqKenburn 18s ease-in-out infinite alternate!important}

.kr-enquiry-visual:before{background:linear-gradient(100deg,#0b0f14 0%,rgba(11,15,20,.58) 8%,rgba(11,15,20,.08) 42%,transparent 72%)!important}

.kr-enquiry-visual:after{right:42px!important;bottom:36px!important;font-size:16px!important;line-height:1.25!important}

.kr-form-area{padding:52px 0 68px!important;background:#f5f6f7!important}

.kr-form-layout{grid-template-columns:27% 47% 26%!important;gap:0!important;align-items:stretch!important;max-width:1240px!important}

.kr-side-message{min-height:540px!important;padding:34px 30px!important;background:#f1f3f5!important;color:#111!important;border:1px solid #e2e5e8!important}

.kr-side-message:before{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(245,246,247,.88) 0%,rgba(245,246,247,.72) 44%,rgba(245,246,247,.2) 100%);z-index:1;pointer-events:none}

.kr-side-message:after{display:none!important}

.kr-side-message .side-copy{position:relative;z-index:3}

.kr-side-message .kr-kicker{color:#e51b23!important}

.kr-side-message h2{font-size:49px!important;line-height:.94!important;color:#111!important;margin:12px 0 16px!important}

.kr-side-message p{color:#525960!important;font-size:15px!important;line-height:1.55!important;max-width:270px}

.kr-side-message img{height:300px!important;opacity:.38!important;mix-blend-mode:multiply!important;filter:grayscale(1)!important}

.kr-side-caption{position:absolute;z-index:4;left:30px;bottom:28px;font:700 23px/.95 Oswald!important;letter-spacing:.01em!important;color:#111!important}

.kr-side-caption em{color:#e51b23!important;font-style:normal}

.kr-contact-form{padding:30px 28px!important;border:1px solid #e0e3e7!important;box-shadow:0 15px 45px rgba(0,0,0,.055)!important;border-radius:0!important;position:relative!important;z-index:2!important}

.kr-contact-form h2{font-size:28px!important;margin:0 0 18px!important}

.kr-form-grid{gap:15px 13px!important}

.kr-field label{font-size:11px!important;font-weight:800!important;margin-bottom:6px!important}

.kr-field input,
.kr-field select,
.kr-field textarea{font-size:13px!important;padding:11px 12px!important;border-color:#dfe3e6!important;background:#fff!important}

.kr-field textarea{min-height:88px!important}

.kr-submit{height:44px!important;margin-top:14px!important;font-size:14px!important}

.kr-note{font-size:10px!important;margin-top:8px!important}

.kr-guidance{min-height:540px!important;background:#f7f8f9!important;padding:28px 26px!important;border:1px solid #e2e5e8!important;border-left:0!important;display:flex!important;flex-direction:column!important;justify-content:flex-start!important;gap:0!important}

.kr-guide-item{display:grid!important;grid-template-columns:48px 1fr!important;gap:14px!important;padding:10px 0 24px!important;border-bottom:1px solid #e1e4e7!important;margin:0!important}

.kr-guide-item + .kr-guide-item{padding-top:25px!important}

.kr-guide-icon{width:42px!important;height:42px!important;border:2px solid #e51b23!important;border-radius:50%!important;color:#e51b23!important;display:grid!important;place-items:center!important;font-size:27px!important;font-weight:700!important;animation:guidePulse 2.8s ease-in-out infinite!important}

.kr-guide-item h3{font:700 17px/.98 Oswald!important;margin:2px 0 8px!important;color:#111!important}

.kr-guide-item p{font-size:11px!important;line-height:1.5!important;color:#687078!important;margin:0!important}

.kr-guide-call{display:flex!important;align-items:center!important;gap:14px!important;padding-top:24px!important;margin-top:auto!important}

.kr-guide-call>span{width:42px!important;height:42px!important;border:2px solid #e51b23!important;border-radius:50%!important;display:grid!important;place-items:center!important;color:#e51b23!important;font-size:25px!important}

.kr-guide-call small{display:block!important;font-size:10px!important;color:#626970!important;margin-bottom:4px!important}

.kr-guide-call b{display:block!important;font:700 21px Oswald!important;color:#111!important}

.kr-head{align-items:end!important}

.kr-head h2{font-size:clamp(44px,4.3vw,65px)!important}

.kr-office{transition:transform .45s cubic-bezier(.2,.75,.2,1),box-shadow .45s ease!important}

.kr-office:hover{transform:translateY(-9px) rotateX(1deg)!important;box-shadow:0 25px 55px rgba(0,0,0,.12)!important}

.kr-office img{transition:transform .7s ease!important}

.kr-office:hover img{transform:scale(1.045)!important}

.kr-enquiry-copy h1,
.kr-hero h1{
  font-size:clamp(38px,3.25vw,47px)!important;
  line-height:.94!important;
  letter-spacing:-.8px!important;
  max-width:560px!important;
  margin:10px 0 14px!important;
}

.kr-enquiry-copy p,
.kr-hero p{
  font-size:14px!important;
  line-height:1.5!important;
  max-width:500px!important;
}

.kr-kicker{
  font-size:10px!important;
  letter-spacing:1.2px!important;
}

.kr-hero,
.kr-enquiry-hero{
  height:590px !important;
  min-height:590px !important;
}

.kr-hero-inner{
  min-height:590px !important;
  height:590px !important;
}

.kr-enquiry-hero .inner{
  min-height:590px !important;
  height:590px !important;
}

.kr-enquiry-visual{
  min-height:590px !important;
  height:590px !important;
}

.kr-btn,
.kr-office-btn{position:relative;overflow:hidden;isolation:isolate;transition:transform .28s cubic-bezier(.2,.8,.2,1),box-shadow .28s ease,background .28s ease,color .28s ease,border-color .28s ease!important}

.kr-btn::before,
.kr-office-btn::before{content:"";position:absolute;z-index:-1;top:-45%;left:-90%;width:48%;height:190%;background:linear-gradient(105deg,transparent 10%,rgba(255,255,255,.04) 38%,rgba(255,255,255,.72) 50%,rgba(255,255,255,.04) 62%,transparent 90%);transform:skewX(-18deg);transition:left .68s cubic-bezier(.2,.7,0,1);pointer-events:none}

.kr-btn:hover::before,
.kr-office-btn:hover::before{left:145%}

.kr-btn,
.kr-office-btn{background:var(--red);color:#fff;border-color:var(--red)}

.kr-btn.alt{background:#fff;color:#111;border:1px solid #ddd}

.kr-btn:hover,
.kr-office-btn:hover{transform:translateY(-4px);box-shadow:0 0 0 1px #ff4148,0 14px 34px rgba(229,27,35,.28),0 0 24px rgba(229,27,35,.18)!important}

.kr-btn.alt:hover{transform:translateY(-4px);box-shadow:0 12px 30px rgba(0,0,0,.16)!important;border-color:#fff;background:#f7f7f7;color:#111}

.kr-btn span,
.kr-office-btn span{transition:transform .3s ease;display:inline-block}

.kr-btn:hover span,
.kr-office-btn:hover span{transform:translateX(6px)}

.kr-field input[type=file]{padding:10px 12px;cursor:pointer}

.kr-btn,
.kr-office-btn,
.kr-final-cta .btn{
  border-radius:999px !important;
  min-height:44px;
  padding:12px 22px !important;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:14px;
  white-space:nowrap;
  -webkit-tap-highlight-color:transparent;
}

.kr-btn::after,
.kr-office-btn::after{
  content:"";position:absolute;inset:0;border-radius:inherit;pointer-events:none;box-shadow:inset 0 0 0 1px rgba(255,255,255,.14);opacity:.7;
}

.kr-btn:active,
.kr-office-btn:active{transform:translateY(-1px) scale(.985)!important}

.kr-office-btn,
.kr-btn{border:1px solid var(--red)!important}

.kr-btn.alt{border:1px solid #ddd!important}

.kr-btn,
.kr-office-btn,
.kr-final-cta .btn,
.kr-final-cta{
  border-radius:6px !important;
  clip-path:none !important;
}

.inner-page .kr-hero,
.inner-page .kr-enquiry-hero{
  height:590px!important;
  min-height:590px!important;
}

.inner-page .kr-hero-inner{
  height:590px!important;
  min-height:590px!important;
  display:flex!important;
  align-items:center!important;
  padding-top:0!important;
  padding-bottom:0!important;
}

.inner-page .kr-hero h1,
.inner-page .kr-enquiry-copy h1{
  font-size:47px!important;
  line-height:.95!important;
  letter-spacing:-.7px!important;
  max-width:560px!important;
  margin:10px 0 16px!important;
}

.inner-page .kr-hero p,
.inner-page .kr-enquiry-copy p{
  font-size:14px!important;
  line-height:1.55!important;
  max-width:500px!important;
  margin-bottom:20px!important;
}

.inner-page .kr-hero-inner,
.inner-page .kr-enquiry-copy{
  position:relative;
  z-index:4;
}

.inner-page .kr-hero{align-items:center!important}

.inner-page .kr-hero-inner{padding-left:0!important}

.inner-page .kr-enquiry-hero .inner{
  height:590px!important;
  min-height:590px!important;
  max-width:1240px!important;
  width:min(calc(100% - 64px),1240px)!important;
  display:flex!important;
  align-items:center!important;
  position:relative!important;
}

.inner-page .kr-enquiry-visual{
  position:absolute!important;
  inset:0!important;
  width:100%!important;
  height:590px!important;
  min-height:590px!important;
  z-index:0!important;
}

.inner-page .kr-enquiry-visual:before{
  background:linear-gradient(90deg,rgba(5,8,11,.94) 0%,rgba(5,8,11,.78) 40%,rgba(5,8,11,.25) 75%,rgba(5,8,11,.16) 100%)!important;
}

.inner-page .kr-enquiry-visual:after{display:none!important}

.inner-page .kr-enquiry-copy{
  width:min(620px,70%)!important;
  padding:0!important;
}

.inner-page .kr-enquiry-steps{max-width:560px!important;margin-top:26px!important}

.kr-page .kr-enquiry-hero .inner{width:100%!important;max-width:none!important}

.kr-page .kr-enquiry-visual{left:0!important;right:0!important;width:100%!important}

.kr-page .kr-enquiry-copy{width:min(58%,720px)!important;margin-left:max(32px,calc((100vw - var(--content-max))/2))!important}

.kr-page .kr-enquiry-hero{width:100%!important;overflow:hidden!important}

.kr-page .kr-enquiry-hero .inner{width:100vw!important;max-width:none!important;margin:0!important;padding-left:0!important;padding-right:0!important}

.kr-page .kr-enquiry-visual{left:0!important;right:0!important;width:100vw!important;height:100%!important}

.kr-page .kr-enquiry-visual img{display:block!important;width:100%!important;height:100%!important;object-fit:cover!important;object-position:center center!important}

.kr-page .kr-enquiry-copy{margin-left:clamp(24px,calc((100vw - 1240px)/2),80px)!important}

.kr-page .kr-enquiry-hero{
  position:relative!important;
  width:100%!important;
  height:590px!important;
  min-height:590px!important;
  overflow:hidden!important;
}

.kr-page .kr-enquiry-hero .inner{
  position:relative!important;
  width:100%!important;
  max-width:none!important;
  height:100%!important;
  min-height:100%!important;
  margin:0!important;
  padding:0!important;
  display:flex!important;
  align-items:center!important;
}

.kr-page .kr-enquiry-visual{
  position:absolute!important;
  inset:0!important;
  width:100%!important;
  height:100%!important;
  min-height:100%!important;
  z-index:0!important;
  overflow:hidden!important;
}

.kr-page .kr-enquiry-visual img{
  position:absolute!important;
  inset:0!important;
  display:block!important;
  width:100%!important;
  height:100%!important;
  max-width:none!important;
  object-fit:cover!important;
  object-position:center center!important;
  transform:none!important;
}

.kr-page .kr-enquiry-copy{
  position:relative!important;
  z-index:3!important;
  width:min(560px,calc(100% - 64px))!important;
  margin:0 0 0 max(32px,calc((100vw - 1240px)/2))!important;
  padding:0!important;
}

.kr-final-cta{
  overflow:hidden!important;
}

.kr-final-cta .container{min-height:0!important;padding-top:30px!important;padding-bottom:30px!important;}

.kr-final-cta h2{font-size:clamp(38px,4.4vw,63px)!important;line-height:.95!important;overflow-wrap:anywhere!important;}

.kr-final-cta{padding:0!important;}

.kr-final-cta{max-width:100%;}

.kr-career-cta{position:relative;overflow:hidden;background:#15191f;color:#fff;padding:48px 0;border-top:1px solid rgba(255,255,255,.06);border-bottom:1px solid rgba(255,255,255,.06)}

.kr-career-cta:before{content:"";position:absolute;inset:0;background:linear-gradient(100deg,rgba(12,16,21,.96),rgba(12,16,21,.52)),url("../assets/images/shared-night-city-background.webp") center/cover;opacity:.82}

.kr-career-cta .container{position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:28px;min-height:0}

.kr-career-cta-copy{min-width:0;max-width:780px}

.kr-career-cta h2{font:700 clamp(34px,4.6vw,60px)/.95 Oswald,sans-serif;text-transform:uppercase;margin:8px 0 12px;overflow-wrap:anywhere}

.kr-career-cta h2 em{color:#ef2027;font-style:normal}

.kr-career-cta p{max-width:650px;margin:0;color:#b8c0c8;font-size:14px;line-height:1.6;overflow-wrap:anywhere}

.kr-career-cta .kr-btn{flex:0 0 auto}

.kr-final-cta,
.kr-career-cta{height:auto!important;}

.kr-final-cta .container,
.kr-career-cta .container{flex-wrap:wrap;}

.kr-final-cta .kr-btn,
.kr-career-cta .kr-btn{visibility:visible!important;opacity:1!important;flex-shrink:0!important;}

.kr-offices{align-items:stretch!important}

.kr-office{min-height:0!important;align-items:stretch!important}

.kr-office-info{padding:21px 22px!important;display:flex!important;flex-direction:column!important;align-items:flex-start!important;min-width:0!important}

.kr-office-info .tag{margin-bottom:8px!important;font-size:10px!important}

.kr-office-info h3{font-size:27px!important;margin:0 0 10px!important;line-height:1!important}

.kr-office-info p{font-size:14px!important;line-height:1.52!important;margin:0!important}

.kr-office-info a:not(.kr-office-btn){font-size:14px!important;margin-top:7px!important;line-height:1.35!important}

.kr-office-btn{font-size:11px!important;line-height:1!important;padding:10px 13px!important;margin-top:13px!important;align-self:flex-start!important;white-space:nowrap!important}

.kr-office-info .kr-office-btn{
  position:relative!important;
  z-index:2!important;
  display:inline-flex!important;
  align-items:center!important;
  justify-content:center!important;
  flex:0 0 auto!important;
  width:auto!important;
  min-width:112px!important;
  max-width:100%!important;
  min-height:36px!important;
  height:auto!important;
  padding:9px 14px!important;
  margin-top:auto!important;
  margin-bottom:0!important;
  line-height:1.15!important;
  text-align:center!important;
  white-space:nowrap!important;
  overflow:visible!important;
  box-sizing:border-box!important;
  color:#ef2027!important;
  background:#fff!important;
  opacity:1!important;
  visibility:visible!important;
}

.kr-office-info .kr-office-btn::before{z-index:-1!important}

.kr-office-info .kr-office-btn:hover{color:#fff!important;background:#ef2027!important}

n
/* Final requested compact office + leadership alignment */
.kr-office{height:500px!important;min-height:0!important}

.kr-office img{height:500px!important;min-height:0!important}

.kr-office{grid-template-columns:.74fr 1.26fr!important}

.kr-office img{width:100%!important;height:100%!important;min-height:235px!important;object-fit:cover!important;object-position:center center!important}

.kr-office-info{padding:24px 26px!important}

.kr-btn,
.kr-office-btn{
  border-radius:6px !important;
  clip-path:none !important;
}

.kr-btn::before,
.kr-btn::after,
.kr-office-btn::before,
.kr-office-btn::after{
  border-radius:inherit !important;
  clip-path:none !important;
}

.kr-btn:hover,
.kr-office-btn:hover{
  border-radius:6px !important;
  clip-path:none !important;
}

.kr-final-cta::before,
.kr-career-cta::before{
  display:none !important;
  background:none !important;
  animation:none !important;
}

.kr-final-cta,
.kr-career-cta{
  background:#0c1015 !important;
  background-image:none !important;
}

.kr-page .kr-enquiry-visual,
.kr-page .kr-enquiry-visual img{
  background:transparent!important;
}

.kr-page .kr-enquiry-visual img{
  transform:scale(1.10)!important;
  transform-origin:center center!important;
  object-fit:cover!important;
  object-position:center center!important;
}

.kr-page .kr-enquiry-visual:before{
  background:linear-gradient(90deg,rgba(5,8,11,.78) 0%,rgba(5,8,11,.34) 30%,rgba(5,8,11,.06) 60%,transparent 100%)!important;
}

.kr-page .kr-enquiry-hero{background:#0b0f14!important;}

.kr-page .kr-enquiry-copy{background:transparent!important;}

.kr-page .kr-enquiry-copy:after{display:none!important;}

.kr-page .kr-enquiry-visual:before{
  background:linear-gradient(90deg,rgba(5,8,11,.72) 0%,rgba(5,8,11,.46) 38%,rgba(5,8,11,.16) 72%,rgba(5,8,11,.06) 100%)!important;
}

.kr-page .kr-enquiry-visual img{
  object-fit:cover!important;
  object-position:center center!important;
}

.inner-page .kr-enquiry-visual{
  width:100vw!important;
  left:50%!important;
  right:auto!important;
  margin-left:-50vw!important;
  overflow:hidden!important;
}

.inner-page .kr-enquiry-visual img{
  width:100%!important;
  height:100%!important;
  object-fit:cover!important;
  object-position:center center!important;
  transform:scale(1.09)!important;
  transform-origin:center center!important;
}

.kr-page .kr-enquiry-visual img{
  object-position:center center!important;
}

.kr-page .kr-enquiry-hero,
.kr-page .kr-enquiry-hero .inner,
.kr-page .kr-enquiry-visual{
  width:100%!important;
  max-width:none!important;
  margin-left:0!important;
  margin-right:0!important;
  left:0!important;
  right:0!important;
}

.kr-page .kr-enquiry-visual img{
  width:100%!important;
  height:100%!important;
  object-fit:cover!important;
  object-position:center center!important;
  transform:none!important;
}

.kr-page .kr-enquiry-visual:before{
  background:linear-gradient(90deg,rgba(5,8,11,.38) 0%,rgba(5,8,11,.16) 45%,rgba(5,8,11,.04) 76%,transparent 100%)!important;
}

.kr-page .kr-enquiry-hero{
  width:100%!important;
  max-width:none!important;
  margin:0!important;
  padding:0!important;
  overflow:hidden!important;
  background:#111!important;
}

.kr-page .kr-enquiry-hero .inner{
  width:100%!important;
  max-width:none!important;
  margin:0!important;
  padding:0!important;
}

.kr-page .kr-enquiry-visual{
  position:absolute!important;
  inset:0!important;
  width:100%!important;
  height:100%!important;
  margin:0!important;
  overflow:hidden!important;
  background:transparent!important;
}

.kr-page .kr-enquiry-visual img{
  position:absolute!important;
  left:-3%!important;
  top:-3%!important;
  width:106%!important;
  height:106%!important;
  max-width:none!important;
  object-fit:cover!important;
  object-position:center center!important;
  transform:none!important;
}

.kr-page .kr-enquiry-visual:before{
  background:rgba(5,8,11,.42)!important;
}

.kr-page .kr-enquiry-visual:after{display:none!important;}

.kr-page{width:100%!important;max-width:none!important;margin:0!important;background:#fff!important;}

.kr-page .kr-enquiry-hero{
  width:100vw!important;
  max-width:none!important;
  min-width:100vw!important;
  margin-left:calc(50% - 50vw)!important;
  margin-right:calc(50% - 50vw)!important;
  padding:0!important;
  background:#000!important;
  overflow:hidden!important;
}

.kr-page .kr-enquiry-hero .inner{
  width:100vw!important;
  max-width:none!important;
  margin:0!important;
  padding:0!important;
  min-height:100%!important;
}

.kr-page .kr-enquiry-visual{
  position:absolute!important;
  inset:0!important;
  width:100vw!important;
  height:100%!important;
  margin:0!important;
  padding:0!important;
  background:transparent!important;
  overflow:hidden!important;
}

.kr-page .kr-enquiry-visual img{
  left:-2%!important;
  top:-2%!important;
  width:104%!important;
  height:104%!important;
  max-width:none!important;
  object-fit:cover!important;
  object-position:center center!important;
}

.kr-page .kr-enquiry-copy{position:relative!important;z-index:3!important;}

.kr-btn:not(.alt)::before,
.kr-office-btn::before{
  background:linear-gradient(105deg,
    transparent 8%,
    rgba(255,255,255,.05) 32%,
    rgba(255,255,255,.88) 50%,
    rgba(255,255,255,.05) 68%,
    transparent 92%) !important;
  transition:left 1.15s cubic-bezier(.2,.7,0,1) !important;
}

.kr-btn.alt::before{
  background:linear-gradient(105deg,
    transparent 8%,
    rgba(229,27,35,.05) 32%,
    rgba(229,27,35,.82) 50%,
    rgba(229,27,35,.05) 68%,
    transparent 92%) !important;
  transition:left 1.15s cubic-bezier(.2,.7,0,1) !important;
}

.kr-btn:not(.alt)::after,
.kr-office-btn::after{
  background:linear-gradient(90deg,transparent,rgba(255,255,255,.38),transparent) !important;
  transition:left 1.05s cubic-bezier(.2,.75,0,1),opacity .35s ease !important;
}

.kr-btn.alt::after{
  background:linear-gradient(90deg,transparent,rgba(229,27,35,.28),transparent) !important;
  transition:left 1.05s cubic-bezier(.2,.75,0,1),opacity .35s ease !important;
}

.kr-btn:hover,
.kr-office-btn:hover{
  transition:transform .42s cubic-bezier(.2,.75,.2,1),box-shadow .42s ease,
    border-color .42s ease,background-color .42s ease,color .42s ease !important;
}

.kr-enquiry-copy h1,
.kr-side-message h2{
  overflow-wrap:anywhere!important;
  word-break:normal!important;
}

.kr-office-info .kr-office-btn{
  align-self:center!important;
  margin-top:14px!important;
  margin-bottom:10px!important;
  position:relative!important;
}

body.kr-image-lightbox-open{overflow:hidden!important;}

.kr-zoomable-image{cursor:zoom-in!important;}

.kr-image-lightbox{
  position:fixed!important;
  inset:0!important;
  z-index:20000!important;
  display:flex!important;
  align-items:center!important;
  justify-content:center!important;
  padding:clamp(16px,4vw,48px)!important;
  background:rgba(5,7,9,.88)!important;
  opacity:0!important;
  visibility:hidden!important;
  pointer-events:none!important;
  transition:opacity .22s ease,visibility .22s ease!important;
}

.kr-image-lightbox.open{
  opacity:1!important;
  visibility:visible!important;
  pointer-events:auto!important;
}

.kr-image-lightbox img{
  display:block!important;
  max-width:min(94vw,1600px)!important;
  max-height:90vh!important;
  width:auto!important;
  height:auto!important;
  object-fit:contain!important;
  border-radius:4px!important;
  box-shadow:0 25px 80px rgba(0,0,0,.45)!important;
  cursor:zoom-out!important;
}

.kr-image-lightbox-close{
  position:absolute!important;
  top:18px!important;
  right:22px!important;
  width:42px!important;
  height:42px!important;
  border:1px solid rgba(255,255,255,.28)!important;
  border-radius:50%!important;
  background:rgba(0,0,0,.42)!important;
  color:#fff!important;
  font-size:27px!important;
  line-height:1!important;
  cursor:pointer!important;
}

.kr-final-cta{padding:42px 0!important;}

.kr-final-cta .container{min-height:0!important;display:grid!important;grid-template-columns:minmax(0,1fr) auto!important;align-items:center!important;gap:34px!important;padding-top:0!important;padding-bottom:0!important;}

.kr-final-cta .container>div{min-width:0!important;}

.kr-final-cta .kr-kicker{margin:0 0 8px!important;}

.kr-final-cta h2{margin:0!important;max-width:920px!important;font-size:clamp(36px,4.4vw,62px)!important;line-height:.94!important;}

.kr-final-cta .kr-btn{align-self:center!important;margin:0!important;white-space:nowrap!important;}

.kr-enquiry-hero .inner{width:min(calc(100% - 64px),var(--content-max))!important;max-width:var(--content-max)!important;margin-inline:auto!important}

.kr-enquiry-copy{padding-left:0!important;padding-right:36px!important}

.kr-section{padding-left:max(0px,calc((100vw - var(--content-max))/2));padding-right:max(0px,calc((100vw - var(--content-max))/2))}

.kr-section>.container{width:100%!important;max-width:var(--content-max)!important}

.kr-head h2{letter-spacing:-.025em}

.kr-head h2{ text-wrap:balance }

.kr-reveal{will-change:transform,opacity}

.kr-reveal.is-visible{animation:homeSectionSettle .78s cubic-bezier(.16,.7,0,1) both}

@keyframes homeSectionSettle{0%{opacity:0;transform:translate3d(0,26px,0) scale(.985)}100%{opacity:1;transform:translate3d(0,0,0) scale(1)}}

.kr-office{transform-style:preserve-3d;backface-visibility:hidden}

.kr-office:hover{transform:translateY(-6px) perspective(900px) rotateX(.7deg) rotateY(-.5deg)!important}

.kr-btn,
.kr-office-btn{position:relative;overflow:hidden;isolation:isolate}

.kr-btn:before,
.kr-office-btn:before{content:"";position:absolute;z-index:-1;top:-45%;left:-85%;width:48%;height:190%;background:linear-gradient(105deg,transparent 10%,rgba(255,255,255,.05) 38%,rgba(255,255,255,.65) 50%,rgba(255,255,255,.05) 62%,transparent 90%);transform:skewX(-18deg);transition:left .65s cubic-bezier(.2,.7,0,1);pointer-events:none}

.kr-btn:hover:before,
.kr-office-btn:hover:before{left:145%}

.kr-btn span,
.kr-office-btn{transition:transform .3s ease}

.kr-page{--inner-max:1240px}

.kr-page .kr-section{scroll-margin-top:90px}

.kr-page img{border-radius:0;}

.kr-page .kr-office,
.kr-page .kr-role,
.kr-page .kr-step{transform-style:preserve-3d;transition:transform .45s cubic-bezier(.2,.8,.2,1),box-shadow .45s ease,border-color .35s ease}

.kr-page .kr-role:hover,
.kr-page .kr-step:hover{transform:translateY(-7px) perspective(1000px) rotateX(1.2deg) rotateY(-1deg)!important;box-shadow:0 22px 48px rgba(0,0,0,.12)}

.kr-page .kr-office:hover{transform:translateY(-8px) perspective(1000px) rotateX(1deg) rotateY(-.7deg)!important}

.kr-hero h1{letter-spacing:-.035em}

.kr-hero p{max-width:540px}

.careers-hero-image{display:block;width:100%;height:100%;object-fit:cover;object-position:center;filter:saturate(.95) contrast(1.04);animation:innerHeroDrift 14s ease-in-out infinite alternate}

@keyframes innerHeroDrift{from{transform:scale(1.02)}to{transform:scale(1.065)}}

.kr-page .kr-hero,
.kr-page .kr-enquiry-hero{
  position:relative!important;
  height:590px!important;
  min-height:590px!important;
  overflow:hidden!important;
}

.kr-page .kr-hero-inner{
  width:min(calc(100% - 64px),var(--content-max))!important;
  max-width:var(--content-max)!important;
  min-height:590px!important;
  height:590px!important;
  padding:0!important;
  display:flex!important;
  flex-direction:column!important;
  justify-content:center!important;
  align-items:flex-start!important;
}

.kr-page .kr-hero h1,
.kr-page .kr-enquiry-copy h1{
  font-size:clamp(36px,4vw,54px)!important;
  line-height:.94!important;
  max-width:610px!important;
  margin:8px 0 14px!important;
  letter-spacing:-.035em!important;
}

.kr-page .kr-hero p,
.kr-page .kr-enquiry-copy p{
  max-width:500px!important;
  font-size:13px!important;
  line-height:1.55!important;
  margin:0 0 22px!important;
}

.kr-page .kr-kicker{
  font-size:9px!important;
  letter-spacing:.16em!important;
  margin-bottom:9px!important;
}

.kr-page .kr-actions{gap:10px!important}

.kr-page .kr-btn{
  min-height:44px!important;
  padding:12px 18px!important;
  font-size:12px!important;
}

.kr-page .kr-hero:after{
  background:linear-gradient(90deg,rgba(5,8,11,.94) 0%,rgba(5,8,11,.70) 43%,rgba(5,8,11,.16) 82%),linear-gradient(0deg,rgba(0,0,0,.62),transparent 55%)!important;
}

.kr-page .kr-enquiry-hero .inner{
  position:relative!important;
  width:min(calc(100% - 64px),var(--content-max))!important;
  max-width:var(--content-max)!important;
  min-height:590px!important;
  height:590px!important;
  display:flex!important;
  align-items:center!important;
  margin-inline:auto!important;
}

.kr-page .kr-enquiry-visual{
  position:absolute!important;
  inset:0!important;
  width:100%!important;
  height:100%!important;
  min-height:0!important;
  z-index:0!important;
}

.kr-page .kr-enquiry-visual img{
  width:100%!important;
  height:100%!important;
  object-fit:cover!important;
  object-position:center!important;
}

.kr-page .kr-enquiry-visual:before{
  background:linear-gradient(90deg,rgba(5,8,11,.94) 0%,rgba(5,8,11,.72) 42%,rgba(5,8,11,.16) 82%)!important;
}

.kr-page .kr-enquiry-copy{
  position:relative!important;
  z-index:3!important;
  width:58%!important;
  padding:0!important;
  background:none!important;
  display:block!important;
}

.kr-page .kr-enquiry-copy:after{display:none!important}

.kr-page .kr-enquiry-copy h1{color:#fff!important}

.kr-page .kr-enquiry-copy p{color:rgba(255,255,255,.82)!important}

.kr-page .kr-enquiry-steps{
  display:grid!important;
  grid-template-columns:repeat(3,minmax(0,1fr))!important;
  max-width:570px!important;
  margin-top:18px!important;
  gap:8px!important;
}

.kr-page .kr-enquiry-step{
  padding:11px 12px!important;
  border:1px solid rgba(255,255,255,.16)!important;
  background:rgba(0,0,0,.18)!important;
  backdrop-filter:blur(5px)!important;
}

.kr-page .kr-enquiry-step b{font-size:16px!important;margin-bottom:3px!important}

.kr-page .kr-enquiry-step span{font-size:9px!important}

.kr-page .kr-form-layout{width:min(100%,var(--content-max))!important}

.kr-page .kr-contact-form,
.kr-page .kr-side-message,
.kr-page .kr-guidance{border-radius:0!important}

.kr-enquiry-hero{
  position:relative!important;
  min-height:78vh!important;
  overflow:hidden!important;
  background:#0c0f13!important;
}

.kr-enquiry-hero .inner{
  position:relative!important;
  display:block!important;
  width:100%!important;
  max-width:none!important;
  min-height:78vh!important;
  margin:0!important;
}

.kr-enquiry-copy{
  position:relative!important;
  z-index:3!important;
  width:min(650px,calc(100% - 64px))!important;
  margin-left:max(32px,calc((100vw - var(--content-max))/2))!important;
  padding:108px 0 72px!important;
}

.kr-enquiry-visual{
  position:absolute!important;
  inset:0!important;
  width:100%!important;
  height:100%!important;
  min-height:100%!important;
  z-index:0!important;
  overflow:hidden!important;
}

.kr-enquiry-visual img{
  width:100%!important;
  height:100%!important;
  object-fit:cover!important;
  object-position:center center!important;
  transform:scale(1.06)!important;
}

.kr-enquiry-visual:before{
  content:""!important;
  position:absolute!important;
  inset:0!important;
  z-index:1!important;
  background:linear-gradient(90deg,rgba(5,8,11,.86) 0%,rgba(5,8,11,.62) 34%,rgba(5,8,11,.20) 67%,rgba(5,8,11,.04) 100%)!important;
}

.kr-enquiry-visual:after{
  z-index:2!important;
}

.kr-enquiry-hero{
  background:#0c0f13!important;
}

.kr-enquiry-visual{
  inset:0 6px!important;
  width:auto!important;
  height:100%!important;
}

.kr-enquiry-visual img{
  width:100%!important;
  height:100%!important;
  object-fit:cover!important;
  transform:scale(1.035)!important;
}
@media (max-width: 768px) {
  .kr-hero h1, .kr-enquiry-copy h1, .inner-page .kr-hero h1, .inner-page .kr-enquiry-copy h1 { font-size: 32px !important; line-height: 1.1 !important; }
  .kr-hero p, .kr-enquiry-copy p { font-size: 14px !important; }
  .kr-ticker, .kr-career-grid, .kr-points, .kr-roles, .kr-steps, .kr-application, .kr-form-layout, .kr-offices { grid-template-columns: 1fr !important; }
  .kr-image-stack { min-height: 350px !important; margin-bottom: 30px !important; }
  .kr-image-stack .p1 { height: 250px !important; }
  .kr-image-stack .p2 { height: 160px !important; }
  .kr-image-stack .p3 { height: 110px !important; }
  .kr-hero, .kr-enquiry-hero, .kr-hero-inner, .kr-enquiry-hero .inner, .kr-enquiry-visual, .inner-page .kr-hero, .inner-page .kr-enquiry-hero, .inner-page .kr-hero-inner, .inner-page .kr-enquiry-hero .inner { min-height: auto !important; height: auto !important; }
  .kr-hero-inner { padding: 120px 20px 60px !important; }
  .kr-enquiry-visual { display: none !important; }
  .kr-enquiry-copy { padding: 40px 20px !important; width: 100% !important; margin: 0 !important; }
  .kr-side-message { min-height: auto !important; padding: 30px 20px !important; }
  .kr-side-message img { display: none !important; }
  .kr-app-intro { padding: 30px 20px !important; }
  .kr-form { padding: 30px 20px !important; }
  .kr-final-cta .container, .kr-career-cta .container { flex-direction: column !important; align-items: flex-start !important; gap: 20px !important; }
  .kr-head { flex-direction: column !important; align-items: flex-start !important; margin-bottom: 30px !important; }
  .kr-enquiry-steps { grid-template-columns: 1fr !important; gap: 15px !important; border-top: none !important; display: flex !important; flex-direction: column !important; }
  .kr-enquiry-step { border-right: none !important; border-bottom: 1px solid rgba(255,255,255,0.1) !important; padding: 15px 0 !important; }
  .kr-page .kr-enquiry-visual { display: none !important; }
  .kr-section { padding: 50px 0 !important; }
  .kr-ticker .item { padding: 15px !important; }
  .kr-ticker b { font-size: 20px !important; }
  .kr-ticker span { font-size: 11px !important; }
}
</style>

<main class="kr-page"><section class="kr-hero"><img fetchpriority="high" srcset="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-06-800w.webp') }} 800w, {{ asset('assets/images/ooh/ahmedabad-hoarding-location-06.webp') }} 1600w" sizes="100vw" alt="Krishna Outdoor workplace and advertising environment" class="hero-media careers-hero-image" decoding="async" loading="eager" src="{{ asset('assets/images/ooh/ahmedabad-hoarding-location-06.webp') }}"/><div class="hero-grid"></div><div class="container kr-hero-inner kr-reveal"><div class="kr-kicker">CAREERS / LIFE AT KRISHNA</div><h1 class="seo-h1">Careers at Krishna Outdoor</h1><p class="seo-h1-slogan">BUILD THE <em>NEXT CHAPTER.</em></p><p>Great outdoor campaigns are built by people who understand places, people and possibilities. Join a team that turns ideas into real-world visibility.</p><div class="kr-actions"><a class="kr-btn" href="#apply">Explore Opportunities <span>→</span></a><a class="kr-btn alt" href="#culture">Life at Krishna <span>↓</span></a></div></div></section>
<section class="kr-ticker"><div class="item kr-reveal"><b>40+</b><span>Years of experience</span></div><div class="item kr-reveal delay-1"><b>360°</b><span>Media thinking</span></div><div class="item kr-reveal delay-2"><b>Ahmedabad</b><span>Core operations</span></div><div class="item kr-reveal delay-3"><b>Mumbai</b><span>Growing network</span></div></section>
<section class="kr-section" id="culture"><div class="container kr-career-grid"><div class="kr-image-stack kr-reveal"><div class="pic p1"><img srcset="{{ asset('assets/images/careers-about-image-01-800w.webp') }} 800w, {{ asset('assets/images/careers-about-image-01.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="Krishna Outdoor team and workplace" decoding="async" loading="lazy" src="{{ asset('assets/images/careers-about-image-01.webp') }}"/></div><div class="pic p2"><img alt="Krishna Outdoor office and city" decoding="async" loading="lazy" src="{{ asset('assets/images/career-f3.webp') }}"/></div><div class="pic p3"><img srcset="{{ asset('assets/images/shared-mumbai-local-train-advertising-800w.webp') }} 800w, {{ asset('assets/images/shared-mumbai-local-train-advertising.webp') }} 1600w" sizes="(max-width: 760px) 100vw, 50vw" alt="Krishna Outdoor outdoor advertising and transit media" decoding="async" loading="lazy" src="{{ asset('assets/images/shared-mumbai-local-train-advertising.webp') }}"/></div><div class="kr-badge">40+<span>YEARS<br/>OF PEOPLE<br/>&amp; PROGRESS</span></div></div><div class="kr-copy kr-reveal delay-1"><div class="kr-kicker">WHY KRISHNA OUTDOOR</div><h2 class="kr-copy-title">PEOPLE MAKE<br/><em>THE DIFFERENCE.</em></h2><p>We work across outdoor, transit, print, electronic and digital media. That means every role connects to something visible, practical and real.</p><div class="kr-points"><div class="kr-point"><b>Think in the real world</b><span>Understand locations, audiences and movement.</span></div><div class="kr-point"><b>Work across media</b><span>Learn how one campaign travels across formats.</span></div><div class="kr-point"><b>Own your growth</b><span>Take responsibility and build practical expertise.</span></div><div class="kr-point"><b>Grow together</b><span>Collaborate with teams and clients every day.</span></div></div></div></div></section>
<section class="kr-section dark"><div class="container"><div class="kr-head kr-reveal"><div><div class="kr-kicker">OPPORTUNITIES</div><h2>FIND YOUR <em>SPACE.</em></h2></div><p>From field operations to creative thinking, there is room to build a career around what you do best.</p></div><div class="kr-roles"><article class="kr-role kr-reveal"><small>01 / GROW</small><h3>Sales &amp; Business</h3><p>Build relationships, understand brands and create opportunities across markets.</p></article><article class="kr-role kr-reveal delay-1"><small>02 / MOVE</small><h3>Operations</h3><p>Make campaigns happen on the ground with precision and ownership.</p></article><article class="kr-role kr-reveal delay-2"><small>03 / CREATE</small><h3>Design &amp; Creative</h3><p>Turn campaign thinking into visual ideas that work in public spaces.</p></article><article class="kr-role kr-reveal"><small>04 / CONNECT</small><h3>Client Servicing</h3><p>Keep brands, teams and execution aligned from brief to delivery.</p></article><article class="kr-role kr-reveal delay-1"><small>05 / SCALE</small><h3>Digital Marketing</h3><p>Extend outdoor visibility into digital conversations and measurable action.</p></article><article class="kr-role kr-reveal delay-2"><small>06 / SUPPORT</small><h3>Admin &amp; Coordination</h3><p>Keep people, processes and day-to-day business moving smoothly.</p></article></div></div></section>
<section class="kr-section"><div class="container"><div class="kr-head kr-reveal"><div><div class="kr-kicker">HOW WE WORK</div><h2>FROM IDEA TO <em>IMPACT.</em></h2></div><p>A simple rhythm: understand the objective, collaborate with the right people, execute well and learn from the result.</p></div><div class="kr-steps"><div class="kr-step kr-reveal"><div class="num">01</div><h3>Understand</h3><p>Start with the brand, audience and real-world requirement.</p></div><div class="kr-step kr-reveal delay-1"><div class="num">02</div><h3>Collaborate</h3><p>Bring creative, media, operations and client thinking together.</p></div><div class="kr-step kr-reveal delay-2"><div class="num">03</div><h3>Execute</h3><p>Turn plans into visible campaigns with attention to detail.</p></div><div class="kr-step kr-reveal delay-3"><div class="num">04</div><h3>Grow</h3><p>Build stronger skills, relationships and possibilities.</p></div></div></div></section>
<section class="kr-section" id="apply"><div class="container"><div class="kr-head kr-reveal"><div><div class="kr-kicker">JOIN THE TEAM</div><h2>YOUR NEXT <em>MOVE.</em></h2></div><p>Send us your details and tell us where you would like to contribute.</p></div><div class="kr-application kr-reveal"><div class="kr-app-intro"><div class="kr-kicker">APPLICATION</div><h2>LET'S BUILD<br/><em>WHAT'S NEXT.</em></h2><p>We review profiles across Ahmedabad and Mumbai. If your skills match an upcoming requirement, our team will connect with you.</p><div class="mini">Accepted profiles: Sales • Operations • Design • Client Servicing • Digital • Administration</div></div><form action="{{ route('handle.career.enquiry') }}" class="kr-form" enctype="multipart/form-data" id="careerApplicationForm" method="POST">
    <input type="hidden" name="_token" value="" data-lazy-csrf>
    <div class="kr-form-grid">
<div class="kr-field">
<label for="career_name">Full Name *</label>
<input id="career_name" name="name" placeholder="Your full name" required="" value="{{ old('name') }}"/>
            @error('name') <small class="file-note" style="color:red">{{ $message }}</small> @enderror
        </div>
<div class="kr-field">
<label for="career_email">Email *</label>
<input id="career_email" name="email" placeholder="you@example.com" required="" type="email" value="{{ old('email') }}"/>
            @error('email') <small class="file-note" style="color:red">{{ $message }}</small> @enderror
        </div>
<div class="kr-field">
<label for="careerPhone">Phone *</label>
<input id="careerPhone" inputmode="numeric" maxlength="10" name="phone" pattern="[0-9]{10}" placeholder="10-digit mobile number" required="" value="{{ old('phone') }}"/>
            @error('phone') <small class="file-note" style="color:red">{{ $message }}</small> @enderror
        </div>
<div class="kr-field">
<label for="career_role">Area of Interest *</label>
<select id="career_role" name="role" required="">
<option value="">Select role</option>
<option>Sales &amp; Business</option>
<option>Operations</option>
<option>Design &amp; Creative</option>
<option>Client Servicing</option>
<option>Digital Marketing</option>
<option>Admin &amp; Coordination</option>
</select>
            @error('role') <small class="file-note" style="color:red">{{ $message }}</small> @enderror
        </div>
<div class="kr-field full">
<label for="career_resume">Resume Attachment *</label>
<input accept=".pdf,.doc,.docx"  id="career_resume" name="resume" required="" type="file"/>
<small class="file-note">PDF, DOC or DOCX • max 10 MB</small>
            @error('resume') <small class="file-note" style="color:red">{{ $message }}</small> @enderror
        </div>
</div>
<button class="kr-btn kr-submit" type="submit">Send Application <span>→</span></button>
<div class="kr-note" id="careerStatus">
        @if(session('message'))
            {{ session('message')['description'] }}
        @else
            We'll use your details only to review your application.
        @endif
    </div>
</form></div></div></section>
<section class="kr-final-cta"><div class="container"><div><div class="kr-kicker">READY TO MOVE FORWARD?</div><h2>MAKE YOUR NEXT<br/><em>MOVE VISIBLE.</em></h2></div><a class="kr-btn" href="#apply">Apply Now <span>→</span></a></div></section></main>
@endsection

@section('web-script')
@endsection
