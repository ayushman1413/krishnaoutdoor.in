# SEO Admin Panel Requirements for Laravel Developer

## Overview

Build one **SEO section in the Laravel admin panel** so the SEO team can edit every SEO value without touching code. Every page, and every dynamic item (blog, product, location), needs its own SEO fields, and all values must output dynamically in the site's `<head>`.

The sections below list what to build, in priority order. **Sections 1–6 are required; 7–9 are strongly recommended.**

---

## 1. Per-page SEO fields

Add these fields to every page and every dynamic item:

- Meta title, with a character counter (about 60)
- Meta description, with a character counter (about 160)
- Meta keywords (optional)
- Focus keyword (optional, for internal reference)
- Canonical URL: defaults to the page's own URL, but editable
- Robots meta: index/noindex and follow/nofollow
- URL slug: editable, with an automatic redirect when it changes
- H1 heading field, if the H1 is not already editable in the page content

---

## 2. Social media tags (Open Graph and Twitter)

- OG title, OG description and OG image upload
- OG type (website or article) and OG URL
- Twitter card type, title, description and image
- Fallback rule: if a field is empty, use the meta title, meta description and featured image

---

## 3. Schema / structured data

- A JSON-LD box on each page where schema code can be pasted
- Global schema in settings: Organization or LocalBusiness (name, logo, address, phone, social links, opening hours)
- Automatic schema for blogs (Article), breadcrumbs (BreadcrumbList) and FAQ pages (FAQPage)

---

## 4. Global SEO settings

One settings page holding site-wide values:

- Default title and description templates, for example `{page title} | Site Name`
- Site name, default OG image and favicon
- Google Search Console verification code
- Google Analytics (GA4) ID and Google Tag Manager ID
- Facebook Pixel or other tracking code box
- Custom code boxes for the `<head>` and for just before `</body>`

---

## 5. Robots.txt and sitemap

- Robots.txt editable from the panel
- sitemap.xml generated automatically and updated when pages are added or removed
- Option to exclude specific pages from the sitemap
- Sitemap URL listed inside robots.txt

---

## 6. Redirect manager

A table in the panel with these columns:

| Column | Purpose |
|---|---|
| Old URL | The URL being retired |
| New URL | Where visitors should land |
| Type | 301 (permanent) or 302 (temporary) |
| Status | On or off |

Also needed:

- Bulk import of redirects via CSV
- A 404 log showing broken URLs that visitors reach, so they can be redirected

---

## 7. Image SEO

- Alt text and title fields in the media upload section
- Automatic compression and conversion to WebP
- Lazy loading on images

---

## 8. Technical requirements

- All SEO values output dynamically in the `<head>` of the layout file (title, meta, canonical, OG, schema); nothing hard-coded
- One canonical site version: HTTPS and either www or non-www, with a 301 redirect from the other
- Automatic breadcrumbs with schema
- Pagination handled with canonical or rel next/prev
- Clean URLs (no `?id=123`): lowercase and hyphen-separated
- Page speed: caching, minified CSS and JS, gzip or Brotli compression
- Mobile-friendly, responsive layout with one H1 per page and a proper heading order
- Admin login with roles, so only authorized users can edit SEO

---

## 9. Nice-to-have features and data template

- SEO score or checklist per page (title length, description length, missing alt text)
- Google-style preview of how the title and description appear in search results
- Revision history, so SEO changes can be rolled back
- Export and import of all SEO data as CSV or Excel, for bulk editing

### Import data template

To let the developer import existing data straight into the panel, the SEO team will supply a sheet with one row per page:

| URL | Current title | New title | New description | H1 | Canonical | Schema type |
|---|---|---|---|---|---|---|
| | | | | | | |
