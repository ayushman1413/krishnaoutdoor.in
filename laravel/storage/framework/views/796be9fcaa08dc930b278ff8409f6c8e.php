<?php $__env->startSection('panel-header'); ?>
    <div>
        <ul class="breadcrumb">
            <li><a href="<?php echo e(route('admin.view.dashboard')); ?>">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="<?php echo e(route('admin.view.seo.list')); ?>">SEO</a></li>
        </ul>
        <h1 class="panel-title">SEO</h1>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('panel-body'); ?>
    <figure class="panel-card">
        <div class="panel-card-header">
            <div>
                <h1 class="panel-card-title">SEO Meta</h1>
                <p class="panel-card-description">Manage meta data for pages, categories and locations</p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="<?php echo e(route('admin.view.seo.list', ['group' => 'pages'])); ?>"
                    class="<?php echo e($group === 'pages' ? 'btn-primary-sm' : 'btn-secondary-md'); ?>">Pages</a>
                <a href="<?php echo e(route('admin.view.seo.list', ['group' => 'categories'])); ?>"
                    class="<?php echo e($group === 'categories' ? 'btn-primary-sm' : 'btn-secondary-md'); ?>">Categories</a>
                <a href="<?php echo e(route('admin.view.seo.list', ['group' => 'locations'])); ?>"
                    class="<?php echo e($group === 'locations' ? 'btn-primary-sm' : 'btn-secondary-md'); ?>">Locations</a>
                <a href="<?php echo e(route('admin.handle.seo.export')); ?>" class="btn-secondary-md">Export CSV</a>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Enums\Permission::EDIT_SEO->value)): ?>
                    <form action="<?php echo e(route('admin.handle.seo.import')); ?>" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                        <?php echo csrf_field(); ?>
                        <input type="file" name="csv_file" accept=".csv,.txt" class="input-box-md" required>
                        <button type="submit" class="btn-secondary-md">Import CSV</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <?php $__errorArgs = ['csv_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="input-error px-5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div class="panel-card-body">
            <div class="panel-card-table">
                <table class="data-table">
                    <thead>
                        <th>Sr. No.</th>
                        <th><?php echo e($group === 'pages' ? 'Page' : 'Item Name'); ?></th>
                        <th>Meta Title</th>
                        <th>Meta Description</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $metas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $meta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($key + 1); ?></td>
                                <td>
                                    <?php if($group === 'pages'): ?>
                                        <?php echo e(\Illuminate\Support\Str::headline(str_replace(['view.', '.'], ['', ' '], $meta->route_name))); ?>

                                    <?php elseif($group === 'locations'): ?>
                                        <?php echo e(\Illuminate\Support\Str::headline(str_replace('view.locations.city.', '', $meta->route_name))); ?>

                                    <?php else: ?>
                                        <?php echo e($meta->seoable->name ?? '-'); ?>

                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($meta->meta_title ?? '-'); ?></td>
                                <td style="white-space: normal; max-width: 280px;">
                                    <?php echo e($meta->meta_description ? \Illuminate\Support\Str::limit($meta->meta_description, 80) : '-'); ?>

                                </td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(\App\Enums\Permission::EDIT_SEO->value)): ?>
                                        <a href="<?php echo e(route('admin.view.seo.update', ['id' => $meta->id])); ?>"
                                            class="btn-primary-sm flex w-fit">
                                            <i data-feather="edit" class="mr-1"></i> Edit
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center">No records found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </figure>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('panel-script'); ?>
    <script>
        document.getElementById('seo-tab').classList.add('active');
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/admin/pages/seo/seo-list.blade.php ENDPATH**/ ?>