@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.career.list') }}">Career Applications</a></li>
        </ul>
        <h1 class="panel-title">Career Applications</h1>
    </div>
@endsection

@section('panel-body')
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Candidate Applications</h1>
                <p class="panel-card-description">List of candidates who applied through the website career page</p>
            </div>
        </div>
        <div class="panel-card-body">
            <div class="panel-card-table">
                <table class="data-table">
                    <thead>
                        <th>Sr. No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Resume</th>
                        <th>Applied Date & Time</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($careers as $key => $career)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $career->name }}</td>
                                <td><a href="mailto:{{ $career->email }}" class="link">{{ $career->email }}</a></td>
                                <td><a href="tel:{{ $career->phone }}" class="link">{{ $career->phone }}</a></td>
                                <td><span class="badge badge-info">{{ $career->role }}</span></td>
                                <td>
                                    @if ($career->resume)
                                        <a href="{{ asset('storage/' . $career->resume) }}" target="_blank" class="table-btn inline-flex items-center text-blue-600 hover:text-blue-800">
                                            <i data-feather="file-text" class="h-3.5 w-3.5 mr-1 stroke-[2.4px]"></i> View Resume
                                        </a>
                                    @else
                                        <span class="text-slate-400">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $career->created_at ? $career->created_at->format('d M Y, h:i A') : '-' }}</td>
                                <td>
                                    @can(\App\Enums\Permission::DELETE_CAREER->value)
                                        <button type="button" class="table-btn" onclick="handleDelete('{{ $career->id }}')">
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
        document.getElementById('career-tab').classList.add('active');

        @can(\App\Enums\Permission::DELETE_CAREER->value)
            const handleDelete = (id) => {
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this candidate application!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location = `{{ url('admin/career/delete') }}/${id}`;
                        }
                    });
            }
        @endcan
    </script>
@endsection
