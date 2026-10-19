<?php

namespace App\Services\Cms;

use App\Models\CmsElement;
use App\Models\SeoMeta;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * Page-content CMS.
 *
 * Page templates keep their default wording. Every heading (H1-H6) and
 * paragraph in a page body can be re-worded, and every heading re-levelled,
 * from the admin panel (Page Content). Only the changes are stored
 * (cms_elements); render() applies them to the body HTML of the page.
 *
 * An element is identified by its template text, not its position, so adding
 * or moving other elements never shifts an override onto the wrong element:
 *   "h1"                the page's first <h1> (its text is seo_meta.h1_override)
 *   "h:<hash>:<n>"      heading with that text, n-th time on the page
 *   "p:<hash>:<n>"      paragraph with that text, n-th time on the page
 * If a developer later rewrites the template text of an overridden element,
 * the override no longer matches; the editor sees it listed as "unused".
 *
 * Template regions that must not be edited (FAQ answers that also feed the
 * FAQPage schema, lists built from database rows, ...) are wrapped in
 * <!--cms:skip--> ... <!--/cms:skip-->.
 */
class Cms
{
    public const LEVELS = ['h2', 'h3', 'h4', 'h5', 'h6'];

    /** Elements found while scanning a page for the admin screen; null outside a scan. */
    private static ?array $capture = null;

    /** Layout hook: returns the page body with this page's overrides applied. */
    public static function render(string $html, ?SeoMeta $meta): string
    {
        if (self::$capture !== null) {
            self::$capture = self::elements($html);

            return $html;
        }
        if (!$meta || trim($html) === '') {
            return $html;
        }

        $overrides = CmsElement::where('seo_meta_id', $meta->id)->get()->keyBy('element_key');
        if ($overrides->isEmpty()) {
            return $html;
        }

        $elements = self::elements($html);
        // Back to front so earlier offsets stay valid while replacing.
        foreach (array_reverse($elements) as $el) {
            $row = $overrides->get($el['key']);
            if (!$row) {
                continue;
            }
            $tag = ($el['tag'] !== 'p' && $row->tag && in_array($row->tag, self::LEVELS, true)) ? $row->tag : $el['tag'];
            $inner = $row->content !== null ? $row->content : $el['inner'];
            if ($tag === $el['tag'] && $inner === $el['inner']) {
                continue;
            }
            $html = substr_replace($html, "<{$tag}{$el['attrs']}>{$inner}</{$tag}>", $el['start'], $el['end'] - $el['start']);
        }

        return $html;
    }

    /**
     * Editable headings and paragraphs of a body HTML string, in page order:
     * [key, tag, attrs, inner, text, start, end].
     */
    public static function elements(string $html): array
    {
        $masked = self::mask($html);
        if (!preg_match_all('~<(h[1-6]|p)(\s[^>]*)?>(.*?)</\1\s*>~is', $masked, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE)) {
            return [];
        }

        $elements = [];
        $seen = [];
        $h1Taken = false;
        foreach ($matches as $m) {
            $start = $m[0][1];
            $end = $start + strlen($m[0][0]);
            $inner = substr($html, $m[3][1], strlen($m[3][0]));
            $text = self::text($inner);
            // Wrapper-like markup or an empty tag is not editable text.
            if ($text === '' || preg_match('~<(div|section|ul|ol|table|form|main|article|aside)\b~i', $inner)) {
                continue;
            }

            $tag = strtolower($m[1][0]);
            if ($tag === 'h1' && !$h1Taken) {
                $h1Taken = true;
                $key = 'h1';
            } else {
                $base = ($tag === 'p' ? 'p' : 'h') . ':' . substr(sha1(mb_strtolower($text)), 0, 10);
                $seen[$base] = ($seen[$base] ?? 0) + 1;
                $key = $base . ':' . $seen[$base];
            }

            $elements[] = [
                'key' => $key,
                'tag' => $tag,
                'attrs' => $m[2][0] ?? '',
                'inner' => $inner,
                'text' => $text,
                'start' => $start,
                'end' => $end,
            ];
        }

        return $elements;
    }

