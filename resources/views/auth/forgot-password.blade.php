@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
<div class="max-w-md w-full mx-auto" data-aos="fade-up">
    <div class="auth-card relative z-10">
        <div class="text-center mb-8 relative z-10">
            <div class="w-20 h-20 gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg transform hover:scale-110 transition">
                <i class="fas fa-key text-white text-3xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Lupa Password?</h2>
            <p class="text-gray-500">Masukkan email untuk reset password</p>
        </div>

        @if (session('status'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5 relative z-10">
            @csrf

            <div>
                <label class="form-label">Email</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="auth-input pl-12 @error('email') border-red-300 @enderror"
                           placeholder="Masukkan email Anda">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="auth-btn">
                <i class="fas fa-paper-plane mr-2"></i>
                Kirim Link Reset
            </button>

            <div class="text-center pt-4">
                <a href="{{ route('login') }}" class="text-gray-500 hover:text-green-600 font-medium">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Kembali ke Login
                </a>
            </div>
        </form>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute -top-20 -right-20 w-64 h-64 gradient-primary rounded-full opacity-10 blur-3xl"></div>
    <div class="absolute -bottom-20 -left-20 w-64 h-64 gradient-primary rounded-full opacity-10 blur-3xl"></div>
</div>
@endsection