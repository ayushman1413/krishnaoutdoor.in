@extends('admin.layouts.auth')

@section('auth-section')
    <figure class="auth-card">
        <form action="{{ route('admin.handle.reset.password',['token' => $token]) }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-1 text-center">
                <h1 class="font-semibold text-ascent-dark text-3xl">Reset Password</h1>
                <p class="text-xs text-gray-500">Enter new password and confirm it to reset</p>
            </div>

            <div hidden>
                <label for="email" class="input-label">Email Address <em>*</em></label>
                <input type="email" readonly name="email" value="{{ old('email', $email) }}"
                    class="input-box-md @error('email') input-invalid @enderror" placeholder="Enter Email Address" required
                    minlength="10" maxlength="100">
                @error('email')
                    <span class="input-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label for="password" class="input-label">Password <em>*</em></label>
                <input type="password" name="password" class="input-box-md w-full @error('password') input-invalid @enderror"
                    placeholder="Enter Password" required minlength="6" maxlength="20">
                @error('password')
                    <span class="input-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label for="password" class="input-label">Confirm Password <em>*</em></label>
                <input type="password" name="password_confirmation" class="input-box-md w-full @error('password_confirmation') input-invalid @enderror"
                    placeholder="Repeat Password" required minlength="6" maxlength="20">
                @error('password_confirmation')
                    <span class="input-error">{{ $message }}</span>
                @enderror
            </div>


            <div>
                <button type="submit" class="btn-primary-md w-full flex items-center justify-center">
                    <span>Reset Password</span>
                    <i data-feather="key" class="absolute left-5"></i>
                </button>
            </div>

            <div>
                <p class="text-xs">Already have an account ? <a href="{{route('admin.view.login')}}" class="link">Login now</a></p>
            </div>

        </form>
    </figure>
@endsection
