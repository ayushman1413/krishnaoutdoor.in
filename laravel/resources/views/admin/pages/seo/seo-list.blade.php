@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.seo.list') }}">SEO</a></li>
        </ul>
        <h1 class="panel-title">SEO</h1>
    </div>
@endsection

@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">SEO Meta</h1>
                <p class="panel-card-description">Manage meta data for pages, categories and locations</p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.view.seo.list', ['group' => 'pages']) }}"
                    class="{{ $group === 'pages' ? 'btn-primary-sm' : 'btn-secondary-md' }}">Pages</a>
                <a href="{{ route('admin.view.seo.list', ['group' => 'categories']) }}"
                    class="{{ $group === 'categories' ? 'btn-primary-sm' : 'btn-secondary-md' }}">Categories</a>
                <a href="{{ route('admin.view.seo.list', ['group' => 'locations']) }}"
                    class="{{ $group === 'locations' ? 'btn-primary-sm' : 'btn-secondary-md' }}">Locations</a>
                <a href="{{ route('admin.handle.seo.export') }}" class="btn-secondary-md">Export CSV</a>
                @can(\App\Enums\Permission::EDIT_SEO->value)
                    <form action="{{ route('admin.handle.seo.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                        @csrf
                        <input type="file" name="csv_file" accept=".csv,.txt" class="input-box-md" required>
                        <button type="submit" class="btn-secondary-md">Import CSV</button>
                    </form>
                @endcan
            </div>
        </div>
        @error('csv_file') <p class="input-error px-5">{{ $message }}</p> @enderror
        <div class="panel-card-body">
            <div class="panel-card-table">
                <table class="data-table">
                    <thead>
                        <th>Sr. No.</th>
                        <th>{{ $group === 'pages' ? 'Page' : 'Item Name' }}</th>
                        <th>Meta Title</th>
                        <th>Meta Description</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @forelse ($metas as $key => $meta)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if ($group === 'pages')
                                        {{ \Illuminate\Support\Str::headline(str_replace(['view.', '.'], ['', ' '], $meta->route_name)) }}
                                    @elseif ($group === 'locations')
                                        {{ \Illuminate\Support\Str::headline(str_replace('view.locations.city.', '', $meta->route_name)) }}
                                    @else
                                        {{ $meta->seoable->name ?? '-' }}
                                    @endif
                                </td>
                                <td>{{ $meta->meta_title ?? '-' }}</td>
                                <td style="white-space: normal; max-width: 280px;">
                                    {{ $meta->meta_description ? \Illuminate\Support\Str::limit($meta->meta_description, 80) : '-' }}
                                </td>
                                <td>
                                    @can(\App\Enums\Permission::EDIT_SEO->value)
                                        <a href="{{ route('admin.view.seo.update', ['id' => $meta->id]) }}"
                                            class="btn-primary-sm flex w-fit">
                                            <i data-feather="edit" class="mr-1"></i> Edit
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </figure>
@endsection

@section('panel-script')
    <script>
        document.getElementById('seo-tab').classList.add('active');
    </script>
@endsection
