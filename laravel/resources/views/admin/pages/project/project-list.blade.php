@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.project.list') }}">Project</a></li>
        </ul>
        <h1 class="panel-title">Project</h1>
    </div>
@endsection


@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Project</h1>
                <p class="panel-card-description">List of all project in the system</p>
            </div>
            @can(\App\Enums\Permission::ADD_PROJECT->value)
                <div>
                    <a href="{{ route('admin.view.project.create') }}" class="btn-primary-sm flex">
                        <span class="lg:block md:block sm:hidden mr-2">Add Project</span>
                        <i data-feather="plus"></i>
                    </a>
                </div>
            @endcan
        </div>
        <div class="panel-card-body">
            <div class="panel-card-table">
                <table class="data-table">
                    <thead>
                        <th>Sr. No.</th>
                        <th>Name</th>
                        <th>Summary</th>
                        @can(\App\Enums\Permission::EDIT_PROJECT->value)
                            <th>Status</th>
                        @endcan
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($projects as $key => $project)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->summary }}</td>
                                @can(\App\Enums\Permission::EDIT_PROJECT->value)
                                    <td>
                                        <label class="toggler-switch">
                                            <input onchange="handleUpdateStatus('{{ $project->id }}')"
                                                @checked($project->status) type="checkbox">
                                            <div class="slider"></div>
                                        </label>
                                    </td>
                                @endcan
                                <td>
                                    <div class="table-dropdown">
                                        <button>Options<i data-feather="chevron-down"
                                                class="ml-1 toggler-icon"></i></button>
                                        <div class="dropdown-menu">
                                            <ul>
                                                @can(\App\Enums\Permission::EDIT_PROJECT->value)
                                                    <li><a href="{{ route('admin.view.project.update', ['id' => $project->id]) }}"
                                                            class="dropdown-link-primary"><i data-feather="edit"
                                                                class="mr-1"></i> Edit Project</a></li>
                                                @endcan

                                                @can(\App\Enums\Permission::DELETE_PROJECT->value)
                                                    <li><a href="javascript:handleDelete('{{ $project->id }}');"
                                                            class="dropdown-link-danger"><i data-feather="trash-2"
                                                                class="mr-1"></i> Delete Project</a></li>
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
        document.getElementById('project-tab').classList.add('active');

        const handleUpdateStatus = (id) => {
            fetch("{{ route('admin.handle.project.status') }}", {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    admin_id: id,
                    _token: "{{ csrf_token() }}"
                })
            }).then((response) => {
                return response.json();
            }).catch((error) => {
                swal({
                    title: "Internal server error",
                    text: "An error occured, please try again",
                    icon: "error",
                })
            });
        }

        @can(\App\Enums\Permission::DELETE_PROJECT->value)
            const handleDelete = (id) => {
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this admin project!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location = `{{ url('admin/project/delete') }}/${id}`;
                        }
                    });
            }
        @endcan
    </script>
@endsection
