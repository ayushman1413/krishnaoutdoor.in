<?php if($testimonials->count() > 0): ?>
<section class="section testimonials" id="testimonials" style="background-color: #f9fafb; padding: 4rem 0;">
    <div class="container">
        <div class="kr-head kr-reveal" style="text-align: center; margin-bottom: 3rem;">
            <div class="kr-kicker" style="font-size: 12px; font-weight: 600; letter-spacing: 2px; color: #6b7280; text-transform: uppercase;">CLIENT VOICES</div>
            <h2 style="font-size: 2.5rem; font-weight: 700; margin-top: 0.5rem;">What Our <em>Clients Say</em></h2>
        </div>
        <div class="testimonials-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="testimonial-card" style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); position: relative;">
                <p style="color: #4b5563; font-size: 1rem; line-height: 1.6; margin-bottom: 1.5rem; font-style: italic;">"<?php echo nl2br(e($testimonial->feedback)); ?>"</p>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <?php if($testimonial->company_logo): ?>
                        <img src="<?php echo e(asset('storage/' . $testimonial->company_logo)); ?>" alt="<?php echo e($testimonial->company_logo_alt ?: $testimonial->company_name); ?>" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                    <?php else: ?>
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: #e5e7eb; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #9ca3af;">
                            <?php echo e(substr($testimonial->client_name, 0, 1)); ?>

                        </div>
                    <?php endif; ?>
                    <div>
                        <h4 style="margin: 0; font-size: 1.1rem; font-weight: 600; color: #111827;"><?php echo e($testimonial->client_name); ?></h4>
                        <?php if($testimonial->company_name): ?>
                            <span style="font-size: 0.875rem; color: #6b7280;"><?php echo e($testimonial->company_name); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/web/common/testimonials.blade.php ENDPATH**/ ?>