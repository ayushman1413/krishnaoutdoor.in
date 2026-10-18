@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.enquiry.list') }}">Enquiries</a></li>
        </ul>
        <h1 class="panel-title">Enquiries</h1>
    </div>
@endsection


@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Simple Enquiries</h1>
                <p class="panel-card-description">Website enquiries submitted by visitors</p>
            </div>
        </div>
        <div class="panel-card-body">
            <div class="panel-card-table">
                <table class="data-table">
                    <thead>
                        <th>Sr. No.</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Company</th>
                        <th>Requirement</th>
                        <th>Date</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($enquiries as $key => $enquiry)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $enquiry->name }}</td>
                                <td><a href="tel:{{ $enquiry->phone }}" class="link">{{ $enquiry->phone }}</a></td>
                                <td>{{ $enquiry->company ?? '-' }}</td>
                                <td>{{ \App\Enums\Requirement::tryFrom($enquiry->requirement)?->label() ?? ($enquiry->requirement ?? '-') }}</td>
                                <td>{{ $enquiry->created_at->format('d M Y, h:i A') }}</td>
                                <td>
                                    @can(\App\Enums\Permission::DELETE_ENQUIRY->value)
                                        <button type="button" class="table-btn" onclick="handleDelete('{{ $enquiry->id }}')">
                                            <i data-feather="trash-2" class="h-3.5 w-3.5 mr-1 stroke-[2.4px]"></i> Delete
                                        </button>
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
        document.getElementById('enquiry-tab').classList.add('active');

        @can(\App\Enums\Permission::DELETE_ENQUIRY->value)
            const handleDelete = (id) => {
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this enquiry!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location = `{{ url('admin/enquiry/delete') }}/${id}`;
                        }
                    });
            }
        @endcan
    </script>
@endsection
