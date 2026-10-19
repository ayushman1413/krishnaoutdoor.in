# SEO fixes: round 2 report (19 Oct 2026)

Follow-up to `SEO-FIXES-REPORT-2026-10-18.md`. Everything under "Already done" in the brief was left alone.

## Read this first: why the live site still looked unfixed

The repo already contained the section 1 and 2 fixes (titles, descriptions, social tags, new templates, H1s, viewport). The live site did not show them because **the 18 Oct work was never deployed**: the SEO values are written by migrations (production never runs `db:seed`), and Laravel kept serving old compiled views.

To publish everything in this report:

1. `./deploy.sh all` (syncs `laravel/` and `public_html/`, then runs `php artisan migrate --force` and `php artisan optimize:clear`).
2. Four new migrations run (`2026_10_19_000001` to `000004`, all idempotent).
3. The web root is **`public_html/`**, which holds a copy of `laravel/public/` assets. CSS and JS were rebuilt and copied there (`npm run build` in `laravel/`, then copy `public/css` and `public/js` to `public_html/`). Remember this step after any future CSS/JS edit.
4. The WordPress mu-plugin (`public_html/blog/wp-content/mu-plugins/krishna-outdoor-seo.php`) runs on the first blog request after deploy and deletes the default post.

## 1. Rendered-HTML check (local app, fresh DB from migrations)

View-source of every URL below was fetched and parsed. All have their own title, meta description, og:title, og:description, og:image, twitter title/description/image and a self-referencing canonical. Canonicals are shown with the production host (the local run used `http://127.0.0.1:8000`).

