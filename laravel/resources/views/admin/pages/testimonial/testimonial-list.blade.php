@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.testimonial.list') }}">Testimonials</a></li>
        </ul>
        <h1 class="panel-title">Testimonials</h1>
    </div>
@endsection


@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Testimonials</h1>
                <p class="panel-card-description">List of all client testimonials</p>
            </div>
            @can(\App\Enums\Permission::ADD_TESTIMONIAL->value)
                <div>
                    <a href="{{ route('admin.view.testimonial.create') }}" class="btn-primary-sm flex">
                        <span class="lg:block md:block sm:hidden mr-2">Add Testimonial</span>
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
                        <th>Logo</th>
                        <th>Client Name</th>
                        <th>Company Name</th>
                        <th>Feedback</th>
                        @can(\App\Enums\Permission::EDIT_TESTIMONIAL->value)
                            <th>Status</th>
                        @endcan
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($testimonials as $key => $testimonial)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img src="{{ $testimonial->company_logo ? asset('storage/' . $testimonial->company_logo) : asset('admin/images/default-thumbnail.png') }}" alt="{{ $testimonial->client_name }}" class="h-[40px] w-[40px] object-cover rounded-md border">
                                </td>
                                <td>{{ $testimonial->client_name }}</td>
                                <td>{{ $testimonial->company_name ?? '-' }}</td>
                                <td style="white-space: normal; max-width: 320px;">{{ \Illuminate\Support\Str::limit($testimonial->feedback, 100) }}</td>
                                @can(\App\Enums\Permission::EDIT_TESTIMONIAL->value)
                                    <td>
                                        <label class="toggler-switch">
                                            <input onchange="handleUpdateStatus('{{ $testimonial->id }}')"
                                                @checked($testimonial->status) type="checkbox">
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
                                                @can(\App\Enums\Permission::EDIT_TESTIMONIAL->value)
                                                    <li><a href="{{ route('admin.view.testimonial.update', ['id' => $testimonial->id]) }}"
                                                            class="dropdown-link-primary"><i data-feather="edit"
                                                                class="mr-1"></i> Edit Testimonial</a></li>
                                                @endcan

                                                @can(\App\Enums\Permission::DELETE_TESTIMONIAL->value)
                                                    <li><a href="javascript:handleDelete('{{ $testimonial->id }}');"
                                                            class="dropdown-link-danger"><i data-feather="trash-2"
                                                                class="mr-1"></i> Delete Testimonial</a></li>
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
        document.getElementById('testimonial-tab').classList.add('active');

        const handleUpdateStatus = (id) => {
            fetch("{{ route('admin.handle.testimonial.status') }}", {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    testimonial_id: id,
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

        @can(\App\Enums\Permission::DELETE_TESTIMONIAL->value)
            const handleDelete = (id) => {
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this testimonial!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location = `{{ url('admin/testimonial/delete') }}/${id}`;
                        }
                    });
            }
        @endcan
    </script>
@endsection
