@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.404log.list') }}">404 Logs</a></li>
        </ul>
        <h1 class="panel-title">404 Logs</h1>
    </div>
@endsection

@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Unresolved 404s</h1>
                <p class="panel-card-description">URLs that returned a 404, most hit first</p>
            </div>
        </div>
        <div class="panel-card-body">
            <div class="panel-card-table">
                <table class="data-table">
                    <thead>
                        <th>Sr. No.</th>
                        <th>URL</th>
                        <th>Hit Count</th>
                        <th>Last Seen</th>
                        <th>Referrer</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @forelse ($logs as $key => $log)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td style="white-space: normal; max-width: 280px;">{{ $log->url }}</td>
                                <td>{{ $log->hit_count ?? 0 }}</td>
                                <td>{{ $log->last_seen_at ? \Illuminate\Support\Carbon::parse($log->last_seen_at)->format('d M Y, h:i A') : '-' }}</td>
                                <td style="white-space: normal; max-width: 200px;">{{ $log->referrer ?? '-' }}</td>
                                <td>
                                    <div class="table-dropdown">
                                        <button>Options<i data-feather="chevron-down" class="ml-1 toggler-icon"></i></button>
                                        <div class="dropdown-menu">
                                            <ul>
                                                @can(\App\Enums\Permission::MANAGE_REDIRECTS->value)
                                                    <li><a href="{{ route('admin.view.redirect.create', ['old_url' => $log->url]) }}"
                                                            class="dropdown-link-primary"><i data-feather="corner-up-right" class="mr-1"></i> Create Redirect</a></li>
                                                    <li><a href="javascript:handleDelete('{{ $log->id }}');"
                                                            class="dropdown-link-danger"><i data-feather="trash-2" class="mr-1"></i> Dismiss</a></li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No 404 logs found</td>
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

        @can(\App\Enums\Permission::MANAGE_REDIRECTS->value)
            const handleDelete = (id) => {
                swal({
                    title: "Are you sure?",
                    text: "Once dismissed, this log entry will be removed!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        window.location = `{{ url('admin/404-log/delete') }}/${id}`;
                    }
                });
            }
        @endcan
    </script>
@endsection