| URL | Title | Meta description | og:image | Canonical | H1 | Schema types | In sitemap | Indexable |
|---|---|---|---|---|---|---|---|---|
| / | Outdoor Advertising Agency in Ahmedabad \| Krishna Outdoor | Y | Y | https://krishnaoutdoor.in/ | Outdoor Advertising Agency in Ahmedabad | Organization, WebSite, LocalBusiness, VideoObject, BreadcrumbList | Y | Y |
| /about | About Krishna Outdoor \| OOH Advertising Since 1985 | Y | Y | https://krishnaoutdoor.in/about | About Krishna Outdoor – Outdoor Advertising Since 1985 | Organization, BreadcrumbList | Y | Y |
| /contact | Contact Krishna Outdoor \| Ahmedabad & Mumbai Office | Y | Y | https://krishnaoutdoor.in/contact | Contact Krishna Outdoor – Ahmedabad & Mumbai | Organization, LocalBusiness, BreadcrumbList | Y | Y |
| /services | Outdoor, Transit & Social Media Services \| Krishna Outdoor | Y | Y | https://krishnaoutdoor.in/services | Outdoor, Transit & Social Media Marketing Services | Organization, BreadcrumbList | Y | Y |
| /media/ooh | OOH Media in Gujarat: Hoardings, Unipoles & Bus Shelters | Y | Y | https://krishnaoutdoor.in/media/ooh | Outdoor (OOH) Media in Gujarat: Hoardings & Bus Shelters | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y | Y |
| /media/transit | Transit Advertising Agency in Mumbai \| Bus & Train Ads | Y | Y | https://krishnaoutdoor.in/media/transit | Transit Advertising Agency in Mumbai & Gujarat | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y | Y |
| /our-network | Outdoor Media Network: Gujarat, Mumbai, Thane & Jaipur | Y | Y | https://krishnaoutdoor.in/our-network | Our Outdoor & Transit Media Network | Organization, BreadcrumbList | Y | Y |
| /projects | OOH Campaigns & Case Studies \| Krishna Outdoor | Y | Y | https://krishnaoutdoor.in/projects | Outdoor Advertising Campaigns by Krishna Outdoor | Organization, VideoObject, BreadcrumbList | Y | Y |
| /careers | Careers at Krishna Outdoor \| Join Our OOH Team | Y | Y | https://krishnaoutdoor.in/careers | Careers at Krishna Outdoor | Organization, BreadcrumbList | Y | Y |
| /hoarding-advertising-ahmedabad | Hoarding Advertising in Ahmedabad \| 300+ Own Sites | Y | Y | https://krishnaoutdoor.in/hoarding-advertising-ahmedabad | HOARDING ADVERTISING IN AHMEDABAD | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y | Y |
| /amts-bus-advertising-ahmedabad | AMTS Bus Advertising in Ahmedabad \| 900+ Buses | Y | Y | https://krishnaoutdoor.in/amts-bus-advertising-ahmedabad | AMTS BUS ADVERTISING IN AHMEDABAD | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y | Y |
| /bus-shelter-advertising-ahmedabad | Bus Shelter Advertising in Ahmedabad \| 400+ Backlit Sites | Y | Y | https://krishnaoutdoor.in/bus-shelter-advertising-ahmedabad | BUS SHELTER ADVERTISING IN AHMEDABAD | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y | Y |
| /gsrtc-bus-advertising | GSRTC Bus Advertising \| 7000+ Buses Across Gujarat | Y | Y | https://krishnaoutdoor.in/gsrtc-bus-advertising | GSRTC BUS ADVERTISING ACROSS GUJARAT | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y | Y |
| /outdoor-advertising-agency-mumbai | Outdoor Advertising Agency in Mumbai \| Krishna Outdoor | Y | Y | https://krishnaoutdoor.in/outdoor-advertising-agency-mumbai | OUTDOOR ADVERTISING AGENCY IN MUMBAI | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y | Y |
| /mumbai-local-train-advertising | Mumbai Local Train Advertising \| WR & CR Train Branding | Y | Y | https://krishnaoutdoor.in/mumbai-local-train-advertising | MUMBAI LOCAL TRAIN ADVERTISING | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y | Y |
| /best-bus-advertising-mumbai | BEST Bus Advertising in Mumbai \| 400+ EV Bus Wraps | Y | Y | https://krishnaoutdoor.in/best-bus-advertising-mumbai | BEST BUS ADVERTISING IN MUMBAI | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y | Y |
| /tmt-bus-advertising-thane | TMT Bus Advertising in Thane \| 350+ City Buses | Y | Y | https://krishnaoutdoor.in/tmt-bus-advertising-thane | TMT BUS ADVERTISING IN THANE | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y | Y |
| /social-media-marketing-ahmedabad | Social Media Marketing in Ahmedabad \| Krishna Outdoor | Y | Y | https://krishnaoutdoor.in/social-media-marketing-ahmedabad | SOCIAL MEDIA MARKETING IN AHMEDABAD | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y | Y |
| /social-media-marketing-mumbai | Social Media Marketing Agency in Mumbai \| Krishna Outdoor | Y | Y | https://krishnaoutdoor.in/social-media-marketing-mumbai | SOCIAL MEDIA MARKETING IN MUMBAI | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y | Y |
| /media/digital | DOOH Advertising Agency Ahmedabad \| Digital Billboards | Y | Y | https://krishnaoutdoor.in/media/digital | Digital Out-of-Home (DOOH) Advertising in Ahmedabad | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y | Y |
| /free-site-list | Get a Free Site List \| Krishna Outdoor | Y | Y | https://krishnaoutdoor.in/free-site-list | Get Your Free Site List | Organization, BreadcrumbList | N | N (noindex,follow) |
| /thank-you | Thank You \| Krishna Outdoor | Y | Y | https://krishnaoutdoor.in/thank-you | THANK YOU! | Organization, BreadcrumbList | N | N (noindex,follow) |
| /locations/bhavnagar | Bhavnagar Locations \| Krishna Outdoor | Y | Y | https://krishnaoutdoor.in/locations/bhavnagar | BHAVNAGAR LOCATIONS | Organization, BreadcrumbList | N | N (noindex,follow) |
| /blog/ | OOH Advertising Guides & Insights \| Krishna Outdoor (set by the mu-plugin) | Y (mu-plugin) | not checked | https://krishnaoutdoor.in/blog/ (mu-plugin) | theme | WordPress | N | N (noindex,follow until a post is published) |

**/blog/ was not run locally** (WordPress needs its production database). Its row comes from reading the mu-plugin code, and the WordPress changes are untested. Please open `/blog/` and `/blog/hello-world/` after deploy.

The sitemap lists the 20 static pages plus every active campaign case study (`/projects/{slug}`). It excludes /free-site-list, /thank-you, /blog/ and any location page that fails the new index gate.

Other checks done on the local app:
- Schema: every JSON-LD block parses; required properties are present for Organization, LocalBusiness, Service, FAQPage, BreadcrumbList, WebSite and VideoObject; FAQPage question counts equal the visible FAQ counts; the visible breadcrumb equals the BreadcrumbList on every page that shows one.
- axe-core (WCAG 2 A/AA + best practice, 375 px and 1280 px) on 19 pages: no violations after the contrast fixes below. One H1 per page, no skipped heading levels. No JavaScript errors (the only console noise is the sandbox blocking Google hosts).
- `document.getAnimations()` on every page: no running animation uses a non-composited property.

## 2. Files changed

