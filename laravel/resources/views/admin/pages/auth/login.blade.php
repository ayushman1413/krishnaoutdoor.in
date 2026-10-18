@extends('admin.layouts.auth')

@section('auth-section')
    <figure class="auth-card">
        <form action="{{ route('admin.handle.login') }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-1 text-center">
                <h1 class="font-semibold text-ascent-dark text-3xl">Admin Login</h1>
                <p class="text-xs text-gray-500">Welcome back! Please login to your account</p>
            </div>

            <div class="input-group">
                <label for="email" class="input-label">Email Address <em>*</em></label>
                <div class="relative">
                    <i data-feather="mail" class="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 stroke-slate-400"></i>
                    <input type="email" name="email" value="{{ old('email') }}" id="email"
                        class="input-box-md pl-11 w-full @error('email') input-invalid @enderror" placeholder="Enter your email address" required
                        minlength="10" maxlength="100">
                </div>
                @error('email')
                    <span class="input-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label for="password" class="input-label">Password <em>*</em></label>
                <div class="relative">
                    <i data-feather="lock" class="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 stroke-slate-400"></i>
                    <input type="password" name="password" id="password" class="input-box-md pl-11 pr-11 w-full @error('password') input-invalid @enderror"
                        placeholder="Enter your password" required minlength="6" maxlength="20">
                    <button type="button" onclick="handleTogglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2">
                        <i data-feather="eye" id="password-toggle-icon" class="h-4 w-4 stroke-slate-400"></i>
                    </button>
                </div>
                @error('password')
                    <span class="input-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Remember me --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" @checked(old('remember')) name="remember" id="remember">
                    <label for="remember" class="text-xs">Remember me</label>
                </div>
                <a href="{{route('admin.view.forgot.password')}}" class="link text-xs">Forgot Password?</a>
            </div>

            <div>
                <button type="submit" class="btn-primary-md w-full flex items-center justify-center uppercase tracking-wide">
                    <span>Submit</span>
                </button>
            </div>

        </form>
    </figure>
@endsection

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
