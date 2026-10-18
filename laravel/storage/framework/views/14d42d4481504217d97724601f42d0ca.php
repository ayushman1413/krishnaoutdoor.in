<?php if($seo): ?>
    <title><?php echo e($seo->pageTitle); ?></title>
    <?php if($seo->description): ?>
        <meta name="description" content="<?php echo e($seo->description); ?>">
    <?php endif; ?>
    <?php if($seo->meta?->meta_keywords): ?>
        <meta name="keywords" content="<?php echo e($seo->meta->meta_keywords); ?>">
    <?php endif; ?>
    <meta name="robots" content="<?php echo e($seo->robotsContent()); ?>">
    <link rel="canonical" href="<?php echo e($seo->canonicalUrl); ?>">

    <meta property="og:type" content="<?php echo e($seo->ogType()); ?>">
    <meta property="og:title" content="<?php echo e($seo->ogTitle()); ?>">
    <?php if($seo->ogDescription()): ?>
        <meta property="og:description" content="<?php echo e($seo->ogDescription()); ?>">
    <?php endif; ?>
    <?php if($seo->ogImage()): ?>
        <meta property="og:image" content="<?php echo e(asset($seo->ogImage())); ?>">
    <?php endif; ?>
    <meta property="og:url" content="<?php echo e($seo->canonicalUrl); ?>">
    <meta property="og:site_name" content="<?php echo e($seo->settings?->site_name ?? 'Krishna Outdoor'); ?>">

    <meta name="twitter:card" content="<?php echo e($seo->twitterCard()); ?>">
    <meta name="twitter:title" content="<?php echo e($seo->twitterTitle()); ?>">
    <?php if($seo->twitterDescription()): ?>
        <meta name="twitter:description" content="<?php echo e($seo->twitterDescription()); ?>">
    <?php endif; ?>
    <?php if($seo->twitterImage()): ?>
        <meta name="twitter:image" content="<?php echo e(asset($seo->twitterImage())); ?>">
    <?php endif; ?>

    <?php if($seo->organizationSchemaJson()): ?>
        <script type="application/ld+json"><?php echo $seo->organizationSchemaJson(); ?></script>
    <?php endif; ?>

    <?php if($seo->websiteSchemaJson()): ?>
        <script type="application/ld+json"><?php echo $seo->websiteSchemaJson(); ?></script>
    <?php endif; ?>

    <?php if($seo->serviceSchemaJson()): ?>
        <script type="application/ld+json"><?php echo $seo->serviceSchemaJson(); ?></script>
    <?php endif; ?>

    <?php if($seo->schemaJson()): ?>
        <script type="application/ld+json"><?php echo $seo->schemaJson(); ?></script>
    <?php endif; ?>
<?php else: ?>
    <title><?php echo $__env->yieldContent('web-title', 'We Are Your One-Stop Shop for Outdoor Advertising!'); ?></title>
    <?php echo $__env->yieldContent('web-meta'); ?>
<?php endif; ?>
<?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/web/common/seo-head.blade.php ENDPATH**/ ?>