Counts are for the whole round (`git diff 99ecbe02..HEAD`). Only source files are listed; `public_html/css`, `public_html/js` and `laravel/public/{css,js}/*.min.*` are rebuilt copies.

**PHP / config / routes**
- `laravel/app/Services/SeoResolver.php` (WhatsApp URL by office, office key, forced noindex, description template)
- `laravel/app/Services/SchemaBuilder.php` (public breadcrumb trail shared with the visible breadcrumb)
- `laravel/app/Services/SitemapService.php` (case studies; location pages only when they pass the gate)
- `laravel/app/Services/LocationPageGate.php` (new)
- `laravel/app/Models/Campaign.php` (slug, gallery, SEO row, keyword-page matching)
- `laravel/app/Http/Controllers/Web/CampaignController.php` (new), `Web/FormController.php`, `Web/LocationController.php`
- `laravel/app/Http/Controllers/Admin/CampaignController.php`, `LocationController.php`, `SeoMetaController.php`, `SeoSettingController.php`, `SeoTodoController.php` (new)
- `laravel/app/Providers/AppServiceProvider.php`
- `laravel/config/campaigns.php` (new), `laravel/config/seo_pages.php`
- `laravel/routes/web.php`, `laravel/routes/admin.php`
- `laravel/database/migrations/2026_10_19_000001..000004_*.php` (new)
- `laravel/public/.htaccess`, `public_html/.htaccess`

**Views**
- Layout and shared: `web/layouts/app.blade.php`, `web/layouts/Thank you.blade.php`, `web/common/header.blade.php`, `footer.blade.php`, `enquiry-popup.blade.php`, `plan-campaign-popup.blade.php`, `breadcrumbs.blade.php` (new), `campaigns-block.blade.php` (new), `social-case-studies.blade.php` (new)
- Pages: `home`, `about`, `contact`, `careers`, `services`, `projects`, `network`, `ooh-media`, `digital-media`, `transit-media`, `free-site-list`, `locations`, `category`, `child-category`, `parent-category`, `project-case` (new), and all 10 files in `pages/keywords/`
- Admin: `campaign-create/update`, `location-create/update`, `seo-list`, `seo-settings`, `seo-update`, `todo-list` (new)

**Assets and tooling**
- `laravel/public/css/kr-laravel.css`, `laravel/public/js/kr-laravel.js`, `laravel/public/js/main.js`, `laravel/tools/build-css.mjs` and the rebuilt bundles

**WordPress blog**
- `public_html/blog/wp-content/mu-plugins/krishna-outdoor-seo.php`, `public_html/blog/llms.txt`

## 3. What was done, by brief section

**1 and 2 (titles, social tags, stale pages).** Already in the repo; re-verified in rendered HTML. Nothing hard-coded in the layout. No `maximum-scale` / `user-scalable` anywhere outside WordPress core files. "Outdoor Outdoor" and "Ahmedabad City Buses (TMT)" no longer exist. /media/ooh and /media/digital gained a 3-sentence answer, a formats list, cities covered and links to the keyword pages, using only facts already on the site (TODO comments mark what is missing).

**3 Linking and 4 Conversion.**
- Home has an "Our media" section linking to the five requested pages; the footer has a Services block with all 10 keyword pages; network cards now point to /outdoor-advertising-agency-mumbai (Mumbai), /tmt-bus-advertising-thane (Thane) and /media/ooh (Gujarat). Rajasthan stays on /media/transit.
- Mumbai hub now also links /media/transit and /social-media-marketing-mumbai; the Ahmedabad social page links Home; GSRTC and bus-shelter pages link all siblings.
- Every lead CTA is "Get Free Site List" to /free-site-list (city and media prefilled). "Contact Us" to /contact remains only in the main nav and footer.
- /free-site-list has a WhatsApp button beside the submit button with a prefilled message that updates as city and media change. It uses +91 98796 16411, or +91 99200 11574 for Mumbai/Thane. The form redirects to /thank-you (tested end to end).
- Header: call and WhatsApp icons on mobile and desktop. "Enquire Now" exists once per viewport (JS moves the single button into the mobile drawer at 760 px or less).
- Chat "Call us" uses the Mumbai number on all six Mumbai/Thane pages including /media/transit. Footer shows both offices exactly as given; social links are icons.

