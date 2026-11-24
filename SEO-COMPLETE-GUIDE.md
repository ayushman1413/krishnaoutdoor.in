# Krishna Outdoor — Complete SEO Guide

> This document is written for beginners.
> Even if you have no prior SEO knowledge, reading this will help you understand how SEO works on this website and how you can replicate the same approach on a different website.

***

## Table of Contents

1. [What is SEO? (Basics)](#1-what-is-seo-basics)
2. [Website Overview](#2-website-overview)
3. [SEO Architecture — How Everything Connects](#3-seo-architecture--how-everything-connects)
4. [Database Tables — Where Data is Stored](#4-database-tables--where-data-is-stored)
5. [Managing SEO from the Admin Panel](#5-managing-seo-from-the-admin-panel)
6. [Meta Title, Description, Keywords — How They Work](#6-meta-title-description-keywords--how-they-work)
7. [Title Template System](#7-title-template-system)
8. [Open Graph & Twitter Cards — Social Sharing](#8-open-graph--twitter-cards--social-sharing)
9. [Schema / Structured Data (JSON-LD)](#9-schema--structured-data-json-ld)
10. [Sitemap.xml — Telling Google About Your Pages](#10-sitemapxml--telling-google-about-your-pages)
11. [Robots.txt — Giving Rules to Google](#11-robotstxt--giving-rules-to-google)
12. [Canonical URLs — Avoiding Duplicate Pages](#12-canonical-urls--avoiding-duplicate-pages)
13. [Keyword Landing Pages — Dedicated Pages for Target Keywords](#13-keyword-landing-pages--dedicated-pages-for-target-keywords)
14. [Page Content CMS — Editing Page Text from Admin](#14-page-content-cms--editing-page-text-from-admin)
15. [H1 Override — Changing the Main Heading](#15-h1-override--changing-the-main-heading)
16. [Breadcrumbs — Navigation Trail](#16-breadcrumbs--navigation-trail)
17. [301 Redirects — Sending Old URLs to New Ones](#17-301-redirects--sending-old-urls-to-new-ones)
18. [404 Logging — Tracking Broken Links](#18-404-logging--tracking-broken-links)
19. [Noindex / Nofollow — Hiding Pages from Google](#19-noindex--nofollow--hiding-pages-from-google)
20. [Image SEO — Alt Text and WebP Compression](#20-image-seo--alt-text-and-webp-compression)
21. [Google Search Console Verification](#21-google-search-console-verification)
22. [GA4, GTM, Facebook Pixel — Tracking Setup](#22-ga4-gtm-facebook-pixel--tracking-setup)
23. [Page Copy & Related Links — Internal Linking](#23-page-copy--related-links--internal-linking)
24. [FAQ Schema — What You See is What Google Gets](#24-faq-schema--what-you-see-is-what-google-gets)
25. [SEO Health Checks — Warnings and Errors](#25-seo-health-checks--warnings-and-errors)
26. [SEO Revision History — Who Changed What](#26-seo-revision-history--who-changed-what)
27. [CSV Export / Import — Bulk SEO Changes](#27-csv-export--import--bulk-seo-changes)
28. [SEO TODOs — What Still Needs to Be Done](#28-seo-todos--what-still-needs-to-be-done)
29. [Location Page Quality Gate](#29-location-page-quality-gate)
30. [Performance — Speed for SEO](#30-performance--speed-for-seo)
31. [WordPress Blog SEO](#31-wordpress-blog-seo)
32. [File Map — Where Each File Lives](#32-file-map--where-each-file-lives)
33. [How to Replicate This SEO on Another Website (Step by Step)](#33-how-to-replicate-this-seo-on-another-website-step-by-step)

***

## 1. What is SEO? (Basics)

**SEO = Search Engine Optimization**

When someone searches Google for "hoarding advertising in Ahmedabad", Google decides which of millions of websites to show on the first page. SEO is the practice of building and optimizing your website so that Google ranks it higher.

### How Does Google Decide Rankings?

Google sends a robot (crawler/spider) that:

1. **Crawls** — reads every page of your website
2. **Indexes** — stores the page in its library
3. **Ranks** — decides the page's position in search results

### What Does Google Need?

| Element              | Purpose                                                    | Example                                                  |
| -------------------- | ---------------------------------------------------------- | -------------------------------------------------------- |
| **Meta Title**       | The page name Google displays in search results            | "Hoarding Advertising Ahmedabad \| Krishna Outdoor"      |
| **Meta Description** | A 2-line summary shown beneath the title in search results | "Hoarding advertising in Ahmedabad on 300+ own sites..." |
| **H1 Heading**       | The main heading on the page                               | "HOARDING ADVERTISING IN AHMEDABAD"                      |
| **Content**          | Useful text written on the page                            | Details about hoardings, formats, pricing                |
| **Schema**           | Hidden structured data for search engines                  | Business address, FAQ, services (JSON-LD format)         |
| **Sitemap**          | A list of all pages on the site                            | sitemap.xml file                                         |
| **Robots.txt**       | Rules — what to crawl and what not to                      | robots.txt file                                          |
| **Canonical URL**    | "This is the official URL for this page"                   | Prevents duplicate content issues                        |
| **Page Speed**       | How fast the page loads                                    | Compressed images, minified CSS                          |
| **Internal Links**   | Pages linked to each other within the site                 | Related pages section                                    |
| **Alt Text**         | Text description of images                                 | Used by screen readers + Google Image Search             |
| **HTTPS**            | Secure connection                                          | SSL certificate                                          |
| **Mobile Friendly**  | Page displays properly on phones                           | Responsive design                                        |

***

## 2. Website Overview

**Website:** krishnaoutdoor.in
**Business:** Krishna Outdoor — outdoor advertising agency (hoardings, bus ads, train ads) since 1985
**Tech Stack:**

| Component    | Technology                             |
| ------------ | -------------------------------------- |
| Main Website | **Laravel** (PHP framework)            |
| Blog         | **WordPress** at /blog/                |
| Static Files | public\_html/ folder (CSS, JS, images) |
| Database     | MySQL                                  |
| Hosting      | Hostinger                              |
| Domain       | krishnaoutdoor.in                      |

### Page Types on the Website

| Type                      | URL Pattern                 | Example                          | SEO Source                    |
| ------------------------- | --------------------------- | -------------------------------- | ----------------------------- |
| Static Pages              | Fixed URLs                  | /, /about, /contact              | `config/seo_pages.php` + DB   |
| Keyword Landing Pages     | /{keyword-slug}             | /hoarding-advertising-ahmedabad  | `config/seo_pages.php` + DB   |
| Category Pages            | /{slug} or /category/{slug} | /hoardings, /category/unipoles   | DB (Category model)           |
| Campaign/Case Study Pages | /projects/{slug}            | /projects/torrent-power          | DB (Campaign model)           |
| Location Pages            | /locations/{city}           | /locations/ahmedabad             | DB (Location + SeoMeta)       |
| Media Pages               | /media/{type}               | /media/ooh, /media/transit       | `config/seo_pages.php` + DB   |
| Blog                      | /blog/\*                    | /blog/outdoor-advertising-trends | WordPress handles its own SEO |

***

## 3. SEO Architecture — How Everything Connects

```
┌─────────────────────────────────────────────────────────────┐
│                     ADMIN PANEL                              │
│                                                              │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌──────────┐    │
│  │ SEO Meta │  │ SEO      │  │ Redirects│  │ 404 Logs │    │
│  │ (per page│  │ Settings │  │ Manager  │  │          │    │
│  │  editor) │  │ (global) │  │          │  │          │    │
│  └────┬─────┘  └────┬─────┘  └────┬─────┘  └────┬─────┘    │
│       │              │              │              │          │
│  ┌────┴──┐     ┌─────┴───┐   ┌─────┴───┐    ┌────┴───┐     │
│  │Page   │     │Content  │   │SEO      │    │SEO     │     │
│  │Content│     │TODOs    │   │Health   │    │Revision│     │
│  │CMS    │     │         │   │Checks   │    │History │     │
│  └───────┘     └─────────┘   └─────────┘    └────────┘     │
└─────────────────────────────────────────────────────────────┘
        │                │
        ▼                ▼
┌─────────────────────────────────────────────────────────────┐
│                   DATABASE (MySQL)                            │
│                                                              │
│  seo_meta          seo_settings       seo_redirects          │
│  seo_meta_revisions                   seo_404_logs           │
│  cms_elements                                                │
└─────────────────────────────────────────────────────────────┘
        │                │
        ▼                ▼
┌─────────────────────────────────────────────────────────────┐
│                   SERVICES (PHP)                             │
│                                                              │
│  SeoResolver      → merges DB + config → final SEO values   │
│  SchemaBuilder    → builds JSON-LD structured data           │
│  SitemapService   → generates sitemap.xml                    │
│  SeoHealth        → checks title/description quality         │
│  LocationPageGate → decides if a location page can be indexed│
│  Cms              → applies admin's text changes to pages    │
│  ImageOptimizer   → compresses images to WebP                │
└─────────────────────────────────────────────────────────────┘
        │
        ▼
┌─────────────────────────────────────────────────────────────┐
│              PUBLIC WEBSITE (HTML output)                     │
│                                                              │
│  <title>         ← SeoResolver.pageTitle                     │
│  <meta desc>     ← SeoResolver.description                   │
│  <meta keywords> ← SeoMeta.meta_keywords                     │
│  <meta robots>   ← SeoResolver.robotsContent()               │
│  <link canonical> ← SeoResolver.canonicalUrl                  │
│  og:title/desc   ← SeoResolver.ogTitle()/ogDescription()     │
│  twitter:card    ← SeoResolver.twitterCard()                  │
│  JSON-LD schema  ← SchemaBuilder.json()                       │
│  /sitemap.xml    ← SitemapService                             │
│  /robots.txt     ← SeoController (from DB or default)         │
└─────────────────────────────────────────────────────────────┘
```

### Data Flow (Complete Journey of a Single Page)

1. **User visits** `/hoarding-advertising-ahmedabad`
2. **Middleware** `HandleSeoRedirects` checks: is there a redirect set for this URL? No → proceed
3. **Route** is matched in `web.php`
4. **Controller** calls `SeoResolver::forRoute('view.keyword.hoarding.ahmedabad')`
5. **SeoResolver** looks up this route\_name in the `seo_meta` database table
6. **SeoResolver** merges: DB values + config/seo\_pages.php fallbacks + seo\_settings (global defaults)
7. **View** is rendered → `seo-head.blade.php` uses the `$seo` variable to generate all meta tags
8. **SchemaBuilder** automatically builds Organization, LocalBusiness, Service, BreadcrumbList, and FAQ schema
9. **Cms::render()** applies the admin's heading/paragraph changes to the page
10. **page-copy.blade.php** displays the body text and related links at the bottom of the page
11. **Final HTML** is sent to the browser — this is also what Google sees

***

## 4. Database Tables — Where Data is Stored

### 4.1 `seo_meta` — SEO Data for Every Page

This is the most important table. Every page (static or dynamic) has one row.

| Column                 | Type         | What it Stores                                                                   |
| ---------------------- | ------------ | -------------------------------------------------------------------------------- |
| `id`                   | UUID         | Unique identifier                                                                |
| `seoable_type`         | string       | Model class (Category, Campaign) — for dynamic pages                             |
| `seoable_id`           | UUID         | Model ID — for dynamic pages                                                     |
| `route_name`           | string       | Laravel route name — for static pages (e.g. `view.home`)                         |
| `meta_title`           | string (70)  | Page title — displayed in Google search results                                  |
| `meta_description`     | string (500) | 2-line summary — displayed in the Google snippet                                 |
| `meta_keywords`        | string       | Comma-separated keywords (Google ignores these, but some engines still use them) |
| `focus_keyword`        | string (100) | Primary keyword the page targets for ranking                                     |
| `skip_title_template`  | boolean      | True = do not apply the title template, use the title as-is                      |
| `canonical_url`        | string       | Override canonical URL if a different URL is the canonical source                |
| `robots_index`         | boolean      | True = Google should index this page, False = do not index                       |
| `robots_follow`        | boolean      | True = Google should follow links on this page                                   |
| `h1_override`          | string (150) | H1 heading override — can be changed from the admin panel                        |
| `og_title`             | string       | Facebook/LinkedIn share title                                                    |
| `og_description`       | string       | Facebook/LinkedIn share description                                              |
| `og_image`             | string       | Facebook/LinkedIn share image path                                               |
| `og_type`              | string       | `website` or `article`                                                           |
| `twitter_card`         | string       | `summary_large_image`                                                            |
| `twitter_title`        | string       | Twitter share title                                                              |
| `twitter_description`  | string       | Twitter share description                                                        |
| `twitter_image`        | string       | Twitter share image path                                                         |
| `schema_json`          | longText     | Extra custom JSON-LD schema (per page)                                           |
| `page_copy`            | longText     | Body text block (paragraphs, headings, links) shown at the bottom of the page    |
| `related_links`        | JSON         | Internal links array \[{label, url}] shown at the bottom of the page             |
| `exclude_from_sitemap` | boolean      | True = do not include in sitemap.xml                                             |

**How does the connection work?**

* Static pages (Home, About, etc.) → use the `route_name` column

* Categories → `seoable_type = Category` + `seoable_id` = category UUID

* Campaigns → `seoable_type = Campaign` + `seoable_id` = campaign UUID

* Location cities → `route_name = view.locations.city.ahmedabad` (treated like static pages)

### 4.2 `seo_settings` — Global SEO Settings (Single Row)

| Column                          | Purpose                                                            |
| ------------------------------- | ------------------------------------------------------------------ |
| `site_name`                     | "Krishna Outdoor" — used in the title template                     |
| `title_template`                | `{page_title} \| {site_name}` — format applied to every page title |
| `description_template`          | Auto-generates a description when a page's description is empty    |
| `default_og_image`              | Fallback OG image when a page has no specific OG image             |
| `favicon`                       | Website icon                                                       |
| `gsc_verification_code`         | Google Search Console verification code                            |
| `ga4_id`                        | Google Analytics 4 Measurement ID (e.g. G-XXXXXXXXXX)              |
| `gtm_id`                        | Google Tag Manager Container ID (e.g. GTM-XXXXXXX)                 |
| `fb_pixel_code`                 | Facebook Pixel HTML code                                           |
| `head_custom_code`              | Custom code to inject into `<head>`                                |
| `body_custom_code`              | Custom code to inject at the end of `<body>`                       |
| `organization_schema_json`      | Custom Organization schema (overrides the default)                 |
| `local_business_ahmedabad_json` | Custom LocalBusiness schema for Ahmedabad                          |
| `local_business_mumbai_json`    | Custom LocalBusiness schema for Mumbai                             |
| `robots_txt`                    | Dynamic robots.txt content                                         |
| `whatsapp_number`               | WhatsApp number override for Ahmedabad pages                       |

### 4.3 `seo_redirects` — URL Redirects

| Column      | Purpose                                   |
| ----------- | ----------------------------------------- |
| `old_url`   | Old URL (e.g. `/bus-advertisement`)       |
| `new_url`   | New URL (e.g. `/media/transit`)           |
| `type`      | `301` (permanent) or `302` (temporary)    |
| `status`    | Active or not                             |
| `hit_count` | Number of times someone hit this redirect |

### 4.4 `seo_404_logs` — Broken URL Tracking

| Column         | Purpose                           |
| -------------- | --------------------------------- |
| `url`          | Which URL is returning 404        |
| `referrer`     | Where the visitor came from       |
| `user_agent`   | Browser/bot name                  |
| `hit_count`    | Number of times this 404 occurred |
| `last_seen_at` | When it last occurred             |
| `resolved`     | Whether it has been fixed         |

### 4.5 `seo_meta_revisions` — Change History

| Column          | Purpose                                      |
| --------------- | -------------------------------------------- |
| `seo_meta_id`   | Which page's revision this is                |
| `admin_id`      | Who made the change                          |
| `snapshot_json` | Data **before** the change (the old version) |

### 4.6 `cms_elements` — Admin's Page Text Overrides

| Column        | Purpose                                               |
| ------------- | ----------------------------------------------------- |
| `seo_meta_id` | Which page this element belongs to                    |
| `element_key` | Element identifier (`h1`, `h:abc123:1`, `p:def456:1`) |
| `tag`         | Heading level override (`h2`, `h3`, etc.)             |
| `content`     | New text (null = use the template's default)          |
| `original`    | Template's original text (kept for reference)         |

***

## 5. Managing SEO from the Admin Panel

Admin panel URL: `https://krishnaoutdoor.in/admin/`

### 5.1 SEO Menu Structure

```
Admin Panel
├── SEO                          → /admin/seo
│   ├── Pages tab                → SEO list for static pages
│   ├── Categories tab           → SEO list for category pages
│   ├── Campaigns tab            → SEO list for campaign pages
│   ├── Locations tab            → SEO list for location city pages
│   ├── Export CSV               → Download all SEO data
│   └── Import CSV               → Bulk update
│
├── Page Content                 → /admin/content
│   ├── Pages tab                → Edit text on static pages
│   ├── Categories tab           → Edit text on category pages
│   ├── Campaigns tab            → Edit text on campaign pages
│   └── Locations tab            → Edit text on location pages
│
├── SEO Settings                 → /admin/seo-settings
│   (Global settings — title template, GA4, GTM, schema, robots.txt)
│
├── Redirects                    → /admin/redirect
│   ├── List                     → All redirects
│   ├── Create                   → New redirect
│   └── Import CSV               → Bulk import
│
├── 404 Logs                     → /admin/404-log
│   (Broken URLs that visitors are hitting)
│
└── Content TODOs                → /admin/seo-todos
    (What still needs to be done — missing content, photos, etc.)
```

### 5.2 Permissions System

The admin panel has role-based access. SEO-related permissions:

| Permission         | What it Allows                    |
| ------------------ | --------------------------------- |
| `VIEW_SEO`         | Can view the SEO list             |
| `EDIT_SEO`         | Can edit SEO meta data            |
| `MANAGE_REDIRECTS` | Can manage redirects and 404 logs |

These permissions are configured in Admin > Settings > Roles & Permissions.

### 5.3 How to Edit SEO for a Page

1. Log in to the admin panel
2. Click **SEO** in the left sidebar
3. Click the **Edit** button for the page you want to modify
4. The form will display these fields:

   * **Meta Title** — 30-60 characters recommended

   * **Skip Title Template** checkbox — if checked, the `| Krishna Outdoor` suffix will not be appended

   * **Meta Description** — 140-160 characters recommended

   * **Meta Keywords** — comma separated

   * **Focus Keyword** — primary target keyword

   * **Canonical URL** — change only if needed

   * **Robots** — Index/NoIndex, Follow/NoFollow checkboxes

   * **H1 Override** — change the page's main heading

   * **OG Title, Description, Image** — for social sharing

   * **Twitter Title, Description, Image** — for Twitter

   * **Schema JSON** — extra structured data (advanced)

   * **Exclude from Sitemap** — remove from sitemap
5. Click **Save**
6. The previous version is automatically saved to the revision history

***

## 6. Meta Title, Description, Keywords — How They Work

### Meta Title

**What is it?** It appears in the browser tab and as the blue link in Google search results.

```html
<title>Hoarding Advertising Ahmedabad | Outdoor Ads Since 1985 | Krishna Outdoor</title>
```

**How is it built?** (Priority order — the first available value is used)

1. `seo_meta.meta_title` — if the admin has set it in the database
2. `config/seo_pages.php` `title` — fallback for static pages
3. Dynamic fallback — the Category name, Campaign name, etc.

Then the **title template** is applied:

```
{page_title} | {site_name}
```

Example: "Hoarding Advertising Ahmedabad" → "Hoarding Advertising Ahmedabad | Krishna Outdoor"

If `skip_title_template = true`, the template is not applied — useful when the title is already complete.

**Code location:** `SeoResolver.php` line 34-37, 142-156

### Meta Description

**What is it?** The 2-line text shown below the title in Google search results.

```html
<meta name="description" content="Hoarding advertising in Ahmedabad on 300+ own sites...">
```

**How is it built?**

1. `seo_meta.meta_description` — from the database
2. `config/seo_pages.php` `description` — fallback
3. `description_template` — if both are empty, auto-generate:

   ```
   "Learn about {page_title} from {site_name}..."
   ```

**Code location:** `SeoResolver.php` line 38-46

### Meta Keywords

```html
<meta name="keywords" content="hoarding advertising ahmedabad, billboard advertising, outdoor ads">
```

**Note:** Google officially ignores the keywords tag, but some search engines (Bing, etc.) still use it. This value comes purely from `seo_meta.meta_keywords`.

**Code location:** `seo-head.blade.php` line 6-8

### How Everything Connects — A Diagram

```
Admin Panel (SEO Edit Form)
         │
         ▼
    seo_meta table
    ┌──────────────────┐
    │ meta_title       │──→ SeoResolver.pageTitle ──→ <title>
    │ meta_description │──→ SeoResolver.description ──→ <meta description>
    │ meta_keywords    │──→ direct ──→ <meta keywords>
    │ focus_keyword    │──→ reference only (for admin tracking)
    └──────────────────┘
         │
    seo_settings table
    ┌──────────────────┐
    │ title_template   │──→ wraps the title: "{page_title} | {site_name}"
    │ site_name        │──→ "Krishna Outdoor"
    │ description_template │──→ auto-generates description if empty
    └──────────────────┘
```

***

## 7. Title Template System

### How It Works

The `seo_settings` table has a `title_template` field:

```
{page_title} | {site_name}
```

Whenever a page is rendered:

1. `{page_title}` → the page's meta\_title (or fallback title)
2. `{site_name}` → seo\_settings.site\_name (default: "Krishna Outdoor")

**Example:**

* Page title: "Hoarding Advertising Ahmedabad"

* Template: `{page_title} | {site_name}`

* Result: "Hoarding Advertising Ahmedabad | Krishna Outdoor"

### Skip Title Template

Some pages already have a complete title, such as:

```
"Outdoor Advertising Agency in Ahmedabad | Krishna Outdoor"
```

If the template were applied: "Outdoor Advertising Agency in Ahmedabad | Krishna Outdoor | Krishna Outdoor" — the site name would be doubled!

This is why the `skip_title_template` checkbox exists. When checked, the title is used as-is.

**Code:** `SeoResolver.php` line 35-37

***

## 8. Open Graph & Twitter Cards — Social Sharing

### Open Graph (OG) Tags — Facebook, LinkedIn, WhatsApp

When someone shares a website link on WhatsApp or Facebook, a preview card appears — with a title, description, and image. This comes from OG tags.

```html
<meta property="og:type" content="website">
<meta property="og:title" content="Hoarding Advertising Ahmedabad | Krishna Outdoor">
<meta property="og:description" content="Hoarding advertising in Ahmedabad...">
<meta property="og:image" content="https://krishnaoutdoor.in/storage/seo/og-hoarding.webp">
<meta property="og:url" content="https://krishnaoutdoor.in/hoarding-advertising-ahmedabad">
<meta property="og:site_name" content="Krishna Outdoor">
```

### Twitter Cards

Twitter has its own set of tags (but if they are empty, OG values are used as fallback):

```html
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="...">
<meta name="twitter:description" content="...">
<meta name="twitter:image" content="...">
```

### Fallback Chain (for Image)

```
Page OG Image (seo_meta.og_image)
      ↓ (if empty)
Page Featured Image (category cover, campaign image)
      ↓ (if empty)
Default OG Image (seo_settings.default_og_image)
```

### How Can an Admin Set These?

1. Admin > SEO > Edit the page
2. Scroll down to the "Open Graph" section and set the title, description, and image
3. If left empty, the meta title/description will automatically be used

**Code:** `SeoResolver.php` line 173-236, `seo-head.blade.php` line 12-30

***

## 9. Schema / Structured Data (JSON-LD)

### What is Schema?

Schema is hidden code that tells Google what the page contains — whether it's a business, a service, an FAQ, etc. Google uses this to display "rich results" (star ratings, FAQ dropdowns, business info boxes, etc.).

### What Schemas Does This Website Use?

All schemas are combined into a single `@graph` array inside a `<script type="application/ld+json">` tag:

| Schema Type        | Where it Appears          | What it Describes                                      |
| ------------------ | ------------------------- | ------------------------------------------------------ |
| **Organization**   | Every page                | Company name, logo, phone, email, social links         |
| **WebSite**        | Home page only            | Website name, URL, publisher                           |
| **LocalBusiness**  | Region-based pages        | Office address, phone, map, area served, opening hours |
| **Service**        | Keyword landing pages     | Service type, area served, description                 |
| **FAQPage**        | Pages with an FAQ section | Questions & answers (Google FAQ rich results)          |
| **BreadcrumbList** | Every page                | Navigation path (Home > Services > Hoardings)          |
| **VideoObject**    | Pages with videos         | Video name, thumbnail, content URL                     |

### How Is It Built?

**File:** `SchemaBuilder.php`

```php
// Every page gets Organization + BreadcrumbList at minimum
$graph = [self::organization($seo)];

// Home page also gets WebSite
if ($seo->routeName === 'view.home') {
    $graph[] = WebSite schema...
}

// LocalBusiness based on the page's region (Ahmedabad and/or Mumbai)
if ($region === 'ahmedabad' || $region === 'both') {
    $graph[] = LocalBusiness for Ahmedabad
}

// Keyword pages get a Service schema
if (!empty($page['service'])) {
    $graph[] = Service schema...
}

// If the page has an FAQ section
if (self::$faqs) {
    $graph[] = FAQPage schema...
}
```

### How Can an Admin Customize Schema?

1. **Per-page custom schema:** Admin > SEO > Edit page > "Schema JSON" textarea
2. **Organization schema:** Admin > SEO Settings > "Organization Schema JSON"
3. **LocalBusiness schemas:** Admin > SEO Settings > Ahmedabad/Mumbai LocalBusiness JSON

Custom schema is output in a separate `<script>` tag in `seo-head.blade.php` (after the auto-generated graph).

### Service Schema — Comes from config/seo\_pages.php

Keyword pages have a `'service'` key defined:

```php
'view.keyword.hoarding.ahmedabad' => [
    ...
    'service' => [
        'name' => 'Hoarding Advertising in Ahmedabad',
        'type' => 'Outdoor hoarding / billboard advertising',
        'area' => ['Ahmedabad', 'Gujarat'],
    ],
],
```

This is automatically converted into a Service schema.

**Code:** `SchemaBuilder.php` line 143-210, `seo-head.blade.php` line 32-36

***

## 10. Sitemap.xml — Telling Google About Your Pages

### What is a Sitemap?

An XML file that tells Google: "These are all my pages, please crawl them." It is submitted via Google Search Console.

**URL:** `https://krishnaoutdoor.in/sitemap.xml`

### How Is It Generated?

**File:** `SitemapService.php`

It is built dynamically (not a static file). Steps:

1. Add all static pages from `config/seo_pages.php`
2. Add all active categories from the database
3. Add all active campaigns (with slugs) from the database
4. Add all active location cities from the database (if they pass the quality gate)
5. Cache the result (until any SeoMeta, Category, Location, or Campaign changes)

### What Gets Included? What Gets Excluded?

**Included:**

* Pages where `robots_index = true`

* Pages where `exclude_from_sitemap = false`

* Pages where both title and description are filled (health check passes)

* Location pages that pass the `LocationPageGate`

**Excluded:**

* `noindex` pages

* `exclude_from_sitemap = true` pages

* Pages with an empty title or description

* `/free-site-list` (conversion landing page, `index: false` in config)

### How Is the Cache Flushed?

In `AppServiceProvider.php`:

```php
foreach ([SeoMeta, Category, Location, Campaign] as $model) {
    $model::saved(fn () => SitemapService::flush());
    $model::deleted(fn () => SitemapService::flush());
}
```

This means: whenever any SEO data changes, a category is added/edited, or a location changes — the sitemap cache is cleared and rebuilt on the next request.

### Route

```php
Route::get('/sitemap.xml', [SeoController::class, 'sitemap']);
```

**Code:** `SitemapService.php`, `SeoController.php`, `sitemap-xml.blade.php`

***

## 11. Robots.txt — Giving Rules to Google

### What is Robots.txt?

A text file that tells search engine crawlers which pages to crawl and which to skip.

**URL:** `https://krishnaoutdoor.in/robots.txt`

### This Website's Robots.txt

There are two versions:

1. **Static file:** `public_html/robots.txt` — basic version (backup)
2. **Dynamic route:** `/robots.txt` → `SeoController::robots()` — this takes priority

The dynamic version is editable from the admin panel (SEO Settings > Robots.txt textarea).

### Current Rules

```
User-agent: *
Allow: /

# Block admin panel and login
Disallow: /admin/
Disallow: /login
Disallow: /api/

# Block WordPress admin, blog search
Disallow: /blog/wp-admin/
Allow: /blog/wp-admin/admin-ajax.php
Disallow: /blog/wp-login.php
...

# Ignore tracking parameters (to prevent duplicate URLs)
Disallow: /*?*utm_
Disallow: /*?*fbclid=
Disallow: /*?*gclid=

# Point to both sitemaps
Sitemap: https://krishnaoutdoor.in/sitemap.xml
Sitemap: https://krishnaoutdoor.in/blog/wp-sitemap.xml
```

**Code:** `SeoController.php` line 27-38, `public_html/robots.txt`

***

## 12. Canonical URLs — Avoiding Duplicate Pages

### What is a Canonical URL?

If a page is accessible from multiple URLs:

* `https://krishnaoutdoor.in/about`

* `http://krishnaoutdoor.in/about`

* `https://www.krishnaoutdoor.in/about`

* `https://krishnaoutdoor.in/about?utm_source=facebook`

Google can get confused. The canonical tag tells it: "This is the official URL for this page":

```html
<link rel="canonical" href="https://krishnaoutdoor.in/about">
```

### How Is It Built?

**File:** `SeoResolver.php`

```php
public static function canonicalFor(string $path): string
{
    $base = rtrim(config('app.url'), '/');  // https://krishnaoutdoor.in
    $path = trim($path, '/');
    return $path === '' ? $base . '/' : $base . '/' . $path;
}
```

* Always uses `https://` (from APP\_URL)

* Always without `www.`

* No query strings (`?utm_source` etc. are excluded)

* Admin can set a custom canonical in `seo_meta.canonical_url`

### Production HTTPS Enforcement

Behind Hostinger's proxy, Laravel sometimes receives `http://` URLs. Fix:

```php
// AppServiceProvider.php
if ($this->app->environment('production')) {
    URL::forceRootUrl(config('app.url'));
    URL::forceScheme('https');
}
```

**Code:** `SeoResolver.php` line 66-72, `AppServiceProvider.php` line 34-37

***

## 13. Keyword Landing Pages — Dedicated Pages for Target Keywords

### Concept

A dedicated page is created for each important search keyword. For example, if someone searches Google for "hoarding advertising ahmedabad", the `/hoarding-advertising-ahmedabad` page should rank.

### Current Keyword Pages

| URL Slug                             | Target Keyword                    | Region    |
| ------------------------------------ | --------------------------------- | --------- |
| `/hoarding-advertising-ahmedabad`    | Hoarding advertising Ahmedabad    | Ahmedabad |
| `/amts-bus-advertising-ahmedabad`    | AMTS bus advertising Ahmedabad    | Ahmedabad |
| `/bus-shelter-advertising-ahmedabad` | Bus shelter advertising Ahmedabad | Ahmedabad |
| `/gsrtc-bus-advertising`             | GSRTC bus advertising             | Ahmedabad |
| `/outdoor-advertising-agency-mumbai` | Outdoor advertising agency Mumbai | Mumbai    |
| `/mumbai-local-train-advertising`    | Mumbai local train advertising    | Mumbai    |
| `/best-bus-advertising-mumbai`       | BEST bus advertising Mumbai       | Mumbai    |
| `/tmt-bus-advertising-thane`         | TMT bus advertising Thane         | Mumbai    |
| `/social-media-marketing-ahmedabad`  | Social media marketing Ahmedabad  | Ahmedabad |
| `/social-media-marketing-mumbai`     | Social media marketing Mumbai     | Mumbai    |

### What Does a Keyword Page Contain?

1. **Hero section** with the keyword in the H1 (admin-override supported)
2. **Breadcrumbs** (Home > OOH Media > Hoarding Advertising Ahmedabad)
3. **Lead paragraph** with the keyword used naturally
4. **CTA** — free site list request + phone + WhatsApp
5. **Detailed content** — what the service is, formats, pricing, process
6. **Statistics** — 300+ hoardings, 2000+ sites, etc.
7. **FAQ section** — common questions (also feeds the FAQPage schema)
8. **Campaigns block** — real case studies the brand has run
9. **Page copy** — editable from admin, shown at the bottom
10. **Related links** — internal links to other pages

### Keyword Page Registration

Each keyword page must be registered in 3 places:

**1.** **`config/seo_pages.php`** — SEO defaults and page metadata:

```php
'view.keyword.hoarding.ahmedabad' => [
    'path' => '/hoarding-advertising-ahmedabad',
    'label' => 'Hoarding Advertising Ahmedabad',
    'parent' => 'view.ooh.media',       // breadcrumb parent
    'region' => 'ahmedabad',            // which office's phone to show
    'title' => '...',                   // fallback title
    'description' => '...',             // fallback description
    'service' => [...],                 // Service schema config
],
```

**2.** **`routes/web.php`** — URL route:

```php
Route::get('/hoarding-advertising-ahmedabad', function () {
    $seo = SeoResolver::forRoute('view.keyword.hoarding.ahmedabad');
    return view('web.pages.keywords.hoarding-advertising-ahmedabad', compact('seo'));
})->name('view.keyword.hoarding.ahmedabad');
```

**3.** **`resources/views/web/pages/keywords/`** — Blade template with the actual content

### Region-Based Office Phone

The keyword page's region determines which phone number appears in the header:

* `region: 'ahmedabad'` → Ahmedabad office phone (+91 98796 16411)

* `region: 'mumbai'` → Mumbai office phone (+91 99200 11574)

* `region: 'both'` → both offices

**Code:** `SeoResolver.php` line 94-127

***

## 14. Page Content CMS — Editing Page Text from Admin

### Concept

The admin can change text written by the developer in templates without touching any code. Headings (H1-H6) and paragraphs are all editable.

### How It Works

**File:** `Cms.php` (App\Services\Cms\Cms)

1. **Scan:** When the admin opens the "Page Content" edit page, `Cms::scan()` internally renders the page and extracts all headings/paragraphs
2. **Identify:** Each element gets a unique key:

   * `h1` — the page's first H1

   * `h:abc1234567:1` — heading with text hash, first occurrence

   * `p:def1234567:1` — paragraph with text hash, first occurrence
3. **Override:** Changes made by the admin are saved to the `cms_elements` table
4. **Render:** When the page loads, `Cms::render()` applies overrides to the template HTML

### Protected Regions

Some content should not be editable (such as FAQ answers that also go into the schema). These regions are wrapped in the template:

```html
<!--cms:skip-->
<div class="kw-faq">
    ... FAQ content ...
</div>
<!--/cms:skip-->
```

### How Can an Admin Use It?

1. Admin > Click **Page Content**
2. Select a page
3. All headings and paragraphs will appear in an editable form
4. Change the text, change heading levels (H2 → H3)
5. Write extra body text in the **Page Copy** textarea (appears in the bottom section)
6. Add **Related Links** (for internal linking)
7. Save — changes go live immediately

### Related Links

The admin can add up to 12 related internal links per page:

```
[
    {"label": "OOH Media in Gujarat", "url": "/media/ooh"},
    {"label": "Bus Shelter Advertising", "url": "/bus-shelter-advertising-ahmedabad"}
]
```

These appear in the "Related pages" section at the bottom of the page.

### Link Validation

When saving, the system checks whether the URLs in the related links and page copy actually point to real pages. If any link is broken, a warning is displayed.

**Code:** `Cms.php`, `PageContentController.php`, `page-copy.blade.php`

***

## 15. H1 Override — Changing the Main Heading

### What Is It?

The H1 tag is the most important heading on a page. Google reads it to understand what the page is about.

```html
<h1>HOARDING ADVERTISING IN AHMEDABAD</h1>
```

### How Can the Admin Change It?

It can be changed from 2 places:

1. **SEO Edit page** → H1 Override field
2. **Page Content** → H1 field (same field, same value)

In the template:

```blade
<h1>
@if ($seo->h1Override())
    {{ $seo->h1Override() }}
@else
    HOARDING ADVERTISING<br/><em>IN AHMEDABAD</em>
@endif
</h1>
```

### Normalization

The H1 is cleaned before saving:

* `*` markers are removed (bold markers)

* Trailing `. ` is removed

* Spaces are trimmed

**Code:** `SeoMeta.php` line 79-84

***

## 16. Breadcrumbs — Navigation Trail

### What Are Breadcrumbs?

A path displayed at the top of the page: `Home / OOH Media / Hoarding Advertising Ahmedabad`

Breadcrumbs serve 2 purposes:

1. **Visible breadcrumb** — shows the user a navigation trail
2. **BreadcrumbList schema** — tells Google the page hierarchy (displayed in rich results)

### How Are They Built?

**File:** `SchemaBuilder.php`

For static pages, the `parent` chain is defined in `config/seo_pages.php`:

```php
'view.keyword.hoarding.ahmedabad' => [
    'parent' => 'view.ooh.media',  // OOH Media page
    ...
]
'view.ooh.media' => [
    'parent' => 'view.home',       // Home
    ...
]
```

**Result:** Home → OOH Media → Hoarding Advertising Ahmedabad

For dynamic pages (categories, campaigns, locations), `SchemaBuilder::setBreadcrumbs()` is called in the controller:

```php
SchemaBuilder::setBreadcrumbs([
    ['name' => 'Our Work', 'url' => route('view.projects')],
    ['name' => $campaign->name, 'url' => $seo->canonicalUrl],
]);
```

**The visible breadcrumb and the schema breadcrumb always match** because both are built from the same function: `SchemaBuilder::trail()`.

**Code:** `SchemaBuilder.php` line 226-267, `breadcrumbs.blade.php`

***

## 17. 301 Redirects — Sending Old URLs to New Ones

### Why Are Redirects Needed?

When a website is restructured, old URLs become dead. If an old URL is indexed in Google or linked from another site, visitors will get a 404 error. A 301 redirect tells them: "This page has permanently moved here."

### How Does It Work?

**Middleware:** `HandleSeoRedirects.php`

On every GET request:

1. The `seo_redirects` table is checked to see if this URL is listed
2. If matched, a redirect is issued (301 permanent or 302 temporary)
3. The `hit_count` is incremented (tracks how often the redirect is used)

### Hardcoded Redirects (routes/web.php)

Some legacy URLs are redirected directly in the route file:

```php
Route::get('/bus-advertisement', fn () => redirect()->route('view.transit.media', [], 301));
Route::get('/outdoor-advertisement', fn () => redirect()->route('view.ooh.media', [], 301));
Route::get('/train-advertisement', fn () => redirect()->route('view.transit.media', [], 301));
```

### How Can the Admin Manage Redirects?

1. Admin > **Redirects** > **Create New**
2. Enter the old URL (e.g. `/old-page`)
3. Enter the new URL (e.g. `/new-page`)
4. Type: 301 (permanent) or 302 (temporary)
5. Save

Bulk import is also supported — upload a CSV file with columns: `old_url, new_url, type, status`

### 301 vs 302

| Type    | Meaning        | When to Use                                                 |
| ------- | -------------- | ----------------------------------------------------------- |
| **301** | Permanent move | The page has permanently moved to a new location            |
| **302** | Temporary move | The page is temporarily at another location and will return |

For SEO, 301 is important because Google transfers the old URL's ranking to the new URL.

**Code:** `HandleSeoRedirects.php`, `SeoRedirectController.php`

***

## 18. 404 Logging — Tracking Broken Links

### What Is It?

When a visitor lands on a non-existent URL (404 error), the system logs it so the admin can see which URLs are broken.

### How Does It Work?

**File:** `Handler.php` (Exception Handler)

```php
$this->renderable(function (NotFoundHttpException $e, Request $request) {
    $this->logSeo404($request);
});
```

On every 404:

1. The URL, referrer (where the visitor came from), and user agent (browser/bot) are saved
2. If the same URL was previously logged → `hit_count` is incremented
3. The admin panel displays a list sorted by hit\_count (most frequent broken URLs first)

### How Can the Admin Use It?

1. Go to Admin > **404 Logs**
2. See which URLs are repeatedly returning 404
3. Create a redirect for them (Admin > Redirects > Create)
4. Or fix the content if the link is incorrect

### 404 Page

A custom 404 page exists (`errors/404.blade.php`):

* Has a `noindex` tag (Google will not index it)

* Includes a "Back to Home" button

* GA4 tracking is loaded (404 visits are tracked)

**Code:** `Handler.php` line 33-73, `Seo404LogController.php`

***

## 19. Noindex / Nofollow — Hiding Pages from Google

### What Is It?

```html
<meta name="robots" content="noindex,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">
```

| Directive  | Meaning                                                |
| ---------- | ------------------------------------------------------ |
| `index`    | Google, show this page in your search results          |
| `noindex`  | Google, do NOT show this page in your search results   |
| `follow`   | Google, follow the links on this page (pass authority) |
| `nofollow` | Google, do NOT follow the links on this page           |

### Where Is It Used?

1. **Admin-controlled:** Uncheck the "Index" checkbox on the SEO edit form → `noindex`
2. **Thank you page:** `forceNoindex()` in code — this page should never be indexed
3. **Location pages:** `LocationPageGate` decides — if content/photos are insufficient → `noindex`
4. **Free site list page:** `'index' => false` in `config/seo_pages.php` — it is a conversion page and should not appear in search
5. **404 page:** Hardcoded `noindex`

### LocationPageGate — Smart Noindex

Location pages have a quality gate (`LocationPageGate.php`). The page stays `noindex` until these conditions are met:

* All locations have real photos (not placeholder icons)

* All locations have the area field filled (minimum 3 characters)

* All locations have the size field filled

* The page copy has a minimum of 300 words

**Code:** `SeoResolver.php` line 159-171, `LocationPageGate.php`

***

## 20. Image SEO — Alt Text and WebP Compression

### Alt Text

Alt text is a text description of an image. It serves 2 purposes:

1. **Accessibility** — screen readers describe the image to visually impaired users
2. **Google Image Search** — Google reads alt text to understand what the image shows

Alt text is set from the admin panel:

* **Category media:** `alt_text` and `title_text` columns (added via migration)

* **Locations, campaigns, projects, testimonials:** `alt_text` column

In templates:

```html
<img alt="Krishna Outdoor hoarding advertising on a main road in Ahmedabad" ...>
```

### WebP Compression

**File:** `ImageOptimizer.php`

Whenever an image is uploaded (from the admin panel), this automatic process occurs:

1. The image is received (JPG/PNG/WebP)
2. `ImageOptimizer::store()` is called
3. The image is converted to WebP format (82% quality)
4. The WebP file is saved (40-60% smaller than the original)
5. If WebP conversion fails (server does not support it) → the original is saved as-is

**Why is this important for SEO?** Google considers page speed a ranking factor. Smaller images = faster page = better rank.

**Code:** `ImageOptimizer.php`, migrations for alt\_text columns

***

## 21. Google Search Console Verification

### What Is It?

Google Search Console (GSC) is a free tool where you can see:

* How Google is crawling your site

* Which keywords you are ranking for

* If there are any errors

* Submit your sitemap

### How Was Verification Done?

**HTML file method:**

```
public_html/google09786c7f663b05e9.html
```

Content: `google-site-verification: google09786c7f663b05e9.html`

Google checked this file → verified!

**Meta tag method (also supported):**
Admin > SEO Settings > "Google Search Console Verification Code" — enter the code → this generates a meta tag in `<head>`:

```html
<meta name="google-site-verification" content="...">
```

**Code:** `app.blade.php` line 8-10

***

## 22. GA4, GTM, Facebook Pixel — Tracking Setup

### Google Analytics 4 (GA4)

**What is it?** Google's tool that tells you how many people visited your website, where they came from, and what they did.

**Setup:** Admin > SEO Settings > Enter GA4 ID (e.g. `G-ABC123XYZ`)

**How is it loaded?** (`app.blade.php`)

1. The `gtag()` function is defined (data queue)
2. The GA4 script is **lazy loaded** — the page renders first, then the script loads (on first user interaction or idle time)
3. This does not hurt page speed

### Google Tag Manager (GTM)

**What is it?** A container where you can add more tags (conversion tracking, remarketing, etc.) without changing code.

**Setup:** Admin > SEO Settings > Enter GTM ID (e.g. `GTM-XXXXXXX`)

### Facebook Pixel

**Setup:** Admin > SEO Settings > Paste the full pixel HTML code in the Facebook Pixel Code field.

### Custom Event Tracking

**File:** `tracking.js`

Events that are automatically tracked:

| Event            | When It Fires                                             |
| ---------------- | --------------------------------------------------------- |
| `click_call`     | When someone clicks a phone number link                   |
| `click_email`    | When someone clicks an email link                         |
| `click_whatsapp` | When someone clicks a WhatsApp link                       |
| `chat_start`     | When someone opens the Krishna AI chat for the first time |
| `generate_lead`  | When a form is successfully submitted (server-side flash) |

### Lazy Loading Strategy

GA4/GTM scripts do not block the first paint:

```javascript
// Loads on: user interaction (click/key/scroll/touch) OR when the browser is idle
['pointerdown', 'keydown', 'scroll', 'touchstart'].forEach(function (e) {
    window.addEventListener(e, load, { capture: true, once: true, passive: true });
});
window.addEventListener('load', function () {
    requestIdleCallback(load, { timeout: 4000 });
});
```

**Code:** `app.blade.php` line 12-57, `tracking.js`

***

## 23. Page Copy & Related Links — Internal Linking

### Page Copy

A text section can appear at the bottom of every page — "More about this page". It is edited from the admin panel:

1. Admin > **Page Content** > Select a page > **Page Copy** textarea
2. Write plain text (paragraphs separated by blank lines), or HTML (p, h2-h6, lists, links)
3. The system automatically sanitizes the content (to prevent XSS attacks)
4. Saved to `seo_meta.page_copy`

**Why is this important?** Extra unique content signals to Google that the page is valuable. Internal links also help Google understand the site structure.

### Related Links

A "Related pages" section at the bottom of each page:

1. Admin > **Page Content** > **Related Links** section
2. Up to 12 links can be added
3. Each link has: Label + URL (select pages from dropdown, or type manually)
4. Saved to `seo_meta.related_links` (JSON array)
5. The system checks whether the links point to valid pages

### HTML Sanitization

Any HTML written by the admin is cleaned by `HtmlSanitizer`:

* Allowed inline tags: `<a>`, `<strong>`, `<b>`, `<em>`, `<i>`, `<br>`

* Allowed block tags (in page copy): `<p>`, `<h2>`-`<h6>`, `<ul>`, `<ol>`, `<li>`

* Tags like `<script>`, `<iframe>`, `<style>` are dropped

* Only safe href values are allowed in links: `/`, `https://`, `mailto:`, `tel:`

**Code:** `page-copy.blade.php`, `Cms.php` line 219-235, `HtmlSanitizer.php`

***

## 24. FAQ Schema — What You See is What Google Gets

### Concept

Google displays FAQ rich results only when:

1. Actual FAQ content is visible on the page (the user can see it)
2. A matching FAQPage schema exists

On this website, both are **built from the same source**:

```blade
{{-- faq.blade.php --}}
@php \App\Services\SchemaBuilder::addFaqs($faqs); @endphp
<!--cms:skip-->
<div class="kw-faq">
@foreach ($faqs as $faq)
    <details>
        <summary><h3>{{ $faq['q'] }}</h3></summary>
        <p>{{ $faq['a'] }}</p>
    </details>
@endforeach
</div>
<!--/cms:skip-->
```

Steps:

1. The page template defines a `$faqs` array
2. The `faq.blade.php` partial is rendered
3. `SchemaBuilder::addFaqs($faqs)` is called — added to the schema
4. The visible FAQ is rendered in `<details>/<summary>` tags
5. A `<!--cms:skip-->` wrapper prevents the admin from accidentally changing the FAQ text (which would cause a schema mismatch)

**Result:** What the user sees = what Google gets in the schema. Always in sync.

**Code:** `faq.blade.php`, `SchemaBuilder.php` line 36-39, 180-189

***

## 25. SEO Health Checks — Warnings and Errors

### What Is It?

The system automatically checks whether a page's SEO is correct.

**File:** `SeoHealth.php`

| Check                   | Threshold          | Type    |
| ----------------------- | ------------------ | ------- |
| Meta title empty        | Must not be empty  | Error   |
| Meta title length       | 30-60 characters   | Warning |
| Meta description empty  | Must not be empty  | Error   |
| Meta description length | 140-160 characters | Warning |

### Where Is It Used?

1. **Admin SEO edit page** — warnings are displayed to the admin
2. **Sitemap generation** — if the title or description is empty, the page is excluded from the sitemap (and a warning is logged)

**Code:** `SeoHealth.php`

***

## 26. SEO Revision History — Who Changed What

### Concept

Whenever an admin changes SEO data, the version **before** the change is automatically saved to the `seo_meta_revisions` table.

### How Does It Work?

1. The admin clicks save
2. The controller captures the old data: `$before = $meta->only(SeoMeta::REVISIONED_FIELDS)`
3. The changes are saved
4. If before ≠ after → a revision is created:

   ```php
   SeoMetaRevision::create([
       'seo_meta_id' => $meta->id,
       'admin_id' => auth()->user()->id,
       'snapshot_json' => $before,  // old data
   ]);
   ```

### Which Fields Are Tracked?

```php
const REVISIONED_FIELDS = [
    'meta_title', 'meta_description', 'meta_keywords', 'focus_keyword',
    'skip_title_template', 'canonical_url', 'robots_index', 'robots_follow', 'h1_override',
    'og_title', 'og_description', 'og_type',
    'twitter_title', 'twitter_description',
    'schema_json', 'page_copy', 'related_links',
];
```

### How to Restore a Previous Version?

1. Admin > SEO > Edit a page
2. Scroll down to the **Revision History** section
3. View previous versions (when and who made the change)
4. Click **Restore** — the old version is restored
5. The current version also becomes a new revision (so you can roll back a rollback)

**Code:** `SeoMetaController.php` line 149-157, 262-298

***

## 27. CSV Export / Import — Bulk SEO Changes

### Export

1. Admin > SEO > Click the **Export CSV** button
2. A CSV file is downloaded with columns: `URL, Current title, New title, New description, H1, Canonical, Schema type`
3. Open the file in Excel/Google Sheets and make changes

### Import

1. Fill in the "New title" and "New description" columns in the CSV file
2. Admin > SEO > Click the **Import CSV** button > upload the file
3. The system matches rows by URL and updates them
4. Revision history is also saved for each update
5. A message shows how many rows were updated/skipped

### Redirect Import

Redirects can also be imported via CSV:

* Columns: `old_url, new_url, type, status`

* Admin > Redirects > Import CSV

**Code:** `SeoMetaController.php` line 169-260

***

## 28. SEO TODOs — What Still Needs to Be Done

### What Is It?

A smart checklist that automatically detects what SEO content is still missing.

**Admin URL:** `/admin/seo-todos`

### What Does It Check?

| Category                | What is Checked                                                           | Where to Fix                               |
| ----------------------- | ------------------------------------------------------------------------- | ------------------------------------------ |
| **Campaigns**           | Do mentioned brands on keyword pages have corresponding campaign entries? | Admin > Our Work                           |
| **Social case studies** | Does each city have at least 2 social media case studies?                 | Admin > Our Work                           |
| **Hoarding/AMTS**       | Is location data and page copy present?                                   | Admin > Locations, Admin > SEO > Page Copy |
| **Location pages**      | Are photos, area, size, and 300+ words of content present?                | Admin > Locations, Admin > SEO             |
| **Business details**    | Are opening hours, Mumbai geo, WhatsApp numbers, and video dates set?     | config/business.php, Admin > SEO Settings  |
| **Tracking**            | Are GA4 and GTM IDs configured?                                           | Admin > SEO Settings                       |
| **Media facts**         | Are DOOH screen counts, Gujarat cities list, and booking terms present?   | Template files                             |
| **Photos**              | Where are real photos missing (TMT bus, Jaipur, DOOH)?                    | Template files                             |

**This page gives the admin a clear picture of what SEO work still remains.**

**Code:** `SeoTodoController.php`

***

## 29. Location Page Quality Gate

### The Problem

Location pages (`/locations/ahmedabad`) — if they only have 2-3 entries without photos, Google may penalize them as "thin content."

### The Solution — LocationPageGate

**File:** `LocationPageGate.php`

The page stays `noindex` until these conditions are met:

1. **All locations have real photos** (not placeholder icons)
2. **All locations have the area field filled** (minimum 3 characters)
3. **All locations have the size field filled**
4. **The page copy has 300+ words of unique text**

```php
// LocationController.php
if (!LocationPageGate::passes($locations, $seo->meta)) {
    $seo->forceNoindex();  // noindex,follow — follow links but do not index the page
}
```

Until the conditions are met:

* The page still renders (users can see it)

* But Google does not index it

* It also does not appear in the sitemap

**The Content TODOs page also shows** which location pages are noindexed and why.

**Code:** `LocationPageGate.php`, `LocationController.php` line 49-51

***

## 30. Performance — Speed for SEO

Google considers page speed a ranking factor. Here are the optimizations on this website:

### CSS

* **Per-page CSS bundles** based on templates: `bundle-home.min.css`, `bundle-keyword.min.css`, etc.

* Only the CSS needed for a specific page is loaded

### JavaScript

* `main.min.js`, `kr-laravel.min.js`, `tracking.min.js` — all minified

* All loaded with the `defer` attribute (do not block rendering)

### Fonts

* Google Fonts with **preload and font-display: swap** — text appears first, font loads afterward

* `<link rel="preload" as="style" ... onload="this.rel='stylesheet'"/>` pattern

### Images

* WebP format (40-60% smaller files)

* `srcset` attribute for responsive images (smaller image on mobile, larger on desktop)

* `loading="lazy"` for below-the-fold images

* `fetchpriority="high"` + `loading="eager"` for hero images

### GA4/GTM Lazy Loading

Analytics scripts do not load on page load — they load on user interaction (or idle callback).

### CSRF Token Strategy

Forms do not include CSRF tokens in the page HTML — forms fetch the token via an AJAX call when the user first interacts. This keeps pages fully cacheable.

### Sitemap Caching

The sitemap is cached with `Cache::rememberForever()`. It only regenerates when data changes.

***

## 31. WordPress Blog SEO

The blog at `/blog/` is on WordPress. Its SEO is handled separately:

### Integration with the Main Website

1. **Robots.txt** lists both sitemaps:

   ```
   Sitemap: https://krishnaoutdoor.in/sitemap.xml
   Sitemap: https://krishnaoutdoor.in/blog/wp-sitemap.xml
   ```
2. **Blog admin/login pages are blocked** in robots.txt
3. WordPress uses its own sitemap (`wp-sitemap.xml`)
4. WordPress SEO plugins (like Yoast/RankMath) manage blog SEO

### Blog LLMs.txt

The blog also has an `llms.txt` file — an emerging standard that tells AI crawlers how the site's content should be used.

***

## 32. File Map — Where Each File Lives

### Models (PHP representation of database tables)

| File                             | Table                | Purpose                 |
| -------------------------------- | -------------------- | ----------------------- |
| `app/Models/SeoMeta.php`         | `seo_meta`           | SEO data for every page |
| `app/Models/SeoSetting.php`      | `seo_settings`       | Global SEO settings     |
| `app/Models/SeoRedirect.php`     | `seo_redirects`      | URL redirects           |
| `app/Models/Seo404Log.php`       | `seo_404_logs`       | 404 error logs          |
| `app/Models/SeoMetaRevision.php` | `seo_meta_revisions` | Change history          |
| `app/Models/CmsElement.php`      | `cms_elements`       | Admin text overrides    |

### Services (Business logic)

| File                                 | Purpose                                              |
| ------------------------------------ | ---------------------------------------------------- |
| `app/Services/SeoResolver.php`       | Merges DB + config → final SEO values for every page |
| `app/Services/SchemaBuilder.php`     | Builds JSON-LD structured data                       |
| `app/Services/SitemapService.php`    | Generates sitemap.xml + cache management             |
| `app/Services/SeoHealth.php`         | Title/description quality checks                     |
| `app/Services/LocationPageGate.php`  | Location page noindex decision                       |
| `app/Services/Cms/Cms.php`           | Applies admin text overrides to pages                |
| `app/Services/Cms/HtmlSanitizer.php` | Cleans HTML content                                  |
| `app/Services/ImageOptimizer.php`    | Compresses images to WebP format                     |

### Admin Controllers

| File                                                   | Purpose                                  |
| ------------------------------------------------------ | ---------------------------------------- |
| `app/Http/Controllers/Admin/SeoMetaController.php`     | SEO meta CRUD, export/import, revisions  |
| `app/Http/Controllers/Admin/SeoSettingController.php`  | Global SEO settings                      |
| `app/Http/Controllers/Admin/SeoRedirectController.php` | Redirects CRUD + import                  |
| `app/Http/Controllers/Admin/Seo404LogController.php`   | 404 logs view + dismiss                  |
| `app/Http/Controllers/Admin/SeoTodoController.php`     | Content TODO checklist                   |
| `app/Http/Controllers/Admin/PageContentController.php` | Page content CMS (headings, text, links) |

### Web Controllers

| File                                              | Purpose                                 |
| ------------------------------------------------- | --------------------------------------- |
| `app/Http/Controllers/Web/SeoController.php`      | Serves dynamic sitemap.xml + robots.txt |
| `app/Http/Controllers/Web/LocationController.php` | Location pages with noindex gate        |
| `app/Http/Controllers/Web/CampaignController.php` | Campaign case study pages with SEO      |

### Middleware

| File                                         | Purpose                               |
| -------------------------------------------- | ------------------------------------- |
| `app/Http/Middleware/HandleSeoRedirects.php` | Checks for redirects on every request |

### Exception Handler

| File                         | Purpose                           |
| ---------------------------- | --------------------------------- |
| `app/Exceptions/Handler.php` | Logs 404 errors to `seo_404_logs` |

### Config Files

| File                   | Purpose                                                                      |
| ---------------------- | ---------------------------------------------------------------------------- |
| `config/seo_pages.php` | Static page SEO registry (path, title, description, parent, region, service) |
| `config/business.php`  | Office addresses, phones, social links (NAP data for schema)                 |
| `config/campaigns.php` | Maps which campaign appears on which keyword page                            |

### Blade Templates (Views)

| File                                             | Purpose                                          |
| ------------------------------------------------ | ------------------------------------------------ |
| `views/web/layouts/app.blade.php`                | Main layout — SEO head, GA4, GTM, fonts, scripts |
| `views/web/common/seo-head.blade.php`            | Title, meta, OG, Twitter, JSON-LD tags output    |
| `views/web/common/schema-organization.blade.php` | Legacy Organization schema (fallback)            |
| `views/web/common/breadcrumbs.blade.php`         | Visible breadcrumb navigation                    |
| `views/web/common/page-copy.blade.php`           | Body text block + related links                  |
| `views/web/common/faq.blade.php`                 | FAQ section (visible content + schema feed)      |
| `views/web/common/sitemap-xml.blade.php`         | sitemap.xml template                             |
| `views/errors/404.blade.php`                     | Custom 404 page (noindex)                        |
| `views/web/pages/keywords/*.blade.php`           | 10 keyword landing pages                         |

### Admin Views

| File                                               | Purpose                      |
| -------------------------------------------------- | ---------------------------- |
| `views/admin/pages/seo/seo-list.blade.php`         | SEO list (all pages grouped) |
| `views/admin/pages/seo/seo-update.blade.php`       | SEO edit form                |
| `views/admin/pages/seo/seo-settings.blade.php`     | Global SEO settings form     |
| `views/admin/pages/seo/redirect-list.blade.php`    | Redirects list               |
| `views/admin/pages/seo/redirect-create.blade.php`  | Create redirect form         |
| `views/admin/pages/seo/log-404-list.blade.php`     | 404 logs list                |
| `views/admin/pages/seo/todo-list.blade.php`        | Content TODOs checklist      |
| `views/admin/pages/content/content-list.blade.php` | Page content list            |
| `views/admin/pages/content/content-edit.blade.php` | Page content edit form       |

### Routes

| File               | Lines   | Description                                                       |
| ------------------ | ------- | ----------------------------------------------------------------- |
| `routes/web.php`   | 144-192 | Keyword landing page routes                                       |
| `routes/web.php`   | 201-208 | Legacy redirect routes                                            |
| `routes/web.php`   | 226-230 | sitemap.xml + robots.txt routes                                   |
| `routes/admin.php` | 132-169 | SEO admin routes (meta, settings, redirects, 404, content, todos) |

### Static Files

| File                                      | Purpose                                            |
| ----------------------------------------- | -------------------------------------------------- |
| `public_html/robots.txt`                  | Static robots.txt (the dynamic route overrides it) |
| `public_html/google09786c7f663b05e9.html` | Google Search Console verification file            |
| `public_html/js/tracking.js`              | GA4 click event tracking                           |

### Trait

| File                        | Purpose                                            |
| --------------------------- | -------------------------------------------------- |
| `app/Traits/HasSeoMeta.php` | Adds the `seo()` relationship to models (morphOne) |

***

## 33. How to Replicate This SEO on Another Website (Step by Step)

If you want to build the same SEO system on a new Laravel website, follow these steps:

### Step 1: Create Database Tables

Create these migrations (or copy the existing ones):

1. **`seo_meta`** — SEO data for every page (title, description, keywords, OG, schema, robots, etc.)
2. **`seo_settings`** — global settings (site name, title template, GA4 ID, GTM, robots.txt, etc.)
3. **`seo_redirects`** — URL redirect rules (old → new, 301/302)
4. **`seo_404_logs`** — broken URL tracking
5. **`seo_meta_revisions`** — change history
6. **`cms_elements`** — admin text overrides

### Step 2: Create Models

1. **SeoMeta** — `seoable` morphTo relationship, `REVISIONED_FIELDS` constant, `forGroup()`, `publicPath()`, `normalizeH1()`
2. **SeoSetting** — simple model (single row)
3. **SeoRedirect** — SoftDeletes
4. **Seo404Log**
5. **SeoMetaRevision** — `snapshot_json` cast as array
6. **CmsElement** — belongs to SeoMeta

### Step 3: Create the HasSeoMeta Trait

```php
trait HasSeoMeta
{
    function seo()
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
```

Any model that needs SEO management (Category, Campaign, Product, etc.) — add `use HasSeoMeta;` to it.

Auto-create an SEO row when the model is created:

```php
protected static function booted(): void
{
    static::created(function ($model) {
        if (!$model->seo()->exists()) {
            $model->seo()->create([]);
        }
    });
}
```

### Step 4: Create Config Files

1. **`config/seo_pages.php`** — list your website's static pages (path, label, parent chain, title, description, region, service schema)
2. **`config/business.php`** — company NAP data (name, address, phone, email, social links, office locations)

### Step 5: Create Services

1. **SeoResolver** — merges DB SEO data + config fallbacks + global settings → final values. Methods: `forRoute()`, `forModel()`, `canonicalFor()`, `robotsContent()`, `ogTitle()`, `ogDescription()`, `ogImage()`, `twitterTitle()`, etc.
2. **SchemaBuilder** — builds JSON-LD `@graph`: Organization, WebSite, LocalBusiness, Service, FAQPage, BreadcrumbList, VideoObject
3. **SitemapService** — dynamic sitemap.xml build + cache + auto-flush
4. **SeoHealth** — title/description quality checks
5. **Cms** — page text override system (scan, render, elements)
6. **HtmlSanitizer** — cleans HTML (whitelist approach)
7. **ImageOptimizer** — auto WebP conversion on upload

### Step 6: Create Middleware

**HandleSeoRedirects** — register in `Kernel.php` as web middleware:

```php
// On every GET request, check the seo_redirects table
// If matched, redirect (301/302)
// Increment hit_count
```

### Step 7: Update the Exception Handler

Add 404 logging to `Handler.php`:

```php
$this->renderable(function (NotFoundHttpException $e, Request $request) {
    $this->logSeo404($request);
});
```

### Step 8: Update AppServiceProvider

```php
// Force HTTPS in production
URL::forceRootUrl(config('app.url'));
URL::forceScheme('https');

// Flush sitemap cache when data changes
foreach ([SeoMeta, Category, Location, Campaign] as $model) {
    $model::saved(fn () => SitemapService::flush());
    $model::deleted(fn () => SitemapService::flush());
}
```

### Step 9: Create Blade Templates

1. **`seo-head.blade.php`** — `<title>`, meta description, keywords, robots, canonical, OG tags, Twitter cards, JSON-LD schema
2. **`app.blade.php`** (layout) — include seo-head, GSC verification, GA4/GTM lazy loading, font loading, CSS/JS
3. **`breadcrumbs.blade.php`** — visible breadcrumb from SchemaBuilder::trail()
4. **`page-copy.blade.php`** — body text + related links section
5. **`faq.blade.php`** — FAQ section that feeds both visible content + FAQPage schema
6. **`sitemap-xml.blade.php`** — XML template
7. **`404.blade.php`** — custom 404 page with noindex + GA4

### Step 10: Set Up Routes

```php
// Dynamic sitemap.xml and robots.txt
Route::get('/sitemap.xml', [SeoController::class, 'sitemap']);
Route::get('/robots.txt', [SeoController::class, 'robots']);

// Pass the $seo variable in every page route
Route::get('/about', function () {
    $seo = SeoResolver::forRoute('view.about');
    return view('web.pages.about', compact('seo'));
})->name('view.about');

// Dynamic model pages
Route::get('/products/{slug}', [ProductController::class, 'show']);
// In the controller: $seo = SeoResolver::forModel($product, $product->name, $product->summary);
```

### Step 11: Build the Admin Panel

1. **SEO Meta List** — grouped by pages/categories/products
2. **SEO Meta Edit** — form with all fields (title, description, OG, schema, robots, etc.)
3. **SEO Settings** — global settings form
4. **Redirects** — CRUD + CSV import
5. **404 Logs** — list with hit counts
6. **Content TODOs** — auto-generated checklist
7. **Page Content** — heading/paragraph edit + page copy + related links
8. **Permissions** — VIEW\_SEO, EDIT\_SEO, MANAGE\_REDIRECTS

### Step 12: Create Keyword Landing Pages

1. Choose target keywords (using Google Keyword Planner or SEMrush)
2. URL slug = keyword (e.g. `/web-design-mumbai`)
3. Register in `config/seo_pages.php` (title, description, parent, service schema)
4. Add the route in `routes/web.php`
5. Create a Blade template in `views/web/pages/keywords/`
6. Content structure: Hero → Breadcrumbs → Lead text → CTA → Details → FAQ → Campaigns → Page Copy

### Step 13: Set Up Google Search Console

1. Upload the `google{hash}.html` file to `public/`
2. Verify in GSC
3. Add the GSC code in Admin > SEO Settings (backup verification)
4. Submit the sitemap in GSC: `https://yoursite.com/sitemap.xml`

### Step 14: Set Up Tracking

1. Create a GA4 property → get the Measurement ID
2. Admin > SEO Settings > Enter GA4 ID
3. Create a GTM container → get the Container ID
4. Admin > SEO Settings > Enter GTM ID
5. Add your custom events in `tracking.js`

### Step 15: Performance Optimizations

1. Create per-page CSS bundles (similar to tools/build-css.mjs)
2. Minify JavaScript files
3. Enable automatic WebP conversion on image upload (ImageOptimizer)
4. Preload fonts with `font-display: swap`
5. Lazy load analytics (on first interaction)
6. Lazy fetch CSRF tokens (keep pages cacheable)
7. Cache sitemap with auto-flush

### Step 16: Ongoing SEO Maintenance

1. Regular check: Admin > **404 Logs** → fix broken URLs
2. Regular check: Admin > **Content TODOs** → complete missing content
3. When creating new pages → fill in SEO meta data
4. Use **Page Content** to optimize text (use keywords naturally)
5. Use **Related Links** to strengthen internal linking
6. Check performance in GSC → optimize low-performing pages
7. Test schemas: check URLs in Google's Rich Results Test tool

***

## Quick Reference — Admin Checklist

Whenever you create a new page or optimize an existing page's SEO:

* [ ] Set Meta Title (30-60 characters, include the keyword)

* [ ] Set Meta Description (140-160 characters, include keyword + CTA)

* [ ] Ensure the H1 heading contains the keyword

* [ ] Set the Focus Keyword

* [ ] Upload an OG Image (1200x630 recommended)

* [ ] Verify Schema JSON (Service schema on keyword pages, FAQPage on FAQ pages)

* [ ] Confirm the breadcrumb parent chain is correct

* [ ] Confirm the Canonical URL is correct

* [ ] Set robots\_index = true (unless noindex is intended)

* [ ] Write 200+ words of unique text in Page Copy

* [ ] Add Related Links (3-5 relevant internal pages)

* [ ] Verify the page appears in /sitemap.xml

* [ ] Ensure images have alt text

* [ ] Check page speed (use PageSpeed Insights)

***

*Last updated: November 2026*
*This document covers the complete SEO implementation of krishnaoutdoor.in*
