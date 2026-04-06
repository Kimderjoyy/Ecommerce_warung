@extends('layouts.guest')

@section('title', 'Login')

@push('styles')
<style>
    /*==============================================
    =            AUTH CARD (DARK THEME)            =
    ==============================================*/
    .auth-card {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 32px;
        padding: 40px 32px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        position: relative;
        overflow: hidden;
    }

    .auth-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 20s infinite;
    }

    .auth-card::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 15s infinite reverse;
    }

    @keyframes float {
        0% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(30px, -30px) rotate(120deg); }
        66% { transform: translate(-30px, 30px) rotate(240deg); }
        100% { transform: translate(0, 0) rotate(360deg); }
    }

    /*==============================================
    =            LOGO SECTION                       =
    ==============================================*/
    .logo-box {
        width: 100px;
        height: 100px;
        margin: 0 auto 20px;
        border-radius: 24px;
        overflow: hidden;
        border: 2px solid rgba(16, 185, 129, 0.3);
        box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.3);
        transition: all 0.3s ease;
    }

    .logo-box:hover {
        transform: scale(1.05);
        border-color: #10b981;
        box-shadow: 0 20px 30px -10px rgba(16, 185, 129, 0.5);
    }

    .logo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .fallback-logo {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #10b981, #047857);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 36px;
        font-weight: bold;
    }

    .auth-title {
        font-size: 28px;
        font-weight: 700;
        color: white;
        margin-bottom: 8px;
    }

    .auth-subtitle {
        color: rgba(255, 255, 255, 0.6);
        font-size: 15px;
        margin-bottom: 8px;
    }

    .auth-badge {
        color: #10b981;
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    /*==============================================
    =            FORM STYLES                        =
    ==============================================*/
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 8px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #10b981;
        font-size: 16px;
        transition: color 0.3s ease;
        z-index: 1;
    }

    .input-wrapper:focus-within .input-icon {
        color: #10b981;
    }

    .auth-input {
        width: 100%;
        padding: 14px 16px 14px 48px;
        background: rgba(55, 65, 81, 0.5);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 16px;
        color: white;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .auth-input:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        background: rgba(55, 65, 81, 0.8);
    }

    .auth-input::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }

    .auth-input.error {
        border-color: #ef4444;
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /*==============================================
    =            CHECKBOX                           =
    ==============================================*/
    .checkbox-wrapper {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .checkbox-custom {
        width: 18px;
        height: 18px;
        background: rgba(55, 65, 81, 0.5);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 6px;
        margin-right: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    input[type="checkbox"] {
        display: none;
    }

    input[type="checkbox"]:checked + .checkbox-custom {
        background: #10b981;
        border-color: #10b981;
    }

    input[type="checkbox"]:checked + .checkbox-custom::after {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        font-size: 10px;
        color: white;
    }

    .checkbox-label {
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
    }

    /*==============================================
    =            LINKS                              =
    ==============================================*/
    .forgot-link {
        color: #10b981;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .forgot-link:hover {
        color: white;
    }

    /*==============================================
    =            BUTTON                             =
    ==============================================*/
    .auth-btn {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #10b981, #047857);
        border: none;
        border-radius: 999px;
        color: white;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 24px;
        box-shadow: 0 10px 25px -10px rgba(16, 185, 129, 0.5);
    }

    .auth-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 30px -10px rgba(16, 185, 129, 0.7);
    }

    /*==============================================
    =            REGISTER LINK                      =
    ==============================================*/
    .register-section {
        text-align: center;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .register-text {
        color: rgba(255, 255, 255, 0.5);
        font-size: 14px;
    }

    .register-link {
        color: #10b981;
        font-weight: 600;
        text-decoration: none;
        margin-left: 4px;
        transition: color 0.3s ease;
    }

    .register-link:hover {
        color: white;
    }

    /*==============================================
    =            FEATURE CARDS                      =
    ==============================================*/
    .feature-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 32px;
    }

    .feature-card {
        background: rgba(55, 65, 81, 0.3);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 16px;
        padding: 16px 8px;
        text-align: center;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }

    .feature-card:hover {
        border-color: #10b981;
        transform: translateY(-5px);
        background: rgba(16, 185, 129, 0.1);
    }

    .feature-icon {
        color: #10b981;
        font-size: 24px;
        margin-bottom: 8px;
    }

    .feature-card p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 11px;
        font-weight: 500;
        line-height: 1.4;
    }

    /*==============================================
    =            DECORATIVE ELEMENTS                =
    ==============================================*/
    .decor-circle {
        position: absolute;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        filter: blur(40px);
        z-index: 0;
        pointer-events: none;
    }

    .decor-circle-1 {
        top: -20px;
        right: -20px;
    }

    .decor-circle-2 {
        bottom: -20px;
        left: -20px;
    }

    /* Container */
    .auth-wrapper {
        max-width: 480px;
        width: 100%;
        margin: 0 auto;
        position: relative;
    }
</style>
@endpush

@section('content')
<div class="auth-wrapper" data-aos="fade-up">
    <div class="auth-card">
        <!-- Logo dan Header -->
        <div class="text-center mb-8">
            <div class="logo-box">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Warung Online"
                     onerror="this.onerror=null; this.style.display='none'; this.parentNode.querySelector('.fallback-logo').style.display='flex';">
                <div class="fallback-logo" style="display: none;">WR</div>
            </div>
            <h1 class="auth-title">Selamat Datang Kembali</h1>
            <p class="auth-subtitle">Silahkan login ke akun Anda</p>
            <p class="auth-badge">EST 2025 · ORGANIC · FRESH</p>
        </div>

        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-5">
                <label class="form-label">Email</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus
                           class="auth-input @error('email') error @enderror"
                           placeholder="Masukkan email Anda">
                </div>
                @error('email')
                    <p class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-5">
                <label class="form-label">Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" 
                           name="password" 
                           required
                           class="auth-input @error('password') error @enderror"
                           placeholder="Masukkan password">
                </div>
                @error('password')
                    <p class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label class="checkbox-wrapper">
                    <input type="checkbox" name="remember">
                    <span class="checkbox-custom"></span>
                    <span class="checkbox-label">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        Lupa password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="auth-btn">
                <i class="fas fa-sign-in-alt"></i>
                Login
            </button>

            <!-- Register Link -->
            <div class="register-section">
                <span class="register-text">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="register-link">
                    Daftar sekarang
                </a>
            </div>
        </form>

        <!-- Feature Cards -->
        <div class="feature-grid">
            <div class="feature-card">
                <i class="fas fa-shield-alt feature-icon"></i>
                <p>Aman & Terpercaya</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-bolt feature-icon"></i>
                <p>Cepat & Mudah</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-headset feature-icon"></i>
                <p>Support 24/7</p>
            </div>
        </div>
    </div>

    <!-- Decorative Elements -->
    <div class="decor-circle decor-circle-1"></div>
    <div class="decor-circle decor-circle-2"></div>
</div>
@endsection