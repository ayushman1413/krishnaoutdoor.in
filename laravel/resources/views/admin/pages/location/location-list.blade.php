@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.location.list') }}">Locations / Media</a></li>
        </ul>
        <h1 class="panel-title">Locations / Media</h1>
    </div>
@endsection


@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Locations / Media</h1>
                <p class="panel-card-description">List of all advertising locations / media</p>
            </div>
            @can(\App\Enums\Permission::ADD_LOCATION->value)
                <div>
                    <a href="{{ route('admin.view.location.create') }}" class="btn-primary-sm flex">
                        <span class="lg:block md:block sm:hidden mr-2">Add Location</span>
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
                        <th>Image</th>
                        <th>Name</th>
                        <th>Media Type</th>
                        <th>City</th>
                        <th>Area</th>
                        <th>Availability</th>
                        @can(\App\Enums\Permission::EDIT_LOCATION->value)
                            <th>Status</th>
                        @endcan
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($locations as $key => $location)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img src="{{ $location->image ? asset('storage/' . $location->image) : asset('admin/images/default-thumbnail.png') }}" alt="{{ $location->name }}" class="h-[40px] w-[40px] object-cover rounded-md border">
                                </td>
                                <td>{{ $location->name }}</td>
                                <td>{{ \App\Enums\MediaType::tryFrom($location->media_type)?->label() ?? $location->media_type }}</td>
                                <td>{{ $location->city }}</td>
                                <td>{{ $location->area ?? '-' }}</td>
                                <td>
                                    @can(\App\Enums\Permission::EDIT_LOCATION->value)
                                        <label class="toggler-switch">
                                            <input onchange="handleUpdateAvailability('{{ $location->id }}')"
                                                @checked($location->is_available) type="checkbox">
                                            <div class="slider"></div>
                                        </label>
                                    @else
                                        @if ($location->is_available)
                                            <span class="table-status-success">Available</span>
                                        @else
                                            <span class="table-status-danger">Booked</span>
                                        @endif
                                    @endcan
                                </td>
                                @can(\App\Enums\Permission::EDIT_LOCATION->value)
                                    <td>
                                        <label class="toggler-switch">
                                            <input onchange="handleUpdateStatus('{{ $location->id }}')"
                                                @checked($location->status) type="checkbox">
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
                                                @can(\App\Enums\Permission::EDIT_LOCATION->value)
                                                    <li><a href="{{ route('admin.view.location.update', ['id' => $location->id]) }}"
                                                            class="dropdown-link-primary"><i data-feather="edit"
                                                                class="mr-1"></i> Edit Location</a></li>
                                                @endcan

                                                @can(\App\Enums\Permission::DELETE_LOCATION->value)
                                                    <li><a href="javascript:handleDelete('{{ $location->id }}');"
                                                            class="dropdown-link-danger"><i data-feather="trash-2"
                                                                class="mr-1"></i> Delete Location</a></li>
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
        document.getElementById('location-tab').classList.add('active');

        const handleUpdateStatus = (id) => {
            fetch("{{ route('admin.handle.location.status') }}", {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    location_id: id,
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

        const handleUpdateAvailability = (id) => {
            fetch("{{ route('admin.handle.location.availability') }}", {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    location_id: id,
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

        @can(\App\Enums\Permission::DELETE_LOCATION->value)
            const handleDelete = (id) => {
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this location!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location = `{{ url('admin/location/delete') }}/${id}`;
                        }
                    });
            }
        @endcan
    </script>
@endsection
