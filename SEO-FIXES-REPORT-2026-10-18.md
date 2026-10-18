# SEO fixes — implementation report (18 Oct 2026)

Follow-up to `SEO-AUDIT-2026.md`. Covers tasks 1–9 from the 18 Oct live check.

## How to deploy

1. `./deploy.sh all` — syncs code, then runs `php artisan migrate --force` and `php artisan optimize:clear` on the server.
   (Or upload and visit `public_html/deploy-migrate.php` once, then delete it.)
2. Delete any static `public_html/sitemap.xml` / `robots.txt` on the server (the new `.htaccess` already routes both to Laravel).
3. In hPanel, keep **Force HTTPS** on (the `.htaccess` sends HSTS and redirects www → non-www).
4. After editing CSS or JS sources: `cd laravel && npm install && npm run build`, then commit the generated `bundle-*.min.css` / `*.min.js`.

## Why titles showed "Krishna Outdoor"

The SEO values were only ever written by a seeder, and production only runs migrations, so `seo_meta` was empty on the live site.
Migration `2026_10_18_000001` now writes them. The three "old version" pages were stale compiled Blade views: the repo already
had the new templates, but the deploy never cleared Laravel's view cache. `deploy.sh` now does.

## Verification (local Apache + PHP, APP_ENV=production, fresh database with migrations only)

| URL | Title | Meta description | Canonical | H1 | Schema types | In sitemap |
|---|---|---|---|---|---|---|
| / | Outdoor Advertising Agency in Ahmedabad \| Krishna Outdoor | Y | https://krishnaoutdoor.in/ | Outdoor Advertising Agency in Ahmedabad | Organization, WebSite, LocalBusiness, VideoObject, BreadcrumbList | Y |
| /about | About Krishna Outdoor \| OOH Advertising Since 1985 | Y | https://krishnaoutdoor.in/about | About Krishna Outdoor – Outdoor Advertising Since 1985 | Organization, BreadcrumbList | Y |
| /contact | Contact Krishna Outdoor \| Ahmedabad & Mumbai Office | Y | https://krishnaoutdoor.in/contact | Contact Krishna Outdoor – Ahmedabad & Mumbai | Organization, LocalBusiness, BreadcrumbList | Y |
| /services | Outdoor, Transit & Social Media Services \| Krishna Outdoor | Y | https://krishnaoutdoor.in/services | Outdoor, Transit & Social Media Marketing Services | Organization, BreadcrumbList | Y |
| /media/ooh | OOH Media in Gujarat: Hoardings, Unipoles & Bus Shelters | Y | https://krishnaoutdoor.in/media/ooh | Outdoor (OOH) Media in Gujarat: Hoardings & Bus Shelters | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y |
| /media/transit | Transit Advertising Agency in Mumbai \| Bus & Train Ads | Y | https://krishnaoutdoor.in/media/transit | Transit Advertising Agency in Mumbai & Gujarat | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y |
| /media/digital | DOOH Advertising Agency Ahmedabad \| Digital Billboards | Y | https://krishnaoutdoor.in/media/digital | Digital Out-of-Home (DOOH) Advertising in Ahmedabad | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y |
| /our-network | Outdoor Media Network: Gujarat, Mumbai, Thane & Jaipur | Y | https://krishnaoutdoor.in/our-network | Our Outdoor & Transit Media Network | Organization, BreadcrumbList | Y |
| /projects | OOH Campaigns & Case Studies \| Krishna Outdoor | Y | https://krishnaoutdoor.in/projects | Outdoor Advertising Campaigns by Krishna Outdoor | Organization, VideoObject, BreadcrumbList | Y |
| /careers | Careers at Krishna Outdoor \| Join Our OOH Team | Y | https://krishnaoutdoor.in/careers | Careers at Krishna Outdoor | Organization, BreadcrumbList | Y |
| /hoarding-advertising-ahmedabad | Hoarding Advertising in Ahmedabad \| 300+ Own Sites | Y | https://krishnaoutdoor.in/hoarding-advertising-ahmedabad | HOARDING ADVERTISING IN AHMEDABAD | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y |
| /amts-bus-advertising-ahmedabad | AMTS Bus Advertising in Ahmedabad \| 900+ Buses | Y | https://krishnaoutdoor.in/amts-bus-advertising-ahmedabad | AMTS BUS ADVERTISING IN AHMEDABAD | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y |
| /bus-shelter-advertising-ahmedabad | Bus Shelter Advertising in Ahmedabad \| 400+ Backlit Sites | Y | https://krishnaoutdoor.in/bus-shelter-advertising-ahmedabad | BUS SHELTER ADVERTISING IN AHMEDABAD | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y |
| /gsrtc-bus-advertising | GSRTC Bus Advertising \| 7000+ Buses Across Gujarat | Y | https://krishnaoutdoor.in/gsrtc-bus-advertising | GSRTC BUS ADVERTISING ACROSS GUJARAT | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y |
| /outdoor-advertising-agency-mumbai | Outdoor Advertising Agency in Mumbai \| Krishna Outdoor | Y | https://krishnaoutdoor.in/outdoor-advertising-agency-mumbai | OUTDOOR ADVERTISING AGENCY IN MUMBAI | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y |
| /mumbai-local-train-advertising | Mumbai Local Train Advertising \| WR & CR Train Branding | Y | https://krishnaoutdoor.in/mumbai-local-train-advertising | MUMBAI LOCAL TRAIN ADVERTISING | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y |
| /best-bus-advertising-mumbai | BEST Bus Advertising in Mumbai \| 400+ EV Bus Wraps | Y | https://krishnaoutdoor.in/best-bus-advertising-mumbai | BEST BUS ADVERTISING IN MUMBAI | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y |
| /tmt-bus-advertising-thane | TMT Bus Advertising in Thane \| 350+ City Buses | Y | https://krishnaoutdoor.in/tmt-bus-advertising-thane | TMT BUS ADVERTISING IN THANE | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y |
| /social-media-marketing-ahmedabad | Social Media Marketing in Ahmedabad \| Krishna Outdoor | Y | https://krishnaoutdoor.in/social-media-marketing-ahmedabad | SOCIAL MEDIA MARKETING IN AHMEDABAD | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y |
| /social-media-marketing-mumbai | Social Media Marketing Agency in Mumbai \| Krishna Outdoor | Y | https://krishnaoutdoor.in/social-media-marketing-mumbai | SOCIAL MEDIA MARKETING IN MUMBAI | Organization, LocalBusiness, Service, FAQPage, BreadcrumbList | Y |
| /free-site-list | Get a Free Site List \| Krishna Outdoor | Y | https://krishnaoutdoor.in/free-site-list | Get Your Free Site List | Organization, BreadcrumbList | N (noindex) |


