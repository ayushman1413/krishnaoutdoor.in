# SEO Playbook — What Was Done & How to Replicate It

> This is a **step-by-step brief** of every SEO task performed on the Krishna Outdoor website (krishnaoutdoor.in).
> It is written as a reusable playbook: follow the same sequence on any Laravel project to get the same results.

---

## Overview: What the Starting Point Looked Like

Before SEO work began, the website had:
- A Laravel app with pages for services, projects, categories, locations, campaigns
- No SEO meta system (no editable titles, descriptions, or OG tags)
- No sitemap.xml
- A static robots.txt with minimal rules
- Hardcoded JSON-LD schema in a Blade partial (Organization only)
- No redirect management
- No 404 tracking
- No admin panel for SEO
- Images served as original JPG/PNG (no compression)
- GA4/GTM scripts loaded synchronously (blocking page render)
- No keyword landing pages
- No structured internal linking system

---

## Phase 1: Foundation — Database, Models, and the SEO Resolver

**Goal:** Build the core data layer so every page can have editable SEO fields.

### Step 1.1: Create Database Tables

Created 6 migrations:

| Migration | Table | Purpose |
|-----------|-------|---------|
| `create_seo_meta_table` | `seo_meta` | Per-page SEO data (title, description, keywords, OG, Twitter, schema, robots, H1 override, page copy, related links) |
| `create_seo_settings_table` | `seo_settings` | Single-row global settings (site name, title template, GA4 ID, GTM ID, default OG image, robots.txt content, schema JSONs) |
| `create_seo_redirects_table` | `seo_redirects` | URL redirect rules (old_url → new_url, 301/302, hit_count, soft deletes) |
| `create_seo_404_logs_table` | `seo_404_logs` | Broken URL tracking (url, referrer, user_agent, hit_count, last_seen_at) |
| `add_skip_title_template_to_seo_meta` | `seo_meta` | Added the `skip_title_template` boolean column |
| `create_seo_meta_revisions_table` | `seo_meta_revisions` | Snapshot-based change history (seo_meta_id, admin_id, snapshot_json) |

Later added:
| Migration | Purpose |
|-----------|---------|
| `upsert_static_page_seo_meta` | Auto-created SEO rows for all static pages defined in config |
| `backfill_category_seo_meta` | Auto-created SEO rows for all existing categories |
| `create_cms_elements_and_related_links` | CMS overrides table + added `page_copy` and `related_links` columns to seo_meta |

**Key design decision:** The `seo_meta` table uses a **polymorphic** design — it can attach to any model (Category, Campaign, Location) via `seoable_type` + `seoable_id`, OR to a static page via `route_name`. This means one table handles all pages.

### Step 1.2: Create Models

Created 6 models:

| Model | Key Features |
|-------|-------------|
| `SeoMeta` | UUID primary key, `seoable` morphTo relationship, `REVISIONED_FIELDS` constant (list of fields to track in revision history), `normalizeH1()` method, `forGroup()` scope, `publicPath()` accessor |
| `SeoSetting` | Simple single-row model for global settings |
| `SeoRedirect` | SoftDeletes enabled, tracks hit_count |
| `Seo404Log` | Tracks broken URLs with hit counts |
| `SeoMetaRevision` | Stores pre-change snapshots, `snapshot_json` cast as array |
| `CmsElement` | Stores admin text overrides per page element |

### Step 1.3: Create the HasSeoMeta Trait

```php
// app/Traits/HasSeoMeta.php
trait HasSeoMeta {
    function seo() {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
```

Added `use HasSeoMeta;` to 3 models:
- `Category` — with auto-create on model creation
- `Campaign` — with auto-create on model creation
- `Location` — with auto-create on model creation

**What this achieves:** Any model that uses this trait automatically gets an editable SEO row in the admin panel.

### Step 1.4: Create the Static Page Registry

Created `config/seo_pages.php` — a PHP config file that registers every static page with:
- `path` — the URL path
- `label` — human-readable name (used in breadcrumbs and admin panel)
- `parent` — parent route name (builds the breadcrumb chain)
- `region` — which office phone to show (`ahmedabad`, `mumbai`, `both`, or `null`)
- `title` — fallback meta title
- `description` — fallback meta description
- `service` — Service schema config (for keyword pages)
- `index` — set to `false` to force noindex (for conversion pages)

Registered 20+ pages including Home, About, Contact, Services, OOH Media, Transit Media, Digital Media, Network, Projects, Careers, all 10 keyword pages, and the Free Site List page.

### Step 1.5: Build the SeoResolver Service

Created `app/Services/SeoResolver.php` — the central brain of the SEO system.

