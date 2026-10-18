<?php $__env->startSection('auth-section'); ?>
    <figure class="auth-card">
        <form action="<?php echo e(route('admin.handle.login')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>

            <div class="space-y-1 text-center">
                <h1 class="font-semibold text-ascent-dark text-3xl">Admin Login</h1>
                <p class="text-xs text-gray-500">Welcome back! Please login to your account</p>
            </div>

            <div class="input-group">
                <label for="email" class="input-label">Email Address <em>*</em></label>
                <div class="relative">
                    <i data-feather="mail" class="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 stroke-slate-400"></i>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" id="email"
                        class="input-box-md pl-11 w-full <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter your email address" required
                        minlength="10" maxlength="100">
                </div>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="input-error"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="input-group">
                <label for="password" class="input-label">Password <em>*</em></label>
                <div class="relative">
                    <i data-feather="lock" class="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 stroke-slate-400"></i>
                    <input type="password" name="password" id="password" class="input-box-md pl-11 pr-11 w-full <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="Enter your password" required minlength="6" maxlength="20">
                    <button type="button" onclick="handleTogglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2">
                        <i data-feather="eye" id="password-toggle-icon" class="h-4 w-4 stroke-slate-400"></i>
                    </button>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="input-error"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" <?php if(old('remember')): echo 'checked'; endif; ?> name="remember" id="remember">
                    <label for="remember" class="text-xs">Remember me</label>
                </div>
                <a href="<?php echo e(route('admin.view.forgot.password')); ?>" class="link text-xs">Forgot Password?</a>
            </div>

            <div>
                <button type="submit" class="btn-primary-md w-full flex items-center justify-center uppercase tracking-wide">
                    <span>Submit</span>
                </button>
            </div>

        </form>
    </figure>
<?php $__env->stopSection(); ?>

<script>
    function handleTogglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('password-toggle-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.setAttribute('data-feather', 'eye-off');
        } else {
            input.type = 'password';
            icon.setAttribute('data-feather', 'eye');
        }
        feather.replace();
    }
</script>

<?php echo $__env->make('admin.layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ayushman/Downloads/krishna-outdoor/laravel/resources/views/admin/pages/auth/login.blade.php ENDPATH**/ ?>