- sitemap.xml: 20 URLs, all `https://krishnaoutdoor.in/...`, each with `<lastmod>`; no `tel:`, `http:` or `#` entries; /blog/ and /free-site-list excluded.
- og:title / og:description / twitter:title / twitter:description present on every page; og:image falls back to `/assets/images/og/og-default.jpg`.
- JSON-LD parses on every page; FAQPage questions match the FAQ shown on the page. Not run through Google's Rich Results Test (no internet access from the build environment) — please run it after deploy.
- axe-core (WCAG 2 A/AA + best practice): no violations on the 21 pages at 375px and 1280px; one H1 per page, no skipped heading levels.
- Lighthouse mobile (local Apache, gzip): home 37 → 81 (LCP 9.3 s → 4.2 s, TBT 1.3 s → 0.24 s, 20 MB → 0.7 MB); hoarding page 60 → 96 (LCP 2.7 s); /services 88 (LCP 3.0 s).

## Needs your input (TODOs left in code)

| Item | Where |
|---|---|
| Mumbai office map pin (lat/lng). The /contact embed centre (19.1386, 72.7552) is in the sea west of Andheri, so `geo` is omitted for Mumbai. | `laravel/config/business.php` |
| Opening hours for both offices (the thank-you page says Mon–Sat 10:00–18:00; confirm before it goes into schema). | `laravel/config/business.php` |
| WhatsApp number (link is hidden until set). | Admin → SEO Settings |
| GTM ID (GA4 `G-H76CYYJE3S` was kept from the old hard-coded tag). | Admin → SEO Settings |
| Video upload dates (Google requires `uploadDate` for video rich results). | `laravel/config/business.php` → `videos` |
| Real photos: high-res TMT/Thane bus (TMT hero currently a BEST bus), a Jaipur/Rajasthan bus (network card shows a Surat bus), a DOOH screen photo for /media/digital. | TODO comments in the Blade views |