**What it does:** Takes a route name or a model, merges data from 3 sources in priority order, and produces the final SEO values for the page.

**Resolution chain (first non-empty value wins):**
1. Database (`seo_meta` row for this page)
2. Config (`config/seo_pages.php` defaults)
3. Global settings (`seo_settings` row)

**Key methods:**
- `forRoute($routeName)` — resolve SEO for a static page
- `forModel($model, $fallbackTitle, $fallbackDescription)` — resolve SEO for a dynamic page
- `canonicalFor($path)` — build canonical URL (always https, no www, no query strings)
- `robotsContent()` — build the robots meta tag content
- `ogTitle()`, `ogDescription()`, `ogImage()` — with cascading fallbacks
- `twitterTitle()`, `twitterDescription()`, `twitterCard()` — with OG fallbacks
- `h1Override()` — returns the admin-set H1 or null
- `region()` — determines which office region this page belongs to

**Title template logic:**
```
Final title = skip_title_template ? page_title : "{page_title} | {site_name}"
```

### Step 1.6: Create the seo-head Blade Partial

Created `resources/views/web/common/seo-head.blade.php` — outputs all SEO tags in the `<head>`:
- `<title>`
- `<meta name="description">`
- `<meta name="keywords">`
- `<meta name="robots">`
- `<link rel="canonical">`
- All Open Graph tags (og:title, og:description, og:image, og:url, og:type, og:site_name)
- All Twitter Card tags (twitter:card, twitter:title, twitter:description, twitter:image)
- JSON-LD structured data (`<script type="application/ld+json">`)
- Per-page custom schema JSON (if set)

Included this partial in the main layout: `@include('web.common.seo-head')`

### Step 1.7: Wire $seo into Every Route

Updated every route in `routes/web.php` to pass the `$seo` variable:

```php
// Static pages
Route::get('/about', function () {
    $seo = SeoResolver::forRoute('view.about');
    return view('web.pages.about', compact('seo'));
})->name('view.about');

// Dynamic pages (in controllers)
$seo = SeoResolver::forModel($campaign, $campaign->name, $campaign->summary);
```

---

## Phase 2: Admin Panel — Let the Admin Control SEO

**Goal:** Build a full SEO management interface in the admin panel.

### Step 2.1: Add SEO Permissions

Added 5 permissions to the `Permission` enum:
- `VIEW_SEO` — can view the SEO list
- `ADD_SEO` — can create SEO entries
- `EDIT_SEO` — can edit SEO meta data
- `DELETE_SEO` — can delete SEO entries
- `MANAGE_REDIRECTS` — can manage redirects and 404 logs

### Step 2.2: Build the SEO Meta Controller

Created `app/Http/Controllers/Admin/SeoMetaController.php`:
- **List page** — groups SEO rows by type (Pages, Categories, Campaigns, Locations) in tabs
- **Edit page** — form with all fields: title, description, keywords, focus keyword, skip title template, canonical URL, robots index/follow, H1 override, OG fields, Twitter fields, schema JSON, exclude from sitemap
- **Save** — validates, saves, creates revision snapshot if any revisioned field changed
- **CSV Export** — downloads all SEO data as a CSV (URL, current title, description, etc.)
- **CSV Import** — uploads a CSV, matches by URL, updates rows, creates revision history

### Step 2.3: Build the SEO Settings Controller

Created `app/Http/Controllers/Admin/SeoSettingController.php`:
- Single form for: site_name, title_template, description_template, default_og_image, favicon, GA4 ID, GTM ID, Facebook Pixel code, GSC verification code, head/body custom code, Organization schema JSON, LocalBusiness schema JSONs (Ahmedabad + Mumbai), robots.txt content, WhatsApp number

### Step 2.4: Build the Redirect Controller

Created `app/Http/Controllers/Admin/SeoRedirectController.php`:
- CRUD for redirect rules (old_url, new_url, type 301/302, status toggle)
- Shows hit_count per redirect
- CSV import for bulk redirect creation
- Soft delete (recoverable)

### Step 2.5: Build the 404 Log Controller

Created `app/Http/Controllers/Admin/Seo404LogController.php`:
- Lists broken URLs sorted by hit_count (most frequent first)
- Shows referrer and user agent
- Dismiss (delete) action to clear resolved entries

### Step 2.6: Build the Content TODOs Controller

Created `app/Http/Controllers/Admin/SeoTodoController.php`:
- Auto-detects missing content: campaigns for keyword page brands, social case studies per city, location data gaps, page copy word counts, missing photos, tracking ID gaps
- Gives the admin a clear checklist of what SEO work remains

