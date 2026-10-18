<figure class="px-4 py-2.5 shadow-lg bg-white rounded-xl border">
    <div class="flex items-center justify-between">
        <div>
            <button onclick="toggleSidebar()"
                class="h-[40px] w-[40px] lg:hidden md:hidden hover:bg-complement rounded-lg flex items-center justify-center transition duration-300 ease-in-out hover:ease-in-out border border-gray-200">
                <i data-feather="menu" class="h-4 w-4 stroke-ascent-dark stroke-[3px]"></i>
            </button>
        </div>
        <div class="lg:hidden md:hidden sm:block">
            <h1 class="font-semibold text-base text-ascent">{{config('app.name')}}</h1>
        </div>
        <div class="space-x-4 flex items-center">

            @php
                $enquiry_count = \App\Models\Enquiry::count();
            @endphp
            <a href="{{route('admin.view.enquiry.list')}}" class="relative h-[40px] w-[40px] flex items-center justify-center rounded-lg hover:bg-complement border border-gray-200">
                <i data-feather="bell" class="h-4 w-4 stroke-slate-600 stroke-[2.2px]"></i>
                @if ($enquiry_count > 0)
                    <span class="absolute -top-1.5 -right-1.5 h-[18px] min-w-[18px] px-1 flex items-center justify-center rounded-full bg-ascent text-white text-[0.6rem] font-semibold">{{ $enquiry_count > 99 ? '99+' : $enquiry_count }}</span>
                @endif
            </a>

            @include('admin.components.profile-dropdown')
        </div>
    </div>
</figure>
