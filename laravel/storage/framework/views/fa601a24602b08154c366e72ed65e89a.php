

<?php $__env->startSection('web-title', 'Thank You | Krishna Outdoor'); ?>
<?php $__env->startSection('body-class', ''); ?>
<?php $__env->startSection('nav', ''); ?>

<?php $__env->startSection('web-meta'); ?>
<meta name="robots" content="noindex,follow"><meta name="description" content="Thank you for contacting Krishna Outdoor. Our team has received your enquiry and will get back to you shortly.">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('web-head'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/thank-you.css')); ?>?v=<?php echo e(@filemtime(public_path('css/thank-you.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('web-section'); ?>


<main>
  <section class="ty-hero">
    <div class="ty-glow ty-glow-one"></div><div class="ty-glow ty-glow-two"></div>
    <div class="container ty-main">
      <div class="ty-copy">
        <div class="ty-check"><span>✓</span></div>
        <div class="kr-kicker">MESSAGE RECEIVED</div>
        <h1>THANK <em>YOU!</em></h1>
        <h2>Your message has been submitted successfully.</h2>
        <p>We’ve received your enquiry and our team will get back to you as soon as possible, usually within one business day.</p>
        <a class="ty-home-btn" href="<?php echo e(route('view.home')); ?>"><span>⌂</span> Back to Home <b>→</b></a>
      </div>
      <div class="ty-visual">
        <img src="<?php echo e(asset('assets/images/thankyou-envelope.png')); ?>" alt="Message sent successfully" loading="eager">
      </div>
    </div>

    <div class="container ty-info-card">
      <div class="ty-info-item"><span class="ty-icon">☎</span><div><b>Need Immediate Help?</b><p>Call us: +91 98796 16411</p></div></div>
      <div class="ty-divider"></div>
      <div class="ty-info-item"><span class="ty-icon">✉</span><div><b>Email Us</b><p>info@krishnaoutdoor.in</p></div></div>
      <div class="ty-divider"></div>
      <div class="ty-info-item"><span class="ty-icon">⌖</span><div><b>Our Office</b><p>301, 3rd Floor, Shilp Aaron, Opp. Arvind, Sindhu Bhavan Road, Bodakdev, Ahmedabad – 380054.</p></div></div>
      <div class="ty-divider"></div>
      <div class="ty-info-item"><span class="ty-icon">◷</span><div><b>Business Hours</b><p>Mon – Sat<br>10:00 AM – 6:00 PM</p></div></div>
    </div>
  </section>
</main>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/web/layouts/Thank you.blade.php ENDPATH**/ ?>