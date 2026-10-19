{{-- Visible breadcrumb, built from the same trail as the BreadcrumbList schema.
     $seo: the page's SeoResolver. $class: CSS class of the wrapper. --}}
@php $crumbs = \App\Services\SchemaBuilder::trail($seo); @endphp
<nav class="{{ $class ?? 'kw-crumbs' }}" aria-label="Breadcrumb">@foreach ($crumbs as $crumb)@if ($loop->last)<b aria-current="page">{{ $crumb['name'] }}</b>@else<a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a><span>/</span>@endif @endforeach</nav>
