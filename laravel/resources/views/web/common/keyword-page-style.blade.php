<style>
.kw-crumbs{font:600 11px Inter,sans-serif;letter-spacing:.04em;color:#68717b;margin:0 0 18px;text-transform:uppercase}
.kw-crumbs a{color:#ed2028;text-decoration:none}
.kw-crumbs a:hover{text-decoration:underline}
.kw-crumbs span{margin:0 6px;color:#aab0b7}
.kw-section{padding:54px 0}
.kw-section-alt{background:#f6f7f8}
.kw-inner{width:min(1180px,92%);margin:0 auto}
.kw-h2{font:700 clamp(28px,3.6vw,42px)/1.08 Oswald,sans-serif;text-transform:uppercase;letter-spacing:-.02em;margin:0 0 16px;color:#101216}
.kw-h2 em{font-style:normal;color:#ed2028}
.kw-h3{font:700 18px/1.3 Oswald,sans-serif;text-transform:uppercase;letter-spacing:-.01em;margin:22px 0 8px;color:#101216}
.kw-p{font:400 15px/1.7 Inter,sans-serif;color:#4b525b;margin:0 0 14px;max-width:760px}
.kw-grid-2{display:grid;grid-template-columns:1.1fr .9fr;gap:36px;align-items:start}
.kw-list{margin:0 0 16px;padding-left:20px;color:#4b525b;font:400 15px/1.8 Inter,sans-serif}
.kw-list li{margin-bottom:6px}
.kw-stat-row{display:flex;flex-wrap:wrap;gap:14px;margin:18px 0 22px}
.kw-stat{background:#fff;border:1px solid #e5e8eb;border-radius:8px;padding:14px 18px;min-width:140px;box-shadow:0 4px 14px rgba(16,18,22,.04)}
.kw-stat strong{display:block;font:700 26px Oswald,sans-serif;color:#ed2028;line-height:1}
.kw-stat span{display:block;font:500 11px Inter,sans-serif;color:#68717b;text-transform:uppercase;letter-spacing:.03em;margin-top:4px}
.kw-img{width:100%;border-radius:10px;overflow:hidden;box-shadow:0 14px 36px rgba(16,18,22,.1)}
.kw-img img{width:100%;height:100%;object-fit:cover;display:block}
.kw-links{display:flex;flex-wrap:wrap;gap:10px;margin:18px 0 6px}
.kw-links a{font:600 12px Inter,sans-serif;color:#101216;background:#fff;border:1px solid #d9dde2;border-radius:6px;padding:9px 14px;text-decoration:none;transition:.25s}
.kw-links a:hover{border-color:#ed2028;color:#ed2028}
.kw-faq{max-width:820px}
.kw-faq details{border-bottom:1px solid #e5e8eb;padding:14px 0}
.kw-faq summary{font:700 14px Inter,sans-serif;color:#101216;cursor:pointer;list-style:none;display:flex;justify-content:space-between;align-items:center;gap:12px}
.kw-faq summary::-webkit-details-marker{display:none}
.kw-faq summary:after{content:"+";font-size:20px;color:#ed2028;flex:0 0 auto}
.kw-faq details[open] summary:after{content:"\2212"}
.kw-faq p{font:400 14px/1.7 Inter,sans-serif;color:#565d66;margin:10px 0 0}
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
.kw-cta-contact a{color:#101216;font-weight:700;text-decoration:none;border-bottom:1px solid #ed2028}
.kw-cta-contact a:hover{color:#ed2028}
.kw-media{display:grid;gap:18px}
.kw-table-wrap{max-width:760px;overflow-x:auto;margin:16px 0 22px;border:1px solid #e5e8eb;border-radius:10px}
.kw-table-wrap .kw-table{margin:0;max-width:none}
.kw-table td:first-child{font-weight:600;color:#101216}
.kw-table tr.kw-hl td{background:#fff4f4;color:#101216;font-weight:600}
.kw-table tr.kw-hl td:first-child{box-shadow:inset 3px 0 0 #ed2028}
@media(min-width:861px){.kw-grid-2>.kw-img,.kw-grid-2>.kw-media{position:sticky;top:110px}}
@media(max-width:860px){.kw-grid-2{grid-template-columns:1fr}.kw-media{grid-template-columns:1fr 1fr;gap:12px}}
@media(max-width:560px){
.kw-stat{flex:1 1 0;min-width:0;padding:12px 14px}
.kw-stat strong{font-size:22px}
.kw-table{font-size:13px}
.kw-table th,.kw-table td{padding:9px 10px}
.kw-cta-row{margin-bottom:30px}
.kw-cta-row .btn{width:100%}
}
</style>
