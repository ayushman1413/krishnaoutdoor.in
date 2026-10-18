<aside id="sidebar">
    <div class="sidebar">
        <div class="space-y-7">
            <div class="flex items-center justify-between relative">
                <div class="md:text-center sm:text-left space-y-4 pt-8 px-6 w-full">
                    <div class="flex items-center justify-center">
                        <div class="w-fit h-fit bg-white rounded-lg p-2.5">
                            <img src="<?php echo e(asset('web/images/logo-header.png')); ?>" alt="Krishna Outdoor Logo" class="w-[130px] h-auto">
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 text-center">Administrator Panel</p>
                </div>
            </div>
            <div class="absolute top-3 right-0 lg:hidden md:hidden sm:block">
                <button onclick="toggleSidebar()"
                    class="h-[40px] w-[40px] bg-ascent rounded-l-lg border-r-0 flex items-center justify-center transition duration-300 ease-in-out hover:ease-in-out">
                    <i data-feather="chevron-left" class="h-4 w-4 stroke-white stroke-[3px]"></i>
                </button>
            </div>
            <hr class="border-white border-opacity-10">
            <ul class="flex flex-col space-y-1 px-2 pb-10">

                <li class="sidebar-tab" id="dashboard-tab">
                    <a href="<?php echo e(route('admin.view.dashboard')); ?>">
                        <i data-feather="grid"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                

                <li class="sidebar-tab" id="testimonial-tab">
                    <a href="<?php echo e(route('admin.view.testimonial.list')); ?>">
                        <i data-feather="message-square"></i>
                        <span>Testimonials</span>
                    </a>
                </li>
                
                <li class="sidebar-tab" id="campaign-tab">
                    <a href="<?php echo e(route('admin.view.campaign.list')); ?>">
                        <i data-feather="image"></i>
                        <span>Our Work</span>
                    </a>
                </li>

                <li class="sidebar-tab" id="enquiry-tab">
                    <a href="<?php echo e(route('admin.view.enquiry.list')); ?>">
                        <i data-feather="mail"></i>
                        <span>Enquiries</span>
                    </a>
                </li>

                <li class="sidebar-tab" id="admin-access-tab">
                    <a href="<?php echo e(route('admin.view.admin.access.list')); ?>">
                        <i data-feather="shield"></i>
                        <span>Admin Access</span>
                    </a>
                </li>

                <li class="sidebar-tab" id="category-tab">
                    <a href="<?php echo e(route('admin.view.category.list')); ?>">
                        <i data-feather="layers"></i>
                        <span>Categories</span>
                    </a>
                </li>

                <li class="sidebar-tab" id="career-tab">
                    <a href="<?php echo e(route('admin.view.career.list')); ?>">
                        <i data-feather="briefcase"></i>
                        <span>Career</span>
                    </a>
                </li>

                <li class="sidebar-tab" id="seo-tab">
                    <a href="<?php echo e(route('admin.view.seo.list')); ?>">
                        <i data-feather="search"></i>
                        <span>SEO</span>
                    </a>
                </li>

                <li class="sidebar-tab" id="setting-tab">
                    <a href="<?php echo e(route('admin.view.setting')); ?>">
                        <i data-feather="settings"></i>
                        <span>Settings</span>
                    </a>
                </li>

            </ul>
        </div>

        <div class="sidebar-footer">
            <a href="javascript:handleLogout();">
                <i data-feather="log-out"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
    <div class="sidebar-overlay" onclick="toggleSidebar()">

    </div>
</aside>
<?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/admin/common/sidebar.blade.php ENDPATH**/ ?>