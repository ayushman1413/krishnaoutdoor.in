<style>
.kw-crumbs{font:600 12px Inter,sans-serif;letter-spacing:.04em;color:#68717b;margin:0 0 18px;text-transform:uppercase}
.kw-crumbs a{color:#ed2028;text-decoration:none}
.kw-crumbs a:hover{text-decoration:underline}
.kw-crumbs span{margin:0 6px;color:#aab0b7}
.kw-section{padding:54px 0}
.kw-section-alt{background:#f6f7f8}
.kw-inner{width:min(calc(100% - 2 * var(--gx,32px)),var(--content-max,1240px));margin:0 auto}
.kw-h2{font:700 clamp(28px,3.6vw,42px)/1.08 Oswald,sans-serif;text-transform:uppercase;letter-spacing:-.02em;margin:0 0 16px;color:#101216}
.kw-h2 em{font-style:normal;color:#ed2028}
.kw-h3{font:700 18px/1.3 Oswald,sans-serif;text-transform:uppercase;letter-spacing:-.01em;margin:22px 0 8px;color:#101216}
.kw-p{font:400 15px/1.7 Inter,sans-serif;color:#4b525b;margin:0 0 14px;max-width:760px}
.kw-p a,.kw-lead a{color:#c4161d;text-decoration:underline;text-underline-offset:2px}
.kw-p a:hover,.kw-lead a:hover{color:#101216}
.kw-grid-2{display:grid;grid-template-columns:1.1fr .9fr;gap:36px;align-items:start}
.kw-list{margin:0 0 16px;padding-left:20px;color:#4b525b;font:400 15px/1.8 Inter,sans-serif}
.kw-list li{margin-bottom:6px}
.kw-stat-row{display:flex;flex-wrap:wrap;gap:14px;margin:18px 0 22px}
.kw-stat{background:#fff;border:1px solid #e5e8eb;border-radius:8px;padding:14px 18px;min-width:140px;box-shadow:0 4px 14px rgba(16,18,22,.04)}
.kw-stat strong{display:block;font:700 26px Oswald,sans-serif;color:#ed2028;line-height:1}
.kw-stat span{display:block;font:500 12px Inter,sans-serif;color:#68717b;text-transform:uppercase;letter-spacing:.03em;margin-top:4px}
.kw-img{width:100%;border-radius:10px;overflow:hidden;box-shadow:0 14px 36px rgba(16,18,22,.1)}
.kw-img img{width:100%;height:100%;object-fit:cover;display:block}
.kw-links{display:flex;flex-wrap:wrap;gap:10px;margin:18px 0 6px}
.kw-links a{display:inline-flex;align-items:center;min-height:44px;font:600 12px Inter,sans-serif;color:#101216;background:#fff;border:1px solid #d9dde2;border-radius:6px;padding:9px 14px;text-decoration:none;transition:.25s}
.kw-links a:hover{border-color:#ed2028;color:#ed2028}
.kw-faq{max-width:820px}
.kw-faq details{border-bottom:1px solid #e5e8eb}
.kw-faq summary{font:700 14px Inter,sans-serif;color:#101216;cursor:pointer;list-style:none;display:flex;justify-content:space-between;align-items:center;gap:12px;min-height:48px;padding:14px 0}
.kw-faq summary::-webkit-details-marker{display:none}
.kw-faq summary:after{content:"+";font-size:20px;color:#ed2028;flex:0 0 auto}
.kw-faq details[open] summary:after{content:"\2212"}
.kw-faq-q{font:inherit;color:inherit;letter-spacing:0!important;text-transform:none;margin:0}
.cta-inner p a{color:#fff;font-weight:700;text-decoration:underline;white-space:nowrap}
.kw-faq p{font:400 14px/1.7 Inter,sans-serif;color:#565d66;margin:0 0 16px}
.kw-cta-strip{background:#0b0e12;color:#fff;border-radius:12px;padding:30px 28px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:20px;margin-top:10px}
.kw-cta-strip p{margin:0;font:400 14px/1.6 Inter,sans-serif;color:#d5d8dc;max-width:480px}
.kw-table{width:100%;max-width:760px;border-collapse:collapse;margin:16px 0 20px;font:400 14px/1.6 Inter,sans-serif;color:#4b525b}
.kw-table th{text-align:left;font-weight:700;color:#101216;background:#f6f7f8;padding:10px 14px;border-bottom:2px solid #e5e8eb}
.kw-table td{padding:10px 14px;border-bottom:1px solid #e5e8eb}
.kw-table tr:last-child td{border-bottom:none}
.kw-steps{counter-reset:step;max-width:760px;margin:16px 0 20px;padding:0;list-style:none}
.kw-steps li{counter-increment:step;position:relative;padding:0 0 14px 40px;font:400 15px/1.7 Inter,sans-serif;color:#4b525b}
.kw-steps li::before{content:counter(step);position:absolute;left:0;top:1px;width:26px;height:26px;border-radius:50%;background:#ed2028;color:#fff;font:700 13px/26px Inter,sans-serif;text-align:center}
.kw-steps li b{color:#101216}
.kw-check{display:flex;flex-wrap:wrap;gap:10px;margin:16px 0}
.kw-check span{display:inline-flex;align-items:center;gap:6px;font:500 13px Inter,sans-serif;color:#4b525b;background:#f6f7f8;border-radius:6px;padding:6px 12px}
.kw-check span::before{content:"✓";color:#ed2028;font-weight:700}
.kw-h2:not(:first-child){margin-top:clamp(32px,4vw,48px)}
.kw-cta-row{display:flex;flex-wrap:wrap;align-items:center;gap:14px 24px;margin:6px 0 40px}
.kw-cta-row .btn{gap:12px;text-align:center;white-space:normal}
.kw-cta-contact{font:500 14px/1.5 Inter,sans-serif;color:#4b525b}
.kw-cta-contact a{color:#101216;font-weight:700;text-decoration:none;border-bottom:1px solid #ed2028;white-space:nowrap}
.kw-cta-contact a:hover{color:#ed2028}
.kw-media{display:grid;gap:18px}
.kw-table-wrap{max-width:760px;overflow-x:auto;margin:16px 0 22px;border:1px solid #e5e8eb;border-radius:10px}
.kw-table-wrap .kw-table{margin:0;max-width:none}
.kw-table td:first-child{font-weight:600;color:#101216}
.kw-table tr.kw-hl td{background:#fff4f4;color:#101216;font-weight:600}
.kw-table tr.kw-hl td:first-child{box-shadow:inset 3px 0 0 #ed2028}
/* Hero: the heading sits on the page grid with a soft shade behind it; the rest of the photo stays clear. */
.media-detail-hero .hero-overlay{display:block!important;background:linear-gradient(90deg,rgba(5,8,11,.68) 0,rgba(5,8,11,.42) 36%,rgba(5,8,11,0) 66%)}
.inner-page .media-detail-hero .hero-inner{align-items:flex-start!important;width:min(calc(100% - 2 * var(--gx,32px)),var(--content-max,1240px))!important;max-width:none!important;margin-left:auto!important;margin-right:auto!important}
.inner-page .media-detail-hero .hero-inner h1{text-shadow:0 2px 16px rgba(0,0,0,.6)!important}
body .cta .cta-inner{width:min(calc(100% - 2 * var(--gx,32px)),var(--content-max,1240px))!important;max-width:none!important;margin-left:auto!important;margin-right:auto!important}
body.inner-page .cta-inner p{font-size:14px!important;line-height:1.55!important}
body.inner-page .kw-cta-row .btn,body.inner-page .cta-inner .btn{font-size:13px!important;min-height:48px}
@media(min-width:861px){.kw-grid-2>.kw-img,.kw-grid-2>.kw-media{position:sticky;top:110px}}
@media(max-width:860px){.kw-grid-2{grid-template-columns:1fr;gap:24px}.kw-media{grid-template-columns:1fr 1fr;gap:12px}}
@media(max-width:560px){
.kw-stat{flex:1 1 0;min-width:0;padding:12px 14px}
.kw-stat strong{font-size:22px}
.kw-table{font-size:13px}
.kw-table th,.kw-table td{padding:9px 10px}
.kw-cta-row{margin-bottom:30px}
.kw-cta-row .btn{width:100%}
.kw-cta-row .btn,.cta-inner .btn{padding:14px 16px!important;gap:10px!important;letter-spacing:.2px!important;text-wrap:balance}
.kw-h2{font-size:clamp(24px,7.2vw,28px)}
.kw-lead{font-size:16px;line-height:1.65}
.kw-links a{width:100%}
.kw-media{grid-template-columns:1fr;gap:14px}
.kw-media .kw-img{aspect-ratio:16/10}
.kw-media .kw-img img{object-position:center top}
.kw-stack{border:0;border-radius:0;overflow:visible}
.kw-stack thead{position:absolute;width:1px;height:1px;overflow:hidden;clip-path:inset(50%)}
.kw-stack .kw-table,.kw-stack tbody,.kw-stack tr,.kw-stack td{display:block;width:100%}
.kw-stack tr{background:#fff;border:1px solid #e5e8eb;border-radius:10px;padding:14px 16px;margin-bottom:12px}
.kw-stack tr:last-child{margin-bottom:0}
.kw-stack .kw-table td{padding:0;border:0}
.kw-stack .kw-table td:first-child{font:700 16px/1.3 Inter,sans-serif;margin-bottom:10px}
.kw-stack .kw-table td+td+td{margin-top:10px}
.kw-stack td[data-label]::before{content:attr(data-label);display:block;font:700 12px/1.4 Inter,sans-serif;letter-spacing:.03em;text-transform:uppercase;color:#68717b;margin-bottom:2px}
.kw-stack tr.kw-hl{background:#fff4f4;border-color:#f3c1c3;box-shadow:inset 3px 0 0 #ed2028}
.kw-stack .kw-table tr.kw-hl td{background:none;box-shadow:none}
}
@media(max-width:760px){
.media-detail-hero .hero-overlay{background:linear-gradient(0deg,rgba(5,8,11,.8) 0,rgba(5,8,11,.55) 28%,rgba(5,8,11,0) 56%)}
.inner-page .media-detail-hero .hero-inner{flex-direction:column!important;justify-content:flex-end!important;align-items:flex-start!important;padding-bottom:26px!important}
}
</style>
