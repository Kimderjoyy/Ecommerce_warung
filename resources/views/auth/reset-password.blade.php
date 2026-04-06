@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
<div class="max-w-md w-full mx-auto" data-aos="fade-up">
    <div class="auth-card relative z-10">
        <div class="text-center mb-8 relative z-10">
            <div class="w-20 h-20 gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg transform hover:scale-110 transition">
                <i class="fas fa-lock text-white text-3xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Reset Password</h2>
            <p class="text-gray-500">Buat password baru Anda</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5 relative z-10">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label class="form-label">Email</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="email" name="email" value="{{ old('email', $request->email) }}" readonly
                           class="auth-input pl-12 bg-gray-50 @error('email') border-red-300 @enderror">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="form-label">Password Baru</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="password" name="password" required
                           class="auth-input pl-12 @error('password') border-red-300 @enderror"
                           placeholder="Minimal 8 karakter">
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="form-label">Konfirmasi Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="password" name="password_confirmation" required
                           class="auth-input pl-12"
                           placeholder="Ulangi password baru">
                </div>
            </div>

            <button type="submit" class="auth-btn">
                <i class="fas fa-save mr-2"></i>
                Reset Password
            </button>
        </form>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute -top-20 -right-20 w-64 h-64 gradient-primary rounded-full opacity-10 blur-3xl"></div>
    <div class="absolute -bottom-20 -left-20 w-64 h-64 gradient-primary rounded-full opacity-10 blur-3xl"></div>
</div>
@endsection