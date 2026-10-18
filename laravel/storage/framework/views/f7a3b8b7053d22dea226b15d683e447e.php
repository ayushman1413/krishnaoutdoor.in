<?php $__env->startSection('panel-header'); ?>
    <div>
        <ul class="breadcrumb">
            <li><a href="<?php echo e(route('admin.view.dashboard')); ?>">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="<?php echo e(route('admin.view.dashboard')); ?>">Dashboard</a></li>
        </ul>
        <h1 class="panel-title">Dashboard</h1>
        <p class="text-sm text-slate-500 mt-1">Welcome back! Here's what's happening with your website.</p>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('panel-body'); ?>
<div class="flex flex-col lg:space-y-8 md:space-y-7 sm:space-y-6">

    
    <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-7">

        

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Enums\Permission::VIEW_TESTIMONIAL->value)): ?>
        <figure class="panel-card">
            <div class="panel-card-body space-y-5">
                <div class="flex items-center space-x-4">
                    <div class="h-[55px] w-[55px] bg-blue-50 rounded-full flex items-center justify-center shrink-0">
                        <i data-feather="message-square" class="h-5 w-5 stroke-blue-600 stroke-[2px]"></i>
                    </div>
                    <div>
                        <p class="text-[0.65rem] font-semibold text-slate-400 uppercase tracking-wide">Testimonials</p>
                        <h1 class="font-semibold text-ascent-dark text-3xl mt-1"><?php echo e($total_testimonials); ?></h1>
                        <p class="text-xs text-slate-500">Total Testimonials</p>
                    </div>
                </div>
                <a href="<?php echo e(route('admin.view.testimonial.list')); ?>" class="flex items-center text-xs font-semibold text-blue-600">
                    <span>View all</span>
                    <i data-feather="chevron-right" class="h-3.5 w-3.5 ml-1 stroke-[3px]"></i>
                </a>
            </div>
        </figure>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Enums\Permission::VIEW_ENQUIRY->value)): ?>
        <figure class="panel-card">
            <div class="panel-card-body space-y-5">
                <div class="flex items-center space-x-4">
                    <div class="h-[55px] w-[55px] bg-green-50 rounded-full flex items-center justify-center shrink-0">
                        <i data-feather="mail" class="h-5 w-5 stroke-green-600 stroke-[2px]"></i>
                    </div>
                    <div>
                        <p class="text-[0.65rem] font-semibold text-slate-400 uppercase tracking-wide">Enquiries</p>
                        <h1 class="font-semibold text-ascent-dark text-3xl mt-1"><?php echo e($total_enquiries); ?></h1>
                        <p class="text-xs text-slate-500">Total Enquiries</p>
                    </div>
                </div>
                <a href="<?php echo e(route('admin.view.enquiry.list')); ?>" class="flex items-center text-xs font-semibold text-green-600">
                    <span>View all</span>
                    <i data-feather="chevron-right" class="h-3.5 w-3.5 ml-1 stroke-[3px]"></i>
                </a>
            </div>
        </figure>
        <?php endif; ?>

    </div>

    
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Quick Actions</h1>
            </div>
        </div>
        <div class="panel-card-body">
            <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-5">

                

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Enums\Permission::VIEW_TESTIMONIAL->value)): ?>
                <a href="<?php echo e(route('admin.view.testimonial.list')); ?>" class="flex items-center space-x-4 p-4 border rounded-lg hover:shadow-lg transition duration-200 ease-in-out">
                    <div class="h-[45px] w-[45px] bg-blue-600 rounded-lg flex items-center justify-center shrink-0">
                        <i data-feather="message-square" class="h-4 w-4 stroke-white stroke-[2.2px]"></i>
                    </div>
                    <div class="flex-1">
                        <h1 class="font-semibold text-sm text-black">Manage Testimonials</h1>
                        <p class="text-xs text-slate-500 mt-0.5">Add, edit or manage testimonials</p>
                    </div>
                    <i data-feather="chevron-right" class="h-4 w-4 stroke-slate-400"></i>
                </a>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Enums\Permission::VIEW_ENQUIRY->value)): ?>
                <a href="<?php echo e(route('admin.view.enquiry.list')); ?>" class="flex items-center space-x-4 p-4 border rounded-lg hover:shadow-lg transition duration-200 ease-in-out">
                    <div class="h-[45px] w-[45px] bg-green-600 rounded-lg flex items-center justify-center shrink-0">
                        <i data-feather="mail" class="h-4 w-4 stroke-white stroke-[2.2px]"></i>
                    </div>
                    <div class="flex-1">
                        <h1 class="font-semibold text-sm text-black">View Enquiries</h1>
                        <p class="text-xs text-slate-500 mt-0.5">View and manage enquiries</p>
                    </div>
                    <i data-feather="chevron-right" class="h-4 w-4 stroke-slate-400"></i>
                </a>
                <?php endif; ?>

            </div>
        </div>
    </figure>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Enums\Permission::VIEW_ENQUIRY->value)): ?>
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">Recent Enquiries</h1>
                <p class="panel-card-description">Latest leads submitted from the website</p>
            </div>
            <div>
                <a href="<?php echo e(route('admin.view.enquiry.list')); ?>" class="link text-xs font-semibold">View All Enquiries</a>
            </div>
        </div>
        <div class="panel-card-body">
            <div class="panel-card-table">
                <table class="data-table <?php echo e($recent_enquiries->isEmpty() ? 'ignore' : ''); ?>">
                    <thead>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Company</th>
                        <th>Requirement</th>
                        <th>Date</th>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recent_enquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($enquiry->name); ?></td>
                                <td><?php echo e($enquiry->phone); ?></td>
                                <td><?php echo e($enquiry->company ?? '-'); ?></td>
                                <td><?php echo e(\App\Enums\Requirement::tryFrom($enquiry->requirement)?->label() ?? ($enquiry->requirement ?? '-')); ?></td>
                                <td><?php echo e($enquiry->created_at->format('d M Y')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr class="ignore">
                                <td colspan="5" class="text-center">No enquiries yet</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </figure>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('panel-script'); ?>
<script>
    document.getElementById('dashboard-tab').classList.add('active');
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/admin/pages/dashboard/dashboard.blade.php ENDPATH**/ ?>