### Step 2.7: Build Admin Views

Created 11 Blade templates:
- `seo-list.blade.php` — tabbed list of all pages with SEO health indicators
- `seo-update.blade.php` — full SEO edit form with character count indicators
- `seo-settings.blade.php` — global settings form
- `redirect-list.blade.php` — redirect table with hit counts
- `redirect-create.blade.php` — create/edit redirect form
- `redirect-update.blade.php` — update redirect form
- `log-404-list.blade.php` — 404 log table
- `todo-list.blade.php` — content TODO checklist
- `content-list.blade.php` — page content list
- `content-edit.blade.php` — page content edit form (headings, paragraphs, page copy, related links)
- `_styles.blade.php` — shared styles for content editor

### Step 2.8: Register Admin Routes

Added routes in `routes/admin.php`:
```
/admin/seo                    → SEO meta list
/admin/seo/{id}/edit          → SEO meta edit
/admin/seo/{id}/update        → SEO meta save
/admin/seo/export-csv         → CSV export
/admin/seo/import-csv         → CSV import
/admin/seo-settings           → Global SEO settings
/admin/redirect               → Redirect list
/admin/redirect/create        → Create redirect
/admin/redirect/{id}/edit     → Edit redirect
/admin/redirect/import-csv    → Import redirects CSV
/admin/404-log                → 404 logs
/admin/content                → Page content list
/admin/content/{id}/edit      → Page content edit
/admin/seo-todos              → Content TODOs
```

---

## Phase 3: Structured Data — JSON-LD Schema

**Goal:** Give Google rich structured data about the business, services, and FAQs.

### Step 3.1: Build the SchemaBuilder Service

Created `app/Services/SchemaBuilder.php` — builds a single `@graph` array containing multiple schema types:

| Schema Type | Where it Appears | Source |
|-------------|-----------------|--------|
| Organization | Every page | `seo_settings.organization_schema_json` or `config/business.php` |
| WebSite | Home page only | Site name + URL |
| LocalBusiness | Region-based pages | `seo_settings.local_business_{region}_json` or `config/business.php` |
| Service | Keyword landing pages | `config/seo_pages.php` → `service` key |
| FAQPage | Pages with FAQ partial | Same `$faqs` array that renders the visible FAQ |
| BreadcrumbList | Every page | `config/seo_pages.php` parent chain or `setBreadcrumbs()` |
| VideoObject | Pages with videos | `config/business.php` → `videos` key |

**Key design decision:** FAQPage schema is built from the same data array that renders the visible FAQ (`SchemaBuilder::addFaqs($faqs)` is called inside `faq.blade.php`). This guarantees schema and visible content are always in sync.

### Step 3.2: Create the Business Config

Created `config/business.php` — single source of truth for:
- Company email
- Office data (Ahmedabad + Mumbai): label, address, phone, street, locality, region, postal code, geo coordinates, map URL, area served, opening hours
- Social media links (Facebook, Instagram, LinkedIn, YouTube, Twitter)
- Video data (name, description, thumbnail, content URL, upload date)

### Step 3.3: Create the FAQ Partial

Created `resources/views/web/common/faq.blade.php`:
- Takes a `$faqs` array from the page template
- Calls `SchemaBuilder::addFaqs($faqs)` to feed the schema
- Renders visible FAQ using `<details>/<summary>` HTML elements
- Wrapped in `<!--cms:skip-->` to prevent admin from editing FAQ text (would cause schema mismatch)

---

## Phase 4: Sitemap & Robots

**Goal:** Tell Google which pages exist and which to ignore.

### Step 4.1: Build the Dynamic Sitemap

Created `app/Services/SitemapService.php`:
- Collects URLs from: static pages (config), categories (DB), campaigns (DB), location cities (DB, with quality gate)
- Excludes: noindex pages, excluded-from-sitemap pages, pages with empty title/description
- Caches result with `Cache::rememberForever()`
- Auto-flushes cache when any SeoMeta, Category, Location, or Campaign is saved/deleted

Created `resources/views/web/common/sitemap-xml.blade.php` — the XML template.

### Step 4.2: Wire Up Cache Flushing

Added to `AppServiceProvider.php`:
```php
foreach ([SeoMeta::class, Category::class, Location::class, Campaign::class] as $model) {
    $model::saved(fn () => SitemapService::flush());
    $model::deleted(fn () => SitemapService::flush());
}
```

### Step 4.3: Build Dynamic Robots.txt

Created the `robots()` method in `app/Http/Controllers/Web/SeoController.php`:
- Reads content from `seo_settings.robots_txt` (admin-editable)
- Falls back to a sensible default
- Served via route, overriding the static `public_html/robots.txt`

