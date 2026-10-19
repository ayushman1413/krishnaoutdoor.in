@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.seo.list') }}">SEO</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.seo.todos') }}">Content TODOs</a></li>
        </ul>
        <h1 class="panel-title">Content TODOs</h1>
    </div>
@endsection

@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Information the site still needs</h1>
                <p class="panel-card-description">Not shown on the public site. Each item disappears once the data is supplied.</p>
            </div>
        </div>
        <div class="panel-card-body">
            @forelse ($groups as $group => $items)
                <h2 class="panel-card-title" style="margin:18px 0 8px">{{ $group }}</h2>
                <div class="panel-card-table">
                    <table class="data-table">
                        <thead><th>TODO</th><th>Where to supply it</th></thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td style="white-space: normal;">{{ $item['todo'] }}</td>
                                    <td style="white-space: normal;">{{ $item['where'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @empty
                <p>Nothing outstanding.</p>
            @endforelse
        </div>
    </figure>
@endsection

@section('panel-script')
    <script>
        document.getElementById('seo-tab').classList.add('active');
    </script>
@endsection