**5 Blog, Bhavnagar, typos.**
- Blog mu-plugin now force-deletes the default post (including one an earlier version only trashed). `llms.txt` no longer lists it. noindex,follow, title, description and canonical are in the plugin.
- /locations/bhavnagar: noindex,follow, out of the sitemap, description corrected, H1 period removed. The migration soft-deletes the "ZappDeal India" listing, clears Area "w" and the bot-icon image.
- New rule for every city page (`LocationPageGate`): noindex and no sitemap entry unless all sites have a photo, an area and a size and the page has 300+ words of copy. New admin fields: location Size, and "Page Copy" in the SEO panel.
- H1 trailing full stops and `*` markers are stripped from saved H1s (migration plus on every save and CSV import). The "Ahemdabad" fix migration from round 1 covers every admin table; no instance exists in code.
- The TMT image `tmt-mumbai-bus.webp` is already correctly named. A larger real TMT/Thane photo is still needed (see section 5 below).

**6 Content.**
- Case studies: every campaign now has `/projects/{slug}` with brief, media used, city, gallery, a link to its keyword page and a CTA. They are built from the campaigns stored in the admin, because the real campaign text and photos are not in the repo. Each project card links to its page, and keyword pages list the campaigns they prove (BEST, TMT, Mumbai hub, hoarding) via `config/campaigns.php`. A brand with no matching campaign in the admin is simply not shown.
- Eight keyword pages now have a 2 to 3 sentence answer at the top and 7 FAQs (the two social pages already had 5), every answer starting with the answer. FAQPage schema is generated from the same data.
- /about has a fact sheet (founded 1985, leadership, both offices, rights held).
- Hoarding "locations by area" lists only Ahmedabad hoardings entered in Admin > Locations; AMTS routes appear only when text is entered in the AMTS page's SEO "Page Copy". Social pages show a case-study block only when real "Social Media" campaigns exist. Nothing is invented.
- New **Admin > SEO > Content TODOs** page lists everything still missing. Nothing appears on the public site.

**7 Schema.** Already complete in code. Added: visible breadcrumbs generated from the same trail as the schema (keyword, media, location, category and case-study pages). Service, FAQPage and LocalBusiness are unchanged.

**8 Tracking and accessibility.**
- `click_call`, `click_email`, `click_whatsapp`, `chat_start` come from one delegated listener. The duplicate legacy `phone_click` handlers on /contact and the Mumbai hub were removed. `generate_lead` fires on the popup, contact, plan-campaign and site-list forms (after the redirect). The thank-you page also sends `thank_you_view`.
- GA4 and GTM scripts now load on first interaction or when the browser is idle; events queue in the data layer until then.
- Contrast: raised the remaining sub-4.5:1 greys and reds on /services, /projects, /careers and location pages. Location table scroller is keyboard-focusable. Videos are decorative (`aria-hidden`, muted, no focus), so no caption track was added.

**9 Speed.** Hero poster is requested for the current viewport only (the second poster used to download too); the showcase poster loads near the viewport; the last non-composited animation (`owPulse`) now uses opacity; per-page CSS, lazy chat, gzip/Brotli, long cache and security headers were already in place. The CSRF token is no longer in page HTML: forms fetch it from `/csrf-token` on first focus or submit, so pages carry no per-request token. `.htaccess` also redirects plain-http requests (as reported by `X-Forwarded-Proto`) to https. Full-page caching is not switched on (see section 4).

**10 Images.** No image file names with spaces remain. Admin uploads for campaigns (and gallery photos) are now named from the campaign title (`kala-kendra-bus-wrap.webp`, `-photo-1`, …); SEO og/twitter uploads use the page title. Generic alts replaced (contact, services, social heroes, location hero, category fallbacks). The Rajasthan card no longer shows a Surat bus (neutral city backdrop plus a TODO).

**11 SEO panel.** Verified present: 60/160-character counters, focus keyword, canonical, robots, H1, Google-style preview, per-page checklist, revision history, OG/Twitter fields with upload, per-page JSON-LD, global Organization/LocalBusiness boxes, GA4/GTM/Pixel/custom code, editable robots.txt, per-page sitemap exclusion, redirect manager (CSV import, status toggle), 404 log, CSV export/import, role-based login. Added: description template, page-copy field, Case Studies group, Content TODOs page, (no redirects are pre-seeded; add old URLs from the 404 log or Search Console). Not built: an editable OG URL field (og:url always equals the canonical).

## 4. What I could not do, and why