### Step 4.4: Register Public Routes

```php
Route::get('/sitemap.xml', [SeoController::class, 'sitemap']);
Route::get('/robots.txt', [SeoController::class, 'robots']);
```

### Step 4.5: Configure Robots Rules

Set up robots.txt to:
- Allow all pages by default
- Block `/admin/`, `/login`, `/api/`
- Block WordPress admin: `/blog/wp-admin/`, `/blog/wp-login.php`
- Allow AJAX: `/blog/wp-admin/admin-ajax.php`
- Block tracking parameters: `/*?*utm_`, `/*?*fbclid=`, `/*?*gclid=`
- Point to both sitemaps: main sitemap + WordPress sitemap

---

## Phase 5: Redirects & 404 Tracking

**Goal:** Catch broken URLs and redirect old URLs to new ones.

### Step 5.1: Build the Redirect Middleware

Created `app/Http/Middleware/HandleSeoRedirects.php`:
- Runs on every GET request
- Checks the `seo_redirects` table for a matching `old_url`
- If found and active → performs 301/302 redirect, increments `hit_count`
- Registered in `Kernel.php` as web middleware

### Step 5.2: Add 404 Logging to Exception Handler

Updated `app/Exceptions/Handler.php`:
- On every `NotFoundHttpException` for GET requests:
  - Saves URL, referrer, user_agent to `seo_404_logs`
  - If same URL already logged → increments `hit_count`
  - Updates `last_seen_at` timestamp

### Step 5.3: Add Hardcoded Legacy Redirects

Added permanent redirects in `routes/web.php` for known old URLs:
```php
Route::get('/bus-advertisement', fn () => redirect()->route('view.transit.media', [], 301));
Route::get('/outdoor-advertisement', fn () => redirect()->route('view.ooh.media', [], 301));
Route::get('/train-advertisement', fn () => redirect()->route('view.transit.media', [], 301));
```

### Step 5.4: Create Custom 404 Page

Created `resources/views/errors/404.blade.php`:
- Has `noindex` meta tag
- Shows a "Back to Home" button
- Loads GA4 directly (to track 404 visits)
- Standalone layout (does not use the main site layout)

---

## Phase 6: Keyword Landing Pages

**Goal:** Create dedicated pages targeting high-value search keywords.

### Step 6.1: Identify Target Keywords

Selected 10 keywords based on business services and cities:
1. hoarding advertising ahmedabad
2. amts bus advertising ahmedabad
3. bus shelter advertising ahmedabad
4. gsrtc bus advertising
5. outdoor advertising agency mumbai
6. mumbai local train advertising
7. best bus advertising mumbai
8. tmt bus advertising thane
9. social media marketing ahmedabad
10. social media marketing mumbai

### Step 6.2: Register Each Page in 3 Places

For each keyword page, registered in:

1. **`config/seo_pages.php`** — path, label, parent (for breadcrumbs), region, fallback title/description, Service schema config
2. **`routes/web.php`** — route with SeoResolver and view
3. **`resources/views/web/pages/keywords/{slug}.blade.php`** — full content template

### Step 6.3: Build Content-Rich Templates

Each keyword page template includes:
- **Hero section** with keyword in H1 (supports admin H1 override)
- **Breadcrumbs** (linked to parent pages)
- **Lead paragraph** with keyword used naturally
- **CTA row** — free site list link + phone + WhatsApp
- **Detailed content** — service explanation, formats table, pricing factors, booking process
- **Statistics** — real company numbers (300+ hoardings, 2000+ sites, etc.)
- **Location inventory** — dynamic listing from the Location model (grouped by area)
- **FAQ section** — 5-7 questions with answers (feeds FAQPage schema)
- **Campaigns block** — real case studies linked to campaign pages
- **Cross-links** — links to related keyword pages
- **CTA footer** — final call-to-action

### Step 6.4: Create Shared Partials

- `keyword-page-style.blade.php` — shared CSS for keyword page layout
- `campaigns-block` partial — shows related campaigns with links to case study pages
- Reused existing partials: `breadcrumbs`, `faq`, `page-copy`

---

## Phase 7: Page Content CMS

**Goal:** Let the admin edit page text without touching code.

### Step 7.1: Build the CMS Service

Created `app/Services/Cms/Cms.php`:
- **scan()** — renders a page internally, extracts all headings (H1-H6) and paragraphs, assigns unique keys based on text hash
- **render()** — takes the template HTML output and applies admin overrides from `cms_elements`
- **Protected regions** — `<!--cms:skip-->` / `<!--/cms:skip-->` blocks are excluded from editing (used for FAQ text that feeds schema)

