<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0" /><meta content="#0c0e11" name="theme-color"/>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php echo $__env->make('web.common.seo-head', ['seo' => $seo ?? null], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $seoSettings = $seo?->settings ?? \App\Models\SeoSetting::query()->first(); ?>
<?php if($seoSettings?->gsc_verification_code): ?>
<meta name="google-site-verification" content="<?php echo e($seoSettings->gsc_verification_code); ?>">
<?php endif; ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H76CYYJE3S"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'G-H76CYYJE3S');
<?php if($seoSettings?->ga4_id): ?>
gtag('config', <?php echo json_encode($seoSettings->ga4_id, 15, 512) ?>);
<?php endif; ?>
function trackConversion(action, label) {
    if (window.gtag) {
        gtag('event', action, { event_category: 'engagement', event_label: label });
    }
}
</script>
<?php if($seoSettings?->gtm_id): ?>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer',<?php echo json_encode($seoSettings->gtm_id, 15, 512) ?>);</script>
<?php endif; ?>
<?php if($seoSettings?->fb_pixel_code): ?>
<?php echo $seoSettings->fb_pixel_code; ?>

<?php endif; ?>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Oswald:wght@500;600;700&display=swap" rel="stylesheet"/>

<link rel="stylesheet" href="<?php echo e(url('/css/style.css')); ?>">
<link rel="stylesheet" href="<?php echo e(url('/css/home-style-sync.css')); ?>">
<link rel="stylesheet" href="<?php echo e(url('/css/kr-laravel.css')); ?>">

<link rel="icon" type="image/png" sizes="64x64" href="<?php echo e(url('/favicon.png')); ?>">
<link rel="shortcut icon" href="<?php echo e(url('/favicon.ico')); ?>">
<link rel="apple-touch-icon" href="<?php echo e(url('/favicon.png')); ?>">

<?php echo $__env->yieldContent('web-head'); ?>
<?php if($seoSettings?->head_custom_code): ?>
<?php echo $seoSettings->head_custom_code; ?>

<?php endif; ?>
<body <?php if(trim($__env->yieldContent('body-class'))): ?> class="<?php echo $__env->yieldContent('body-class'); ?>" <?php endif; ?>>
<?php echo $__env->make('web.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('web-section'); ?>
<?php echo $__env->make('web.common.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('web.common.chatbot', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
window.KR_ROUTES = {
  home: <?php echo json_encode(route('view.home'), 15, 512) ?>, about: <?php echo json_encode(route('view.about'), 15, 512) ?>, services: <?php echo json_encode(route('view.services'), 15, 512) ?>,
  ooh: <?php echo json_encode(route('view.ooh.media'), 15, 512) ?>, transit: <?php echo json_encode(route('view.transit.media'), 15, 512) ?>, digital: <?php echo json_encode(route('view.digital.media'), 15, 512) ?>,
  network: <?php echo json_encode(route('view.network'), 15, 512) ?>, location: <?php echo json_encode(route('view.network').'#presence', 15, 512) ?>,
  campaign: <?php echo json_encode(route('view.projects').'#campaigns', 15, 512) ?>, work: <?php echo json_encode(route('view.projects'), 15, 512) ?>,
  careers: <?php echo json_encode(route('view.careers'), 15, 512) ?>, enquire: <?php echo json_encode(route('view.contact'), 15, 512) ?>
};
</script>
<script defer="defer" src="<?php echo e(asset('js/main.js')); ?>?v=<?php echo e(@filemtime(public_path('js/main.js'))); ?>"></script>
<script defer="defer" src="<?php echo e(asset('js/kr-laravel.js')); ?>?v=<?php echo e(@filemtime(public_path('js/kr-laravel.js'))); ?>"></script>
<?php echo $__env->yieldContent('web-script'); ?>
<?php if(session('message')): ?>
<script>
window.addEventListener('DOMContentLoaded', function () {
  window.krToast(<?php echo json_encode(session('message')['status'] ?? 'success', 15, 512) ?>, <?php echo json_encode(session('message')['title'] ?? '', 15, 512) ?>, <?php echo json_encode(session('message')['description'] ?? '', 15, 512) ?>);
});
</script>
<?php endif; ?>
<?php if(session('track_event')): ?>
<script>
window.addEventListener('DOMContentLoaded', function () {
  trackConversion(<?php echo json_encode(session('track_event'), 15, 512) ?>, window.location.pathname);
});
</script>
<?php endif; ?>
<?php if($seoSettings?->body_custom_code): ?>
<?php echo $seoSettings->body_custom_code; ?>

<?php endif; ?>
</body>
</html>
<?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/web/layouts/app.blade.php ENDPATH**/ ?>