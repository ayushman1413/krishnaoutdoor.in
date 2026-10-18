<?php
    $nav = trim($__env->yieldContent('nav'));
    $navCategories = \App\Models\Category::where('category_id', null)->get();
?>

<div class="page-progress" id="pageProgress"></div>

<header class="header" id="header">
    <div class="container nav-wrap">

        <!-- Mobile Menu Button -->
        <button
            aria-expanded="false"
            aria-label="Toggle menu"
            class="nav-toggle"
            id="navToggle"
            type="button"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Logo -->
        <a class="site-logo" href="<?php echo e(route('view.home')); ?>">
            <img
                src="<?php echo e(asset('assets/images/header-logo.webp')); ?>"
                alt="Krishna Outdoor"
            />
        </a>

        <!-- Navigation -->
        <nav class="nav" id="nav">

            <!-- Home -->
            <a
                <?php if($nav === 'home'): ?> aria-current="page" class="active" <?php endif; ?>
                href="<?php echo e(route('view.home')); ?>"
            >
                Home
            </a>

            <!-- About -->
            <a
                <?php if($nav === 'about'): ?> aria-current="page" class="active" <?php endif; ?>
                href="<?php echo e(route('view.about')); ?>"
            >
                About Us
            </a>

            <!-- Media Solutions -->
            <div class="nav-dropdown">

                <a
                    <?php if($nav === 'services'): ?> aria-current="page" class="active" <?php endif; ?>
                    href="<?php echo e(route('view.services')); ?>"
                >
                    Media Solutions
                </a>

                <button
                    class="nav-arrow"
                    type="button"
                    aria-label="Open Media Solutions menu"
                    aria-expanded="false"
                ></button>

                <div class="nav-menu">

                    <?php $__empty_1 = true; $__currentLoopData = $navCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <a href="<?php echo e(route('view.parent.category', ['slug' => $item->slug])); ?>">
                            <?php echo e($item->name); ?>

                        </a>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <a href="<?php echo e(route('view.ooh.media')); ?>">
                            OOH Media
                        </a>

                        <a href="<?php echo e(route('view.transit.media')); ?>">
                            Transit Media
                        </a>

                        <a href="<?php echo e(route('view.digital.media')); ?>">
                            Digital Media
                        </a>

                    <?php endif; ?>

                </div>
            </div>

            <!-- Our Network -->
            <a
                <?php if($nav === 'network'): ?> aria-current="page" class="active" <?php endif; ?>
                href="<?php echo e(route('view.network')); ?>"
            >
                Our Network
            </a>

            <!-- Our Work -->
            <a
                <?php if($nav === 'projects'): ?> aria-current="page" class="active" <?php endif; ?>
                href="<?php echo e(route('view.projects')); ?>"
            >
                Our Work
            </a>

            <!-- Contact Us -->
            <a
                <?php if($nav === 'contact'): ?> aria-current="page" class="active" <?php endif; ?>
                href="<?php echo e(route('view.contact')); ?>"
            >
                Contact Us
            </a>


            <!-- Mobile Enquire Now -->
            <div class="nav-cta-drawer-box">
                <button
                    type="button"
                    class="nav-cta-drawer enquiry-popup-trigger"
                >
                    Enquire Now
                    <span>→</span>
                </button>
            </div>

        </nav>

        <!-- Desktop Enquire Now -->
        <button
            type="button"
            class="nav-cta enquiry-popup-trigger"
        >
            Enquire Now
            <span>→</span>
        </button>

    </div>
</header>

<?php echo $__env->make('web.common.enquiry-popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/web/common/header.blade.php ENDPATH**/ ?>