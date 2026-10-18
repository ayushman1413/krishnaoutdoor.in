<?php $__env->startSection('web-title', $city.' Locations | Krishna Outdoor'); ?>
<?php $__env->startSection('body-class', 'inner-page'); ?>
<?php $__env->startSection('nav', 'network'); ?>

<?php $__env->startSection('web-meta'); ?>
<meta name="description" content="Explore our available outdoor advertising media - billboards, bus branding, train media and more - across <?php echo e($city); ?>.">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('web-section'); ?>
<main>
<section class="hero media-detail-hero dyn-hero" id="home">
<div class="media-detail-hero-bg"><img alt="<?php echo e($city); ?>" decoding="async" loading="eager" src="<?php echo e(asset('assets/images/shared-night-city-background.png')); ?>"/></div>
<div class="hero-overlay"></div><div class="hero-grid"></div><div class="hero-noise"></div>
<div class="container hero-inner reveal"><h1><?php echo e(strtoupper($city)); ?><br/><em>LOCATIONS.</em></h1></div>
</section>
<section class="dyn-section"><div class="container">
<div class="dyn-crumbs"><a href="<?php echo e(route('view.home')); ?>">Home</a><span>/</span><b><?php echo e($city); ?></b></div>
<p class="dyn-intro">Explore our available outdoor advertising media &mdash; billboards, bus branding, train media and more &mdash; across <?php echo e($city); ?>.</p>
<div class="dyn-table-wrap">
<table class="dyn-table">
<thead><tr><th>Image</th><th>Location</th><th>Area</th><th>Media Type</th><th>Availability</th></tr></thead>
<tbody>
<?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
<td><?php if($location->image): ?><img src="<?php echo e(asset('storage/'.$location->image)); ?>" alt="<?php echo e($location->image_alt ?: $location->name); ?>" loading="lazy"><?php else: ?><span class="dyn-noimg">No image</span><?php endif; ?></td>
<td class="name"><?php echo e($location->name); ?></td>
<td><?php echo e($location->area ?? '-'); ?></td>
<td><?php echo e($media_type::tryFrom($location->media_type)?->label() ?? $location->media_type); ?></td>
<td><?php if($location->is_available): ?><span class="dyn-badge ok">Available</span><?php else: ?><span class="dyn-badge no">Booked</span><?php endif; ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>
</div>
<div class="dyn-cta"><p>Interested in one of these locations?</p><a class="dyn-btn" href="<?php echo e(route('view.contact')); ?>">Enquire Now <span>→</span></a></div>
</div></section>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/web/pages/locations.blade.php ENDPATH**/ ?>