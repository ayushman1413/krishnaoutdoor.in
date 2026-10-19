{{-- FAQ list. The same $faqs feed the FAQPage schema (SchemaBuilder), so what
     search engines read always matches what is on the page.
     $faqs: array of ['q' => question, 'a' => answer] (plain text). --}}
@php \App\Services\SchemaBuilder::addFaqs($faqs); @endphp
{{-- Answers are also in the FAQPage schema, so Page Content cannot edit them. --}}
<!--cms:skip-->
<div class="kw-faq">
@foreach ($faqs as $faq)
    <details @if ($loop->first) open @endif>
        <summary>{{ $faq['q'] }}</summary>
        <p>{{ $faq['a'] }}</p>
    </details>
@endforeach
</div>
<!--/cms:skip-->
