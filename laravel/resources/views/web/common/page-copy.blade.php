{{-- Editable text block of a page: body text (1-2 paragraphs, optionally H2-H6 and links) and
     related-page links, both from Admin > Page Content. Renders nothing when both are empty. --}}
@php
    $copyHtml = \App\Services\Cms\Cms::pageCopyHtml($seo?->meta?->page_copy);
    $relatedLinks = collect($seo?->meta?->related_links ?? [])
        ->filter(fn ($link) => filled($link['label'] ?? null) && \App\Services\Cms\HtmlSanitizer::safeHref((string) ($link['url'] ?? '')) !== null);
@endphp
@if ($copyHtml !== '' || $relatedLinks->isNotEmpty())
<section class="page-copy" aria-label="More about this page">
<div class="page-copy-inner">
@if ($copyHtml !== '')
<div class="page-copy-body">{!! $copyHtml !!}</div>
@endif
@if ($relatedLinks->isNotEmpty())
<nav class="page-copy-links" aria-label="Related pages">
<p class="page-copy-links-title">Related pages</p>
<ul>
@foreach ($relatedLinks as $link)
<li><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
@endforeach
</ul>
</nav>
@endif
</div>
</section>
@endif