### Step 7.2: Build the HTML Sanitizer

Created `app/Services/Cms/HtmlSanitizer.php`:
- Whitelist approach: only allows safe tags
- Inline: `<a>`, `<strong>`, `<b>`, `<em>`, `<i>`, `<br>`
- Block (page copy): `<p>`, `<h2>`-`<h6>`, `<ul>`, `<ol>`, `<li>`
- Link hrefs: only `/`, `https://`, `mailto:`, `tel:` allowed
- Strips everything else (`<script>`, `<iframe>`, `<style>`, etc.)

### Step 7.3: Build the Page Content Controller

Created `app/Http/Controllers/Admin/PageContentController.php`:
- **List page** — shows all pages grouped by type
- **Edit page** — shows all editable headings/paragraphs, page copy textarea, related links editor
- **Save** — validates content, rescans the page, writes overrides to `cms_elements` in a transaction
- **Link validation** — checks that related links and page copy URLs point to real pages

### Step 7.4: Create the Page Copy Partial

Created `resources/views/web/common/page-copy.blade.php`:
- Renders `seo_meta.page_copy` (sanitized HTML) at the bottom of the page
- Renders `seo_meta.related_links` as a "Related pages" section (up to 12 links)

---

## Phase 8: Breadcrumbs

**Goal:** Show navigation trails and feed BreadcrumbList schema.

### Step 8.1: Build the Breadcrumb System

Used `config/seo_pages.php` parent chains for static pages:
```
Home → OOH Media → Hoarding Advertising Ahmedabad
```

For dynamic pages, controllers call `SchemaBuilder::setBreadcrumbs()`.

### Step 8.2: Create the Breadcrumb Partial

Created `resources/views/web/common/breadcrumbs.blade.php`:
- Calls `SchemaBuilder::trail($seo)` to get the breadcrumb items
- Renders visible `<nav>` breadcrumb
- **Visible and schema breadcrumbs always match** because both use the same `trail()` function

---

## Phase 9: Canonical URLs & HTTPS Enforcement

**Goal:** Prevent duplicate content and ensure consistent URLs.

### Step 9.1: Build Canonical URL Logic

In `SeoResolver.php`:
- `canonicalFor($path)` — builds canonical from `APP_URL` (always https, no www, no query strings)
- Admin can override per page via `seo_meta.canonical_url`
- Output as `<link rel="canonical" href="...">` in seo-head

### Step 9.2: Force HTTPS in Production

Added to `AppServiceProvider.php`:
```php
if ($this->app->environment('production')) {
    URL::forceRootUrl(config('app.url'));
    URL::forceScheme('https');
}
```

**Why:** Hostinger's proxy sometimes passes `http://` URLs to Laravel. This ensures all generated URLs are always `https://`.

---

## Phase 10: Image SEO

**Goal:** Optimize images for speed and add alt text for accessibility.

### Step 10.1: Build the Image Optimizer

Created `app/Services/ImageOptimizer.php`:
- On every image upload from admin panel: convert to WebP at 82% quality
- Result is 40-60% smaller than the original
- Falls back to original if WebP conversion fails

### Step 10.2: Add Alt Text Fields

Created a migration adding `alt_text` and `title_text` columns to category media.
Locations, campaigns, projects, and testimonials already had `alt_text` columns.

### Step 10.3: Use Responsive Images in Templates

All keyword page templates use:
```html
<img srcset="image-800w.webp 800w, image.webp 1600w"
     sizes="(max-width: 860px) 100vw, 45vw"
     alt="Descriptive alt text"
     loading="lazy"
     decoding="async">
```

Hero images use `fetchpriority="high"` + `loading="eager"` for fast first paint.

---

## Phase 11: Tracking & Verification

**Goal:** Set up analytics, event tracking, and search console.

### Step 11.1: Google Search Console Verification

Uploaded `public_html/google09786c7f663b05e9.html` for HTML file verification.
Also added meta tag verification support via admin SEO Settings.

### Step 11.2: GA4 and GTM — Lazy Loading

Updated `resources/views/web/layouts/app.blade.php`:
- GA4 and GTM scripts are **not loaded on page load**
- They load on **first user interaction** (click, keypress, scroll, touch) **or** browser idle callback (4s timeout)
- This prevents analytics from blocking the first paint

```javascript
['pointerdown', 'keydown', 'scroll', 'touchstart'].forEach(function (e) {
    window.addEventListener(e, load, { capture: true, once: true, passive: true });
});
window.addEventListener('load', function () {
    requestIdleCallback(load, { timeout: 4000 });
});
```

