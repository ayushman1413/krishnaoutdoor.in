@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.content.list') }}">Page Content</a></li>
        </ul>
        <h1 class="panel-title">Page Content</h1>
    </div>
@endsection

@section('panel-body')
    <style>
        /* Keep the Edit button on screen: header wraps, and on phones only Page and Action stay. */
        #panel-section { min-width: 0; } /* let wide content scroll inside its card instead of widening the page */
        .content-page .panel-card-header { flex-wrap: wrap; gap: 12px; }
        .content-page .data-table { width: 100%; }
        @media (max-width: 640px) {
            .content-page .data-table th:nth-child(1), .content-page .data-table td:nth-child(1),
            .content-page .data-table th:nth-child(3), .content-page .data-table td:nth-child(3),
            .content-page .data-table th:nth-child(4), .content-page .data-table td:nth-child(4) { display: none; }
        }
    </style>
    <figure class="panel-card content-page">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Headings, text &amp; internal links</h1>
                <p class="panel-card-description">Edit every heading (H1–H6) and paragraph of a page, its body text and its related-page links</p>
            </div>
            <div class="flex items-center flex-wrap gap-2">
                @foreach (['pages' => 'Pages', 'categories' => 'Categories', 'campaigns' => 'Case Studies', 'locations' => 'Locations'] as $key => $label)
                    <a href="{{ route('admin.view.content.list', ['group' => $key]) }}"
                        class="{{ $group === $key ? 'btn-primary-sm' : 'btn-secondary-md' }}">{{ $label }}</a>
                @endforeach
            </div>
        </div>
        <div class="panel-card-body">
            <div class="panel-card-table">
                <table class="data-table">
                    <thead>
                        <th>Sr. No.</th>
                        <th>Page</th>
                        <th>URL</th>
                        <th>Content</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($metas as $key => $meta)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $meta->displayName() }}</td>
                                <td style="white-space:normal;word-break:break-all;">{{ $meta->publicPath() ?? '-' }}</td>
                                <td style="white-space:normal;min-width:150px;">
                                    <span class="text-xs text-slate-500">
                                        {{ $meta->cms_elements_count }} changed<br>
                                        {{ filled($meta->page_copy) ? str_word_count(strip_tags($meta->page_copy)) . ' words text' : 'no text block' }}<br>
                                        {{ count($meta->related_links ?? []) }} related links
                                    </span>
                                </td>
                                <td>
                                    @can(\App\Enums\Permission::EDIT_SEO->value)
                                        <a href="{{ route('admin.view.content.edit', ['id' => $meta->id]) }}" class="btn-primary-sm flex w-fit">
                                            <i data-feather="edit" class="mr-1"></i> Edit
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </figure>
@endsection

@section('panel-script')
    <script>
        document.getElementById('content-tab').classList.add('active');
    </script>
@endsection
