# Bus Shelter Advertising Ahmedabad — SEO & Content Overhaul

**Page:** `/bus-shelter-advertising-ahmedabad`  
**Source:** SEO Tape Business Solutions · October 2026  
**Blade:** `resources/views/web/pages/keywords/bus-shelter-advertising-ahmedabad.blade.php`

---

## Part 1 — SEO Title & Meta Description (CRITICAL FIX)

**Status:** [x] Live tags, lengths and fallbacks verified 2026-11-04. No change needed.

The biggest single fix. Currently handled by `config/seo_pages.php` → `seo_meta` DB table.

**What to verify/change:**
- `seo_pages.php` already has:  
  - title: `Bus Shelter Advertising in Ahmedabad | 400+ Backlit Sites` (57 chars) ✓  
  - description: current is generic, update to:  
    `Bus shelter advertising in Ahmedabad on 400+ backlit shelters at eye level. Longer viewing time, day and night. Get the free location list with rates.` (150 chars)
- Confirm `og:title`, `og:description`, `twitter:title`, `twitter:description` pull from the same source (they should via the layout/seo-head partial).
- Confirm the title is NOT just "Krishna Outdoor" on the live page.

**Test:** Check the rendered `<title>`, `<meta name="description">`, `og:title`, `og:description` in the page source.

---

## Part 2 — Hero Image Alt Text

**Status:** [x] Alt text correct. Hero and OG re-cropped to remove the burned-in GPS stamp; new hero is `ahmedabad-bus-shelter-hero(-800w).webp`. **Deploy pending.**

Fix the hero image alt text from generic "Hoarding at Prem Darwaja..." to:  
`Backlit bus shelter advertising panel at a bus stop in Ahmedabad`

Also fix the second image alt text to match the doc spec.

**Test:** View page source, confirm both alt texts are correct.

---

## Part 3 — Rewrite Lead Paragraph (AI Overview Optimized)

**Status:** [x] Lead and CTA match the doc. No change needed.

Replace the current `kw-lead` with the SEO doc's 57-word answer:

> Bus shelter advertising in Ahmedabad places your brand on backlit panels at bus stops, at eye level, where commuters wait for several minutes. Krishna Outdoor holds advertising rights on 400+ backlit bus shelters across Ahmedabad, so you can choose stops by area and audience and get longer viewing time than most outdoor formats.

Add CTA line after: `Get the free bus shelter location list → | Call or WhatsApp +91 98796 16411`

**Test:** View page, confirm lead text matches, CTA links work.

---

## Part 4 — Rewrite Main Content Sections (H2s & H3s)

**Status:** [x] All sections match the doc; period added to the Shelter network line and the cost table cell. Booking section now carries the doc's "Minimum booking period" and "Recommended lead time" lines. **Deploy pending.**

Replace the existing content sections with the new optimized structure:

1. **H2: What is bus shelter advertising?** (new section — explains the format)
2. **H2: How many bus shelters does Krishna Outdoor have in Ahmedabad?** (400+ shelters, AMTS/BRTS, key areas list)
3. **H2: Why does bus shelter advertising work?** (with comparison table)
4. **H2: How much does bus shelter advertising cost in Ahmedabad?** (with cost-factor table)
5. **H2: How do you book bus shelters in Ahmedabad?** (booking steps)
6. **H2: Bus shelters plus AMTS buses: one city campaign** (internal links)
7. **H2: Why choose Krishna Outdoor for bus shelter advertising?** (E-E-A-T signals)

**New CSS needed:** `kw-table` for the two tables, `kw-steps` for the numbered booking steps.

**Test:** View page, confirm all sections render, tables display correctly, internal links work.

---

## Part 5 — Expand FAQs from 4→6 (Match Doc)

**Status:** [x] 6 FAQs match the doc and the live schema. FAQ 6 omits the `[ADD]` clause until the real minimum is confirmed.

Replace the current 7 FAQs with the 6 from the SEO doc (word-for-word for schema match):

