# Technical & Strategic SEO Audit — krishnaoutdoor.in

**Prepared by:** SEO Tape Business Solutions
**Date:** 14 October 2026
**Scope:** Outdoor & transit advertising, Ahmedabad, Gujarat & Mumbai

## Headline scores

| Metric | Score |
|---|---|
| PageSpeed mobile performance | 73 |
| PageSpeed SEO score | 100 |
| GTmetrix grade | B |
| Client keywords with a dedicated page | 1 / 12 |

---

## Table of contents

1. Executive summary
2. Technical SEO
3. On-page SEO
4. Off-page & local
5. AI search visibility
6. User experience
7. New pages (10 recommended, with outlines)
8. Competitor benchmarking
9. Priority action plan
10. Data needed
11. Conclusion & next steps
12. Appendix — pages crawled and sources

*Note: no previous audit was shared, so "wins" reflect the current state of the site rather than progress since a past audit.*

---

## 1. Executive summary

### SEO health snapshot

**Google PageSpeed Insights — Mobile (14 Oct 2026)**

| Performance | Accessibility | Best practices | SEO |
|---|---|---|---|
| 73 | 87 | 96 | 100 |

**GTmetrix — Seattle test server (14 Oct 2026)**

| GTmetrix grade | Performance | Structure | Agentic browsing (PSI) |
|---|---|---|---|
| B | 76% | 85% | 1/2 |

*Neither tool produces one overall "SEO score"; the verdict below is SEO Tape's assessment from the scores plus a full site crawl.*

### Verdict

- **Technical basics pass.** Lighthouse finds no basic SEO errors and layout is stable (CLS 0).
- **Mobile speed lags.** Largest Contentful Paint appears at 4.8s on mobile — Google's "good" mark is 2.5s.
- **Housekeeping errors.** `sitemap.xml` lists phone numbers as pages, `robots.txt` points to the homepage instead of the sitemap, and two pages have no meta description.
- **Ranking pages are missing.** Of the client's 12 target keywords, only "outdoor advertising Ahmedabad" has a page built for it. Aggregators own most of the rest.

### What is working well today

- Lighthouse SEO score of 100; GTmetrix LCP 969ms on desktop; CLS 0
- HTTPS everywhere; http and www redirect to `https://krishnaoutdoor.in`
- Unique titles and meta descriptions on 9 of 11 pages, including the rebuilt About and Contact pages
- Organization + BreadcrumbList schema on main pages; LocalBusiness on Contact
- All images have alt text; no broken internal links found
- Images already in WebP format
- Strong proof points: 2000+ hoarding sites, 7000+ GSRTC and 900+ AMTS bus rights, 8 campaign summaries

### Fix now

| Priority | Issue | Detail |
|---|---|---|
| HIGH | Build pages for the 12 client keywords | Only 1 of 12 target keywords has a dedicated page today |
| HIGH | Speed up mobile loading | FCP 3.6s, LCP 4.8s, 7,862 KiB page weight |
| HIGH | Fix sitemap.xml and robots.txt | Sitemap lists phone numbers as pages; robots points to the homepage |
| MED | Retarget titles, metas and H1s to the keywords | Home has no H1; Transit title says Ahmedabad; Network & Blog lack a meta |
| MED | Settle the Mumbai address | Network page says Lower Parel; Contact page says Andheri West |
| MED | Remove the placeholder blog | `/blog/` shows WordPress's default "Hello world" post |

---

## 2. Technical SEO

### Core Web Vitals: desktop is fine, mobile is slow

| Metric | PSI mobile (lab) | GTmetrix (desktop) | Google "good" | Status |
|---|---|---|---|---|
| First Contentful Paint | 3.6s | Not in screenshot | ≤ 1.8s | HIGH |
| Largest Contentful Paint | 4.8s | 969ms | ≤ 2.5s | HIGH |
| Total Blocking Time | 110ms | 330ms | ≤ 200ms | MED |
| Cumulative Layout Shift | 0 | 0 | ≤ 0.1 | LOW |
| Speed Index | 4.3s | Not in screenshot | ≤ 3.4s | MED |
| INP (responsiveness) | No field data | Not reported | ≤ 200ms | DATA NEEDED |

*PSI shows "No Data" for real-user experience, so INP and real-user LCP cannot be reported yet. FID has been replaced by INP as a Core Web Vital.*

**What this means:** On a phone over 4G, visitors see a black hero area for several seconds before content appears (per the PSI filmstrip). The desktop GTmetrix test is fast, so the problem is mobile weight — the hero video, large images and render-blocking files — not the server.

### Where the mobile speed is being lost

| PageSpeed finding | Reported saving / size | Plain-English fix | Priority |
|---|---|---|---|
| Render-blocking requests | Est. 1,050ms | Inline critical CSS; load other CSS and JS with defer/async | HIGH |
| Avoid enormous network payloads | Total 7,862 KiB | Use a poster image for the hero video and load the video after the page appears; serve a light mobile video | HIGH |
| Improve image delivery | Est. 406 KiB | Resize images to display size; lazy-load below-the-fold images | HIGH |
| Minimise main-thread work | 4.3s | Trim sliders/animations and the chat widget script on first load | MED |
| Use efficient cache lifetimes | Est. 108 KiB | Set long cache headers for `/assets/` images, CSS, JS, fonts | MED |
| Reduce unused JavaScript | Est. 72 KiB | Split scripts per page; load the chat widget on interaction | MED |
| Reduce unused CSS | Est. 55 KiB | Remove unused rules; split CSS per template | MED |
| Minify CSS | Est. 14 KiB | Enable minification in the build | LOW |
| Long main-thread tasks | 3 found | Break up long scripts | LOW |
| Non-composited animations | 11 elements | Animate transform/opacity only | LOW |