### Step 11.3: Custom Event Tracking

Created `public_html/js/tracking.js`:
- Uses delegated document listeners (single listener per event type)
- Automatically tracks: `click_call`, `click_email`, `click_whatsapp`, `chat_start`, `generate_lead`

### Step 11.4: Facebook Pixel

Admin can paste the full Facebook Pixel HTML code in SEO Settings → injected via `body_custom_code`.

---

## Phase 12: Performance Optimization

**Goal:** Make pages load fast (Google uses speed as a ranking factor).

### Step 12.1: Per-Page CSS Bundles

Instead of one large CSS file, created per-template bundles:
- `bundle-home.min.css`
- `bundle-keyword.min.css`
- `bundle-inner.min.css`
- etc.

Each page loads only the CSS it needs.

### Step 12.2: JavaScript Optimization

- All JS files minified: `main.min.js`, `kr-laravel.min.js`, `tracking.min.js`
- All loaded with `defer` attribute (non-render-blocking)

### Step 12.3: Font Loading

Google Fonts loaded with preload + font-display swap:
```html
<link rel="preload" as="style" href="fonts-url" onload="this.rel='stylesheet'"/>
```
Text renders immediately with fallback font; Google Font loads async.

### Step 12.4: Lazy CSRF Token

Forms don't include CSRF token in page HTML. Instead, they fetch the token via AJAX on first user interaction. This makes pages fully cacheable by CDN/proxy.

### Step 12.5: Sitemap Caching

`Cache::rememberForever()` — sitemap builds once and stays cached until model data changes trigger a flush.

---

## Phase 13: Location Page Quality Gate

**Goal:** Prevent thin content pages from hurting SEO.

### Step 13.1: Build the LocationPageGate

Created `app/Services/LocationPageGate.php`:

A location page stays `noindex` until ALL conditions are met:
1. Every location entry has a real photo (not a placeholder)
2. Every location entry has an area name (≥ 3 characters)
3. Every location entry has a size value
4. The page copy has ≥ 300 words of unique text

### Step 13.2: Wire It Into the Controller

```php
// LocationController.php
if (!LocationPageGate::passes($locations, $seo->meta)) {
    $seo->forceNoindex();  // noindex,follow
}
```

The page still renders for users, but Google won't index it. It also won't appear in the sitemap.

---

## Phase 14: SEO Health & Revision History

**Goal:** Catch quality issues and track who changed what.

### Step 14.1: Build the SEO Health Service

Created `app/Services/SeoHealth.php`:
- Empty title → Error
- Title outside 30-60 chars → Warning
- Empty description → Error
- Description outside 140-160 chars → Warning

Used in: admin edit page (shows warnings) + sitemap generation (excludes pages with empty title/description).

### Step 14.2: Implement Revision History

On every SEO save:
1. Capture `$before = $meta->only(SeoMeta::REVISIONED_FIELDS)`
2. Apply changes
3. If before ≠ after → create `SeoMetaRevision` with `snapshot_json = $before`
4. Admin can view history and restore any previous version

---

## Phase 15: Internal Linking & CTAs

**Goal:** Build a strong internal link structure and drive conversions.

### Step 15.1: Related Links System

Admin can add up to 12 related links per page from the Page Content editor.
Links are validated against real pages on save.
Rendered at the bottom of every page.

### Step 15.2: Cross-Linking Keyword Pages

Each keyword page links to related keyword pages:
```
Hoarding → links to AMTS bus, Bus shelter, GSRTC bus
Mumbai agency → links to Local train, BEST bus, TMT bus
```

### Step 15.3: Hub Links on Service Pages

The `/services` page links to all keyword pages, creating a hub-and-spoke link structure.

### Step 15.4: Free Site List CTA

Created the `/free-site-list` landing page as the main conversion point.
Every keyword page has a prominent CTA linking to it.
The page is set to `noindex` (conversion page, not meant for search).

### Step 15.5: WhatsApp Links

Every keyword page includes a WhatsApp link with a pre-filled message.
`SeoResolver::whatsappUrl()` builds the `wa.me` URL with the right phone number based on page region.

---

## Phase 16: WordPress Blog Integration

**Goal:** Ensure the blog's SEO works alongside the main site.

### What Was Done:

1. Added both sitemaps to robots.txt: main + WordPress (`wp-sitemap.xml`)
2. Blocked blog admin URLs in robots.txt
3. WordPress handles its own SEO via plugins (Yoast/RankMath)
4. Added `llms.txt` for AI crawler guidance
5. Added blog link in the site header

---

## Phase 17: Accessibility & Heading Hierarchy

