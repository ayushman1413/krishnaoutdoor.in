<?php

namespace App\Services\Cms;

use DOMComment;
use DOMDocument;
use DOMElement;
use DOMNode;

/**
 * Whitelist HTML cleaner for editor-entered content. Disallowed tags are
 * unwrapped (their text stays), script-like tags are dropped with their
 * content, and every attribute except a safe `href` on <a> is removed.
 */
class HtmlSanitizer
{
    /** Allowed inside a heading or a paragraph. */
    public const INLINE = ['a', 'strong', 'b', 'em', 'i', 'br'];

    /** Allowed in the page text block: headings H2-H6, lists and paragraphs too. */
    public const BLOCK = ['p', 'h2', 'h3', 'h4', 'h5', 'h6', 'ul', 'ol', 'li', 'a', 'strong', 'b', 'em', 'i', 'br'];

    private const DROP_WITH_CONTENT = ['script', 'style', 'iframe', 'object', 'embed', 'form', 'template', 'svg', 'noscript'];

    public static function clean(string $html, array $allowed): string
    {
        $html = trim($html);
        if ($html === '') {
            return '';
        }

        $previous = libxml_use_internal_errors(true);
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->loadHTML('<?xml encoding="utf-8"?><body>' . $html . '</body>', LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $body = $doc->getElementsByTagName('body')->item(0);
        if (!$body) {
            return '';
        }

        self::walk($body, $allowed);

        $out = '';
        foreach ($body->childNodes as $child) {
            $out .= $doc->saveHTML($child);
        }

        return trim(preg_replace('/[ \t]+/', ' ', $out));
    }

    private static function walk(DOMNode $parent, array $allowed): void
    {
        foreach (iterator_to_array($parent->childNodes) as $child) {
            if ($child instanceof DOMComment) {
                $parent->removeChild($child);
                continue;
            }
            if (!$child instanceof DOMElement) {
                continue;
            }

            $name = strtolower($child->nodeName);
            if (in_array($name, self::DROP_WITH_CONTENT, true)) {
                $parent->removeChild($child);
                continue;
            }

            self::walk($child, $allowed);

            $href = $name === 'a' ? self::safeHref($child->getAttribute('href')) : null;
            if (!in_array($name, $allowed, true) || ($name === 'a' && $href === null)) {
                while ($child->firstChild) {
                    $parent->insertBefore($child->firstChild, $child);
                }
                $parent->removeChild($child);
                continue;
            }

            foreach (iterator_to_array($child->attributes) as $attribute) {
                $child->removeAttributeNode($attribute);
            }
            if ($name === 'a') {
                $child->setAttribute('href', $href);
                if (self::isExternal($href)) {
                    $child->setAttribute('rel', 'noopener');
                }
            }
        }
    }

    /** Site-relative paths, anchors, http(s), mailto and tel links only. */
    public static function safeHref(string $href): ?string
    {
        $href = trim($href);
        if ($href === '' || preg_match('~[\x00-\x1f\s]~', $href)) {
            return null;
        }

        return preg_match('~^(/(?!/)|#|https?://|mailto:|tel:)~i', $href) ? $href : null;
    }

    private static function isExternal(string $href): bool
    {
        if (!preg_match('~^https?://([^/:?#]+)~i', $href, $m)) {
            return false;
        }

        return strcasecmp($m[1], (string) parse_url((string) config('app.url'), PHP_URL_HOST)) !== 0;
    }
}