*Also flagged by PSI: "Network dependency tree" (chained requests). "Optimize DOM size", "LCP breakdown" and "3rd parties" were listed without values in the screenshot — see Data needed.*

### Crawlability & indexability

**`robots.txt` — current:**

```
User-agent: *
Disallow:
Disallow: /cgi-bin/
Sitemap: https://krishnaoutdoor.in/
```

The Sitemap line points to the homepage, not the sitemap file. Change to:
`Sitemap: https://krishnaoutdoor.in/sitemap.xml`

**`sitemap.xml` — 13 entries, 3 of them wrong:**

```
http://krishnaoutdoor.in/tel:+919879616411
http://krishnaoutdoor.in/tel:+919920011574
http://krishnaoutdoor.in/
```

Phone links are listed as pages, there's an http duplicate of Home, there are no `<lastmod>` dates, and `/blog/` is missing entirely.

**Other crawl checks:**

| Check | Finding | Status |
|---|---|---|
| Indexing directive | index, follow on main pages | LOW |
| Canonical tags | Present on 9 pages; missing on Careers and Blog | MED |
| og:title vs `<title>` | Differ on About, Contact, Projects, Careers | LOW |
| http / www versions | Redirect to https non-www | LOW |
| 404 handling | Returns a real 404 status | LOW |
| Broken internal links | None found in a live check | LOW |
| Blog (WordPress) | Default "Hello world" post indexable | MED |
| Index coverage | Needs Search Console access | DATA NEEDED |

### Mobile, accessibility, HTTPS and URL hygiene

**Mobile responsiveness**
- Responsive layout with a separate mobile hero video
- Viewport blocks pinch-zoom (`maximum-scale=1.0, user-scalable=no`) on all new pages — flagged by PSI
- Visible text in hero is slow to appear on 4G

**Accessibility (score 87)**
- `[aria-hidden="true"]` elements contain focusable items
- Text/background colour contrast fails in places
- Videos have no captions track
- PSI Agentic: accessibility tree not well-formed (affects AI agents)

**SSL / HTTPS & best practices (96)**
- Valid HTTPS; http→https and www→non-www redirects work
- Browser console errors logged — investigate
- No CSP, HSTS, COOP or XFO headers reported (security hardening)

**URLs, files & links**
- Clean, short URLs (`/media/ooh`, `/our-network`)
- Image files with spaces: "Transit Banner.webp", "tmt mumbai bus.webp", "Media 5.webp", "Carrer f3.webp"
- No broken internal links found (live check)

### Structured data