**Goal:** Proper HTML structure for both SEO and accessibility.

### What Was Done:

1. Ran an **axe audit** on every page
2. Fixed heading hierarchy (no skipped levels: H1 → H2 → H3)
3. Added alt text to all images
4. Ensured proper contrast ratios
5. Fixed keyboard navigation issues
6. Added ARIA labels where needed

---

## Summary: Complete File List Created/Modified for SEO

### Files Created (New)

```
# Models
app/Models/SeoMeta.php
app/Models/SeoSetting.php
app/Models/SeoRedirect.php
app/Models/Seo404Log.php
app/Models/SeoMetaRevision.php
app/Models/CmsElement.php

# Trait
app/Traits/HasSeoMeta.php

# Services
app/Services/SeoResolver.php
app/Services/SchemaBuilder.php
app/Services/SitemapService.php
app/Services/SeoHealth.php
app/Services/LocationPageGate.php
app/Services/Cms/Cms.php
app/Services/Cms/HtmlSanitizer.php
app/Services/ImageOptimizer.php

# Admin Controllers
app/Http/Controllers/Admin/SeoMetaController.php
app/Http/Controllers/Admin/SeoSettingController.php
app/Http/Controllers/Admin/SeoRedirectController.php
app/Http/Controllers/Admin/Seo404LogController.php
app/Http/Controllers/Admin/SeoTodoController.php
app/Http/Controllers/Admin/PageContentController.php

# Web Controllers
app/Http/Controllers/Web/SeoController.php

# Middleware
app/Http/Middleware/HandleSeoRedirects.php

# Config
config/seo_pages.php
config/business.php
config/campaigns.php

# Blade Partials
resources/views/web/common/seo-head.blade.php
resources/views/web/common/breadcrumbs.blade.php
resources/views/web/common/page-copy.blade.php
resources/views/web/common/faq.blade.php
resources/views/web/common/sitemap-xml.blade.php
resources/views/web/common/keyword-page-style.blade.php

# Keyword Landing Pages (10)
resources/views/web/pages/keywords/hoarding-advertising-ahmedabad.blade.php
resources/views/web/pages/keywords/amts-bus-advertising-ahmedabad.blade.php
resources/views/web/pages/keywords/bus-shelter-advertising-ahmedabad.blade.php
resources/views/web/pages/keywords/gsrtc-bus-advertising.blade.php
resources/views/web/pages/keywords/outdoor-advertising-agency-mumbai.blade.php
resources/views/web/pages/keywords/mumbai-local-train-advertising.blade.php
resources/views/web/pages/keywords/best-bus-advertising-mumbai.blade.php
resources/views/web/pages/keywords/tmt-bus-advertising-thane.blade.php
resources/views/web/pages/keywords/social-media-marketing-ahmedabad.blade.php
resources/views/web/pages/keywords/social-media-marketing-mumbai.blade.php

# Admin Views (11)
resources/views/admin/pages/seo/seo-list.blade.php
resources/views/admin/pages/seo/seo-update.blade.php
resources/views/admin/pages/seo/seo-settings.blade.php
resources/views/admin/pages/seo/redirect-list.blade.php
resources/views/admin/pages/seo/redirect-create.blade.php
resources/views/admin/pages/seo/redirect-update.blade.php
resources/views/admin/pages/seo/log-404-list.blade.php
resources/views/admin/pages/seo/todo-list.blade.php
resources/views/admin/pages/content/content-list.blade.php
resources/views/admin/pages/content/content-edit.blade.php
resources/views/admin/pages/content/_styles.blade.php

# Error Page
resources/views/errors/404.blade.php

# Static Files
public_html/google09786c7f663b05e9.html
public_html/js/tracking.js

# Migrations (13)
database/migrations/2026_10_16_225212_create_seo_meta_table.php
database/migrations/2026_10_16_225212_create_seo_redirects_table.php
database/migrations/2026_10_16_225212_create_seo_settings_table.php
database/migrations/2026_10_16_225213_create_seo_404_logs_table.php
database/migrations/2026_10_16_230450_add_skip_title_template_to_seo_meta_table.php
database/migrations/2026_10_17_155449_drop_custom_slug_from_seo_meta_table.php
database/migrations/2026_10_17_155450_create_seo_meta_revisions_table.php
database/migrations/2026_10_18_000001_upsert_static_page_seo_meta.php
database/migrations/2026_10_18_000003_add_contact_and_schema_settings_to_seo_settings.php
database/migrations/2026_10_18_000004_add_free_site_list_seo_and_ga4_setting.php
database/migrations/2026_10_18_000005_backfill_category_seo_meta.php
database/migrations/2026_10_20_000001_create_cms_elements_and_related_links.php
database/migrations/2026_11_04_000001_set_hoarding_seo_og_image_and_case_study_alt.php
```

