<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title') - Warung Online</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    @stack('styles')
    
    <style>
        /*==============================================
        =            VARIABLES                          =
        ==============================================*/
        :root {
            --primary: #10b981;
            --primary-dark: #047857;
            --primary-light: rgba(16, 185, 129, 0.15);
            --bg-dark: #0f172a;
            --bg-card: rgba(31, 41, 55, 0.8);
            --text-primary: #F9FAFB;
            --text-secondary: #9CA3AF;
            --border-color: rgba(16, 185, 129, 0.2);
        }

        /*==============================================
        =            GLOBAL STYLES                      =
        ==============================================*/
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            position: relative;
            overflow-x: hidden;
            color: var(--text-primary);
        }

        /* Gradient */
        .gradient-primary {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        }

        /* Floating Background */
        .floating-bg {
            position: fixed;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            filter: blur(100px);
            z-index: 0;
            pointer-events: none;
            opacity: 0.5;
        }

        .floating-bg-1 { top: -200px; left: -200px; }
        .floating-bg-2 { bottom: -200px; right: -200px; }
        .floating-bg-3 { top: 50%; left: 50%; transform: translate(-50%, -50%); }

        /*==============================================
        =            NAVIGATION (DARK THEME)           =
        ==============================================*/
        .navbar {
            background: rgba(31, 41, 55, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(16, 185, 129, 0.2);
            position: relative;
            z-index: 20;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .nav-logo:hover {
            transform: scale(1.02);
        }

        .nav-logo-img {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .nav-logo-text {
            font-size: 20px;
            font-weight: 700;
        }

        .nav-logo-text span:first-child {
            color: #10b981;
        }

        .nav-logo-text span:last-child {
            color: white;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 12px;
        }

        .nav-link:hover {
            color: white;
            background: rgba(16, 185, 129, 0.1);
        }

        .nav-btn {
            background: linear-gradient(135deg, #10b981, #047857);
            color: white;
            padding: 8px 20px;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px -5px rgba(16, 185, 129, 0.5);
            border: none;
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -8px rgba(16, 185, 129, 0.7);
        }

        /*==============================================
        =            MAIN CONTENT                       =
        ==============================================*/
        .main-content {
            position: relative;
            z-index: 10;
            min-height: calc(100vh - 64px - 60px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 16px;
        }

        /*==============================================
        =            FOOTER (DARK THEME)               =
        ==============================================*/
        .footer {
            background: rgba(31, 41, 55, 0.8);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(16, 185, 129, 0.2);
            padding: 16px 0;
            position: relative;
            z-index: 20;
        }

        .footer-text {
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
            text-align: center;
        }

        /*==============================================
        =            ANIMATIONS                         =
        ==============================================*/
        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-30px, 30px) rotate(240deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }

        .animate-float {
            animation: float 20s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 0.8; }
        }

        .animate-pulse-slow {
            animation: pulse 4s infinite;
        }
    </style>
</head>
<body>
    <!-- Floating Backgrounds dengan tema dark -->
    <div class="floating-bg floating-bg-1 animate-float"></div>
    <div class="floating-bg floating-bg-2 animate-float" style="animation-delay: -5s;"></div>
    <div class="floating-bg floating-bg-3 animate-pulse-slow"></div>

    <!-- Navigation dengan tema dark -->
    <nav class="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="nav-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Warung Online" class="nav-logo-img">
                    <span class="nav-logo-text">
                        <span>Warung</span>
                        <span>Online</span>
                    </span>
                </a>
                
                <div class="flex items-center space-x-2">
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="nav-btn">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer dengan tema dark -->
    <footer class="footer">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="footer-text">
                &copy; {{ date('Y') }} Warung Online. All rights reserved. EST 2025 · ORGANIC · FRESH
            </p>
        </div>
    </footer>

    <script>
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-in-out'
        });
    </script>

    @stack('scripts')
</body>
</html>