Checked live: Organization and BreadcrumbList schema run on 9 main pages and LocalBusiness on Contact. Careers and Blog carry none. (The brief's EducationalOrganization schema does not apply to an advertising business.)

| Schema type | Status today | Recommended action | Priority |
|---|---|---|---|
| Organization | Present on 9 pages | Add sameAs (3 social profiles), foundingDate 1985 and logo if missing | LOW |
| LocalBusiness – Ahmedabad | On Contact; address & phone, no geo or hours | Add geo coordinates, opening hours, areaServed and map link | MED |
| LocalBusiness – Mumbai | Missing | Add a second LocalBusiness once the Mumbai address is confirmed | HIGH |
| Service (with areaServed) | Missing | Add to OOH, Transit, Digital and all 10 new keyword pages | HIGH |
| FAQPage | Missing | Add alongside FAQ sections on keyword pages | MED |
| BreadcrumbList | Present on 9 pages | Add to Careers and every new page | LOW |
| WebSite / VideoObject | Missing | WebSite on Home; VideoObject for hero and showcase videos | LOW |

---

## 3. On-page SEO

### Client target keywords: one page for each

| # | Target keyword (client) | Market | Assigned page | Today | Action |
|---|---|---|---|---|---|
| 1 | outdoor advertising Ahmedabad | Ahmedabad | `/` (Home) | Title targets it; no H1, thin copy | RETARGET |
| 2 | hoarding advertising Ahmedabad | Ahmedabad | `/hoarding-advertising-ahmedabad` | Only the thin `/media/ooh` page | NEW PAGE |
| 3 | AMTS bus advertising | Ahmedabad | `/amts-bus-advertising-ahmedabad` | One line on Transit page | NEW PAGE |
| 4 | bus shelter advertising Ahmedabad | Ahmedabad | `/bus-shelter-advertising-ahmedabad` | One line on OOH page | NEW PAGE |
| 5 | GSRTC bus advertising | Gujarat | `/gsrtc-bus-advertising` | One line on Transit page | NEW PAGE |
| 6 | outdoor advertising agency in Mumbai | Mumbai | `/outdoor-advertising-agency-mumbai` | Mumbai only on Network page | NEW PAGE |
| 7 | Mumbai local train advertising | Mumbai | `/mumbai-local-train-advertising` | One line on Transit page | NEW PAGE |
| 8 | BEST bus advertising Mumbai | Mumbai | `/best-bus-advertising-mumbai` | Only as project cards | NEW PAGE |
| 9 | TMT bus advertising (Thane / Mumbai) | Thane | `/tmt-bus-advertising-thane` | One line on Transit page | NEW PAGE |
| 10 | transit advertising agency Mumbai | Mumbai | `/media/transit` | Title says "Ahmedabad" | RETARGET |
| 11 | social media marketing in Ahmedabad | Ahmedabad | `/social-media-marketing-ahmedabad` | One paragraph on Services | NEW PAGE |
| 12 | social media marketing in Mumbai | Mumbai | `/social-media-marketing-mumbai` | Nothing | NEW PAGE |

Only keyword 1 has a page built for it today. Keywords are as supplied by the client, with spelling normalised ("Tmt bus in Mumbai thane" → TMT bus advertising Thane/Mumbai; "transit advertising in agency mumbai" → transit advertising agency Mumbai). Current Google positions and monthly search volumes: **Data needed**.

### How the 12 keywords fit together on the site

**Ahmedabad & Gujarat hub**
1. outdoor advertising Ahmedabad → `/` (Home)
2. hoarding advertising Ahmedabad → `/hoarding-advertising-ahmedabad`
3. AMTS bus advertising → `/amts-bus-advertising-ahmedabad`
4. bus shelter advertising Ahmedabad → `/bus-shelter-advertising-ahmedabad`
5. GSRTC bus advertising → `/gsrtc-bus-advertising`

**Mumbai hub**
1. outdoor advertising agency in Mumbai → `/outdoor-advertising-agency-mumbai`
2. Mumbai local train advertising → `/mumbai-local-train-advertising`
3. BEST bus advertising Mumbai → `/best-bus-advertising-mumbai`
4. TMT bus advertising Thane → `/tmt-bus-advertising-thane`
5. transit advertising agency Mumbai → `/media/transit`

**Social media marketing** (linked from `/services`, Digital section)
1. social media marketing in Ahmedabad → `/social-media-marketing-ahmedabad`
2. social media marketing in Mumbai → `/social-media-marketing-mumbai`

*Different battle: these two keywords compete with digital agencies, not OOH firms. Win with "outdoor + social" campaigns and real social media case studies.*

**Rules:** one primary keyword per page, so pages never compete with each other. Each hub links to all its pages and each page links back. Home keeps Ahmedabad; Mumbai gets its own hub page.

### Current titles and meta descriptions

*Checked live in Chrome on 14 Oct 2026 (4pm IST), bypassing cache. Status = how urgently the tags need work. Ideal: title up to 60 characters, description 140–160.*

| Page | Current title (chars) | Current meta description (chars) | Status | Note |
|---|---|---|---|---|
| Home `/` | Outdoor Advertising Agency Ahmedabad \| Hoardings & DOOH (55) | Top outdoor advertising agency in Ahmedabad since 1985. Hoardings, DOOH, billboards & transit media. Get a free site availability list today! (141) | LOW | Good. No H1 on page |
| About `/about` | Outdoor Advertising Company Since 1985 \| About Krishna Outdoor (62) | 43+ years of outdoor advertising experience in Ahmedabad & Mumbai. Discover our journey, expertise, and commitment to impactful OOH campaigns. (142) | LOW | Good; title 2 chars over 60 |
| Contact `/contact` | Contact Krishna Outdoor \| Ahmedabad & Mumbai Office (51) | Get in touch for your next outdoor advertising campaign. Call, email, or visit our Ahmedabad or Mumbai office for a free site availability list. (144) | LOW | Good |
| Services `/services` | Hoarding, DOOH & Transit Media Advertising Ahmedabad (52) | Explore hoarding advertising, digital out-of-home (DOOH), transit media & bus shelter ads across Ahmedabad and Mumbai. Trusted OOH solutions since 1985. (152) | MED | No social media mention |
| OOH `/media/ooh` | Hoarding Advertising Ahmedabad \| OOH Media Sites (48) | Premium hoarding and OOH media sites across Ahmedabad. Strategically positioned outdoor advertising formats for maximum brand visibility. (137) | MED | Will clash with new hoarding page |
| Transit `/media/transit` | Transit Advertising Ahmedabad \| Bus & Train Media (49) | Transit advertising on buses, trains & bus shelters in Ahmedabad and Mumbai. Capture attention with mobile outdoor advertising that's always on the move. (153) | HIGH | Client keyword is Mumbai |
| Digital `/media/digital` | DOOH Advertising Agency Ahmedabad \| Digital Billboards (54) | Digital out-of-home (DOOH) advertising in Ahmedabad. Reach your audience with dynamic digital billboards and screens across prime city locations. (145) | LOW | Good; no client keyword |
| Our Network `/our-network` | Outdoor Advertising Network \| Krishna Outdoor (45) | Missing | HIGH | Meta description missing |
| Projects `/projects` | Our Outdoor Advertising Projects \| Krishna Outdoor (50) | See our completed outdoor advertising projects: hoardings, video walls, bus shelters & train branding across Ahmedabad and Mumbai. (130) | LOW | og:title differs from title |
| Careers `/careers` | Careers at Krishna Outdoor \| Join Our OOH Team (46) | Explore career opportunities at Krishna Outdoor, a leading outdoor advertising company in Ahmedabad and Mumbai since 1985. (122) | MED | No canonical tag |
| Blog `/blog/` | Blog (4) | Missing | HIGH | Placeholder; no meta, no canonical |

### Recommended titles and descriptions: existing pages

| Page | Target keyword | Recommended title (chars) | Recommended meta description (chars) |
|---|---|---|---|
| Home | outdoor advertising Ahmedabad | Outdoor Advertising Agency in Ahmedabad \| Krishna Outdoor (57) | Outdoor advertising in Ahmedabad since 1985: 2000+ hoardings, AMTS and GSRTC bus ads, bus shelters and DOOH. Get a free site availability list today. (149) |
| About | brand | About Krishna Outdoor \| OOH Advertising Since 1985 (50) | Since 1985, Krishna Outdoor has built brand visibility with hoardings, bus and train advertising across Ahmedabad, Gujarat and Mumbai. Meet our team. (149) |
| Contact | brand + both cities | Contact Krishna Outdoor \| Ahmedabad & Mumbai Office (51) | Contact our Ahmedabad and Mumbai offices for hoarding, bus shelter, bus and local train advertising. Call +91 98796 16411 for a free site list today. (149) |
| Services | umbrella (incl. social media) | Outdoor, Transit & Social Media Services \| Krishna Outdoor (58) | Hoardings, AMTS and GSRTC bus ads, bus shelters, Mumbai local train and BEST bus branding, plus social media marketing in Ahmedabad and Mumbai. (143) |
| OOH | hub → hoarding & shelter pages | OOH Media in Gujarat: Hoardings, Unipoles & Bus Shelters (56) | Explore 2000+ hoarding sites across Gujarat, 300+ own hoardings in Ahmedabad, 400+ backlit bus shelters, unipoles and gantries. Check availability. (147) |
| Transit | transit advertising agency Mumbai | Transit Advertising Agency in Mumbai \| Bus & Train Ads (54) | Transit advertising agency for Mumbai local trains, BEST and TMT buses, plus GSRTC and AMTS buses in Gujarat. Rights on 7000+ buses. Enquire today. (147) |
| Digital | (no client keyword) | Keep current title | Keep current description |
| Our Network | supports all city keywords | Outdoor Media Network: Gujarat, Mumbai, Thane & Jaipur (54) | See our network: 2000+ Gujarat hoardings, 7000+ GSRTC buses, AMTS, BEST and TMT buses and Mumbai local trains. Explore media availability today. (144) |
| Projects | supports all keywords | OOH Campaigns & Case Studies \| Krishna Outdoor (46) | Hoarding, BEST bus, TMT bus and Mumbai local train campaigns for brands like Ambuja Cement, Torrent Power and Prefr across Ahmedabad and Mumbai. (144) |
| Careers | brand | Keep current title (add canonical) | Keep current description |
| Blog | informational | OOH Advertising Guides & Insights \| Krishna Outdoor (51) | Guides on hoarding, bus and train advertising in Ahmedabad and Mumbai: costs, planning tips and campaign ideas from the Krishna Outdoor team. (141) |

*OOH is turned into a hub so it does not compete with the new "hoarding advertising Ahmedabad" page. Transit takes "transit advertising agency Mumbai". Home keeps Ahmedabad; Mumbai gets its own page.*

### Heading hierarchy: every H1 is a slogan, Home has none

| Page | Current H1 (live) | Recommended H1 |
|---|---|---|
| Home | None — no H1 on the page | Outdoor Advertising Agency in Ahmedabad |
| About | A LEGACY BUILT AROUND HOW BRANDS ARE SEEN. | About Krishna Outdoor – Outdoor Advertising Since 1985 |
| Contact | LET'S START WITH A CONVERSATION. | Contact Krishna Outdoor – Ahmedabad & Mumbai |
| Services | ONE PARTNER. MULTIPLE MEDIA. ONE CLEAR OBJECTIVE. | Outdoor, Transit & Social Media Marketing Services |
| OOH | OUTDOOR (OOH) MEDIA. | Outdoor (OOH) Media in Gujarat: Hoardings & Bus Shelters |
| Transit | TRANSIT MEDIA. | Transit Advertising Agency in Mumbai & Gujarat |
| Digital | DIGITAL OUT-OF-HOME. | Digital Out-of-Home (DOOH) Advertising in Ahmedabad |
| Our Network | PRESENT WHERE THE AUDIENCE MOVES. | Our Outdoor & Transit Media Network |
| Projects | VISIBILITY IN ACTION. | Outdoor Advertising Campaigns by Krishna Outdoor |
| Careers | BUILD THE NEXT CHAPTER. | Careers at Krishna Outdoor |

**Keep the design:**
- The creative slogans can stay as large display text — just mark them up as a styled `<p>` or `<h2>`.
- Put the keyword H1 directly above or inside the hero; it can be visually small.
- Also fix H2 typos: "Our Outdoor Outdoor Media" on the Digital page.
- H2s on OOH/Transit should name the formats (hoardings, unipoles, bus wraps) and cities.

### Images, internal links and content quality

**Images & alt text**
- Every image has alt text, but much of it is generic: "Outdoor billboard at night", "Krishna Outdoor hoarding"
- Mismatched alt/images: Rajasthan uses a Surat EV bus photo; Digital page reuses a Careers image
- Est. 406 KiB image savings available (PSI)
- Fix: alt text = format + city + brand, e.g. "Backlit hoarding on SG Highway, Ahmedabad – Krishna Outdoor"

**Internal linking**
- Every CTA goes to the general Contact page; there is no dedicated site-list page
- Thane and Rajasthan "View network" buttons go to generic Transit/OOH pages
- Projects campaigns are not linked from the media pages they prove
- Fix: link each asset page ↔ its case studies ↔ the network map

**Content depth & accuracy**
- OOH, Transit and Digital pages are mostly stat blocks with 1–2 short paragraphs
- "Since 1985" and "43+ years" don't match (1985 to 2026 is 41 years)
- OOH page labels 350+ TMT buses as "Ahmedabad City Buses" (Home says Thane)
- Typo "Ahemdabad" on Projects; blog is placeholder

---

## 4. Off-page & local

### Backlinks and authority

**Backlink profile for https://krishnaoutdoor.in/** (domain including subdomains, one link per domain)

| Domain Rating | Backlinks | Linking websites |
|---|---|---|
| 0.4 | 537 (12% dofollow) | 498 (12% dofollow) |

**Link and authority opportunities**
- **Trade press:** OOH outlets (e.g. media4growth, afaqs) regularly cover advertising-rights wins — announce GSRTC, AMTS, BEST and TMT rights
- **Client co-marketing:** ask featured brands (Torrent Power, Ambuja Cement, Aluminium Bharat) for a credit link
- **Rakesh Advertising:** make sure the sister site links to krishnaoutdoor.in

**Brand identity**
- On-site signals are now consistent: one brand name and one set of social profiles (krishnaoutdoorofficial on Facebook & Instagram, `/krishnaoutdoor` on LinkedIn)
- An older version of the site linked to profiles under "Krishna Communication (Outdoor)" — check whether these still exist and merge or retire them
- Older directory listings may still carry the old name and addresses
- Add the official profiles as `sameAs` in Organization schema

### Local SEO: the Mumbai address differs between pages

| Detail | Where it appears | What it says |
|---|---|---|
| Ahmedabad HQ | Contact page + LocalBusiness schema | Aakanksha Complex, 403-404, Netaji Rd, nr. Railway Crossing, Navrangpura, Ahmedabad 380009 |
| Mumbai office | Contact page | Morya Blue Moon, Off New Link Road, Andheri West, Mumbai 400053 |
| Mumbai office | Our Network page | 1207, Lodha Supremus, Senapati Bapat Marg, Lower Parel, Mumbai 400013 |
| Mumbai in schema | — | No LocalBusiness entry for the Mumbai office |
| Ahmedabad phone | Schema, chat widget | +91 98796 16411 |
| Mumbai phone | Our Network page | +91 99200 11574 |

**⚠️ Please confirm which Mumbai address is current before any listings are updated.**

**Google Business Profile:** Status, categories, reviews and ratings for the Ahmedabad and Mumbai profiles were not shared — needs screenshots of each GBP dashboard.

**Recommended**
- One confirmed NAP (Name, Address, Phone) per office, used everywhere
- Both offices in the footer of every page
- GBP category "Advertising agency" + services list
- Citations: JustDial, IndiaMART, Sulekha, Bing Places, Apple Maps

---

## 5. AI search visibility

### AI search readiness: good raw facts, no answers yet

| Readiness factor | Status | Finding |
|---|---|---|
| AI crawler access | LOW | robots.txt blocks only `/cgi-bin/` — AI crawlers can read the site |
| Entity clarity (who you are) | MED | One brand name now; Mumbai address and "since 1985 / 43+ years" conflict |
| Quotable facts | MED | Strong inventory numbers; OOH page labels TMT buses as Ahmedabad |
| Answer-ready content | HIGH | No FAQs, cost guidance or how-to content to cite |
| Structured data | MED | Organization, Breadcrumb, LocalBusiness present; no Service or FAQ |
| Agent accessibility | MED | PSI Agentic Browsing 1/2 — accessibility tree not well-formed |
| Third-party mentions | DATA NEEDED | Needs a brand-mention / backlink export |

*Badge colour = how urgently it needs work.*

### How to get cited

- Open each service page with a 2–3 sentence direct answer (what, where, how many sites)
- Add 5–8 FAQs per page written as real buyer questions: "How much does a hoarding cost in Ahmedabad?"
- One fact sheet on About: founded year, owners, offices, rights held
- Comparison content: hoarding vs bus vs train for a given budget
- Add Service and FAQPage schema to the keyword pages

---

## 6. User experience & conversion

### The enquiry path promises a site list it never delivers

**Today:**
Search / ad → Service page → "Get Site List" CTA → General Contact page → Generic form, no list

**Recommended:**
Search / ad → Asset & city page → "Get free site list" → Short form / WhatsApp → Thank-you page + tracked lead

**Friction points found**
- Six different CTA labels promise different things (site list, availability, plan campaign)
- "Free site list" is promised, but no list is delivered on the page
- Enquiry pop-up and Contact page form are separate — track both in GA4
- No phone number or WhatsApp in the header; pinch-zoom disabled

**User signals — data needed:** Bounce / engagement rate, average engagement time, top exit pages and form-submit, call-click and chat events need GA4 access (screenshot of GA4 Pages & Engagement report, last 90 days).

**Positive:** the Krishna AI chat and the interactive network map give visitors useful ways to engage.

---

## 7. New pages — 10 recommended, one per client keyword

### Summary table

| # | Page | URL slug | Primary keyword (client) | Why it matters |
|---|---|---|---|---|
| 1 | Hoarding Advertising in Ahmedabad | `/hoarding-advertising-ahmedabad` | hoarding advertising Ahmedabad | 300+ own hoardings; aggregators lead today |
| 2 | AMTS Bus Advertising | `/amts-bus-advertising-ahmedabad` | AMTS bus advertising | 900+ AMTS bus rights |
| 3 | Bus Shelter Advertising, Ahmedabad | `/bus-shelter-advertising-ahmedabad` | bus shelter advertising Ahmedabad | 400+ backlit shelter rights |
| 4 | GSRTC Bus Advertising | `/gsrtc-bus-advertising` | GSRTC bus advertising | 7000+ bus rights — unique asset |
| 5 | Outdoor Advertising Agency in Mumbai | `/outdoor-advertising-agency-mumbai` | outdoor advertising agency in Mumbai | Mumbai hub; Home stays Ahmedabad |
| 6 | Mumbai Local Train Advertising | `/mumbai-local-train-advertising` | Mumbai local train advertising | Display rights on WR & CR |
| 7 | BEST Bus Advertising Mumbai | `/best-bus-advertising-mumbai` | BEST bus advertising Mumbai | 400+ EV buses; 5 case studies |
| 8 | TMT Bus Advertising Thane | `/tmt-bus-advertising-thane` | TMT bus advertising Thane / Mumbai | 350+ rights; low competition |
| 9 | Social Media Marketing, Ahmedabad | `/social-media-marketing-ahmedabad` | social media marketing in Ahmedabad | New service line for HQ city |
| 10 | Social Media Marketing, Mumbai | `/social-media-marketing-mumbai` | social media marketing in Mumbai | New service line for Mumbai |

*Existing pages retargeted: Home → "outdoor advertising Ahmedabad"; `/media/transit` → "transit advertising agency Mumbai". Supporting pages for phase 2: OOH cost guide, individual case-study pages, "Get free site list" landing page, OOH guides blog, Surat EV and Jaipur bus pages.*

### Page outlines

#### 1. Hoarding Advertising in Ahmedabad
**URL:** `/hoarding-advertising-ahmedabad` · **Client keyword:** hoarding advertising Ahmedabad

Aggregators currently own this search. As the owner of 300+ Ahmedabad hoardings, Krishna Outdoor can show real locations, sizes and photos they cannot.

Suggested outline:
- H2 Hoarding advertising in Ahmedabad with Krishna Outdoor
- H2 Our 300+ hoarding locations by area (map + list)
  - H3 Frontlit, backlit, unipoles & gantries
- H2 What does a hoarding cost in Ahmedabad?
- H2 How booking works (4 steps)
- H2 Campaigns we have run (e.g. Torrent Power)
- H2 FAQs + "Get free site list" CTA

#### 2. AMTS Bus Advertising
**URL:** `/amts-bus-advertising-ahmedabad` · **Client keyword:** AMTS bus advertising

900+ advertising rights on Ahmedabad's own city buses. Today this asset gets one line on the Transit page.

Suggested outline:
- H2 AMTS bus advertising with Krishna Outdoor
- H2 900+ AMTS bus rights explained
  - H3 Full wrap, side panel and back panel formats
- H2 Routes and areas of Ahmedabad covered
- H2 Cost factors and minimum duration
- H2 AMTS campaigns we have run
- H2 FAQs (pair with bus shelters, page 3)

#### 3. Bus Shelter Advertising, Ahmedabad
**URL:** `/bus-shelter-advertising-ahmedabad` · **Client keyword:** bus shelter advertising Ahmedabad

400+ backlit shelter rights. People wait at shelters, so the message is seen at eye level for longer than a passing hoarding.

Suggested outline:
- H2 Backlit bus shelter advertising in Ahmedabad
- H2 400+ shelter locations by area
- H2 Why shelters work: dwell time & eye level
  - H3 Sizes, printing and installation
- H2 Combine shelters with AMTS buses
- H2 Cost factors
- H2 FAQs

#### 4. GSRTC Bus Advertising
**URL:** `/gsrtc-bus-advertising` · **Client keyword:** GSRTC bus advertising

7000+ state bus rights is a rare, defensible asset. One strong page can rank across all of Gujarat, not only Ahmedabad.

Suggested outline:
- H2 Reach every district of Gujarat
- H2 7000+ GSRTC bus rights explained
  - H3 Formats and sizes
- H2 Route & depot coverage
- H2 Who it works for (FMCG, education, govt.)
- H2 Timelines & process
- H2 FAQs

#### 5. Outdoor Advertising Agency in Mumbai
**URL:** `/outdoor-advertising-agency-mumbai` · **Client keyword:** outdoor advertising agency in Mumbai

The homepage serves Ahmedabad. Mumbai needs its own hub page with the Mumbai office, all Mumbai media and links to pages 6–8.

Suggested outline:
- H2 Outdoor advertising agency in Mumbai — Krishna Outdoor
- H2 Our Mumbai media: local trains, BEST buses, TMT buses
- H2 Mumbai campaigns (Kala-Kendra, Prefr, Fashionism…)
- H2 How we plan a Mumbai campaign
- H2 Our Mumbai office (address + map pin)
- H2 FAQs + enquiry CTA

#### 6. Mumbai Local Train Advertising
**URL:** `/mumbai-local-train-advertising` · **Client keyword:** Mumbai local train advertising

A high-value Mumbai search where aggregators lead today. Holding display rights on Western & Central lines is the selling point.

Suggested outline:
- H2 Mumbai local train advertising on WR & CR
  - H3 Available exterior formats
- H2 Line and route coverage
- H2 What drives the cost
- H2 Campaign examples
- H2 How to book & lead times
- H2 FAQs

#### 7. BEST Bus Advertising Mumbai
**URL:** `/best-bus-advertising-mumbai` · **Client keyword:** BEST bus advertising Mumbai

400+ BEST EV full-wrap rights plus five existing case studies (Kala-Kendra, Shree Swaminarayan, Prefr, Fashionism, Aluminium Bharat) ready to reuse.

Suggested outline:
- H2 BEST bus advertising in Mumbai
- H2 BEST EV full-wrap formats
- H2 Coverage & routes
- H2 Five Mumbai campaigns we ran
- H2 Design specs & approvals
- H2 FAQs

#### 8. TMT Bus Advertising Thane
**URL:** `/tmt-bus-advertising-thane` · **Client keyword:** TMT bus advertising Thane / Mumbai

350+ TMT rights in a less competitive market. Existing campaigns (Ambuja Cement, Doraemon movie) give instant proof.

Suggested outline:
- H2 TMT bus advertising in Thane
- H2 Thane & Mumbai-region routes covered
  - H3 Formats: full & partial branding
- H2 Campaigns: Ambuja Cement, Doraemon
- H2 Cost factors
- H2 FAQs

#### 9. Social Media Marketing, Ahmedabad
**URL:** `/social-media-marketing-ahmedabad` · **Client keyword:** social media marketing in Ahmedabad

A new battle against digital agencies. Win by offering what they can't: social campaigns tied to hoardings and buses. Needs real social media case studies.

Suggested outline:
- H2 Social media marketing services in Ahmedabad
- H2 Platforms: Instagram, Facebook, LinkedIn, YouTube
- H2 What we do: strategy, content, paid ads, reports
- H2 Outdoor + social: connected campaigns
- H2 Results for Ahmedabad brands (client data)
- H2 How we work & FAQs

#### 10. Social Media Marketing, Mumbai
**URL:** `/social-media-marketing-mumbai` · **Client keyword:** social media marketing in Mumbai

Same service, written fresh for Mumbai (not copied from page 9) so Google treats it as a unique page. Link it from the Mumbai hub.

Suggested outline:
- H2 Social media marketing agency in Mumbai
- H2 Services for Mumbai brands
- H2 Pairing social with local train & BEST bus ads
- H2 Mumbai case studies (client data)
- H2 Our Mumbai team & office
- H2 FAQs

---

## 8. Competitor benchmarking

### For the OOH keywords, your real rivals are aggregators

| Factor | Krishna Outdoor | Search Outdoor | The Media Ant | SmartAds |
|---|---|---|---|---|
| Business type | Media owner & rights holder | Media owner (Ahmedabad) | National aggregator | National aggregator |
| Inventory claims | 2000+ hoardings, 7000+ GSRTC, 900+ AMTS, 400+ BEST, 350+ TMT | 400+ hoardings, 35+ years, 342+ clients | Listings per site with rate cards | Listings per road/site |
| City / asset pages | None (3 generic media pages) | 4 generic service pages | Yes — per city & site | Yes — per site |
| Cost / rate content | None | None | Yes | Yes (cost factors) |
| FAQs | None | None | Yes | Q&A-style sections |
| Blog | Placeholder only | Empty ("Nothing found") | Not checked | Not checked |
| Case studies | 8 campaign summaries | Gallery only | Not checked | Not checked |
| Rankings & backlinks | Data needed | Data needed | Data needed | Data needed |

**Takeaway:** Search Outdoor (the stated rival) is technically weak — duplicated title, no blog content, no city pages — so it is beatable with the new pages alone. To win non-brand searches, Krishna Outdoor must out-inform the aggregators with owner-level detail: real locations, photos, formats, availability and indicative pricing. The two social media marketing keywords compete with digital agencies, which are not benchmarked here — SEO Tape can add 2–3 once the client confirms names.

---

## 9. Priority action plan

### Quick wins: 0–2 weeks

| Issue | Impact | Effort | Priority |
|---|---|---|---|
| Apply the recommended titles and meta descriptions to all 11 existing pages (Home and Transit retargeted to client keywords) | High | Low | HIGH |
| Fix sitemap.xml (remove tel: and http entries, add lastmod & blog) and robots.txt Sitemap line; resubmit in Search Console | High | Low | HIGH |
| Settle one Mumbai address (Lower Parel vs Andheri West) and use it everywhere | High | Low | HIGH |
| Add keyword H1s (Home has none); keep slogans as styled text | High | Low | HIGH |
| Write meta descriptions for Our Network & Blog; add canonical to Careers & Blog; align og:title | Medium | Low | MED |
| Unpublish or noindex the "Hello world" blog until real posts exist | Medium | Low | MED |
| Fix factual slips: "since 1985" vs "43+ years", TMT labelled Ahmedabad, "Ahemdabad", "Outdoor Outdoor" | Medium | Low | MED |
| Extend schema: Mumbai LocalBusiness, Service, FAQPage, WebSite; add geo & hours | Medium | Low | MED |
| Allow zoom in viewport; fix aria-hidden focus & contrast; add video captions | Medium | Low | MED |
| Set up GA4 events: enquiry submit, call click, email click, chat start | High | Low | HIGH |
| Rename image files with spaces; rewrite generic or mismatched alt text | Low | Low | LOW |

### Mid-term: 1–2 months

| Issue | Impact | Effort | Priority |
|---|---|---|---|
| Mobile speed: poster image + delayed hero video, defer render-blocking CSS/JS, resize images, cache headers — target LCP under 2.5s | High | Medium | HIGH |
| Build Ahmedabad pages 1–4 (hoarding, AMTS, bus shelter, GSRTC) and rewrite Home copy for "outdoor advertising Ahmedabad" | High | High | HIGH |
| Build Mumbai hub (page 5) and pages 6–8 (local train, BEST, TMT); expand `/media/transit` for "transit advertising agency Mumbai" | High | High | HIGH |
| Create / verify Google Business Profiles for Ahmedabad and Mumbai; build core citations | High | Medium | HIGH |
| Launch "Get free site list" landing page and point every CTA and Google Ads to it | High | Medium | HIGH |
| Social media marketing pages 9–10, each with at least 2 real case studies | Medium | Medium | MED |
| Add FAQ sections + FAQPage and Service schema to all keyword pages | Medium | Low | MED |
| Turn the 8 project cards into case-study pages linked from pages 1–8 | Medium | Medium | MED |

### Long-term: 3+ months

| Issue | Impact | Effort | Priority |
|---|---|---|---|
| Digital PR: press releases on advertising-rights wins to OOH trade media; client credit links | High | Medium | HIGH |
| Searchable site-availability inventory (one page per major site or cluster) | High | High | MED |
| OOH cost guide + blog hub (2–4 guides per month) linking to the 12 keyword pages | Medium | Medium | MED |
| Phase-2 pages: Surat EV buses, Jaipur buses, unipoles & gantries, Gujarat city hoardings | Medium | High | MED |
| Consolidate old social profiles and brand mentions under "Krishna Outdoor" | Medium | Medium | LOW |
| Review programme for both Google profiles | Medium | Low | MED |
| Security headers (HSTS, CSP, XFO) and quarterly Core Web Vitals re-audit | Low | Low | LOW |

---

## 10. Data needed

Items to share before SEO Tape finalises certain parts of this audit:

- Search Console access (index coverage data)
- GA4 access (bounce/engagement rate, top exit pages, form-submit/call-click/chat events)
- Confirmed current Mumbai office address (Lower Parel vs Andheri West)
- Confirmed founding year (1985 vs "43+ years" discrepancy)
- Google Business Profile screenshots/status for both Ahmedabad and Mumbai locations
- Current Google rankings and monthly search volumes for the 12 target keywords
- Brand-mention / backlink export for third-party AI-citation tracking
- Names of 2–3 digital-agency competitors for the social media marketing keywords
- INP (responsiveness) real-user field data, once available

---

## 11. Conclusion & next steps

### Fix the foundations, then out-publish the aggregators

Krishna Outdoor owns inventory that few competitors can match — but the website does not yet tell Google, AI tools or buyers about it. A faulty sitemap, titles and H1s that miss the target keywords, and slow mobile loading hold back an otherwise sound technical base. Once fixed, dedicated pages for each asset and city give the business a clear route past both Search Outdoor and the aggregators.

**Timeline:**

| Week | Milestone |
|---|---|
| Week 1 | Approve plan; share the data listed; confirm Mumbai address & founding year |
| Week 2 | New titles, metas & H1s; sitemap, robots, schema and GA4 events live |
| Weeks 3–6 | Mobile speed fixes; Ahmedabad pages 1–4 and free-site-list page live |
| Weeks 7–8 | Mumbai pages 5–8, social pages 9–10, Google profiles; first ranking review |

**Success measures:** rankings for the 12 client keywords · LCP under 2.5s on mobile · zero broken internal links · tracked enquiries per month (baseline from GA4).

---

## Appendix — pages crawled and sources used

**krishnaoutdoor.in pages checked (14 Oct 2026):**
- `/` (Home), `/about`, `/contact`, `/services`
- `/media/ooh`, `/media/transit`, `/media/digital`
- `/our-network`, `/projects`, `/careers`, `/blog/`
- `/robots.txt`, `/sitemap.xml`
- `http://www.` redirect and a test 404 URL

**Other sources:**
- Google PageSpeed Insights mobile report, 14 Oct 2026, 2:55 PM IST (client screenshot)
- GTmetrix report, 14 Oct 2026, Seattle server, Chrome 154 / Lighthouse 12.6.1 (client screenshot)
- searchoutdoor.in homepage and blog
- The Media Ant and SmartAds Ahmedabad hoarding pages; OOH trade coverage (media4growth, afaqs)
- Google "good" thresholds: FCP 1.8s, LCP 2.5s, TBT 200ms, CLS 0.1, SI 3.4s (Lighthouse guidance)

*Titles, descriptions, canonicals, H1s, schema and links were re-checked in a live Chrome session at 4pm IST on 14 Oct 2026. An earlier automated fetch had returned a cached older copy of `/about` and `/contact`; every finding based on it has been removed.*
