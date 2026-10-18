<?php $__env->startSection('web-title', $category->name.' | Krishna Outdoor'); ?>
<?php $__env->startSection('body-class', 'inner-page'); ?>
<?php $__env->startSection('nav', 'services'); ?>

<?php $__env->startSection('web-meta'); ?>
<meta name="description" content="<?php echo e($category->summary); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('web-section'); ?>
<main>
<section class="hero media-detail-hero dyn-hero" id="home">
<div class="media-detail-hero-bg"><img alt="<?php echo e($category->name); ?>" decoding="async" loading="eager" src="<?php echo e($category->cover_image ? asset('storage/'.$category->cover_image) : asset('assets/images/shared-night-city-background.png')); ?>"/></div>
<div class="hero-overlay"></div><div class="hero-grid"></div><div class="hero-noise"></div>
<div class="container hero-inner reveal"><h1><?php echo e($category->name); ?></h1></div>
</section>
<section class="dyn-section"><div class="container">
<div class="dyn-crumbs"><a href="<?php echo e(route('view.home')); ?>">Home</a><span>/</span><b><?php echo e($category->name); ?></b></div>
<?php if($category->summary): ?><p class="dyn-intro"><?php echo e($category->summary); ?></p><?php endif; ?>
<div class="dyn-grid two">
<?php $__currentLoopData = $category->child_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<article class="dyn-card">
<div class="dyn-card-media">
<?php if(pathinfo((string) $child_category->cover_image, PATHINFO_EXTENSION) == 'mp4'): ?>
<video src="<?php echo e(asset('storage/'.$child_category->cover_image)); ?>" autoplay muted loop playsinline></video>
<?php else: ?>
<img src="<?php echo e(asset('storage/'.$child_category->cover_image)); ?>" alt="<?php echo e($child_category->name); ?> Cover Image" loading="lazy">
<?php endif; ?>
</div>
<div class="dyn-card-body">
<h3><a href="<?php echo e(route('view.child.category', ['slug' => $child_category->slug])); ?>"><?php echo e($child_category->name); ?></a></h3>
<p><?php echo e($child_category->summary); ?></p>
<a class="dyn-btn" href="<?php echo e(route('view.child.category', ['slug' => $child_category->slug])); ?>">View Projects <span>→</span></a>
</div>
</article>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
</div></section>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/web/pages/parent-category.blade.php ENDPATH**/ ?>