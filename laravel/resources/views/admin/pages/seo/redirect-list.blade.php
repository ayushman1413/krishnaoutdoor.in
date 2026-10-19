@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.redirect.list') }}">Redirects</a></li>
        </ul>
        <h1 class="panel-title">Redirects</h1>
    </div>
@endsection

@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">301 / 302 Redirects</h1>
                <p class="panel-card-description">List of all configured redirects</p>
            </div>
            <div class="flex items-center space-x-3">
                <form action="{{ route('admin.handle.redirect.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                    @csrf
                    <input type="file" name="csv_file" accept=".csv,.txt" class="input-box-md" required>
                    <button type="submit" class="btn-secondary-md">Import CSV</button>
                </form>
                @can(\App\Enums\Permission::MANAGE_REDIRECTS->value)
                    <a href="{{ route('admin.view.redirect.create') }}" class="btn-primary-sm flex">
                        <span class="lg:block md:block sm:hidden mr-2">Add Redirect</span>
                        <i data-feather="plus"></i>
                    </a>
                @endcan
            </div>
        </div>
        @error('csv_file') <p class="input-error px-5">{{ $message }}</p> @enderror
        <div class="panel-card-body">
            <div class="panel-card-table">
                <table class="data-table">
                    <thead>
                        <th>Sr. No.</th>
                        <th>Old URL</th>
                        <th>New URL</th>
                        <th>Type</th>
                        <th>Hit Count</th>
                        @can(\App\Enums\Permission::MANAGE_REDIRECTS->value)
                            <th>Status</th>
                        @endcan
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($redirects as $key => $redirect)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td style="white-space: normal; max-width: 250px;">{{ $redirect->old_url }}</td>
                                <td style="white-space: normal; max-width: 250px;">{{ $redirect->new_url }}</td>
                                <td>{{ $redirect->type }}</td>
                                <td>{{ $redirect->hit_count ?? 0 }}</td>
                                @can(\App\Enums\Permission::MANAGE_REDIRECTS->value)
                                    <td>
                                        <label class="toggler-switch">
                                            <input onchange="handleUpdateStatus('{{ $redirect->id }}')"
                                                @checked($redirect->status) type="checkbox">
                                            <div class="slider"></div>
                                        </label>
                                    </td>
                                @endcan
                                <td>
                                    <div class="table-dropdown">
                                        <button>Options<i data-feather="chevron-down" class="ml-1 toggler-icon"></i></button>
                                        <div class="dropdown-menu">
                                            <ul>
                                                @can(\App\Enums\Permission::MANAGE_REDIRECTS->value)
                                                    <li><a href="{{ route('admin.view.redirect.update', ['id' => $redirect->id]) }}"
                                                            class="dropdown-link-primary"><i data-feather="edit" class="mr-1"></i> Edit Redirect</a></li>
                                                    <li><a href="javascript:handleDelete('{{ $redirect->id }}');"
                                                            class="dropdown-link-danger"><i data-feather="trash-2" class="mr-1"></i> Delete Redirect</a></li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </div>
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
        document.getElementById('seo-tab').classList.add('active');

        const handleUpdateStatus = (id) => {
            fetch("{{ route('admin.handle.redirect.status') }}", {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ redirect_id: id, _token: "{{ csrf_token() }}" })
            }).then((response) => response.json()).catch(() => {
                swal({ title: "Internal server error", text: "An error occured, please try again", icon: "error" })
            });
        }

        @can(\App\Enums\Permission::MANAGE_REDIRECTS->value)
            const handleDelete = (id) => {
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this redirect!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        window.location = `{{ url('admin/redirect/delete') }}/${id}`;
                    }
                });
            }
        @endcan
    </script>
@endsection
