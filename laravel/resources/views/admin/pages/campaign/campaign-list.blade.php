@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.campaign.list') }}">Our Work</a></li>
        </ul>
        <h1 class="panel-title">Our Work</h1>
    </div>
@endsection

@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Campaigns</h1>
                <p class="panel-card-description">List of all campaigns</p>
            </div>
            @can(\App\Enums\Permission::ADD_CAMPAIGN->value)
                <div>
                    <a href="{{ route('admin.view.campaign.create') }}" class="btn-primary-sm flex">
                        <span class="lg:block md:block sm:hidden mr-2">Add Campaign</span>
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
                        <th>Tagline</th>
                        <th>Media Type</th>
                        <th>City</th>
                        <th>Description</th>
                        @can(\App\Enums\Permission::EDIT_CAMPAIGN->value)
                            <th>Status</th>
                        @endcan
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($campaigns as $key => $campaign)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img src="{{ $campaign->image ? asset('storage/' . $campaign->image) : asset('admin/images/default-thumbnail.png') }}"
   style="height:100px;width:160px;min-width:160px;max-width:none;object-fit:cover;border-radius:6px;border:1px solid #ddd;display:block;">
                                </td>
                                <td>{{ $campaign->name }}</td>
                                <td>{{ $campaign->tagline ?? '-' }}</td>
                                <td>{{ ucfirst($campaign->media_type) }}</td>
                                <td>{{ $campaign->city }}</td>
                                <td style="white-space: normal; max-width: 280px;">{{ \Illuminate\Support\Str::limit($campaign->description, 80) }}</td>
                                @can(\App\Enums\Permission::EDIT_CAMPAIGN->value)
                                    <td>
                                        <label class="toggler-switch">
                                            <input onchange="handleUpdateStatus('{{ $campaign->id }}')"
                                                @checked($campaign->status) type="checkbox">
                                            <div class="slider"></div>
                                        </label>
                                    </td>
                                @endcan
                                <td>
                                    <div class="table-dropdown">
                                        <button>Options<i data-feather="chevron-down" class="ml-1 toggler-icon"></i></button>
                                        <div class="dropdown-menu">
                                            <ul>
                                                @can(\App\Enums\Permission::EDIT_CAMPAIGN->value)
                                                    <li><a href="{{ route('admin.view.campaign.update', ['id' => $campaign->id]) }}"
                                                            class="dropdown-link-primary"><i data-feather="edit" class="mr-1"></i> Edit Campaign</a></li>
                                                @endcan
                                                @can(\App\Enums\Permission::DELETE_CAMPAIGN->value)
                                                    <li><a href="javascript:handleDelete('{{ $campaign->id }}');"
                                                            class="dropdown-link-danger"><i data-feather="trash-2" class="mr-1"></i> Delete Campaign</a></li>
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
        document.getElementById('campaign-tab').classList.add('active');

        const handleUpdateStatus = (id) => {
            fetch("{{ route('admin.handle.campaign.status') }}", {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ campaign_id: id, _token: "{{ csrf_token() }}" })
            }).then((response) => response.json()).catch(() => {
                swal({ title: "Internal server error", text: "An error occured, please try again", icon: "error" })
            });
        }

        @can(\App\Enums\Permission::DELETE_CAMPAIGN->value)
            const handleDelete = (id) => {
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this campaign!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        window.location = `{{ url('admin/campaign/delete') }}/${id}`;
                    }
                });
            }
        @endcan
    </script>
@endsection