1. How much does bus shelter advertising cost in Ahmedabad?
2. How many bus shelters can I advertise on in Ahmedabad?
3. Why is bus shelter advertising effective?
4. Are bus shelter ads lit at night?
5. Can I combine bus shelter ads with AMTS bus advertising?
6. What is the minimum period for bus shelter advertising?

Note: the doc's `[ADD: confirm minimum period]` clause is left out of FAQ #6 and must not be published as a placeholder.

**Test:** View page, confirm 6 FAQs render, toggle open/close. Check JSON-LD in page source has matching FAQ schema.

---

## Part 6 — Internal Links & CTA Updates

**Status:** [x] All 5 doc anchors present and in the sections the doc names (link row moved under Shelters + AMTS), both CTAs use "bus shelter location list", every internal link returns 200, and the form preselects Bus Shelters. **Deploy pending.**

- Both CTAs should point to `/free-site-list?media=bus-shelters&city=Ahmedabad` (already correct in current code).
- Add internal links in the "Bus shelters plus AMTS buses" section:
  - AMTS bus advertising → `/amts-bus-advertising-ahmedabad`
  - Hoarding advertising → `/hoarding-advertising-ahmedabad`
  - GSRTC bus advertising → `/gsrtc-bus-advertising`
- Add campaign case studies link → `/projects` in "Why choose" section.
- Keep the "More formats" links section at the bottom.

**Test:** Click every internal link, confirm they resolve correctly.

---

## Part 7 — JSON-LD Schema Validation

**Status:** [x] All 5 nodes verified on the live page in one ld+json block. Google Rich Results Test still to be run after deploy.

The schema is auto-built by `SchemaBuilder.php` from:
- `seo_pages.php` config (Service, BreadcrumbList, LocalBusiness)
- `faq.blade.php` partial (FAQPage — auto from same Q&A)

**Verify these nodes exist in the rendered `@graph`:**
- Organization (already global)
- LocalBusiness (region: ahmedabad — already configured)
- Service (already in seo_pages.php config)
- FAQPage (auto-built from the faq partial)
- BreadcrumbList (Home → OOH Media → Bus Shelter Advertising Ahmedabad)

No manual schema paste needed — the existing `SchemaBuilder` handles everything.

**Test:** Copy the JSON-LD from page source, paste into Google Rich Results Test. All types should validate.

---

## Part 8 — Deploy & Verify Live

**Status:** [ ] Not deployed. Needs to be run by hand: Claude cannot reach the server. This also ships the Hoarding page.

- Do not use `./deploy.sh all`: it also syncs `public_html/blog`, which has local WordPress changes.
- Send the images first, then the app (this also runs the migration and clears caches):
  - `rsync -avz -e "ssh -p 65002 -i ~/.ssh/krishna_outdoor" public_html/assets/images/ooh/ u606581843@46.202.182.2:~/domains/krishnaoutdoor.in/public_html/assets/images/ooh/`
  - `./deploy.sh app`
- Verify live page at `https://krishnaoutdoor.in/bus-shelter-advertising-ahmedabad`
- Check: title tag, meta description, og tags, content sections, tables, FAQs, schema, internal links.

---

## Summary of files to edit

| File | Changes |
|------|---------|
| `config/seo_pages.php` | Update meta description |
| `views/web/pages/keywords/bus-shelter-advertising-ahmedabad.blade.php` | Full content rewrite |
| `views/web/common/keyword-page-style.blade.php` | Add table & steps CSS |

---

## Still needed from Krishna Outdoor

- Minimum booking period, for FAQ #6 and the booking section.
- Recommended lead time. The page says "a few weeks ahead", borrowed from the Hoarding doc; confirm it for shelters.
- A real night photo of a backlit shelter (doc alt: "Backlit bus shelter ad lit at night in Ahmedabad").
- The road or area for `ahmedabad-bus-shelter-original-02`, for its alt text.
