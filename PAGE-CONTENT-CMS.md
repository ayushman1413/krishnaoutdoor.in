# Page Content CMS (Admin > Page Content)

Every public page can now be edited without code, in addition to the existing sections (Categories, Our Work, Locations, Testimonials, Careers, Settings, SEO).

## What an editor can change

Open **Admin > Page Content**, pick a page, then **Edit**.

| Area | What you can do |
|---|---|
| Heading structure | Live outline of the page's headings with warnings (no H1, two H1s, skipped levels) |
| Headings H1–H6 | Re-word any heading and set its level to H2–H6 (the main H1 stays H1; its text is also under SEO > H1 Override) |
| Paragraphs | Re-word any paragraph in the page body; links, bold and italic are allowed |
| Page text block | 1–2 paragraphs shown above the footer. Plain text works; buttons add H2–H4, bold, italic, lists and internal links (picker lists every page of the site) |
| Related pages | Up to 12 internal-link buttons under the text block, filled from a page picker |

Leaving a box unchanged, or empty, keeps the original template wording. **Reset to original** restores one element, **Reset all** restores the page. Saves are recorded as revisions in SEO > (page) > Revisions.

Categories, case studies and location pages work the same way (tabs on the list). Their own database-driven text stays in their own admin sections.

## Starting content

Migration `2026_10_20_000002_seed_page_text_and_internal_links` fills a 1–2 paragraph text block and related links, with internal links, for the 20 static pages. It only fills empty fields. The AMTS page gets links only: its body text is client-supplied.

## How it works (for developers)

- `App\Services\Cms\Cms` finds every `h1`–`h6` and `p` in a page body and applies saved overrides (`cms_elements`) when the layout renders (`web/layouts/app.blade.php`). Only changes are stored; templates keep their default text.
- An element is matched by the hash of its template text (`h:<hash>:<n>`, `p:<hash>:<n>`), not by position. If a developer rewrites an overridden template text, the override is listed as "unused changes" and can be deleted in the editor.
- Wrap template regions that must not be editable (FAQ answers that feed FAQPage schema, lists built from database rows) in `<!--cms:skip-->` … `<!--/cms:skip-->`.
- Editor HTML is cleaned by `App\Services\Cms\HtmlSanitizer` (whitelist; only safe `href` values; scripts removed) on save and again on render.
- The page text block is `seo_meta.page_copy`; related links are `seo_meta.related_links` (JSON). Both render through `web/common/page-copy.blade.php`.
- Changing a heading level keeps its CSS classes, so the look is unchanged; only the document structure changes.

## Deploy

`./deploy.sh all` (runs `php artisan migrate --force` and `optimize:clear`). CSS bundles were rebuilt (`npm run build:css`) and copied to `public_html/css`.