### Files Modified (Existing)

```
# Models (added HasSeoMeta trait)
app/Models/Category.php
app/Models/Campaign.php
app/Models/Location.php

# Enum (added SEO permissions)
app/Enums/Permission.php

# Exception Handler (added 404 logging)
app/Exceptions/Handler.php

# App Service Provider (HTTPS force + sitemap cache flush)
app/Providers/AppServiceProvider.php

# HTTP Kernel (registered redirect middleware)
app/Http/Kernel.php

# Routes
routes/web.php          — keyword routes, legacy redirects, sitemap/robots routes
routes/admin.php        — all SEO admin routes

# Main Layout (added seo-head, GA4/GTM lazy load, font preload)
resources/views/web/layouts/app.blade.php

# Static robots.txt (baseline)
public_html/robots.txt
```

---

## Replication Checklist — Use This for a New Project

When starting SEO on a new Laravel project, follow these phases in order:

- [ ] **Phase 1:** Create DB tables (seo_meta, seo_settings, seo_redirects, seo_404_logs, seo_meta_revisions, cms_elements)
- [ ] **Phase 1:** Create models (SeoMeta, SeoSetting, SeoRedirect, Seo404Log, SeoMetaRevision, CmsElement)
- [ ] **Phase 1:** Create HasSeoMeta trait, add to relevant models
- [ ] **Phase 1:** Create config/seo_pages.php with all static pages
- [ ] **Phase 1:** Create config/business.php with NAP data
- [ ] **Phase 1:** Build SeoResolver service
- [ ] **Phase 1:** Create seo-head.blade.php partial
- [ ] **Phase 1:** Wire $seo into every route
- [ ] **Phase 2:** Add SEO permissions to Permission enum
- [ ] **Phase 2:** Build admin controllers (SeoMeta, SeoSetting, Redirect, 404Log, Todo, PageContent)
- [ ] **Phase 2:** Build admin views (11 templates)
- [ ] **Phase 2:** Register admin routes
- [ ] **Phase 3:** Build SchemaBuilder service
- [ ] **Phase 3:** Create FAQ partial (feeds visible + schema)
- [ ] **Phase 4:** Build SitemapService + cache flushing
- [ ] **Phase 4:** Build dynamic robots.txt
- [ ] **Phase 4:** Register sitemap.xml and robots.txt routes
- [ ] **Phase 5:** Build HandleSeoRedirects middleware
- [ ] **Phase 5:** Add 404 logging to exception handler
- [ ] **Phase 5:** Add legacy redirects in routes
- [ ] **Phase 5:** Create custom 404 page
- [ ] **Phase 6:** Identify target keywords
- [ ] **Phase 6:** Create keyword landing pages (config + route + template)
- [ ] **Phase 7:** Build CMS service (scan, render, overrides)
- [ ] **Phase 7:** Build HtmlSanitizer
- [ ] **Phase 7:** Build PageContent controller and views
- [ ] **Phase 7:** Create page-copy partial
- [ ] **Phase 8:** Build breadcrumb system (partial + schema integration)
- [ ] **Phase 9:** Implement canonical URL logic
- [ ] **Phase 9:** Force HTTPS in production
- [ ] **Phase 10:** Build ImageOptimizer (WebP conversion)
- [ ] **Phase 10:** Add alt text fields to models
- [ ] **Phase 10:** Use srcset + lazy loading in templates
- [ ] **Phase 11:** Upload GSC verification file
- [ ] **Phase 11:** Implement GA4/GTM lazy loading
- [ ] **Phase 11:** Create tracking.js for custom events
- [ ] **Phase 12:** Create per-page CSS bundles
- [ ] **Phase 12:** Minify and defer all JS
- [ ] **Phase 12:** Implement font preloading
- [ ] **Phase 12:** Implement lazy CSRF token
- [ ] **Phase 13:** Build LocationPageGate (or equivalent quality gate)
- [ ] **Phase 14:** Build SeoHealth service
- [ ] **Phase 14:** Implement revision history
- [ ] **Phase 15:** Build related links system
- [ ] **Phase 15:** Cross-link keyword pages
- [ ] **Phase 15:** Create conversion landing page
- [ ] **Phase 16:** Integrate blog sitemaps in robots.txt
- [ ] **Phase 17:** Run accessibility audit and fix issues

---

*Last updated: November 2026*
*Based on the complete SEO implementation of krishnaoutdoor.in*
