<!DOCTYPE html>
<html lang="en">

<head>

    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    
    <link rel="icon" type="image/png" sizes="64x64" href="<?php echo e(asset('favicon.png')); ?>">

    
    <link rel="stylesheet" href="<?php echo e(asset('admin/css/app.css?v=8')); ?>">

    
    <title>Admin Panel </title>

    <?php echo $__env->yieldContent('panel-head'); ?>

</head>

<body>

    <?php if(auth()->user()->status): ?>

        
        <main>

            
            <?php echo $__env->make('admin.common.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            
            <section id="panel-section">
                <div class="panel-container">
                    <header class="panel-header">
                        <div class="lg:px-0 md:px-0 sm:px-2">
                            <?php echo $__env->yieldContent('panel-header'); ?>
                        </div>
                        <div>
                            <?php echo $__env->make('admin.common.header-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </header>
                    <section class="panel-body">
                        <?php echo $__env->yieldContent('panel-body'); ?>
                    </section>
                </div>
            </section>
            

        </main>
        

        
        <form action="<?php echo e(route('admin.handle.logout')); ?>" id="logout-form" method="POST"><?php echo csrf_field(); ?></form>

        
        <script src="<?php echo e(asset('admin/js/app.js?v=9')); ?>"></script>

        <?php echo $__env->yieldContent('panel-script'); ?>
        
        <?php if(session('message')): ?>
        <script defer>
            swal({
                icon: "<?php echo e(session('message')['status']); ?>",
                title: "<?php echo e(session('message')['title']); ?>",
                text: "<?php echo e(session('message')['description']); ?>",
            });
        </script>
        <?php endif; ?>
    
    <?php else: ?>
    <main class="h-screen w-full flex items-center justify-center">
        <h1 class="text-2xl font-semibold text-admin-ascent">Your Access is Blocked</h1>
    </main>
    <?php endif; ?>

</body>

</html><?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/admin/layouts/app.blade.php ENDPATH**/ ?>