@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('admin.view.dashboard')}}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{route('admin.view.dashboard')}}">Dashboard</a></li>
        </ul>
        <h1 class="panel-title">Dashboard</h1>
        <p class="text-sm text-slate-500 mt-1">Welcome back! Here's what's happening with your website.</p>
    </div>
@endsection


@section('panel-body')
<div class="flex flex-col lg:space-y-8 md:space-y-7 sm:space-y-6">

    {{-- Stat Cards --}}
    <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-7">

        {{-- @can(\App\Enums\Permission::VIEW_LOCATION->value)
        <figure class="panel-card">
            <div class="panel-card-body space-y-5">
                <div class="flex items-center space-x-4">
                    <div class="h-[55px] w-[55px] bg-red-50 rounded-full flex items-center justify-center shrink-0">
                        <i data-feather="map-pin" class="h-5 w-5 stroke-ascent stroke-[2px]"></i>
                    </div>
                    <div>
                        <p class="text-[0.65rem] font-semibold text-slate-400 uppercase tracking-wide">Locations / Media</p>
                        <h1 class="font-semibold text-ascent-dark text-3xl mt-1">{{ $total_locations }}</h1>
                        <p class="text-xs text-slate-500">Total Locations</p>
                    </div>
                </div>
                <a href="{{ route('admin.view.location.list') }}" class="flex items-center text-xs font-semibold text-ascent">
                    <span>View all</span>
                    <i data-feather="chevron-right" class="h-3.5 w-3.5 ml-1 stroke-[3px]"></i>
                </a>
            </div>
        </figure>
        @endcan --}}

        @can(\App\Enums\Permission::VIEW_TESTIMONIAL->value)
        <figure class="panel-card">
            <div class="panel-card-body space-y-5">
                <div class="flex items-center space-x-4">
                    <div class="h-[55px] w-[55px] bg-blue-50 rounded-full flex items-center justify-center shrink-0">
                        <i data-feather="message-square" class="h-5 w-5 stroke-blue-600 stroke-[2px]"></i>
                    </div>
                    <div>
                        <p class="text-[0.65rem] font-semibold text-slate-400 uppercase tracking-wide">Testimonials</p>
                        <h1 class="font-semibold text-ascent-dark text-3xl mt-1">{{ $total_testimonials }}</h1>
                        <p class="text-xs text-slate-500">Total Testimonials</p>
                    </div>
                </div>
                <a href="{{ route('admin.view.testimonial.list') }}" class="flex items-center text-xs font-semibold text-blue-600">
                    <span>View all</span>
                    <i data-feather="chevron-right" class="h-3.5 w-3.5 ml-1 stroke-[3px]"></i>
                </a>
            </div>
        </figure>
        @endcan

        @can(\App\Enums\Permission::VIEW_ENQUIRY->value)
        <figure class="panel-card">
            <div class="panel-card-body space-y-5">
                <div class="flex items-center space-x-4">
                    <div class="h-[55px] w-[55px] bg-green-50 rounded-full flex items-center justify-center shrink-0">
                        <i data-feather="mail" class="h-5 w-5 stroke-green-600 stroke-[2px]"></i>
                    </div>
                    <div>
                        <p class="text-[0.65rem] font-semibold text-slate-400 uppercase tracking-wide">Enquiries</p>
                        <h1 class="font-semibold text-ascent-dark text-3xl mt-1">{{ $total_enquiries }}</h1>
                        <p class="text-xs text-slate-500">Total Enquiries</p>
                    </div>
                </div>
                <a href="{{ route('admin.view.enquiry.list') }}" class="flex items-center text-xs font-semibold text-green-600">
                    <span>View all</span>
                    <i data-feather="chevron-right" class="h-3.5 w-3.5 ml-1 stroke-[3px]"></i>
                </a>
            </div>
        </figure>
        @endcan

    </div>

    {{-- Quick Actions --}}
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Quick Actions</h1>
            </div>
        </div>
        <div class="panel-card-body">
            <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-5">

                {{-- @can(\App\Enums\Permission::VIEW_LOCATION->value)
                <a href="{{ route('admin.view.location.list') }}" class="flex items-center space-x-4 p-4 border rounded-lg hover:shadow-lg transition duration-200 ease-in-out">
                    <div class="h-[45px] w-[45px] bg-ascent rounded-lg flex items-center justify-center shrink-0">
                        <i data-feather="map-pin" class="h-4 w-4 stroke-white stroke-[2.2px]"></i>
                    </div>
                    <div class="flex-1">
                        <h1 class="font-semibold text-sm text-black">Manage Locations</h1>
                        <p class="text-xs text-slate-500 mt-0.5">Add, edit or manage locations</p>
                    </div>
                    <i data-feather="chevron-right" class="h-4 w-4 stroke-slate-400"></i>
                </a>
                @endcan --}}

                @can(\App\Enums\Permission::VIEW_TESTIMONIAL->value)
                <a href="{{ route('admin.view.testimonial.list') }}" class="flex items-center space-x-4 p-4 border rounded-lg hover:shadow-lg transition duration-200 ease-in-out">
                    <div class="h-[45px] w-[45px] bg-blue-600 rounded-lg flex items-center justify-center shrink-0">
                        <i data-feather="message-square" class="h-4 w-4 stroke-white stroke-[2.2px]"></i>
                    </div>
                    <div class="flex-1">
                        <h1 class="font-semibold text-sm text-black">Manage Testimonials</h1>
                        <p class="text-xs text-slate-500 mt-0.5">Add, edit or manage testimonials</p>
                    </div>
                    <i data-feather="chevron-right" class="h-4 w-4 stroke-slate-400"></i>
                </a>
                @endcan

                @can(\App\Enums\Permission::VIEW_ENQUIRY->value)
                <a href="{{ route('admin.view.enquiry.list') }}" class="flex items-center space-x-4 p-4 border rounded-lg hover:shadow-lg transition duration-200 ease-in-out">
                    <div class="h-[45px] w-[45px] bg-green-600 rounded-lg flex items-center justify-center shrink-0">
                        <i data-feather="mail" class="h-4 w-4 stroke-white stroke-[2.2px]"></i>
                    </div>
                    <div class="flex-1">
                        <h1 class="font-semibold text-sm text-black">View Enquiries</h1>
                        <p class="text-xs text-slate-500 mt-0.5">View and manage enquiries</p>
                    </div>
                    <i data-feather="chevron-right" class="h-4 w-4 stroke-slate-400"></i>
                </a>
                @endcan

            </div>
        </div>
    </figure>

    {{-- Recent Enquiries --}}
    @can(\App\Enums\Permission::VIEW_ENQUIRY->value)
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Recent Enquiries</h1>
                <p class="panel-card-description">Latest leads submitted from the website</p>
            </div>
            <div>
                <a href="{{ route('admin.view.enquiry.list') }}" class="link text-xs font-semibold">View All Enquiries</a>
            </div>
        </div>
        <div class="panel-card-body">
            <div class="panel-card-table">
                <table class="data-table {{ $recent_enquiries->isEmpty() ? 'ignore' : '' }}">
                    <thead>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Company</th>
                        <th>Requirement</th>
                        <th>Date</th>
                    </thead>
                    <tbody>
                        @forelse ($recent_enquiries as $enquiry)
                            <tr>
                                <td>{{ $enquiry->name }}</td>
                                <td>{{ $enquiry->phone }}</td>
                                <td>{{ $enquiry->company ?? '-' }}</td>
                                <td>{{ \App\Enums\Requirement::tryFrom($enquiry->requirement)?->label() ?? ($enquiry->requirement ?? '-') }}</td>
                                <td>{{ $enquiry->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr class="ignore">
                                <td colspan="5" class="text-center">No enquiries yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </figure>
    @endcan

</div>
@endsection

@section('panel-script')
<script>
    document.getElementById('dashboard-tab').classList.add('active');
</script>
@endsection