    /** Plain, whitespace-collapsed text of an HTML fragment. */
    public static function text(string $html): string
    {
        $text = html_entity_decode(strip_tags(preg_replace('~<br\s*/?>~i', ' ', $html)), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(preg_replace('/\s+/u', ' ', $text));
    }

    /** Whether two inner-HTML strings differ only in whitespace or entity spelling (&amp; vs &). */
    public static function sameMarkup(string $a, string $b): bool
    {
        $squash = fn (string $s) => html_entity_decode(
            trim(preg_replace('/\s+/u', ' ', preg_replace('~\s*<br\s*/?>\s*~i', '<br>', $s))),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );

        return $squash($a) === $squash($b);
    }

    /** Inner HTML as shown in an edit box: "&amp;" shown as "&" (the sanitiser re-encodes it on save). */
    public static function forEditing(string $html): string
    {
        return str_replace('&amp;', '&', trim($html));
    }

    /**
     * HTML with every region that must not be edited blanked out with spaces,
     * so offsets in the result are offsets in the original.
     */
    private static function mask(string $html): string
    {
        $blank = fn (array $m) => str_repeat(' ', strlen($m[0]));

        $html = preg_replace_callback('~<!--cms:skip-->.*?<!--/cms:skip-->~s', $blank, $html);
        $html = preg_replace_callback('~<!--.*?-->~s', $blank, $html);

        return preg_replace_callback('~<(script|style|svg|template|noscript|textarea|select|button)\b.*?</\1\s*>~is', $blank, $html);
    }

    /**
     * Render a page's route without a web request and return its editable
     * elements (as the template wrote them, no overrides). Null when the
     * page cannot be rendered.
     */
    public static function scan(SeoMeta $meta): ?array
    {
        $path = $meta->publicPath();
        if ($path === null) {
            return null;
        }

        $original = app('request');
        $request = Request::create(rtrim((string) config('app.url'), '/') . $path, 'GET');
        self::$capture = [];
        // The web middleware that shares the session's $errors does not run here;
        // forms in the page templates need an (empty) bag, not the admin's.
        $sharedErrors = View::shared('errors');
        View::share('errors', new ViewErrorBag());

        try {
            $route = app('router')->getRoutes()->match($request);
            $request->setRouteResolver(fn () => $route);
            $route->bind($request);
            app()->instance('request', $request);

            $result = $route->run();
            if ($result instanceof Renderable) {
                $result->render();
            }

            return self::$capture;
        } catch (HttpExceptionInterface) {
            return null;
        } catch (Throwable $e) {
            report($e);

            return null;
        } finally {
            View::share('errors', $sharedErrors);
            self::$capture = null;
            app()->instance('request', $original);
        }
    }

    /** Heading / paragraph inner HTML: inline formatting and links only. */
    public static function cleanInline(string $html): string
    {
        return HtmlSanitizer::clean($html, HtmlSanitizer::INLINE);
    }

    /**
     * Page text block (seo_meta.page_copy) as safe HTML. Plain text with blank
     * lines between paragraphs is accepted as well as HTML (p, H2-H6, lists, links).
     */
    public static function pageCopyHtml(?string $copy): string
    {
        $copy = trim((string) $copy);
        if ($copy === '') {
            return '';
        }
        if (preg_match('~<\s*(p|h[2-6]|ul|ol)\b~i', $copy)) {
            return HtmlSanitizer::clean($copy, HtmlSanitizer::BLOCK);
        }

        $paragraphs = array_filter(array_map(
            fn (string $chunk) => self::cleanInline($chunk),
            preg_split('/\R{2,}/', $copy)
        ), fn (string $chunk) => $chunk !== '');

        return implode("\n", array_map(fn (string $chunk) => '<p>' . $chunk . '</p>', $paragraphs));
    }
}
