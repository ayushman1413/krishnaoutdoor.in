<!DOCTYPE html>
<html lang="en">

<head>

    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    
    <link rel="icon" type="image/png" sizes="64x64" href="<?php echo e(asset('favicon.png')); ?>">

    
    <link rel="stylesheet" href="<?php echo e(asset('admin/css/app.css')); ?>">

    
    <title>Admin Panel </title>

</head>

<body>

    
    <main class="relative h-screen w-full flex items-center justify-center">

        <div style="background-image: url('<?php echo e(asset('web/images/front-carousel/img-3.jpeg')); ?>')"
            class="bg-cover bg-center bg-no-repeat absolute inset-0 h-full w-full"></div>
        <div class="absolute inset-0 h-full w-full bg-ascent-dark bg-opacity-40"></div>

        <div class="relative z-10 w-full flex flex-col items-center lg:py-16 sm:py-10 px-4 space-y-8">

            <div class="text-center space-y-1">
                <div class="w-fit h-fit mx-auto p-3 bg-white rounded-lg shadow-lg">
                    <img src="<?php echo e(asset('web/images/logo-header.png')); ?>" alt="Krishna Outdoor" class="w-[150px] h-auto">
                </div>
            </div>

            <div class="w-full lg:max-w-[420px] md:max-w-[420px] sm:max-w-full">
                <?php echo $__env->yieldContent('auth-section'); ?>
            </div>

            <p class="text-xs text-slate-300 text-center">&copy; <?php echo e(date('Y')); ?> Krishna Communication (Outdoor). All rights reserved.</p>

        </div>

    </main>
    

    
    <script src="<?php echo e(asset('admin/js/app.js')); ?>"></script>

    <?php if(session('message')): ?>
        <script defer>
            swal({
                icon: "<?php echo e(session('message')['status']); ?>",
                title: "<?php echo e(session('message')['title']); ?>",
                text: "<?php echo e(session('message')['description']); ?>",
            });
        </script>
    <?php endif; ?>

</body>

</html>
<?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/admin/layouts/auth.blade.php ENDPATH**/ ?>