- **Google Rich Results Test and GA4 DebugView.** The sandbox cannot reach Google or your GA4 property. Schema was validated structurally (script). Events were verified by capturing what the page sends to `gtag`/`dataLayer` in a real browser (click_call, click_whatsapp, click_email, chat_start, generate_lead, thank_you_view all fire). **Please confirm in DebugView:** open the site with `?debug_mode=1` (or the GA Debugger extension), click a phone link, the WhatsApp icon and the chat button, submit /free-site-list, then watch them arrive. Mark `generate_lead` as a key event in GA4 Admin > Events (that, plus the /thank-you page view, is the conversion).
- **PageSpeed.** No internet, so no live PSI. I used Lighthouse 12 (mobile, simulated 4G/CPU throttling) against the local app behind a gzip and cache-header proxy that imitates `.htaccess`. Mobile scores: **home 88 → 98, LCP 3.8 s → 2.1 s**; hoarding page 99 (LCP 2.0 s); /services 94 (LCP 2.5 s); /about 98 (LCP 2.3 s). The "before" is the repo as I found it, measured under the same harness with my linking and footer edits already in. Please re-run PageSpeed Insights on production after deploy; real hosting will differ.
- **Critical-CSS inlining** was not done: the per-page CSS is about 50 KB gzipped and FCP is 1.1 s under simulated 4G, so the added complexity and flash-of-unstyled-content risk did not pay off.
- **Full-page caching** is not enabled. The token is out of the HTML, but the site still sets a session cookie and shows per-session toast messages, so caching HTML needs a decision on those first.
- **WordPress blog**: the plugin changes are syntax-checked only.
- **Case-study photos, names and results**: not in the repo, so not created. The pages render from the admin campaigns.
- **Real photos** (TMT hero, Jaipur bus, DOOH screen) cannot be invented.

## 5. Needs input from you or the client

All of these also appear in Admin > SEO > Content TODOs where applicable.

1. **Opening hours** for both offices (`laravel/config/business.php`, needed for LocalBusiness schema).
2. **Mumbai map pin** (latitude and longitude) in `business.php`; the `/contact` embed centre is in the sea.
3. **Campaign data in Admin > Our Work**: confirm campaigns named Kala-Kendra, Shree Swaminarayan, Prefr, Fashionism, Aluminium Bharat, Ambuja Cement, Doraemon and Torrent Power exist (names are matched loosely); add real photos, descriptions and optional gallery photos. Without a match, the "Campaigns we have run" block stays hidden.
4. **Social media case studies**: at least 2 per city (media type "Social Media"), with client-approved results.
5. **Real location inventory**: Ahmedabad hoardings (area, size, photo), and for any city page to be indexed: 300+ words of copy and complete sites. A map also needs coordinates per site, which the site does not store.
6. **AMTS routes and areas**: paste into Admin > SEO > Amts bus advertising > Page Copy.
7. **Photos**: real TMT/Thane bus photo (hero, plus a larger version of the small one), Jaipur/Rajasthan bus photo, DOOH screen photo; descriptive alt text and locations for existing hoarding images (I did not guess locations).
8. **DOOH facts**: number, locations and sizes of screens; list of Gujarat cities for hoardings, unipoles and gantries.
9. **Video upload dates** (`business.php` > videos) for VideoObject.
10. **GTM container ID** (GA4 `G-H76CYYJE3S` is set; GTM is empty). **WhatsApp number**: WhatsApp links currently use the two office numbers; confirm they are WhatsApp-enabled or set a different Ahmedabad number in SEO Settings.
11. **Booking terms in existing FAQs** (one-month minimum for AMTS, 3 to 4 weeks lead time for local trains): these were on the site before this round; please confirm they are true.

## 6. Security finding (not changed)

Two sensitive files are committed to this git repository: `laravel/.env` (mail password, default admin password) and `public_html/blog/wp-config.php` (database credentials and salts). Remove them from git history and rotate those credentials, especially if the repository is shared.

## 7. Verification summary

- **Schema:** structural validation script over 22 URLs plus a case study: all pass.
- **Events:** Playwright against the running app, recording the data layer (see above).
- **Speed:** Lighthouse mobile, numbers above.
- **Forms:** /free-site-list and the enquiry popup submitted end to end with the lazy token, redirect to /thank-you confirmed.
- **Admin:** logged in as the seeded admin; campaign create with gallery upload (file names come from the title), SEO list, Content TODOs, settings and location forms all load.
- Local setup used SQLite built from migrations only (as production), PHP's built-in server and headless Chromium.

## 8. Addendum (title and description safeguard)

- New `SeoHealth` check: the SEO panel list now has a "Check" column that flags an empty title or description (error) and a title outside 30-60 or description outside 140-160 characters (warning). The sitemap skips and logs any indexable page whose title or description is empty, so a blank record cannot reach search engines silently (tested by blanking /about: it left the sitemap, then returned).
- Lengths of all seeded values: every title is 38-58 characters. Every description is 143-151 characters except **/careers, which is 122** (the exact text supplied in the brief). I kept the supplied wording rather than invent more copy; a 140+ character version needs your approval.
