<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Warung Online')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
    
    <style>
        /* ===== BACKGROUND GRADIENT GLOBAL ===== */
        body {
            background: linear-gradient(135deg, #000000 0%, #047857 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: white;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        
        /* ===== CONTAINER ===== */
        .container-custom {
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            padding-left: 12px;
            padding-right: 12px;
        }
        
        @media (min-width: 640px) {
            .container-custom {
                padding-left: 20px;
                padding-right: 20px;
                max-width: 640px;
            }
        }
        
        @media (min-width: 768px) {
            .container-custom {
                padding-left: 24px;
                padding-right: 24px;
                max-width: 768px;
            }
        }
        
        @media (min-width: 1024px) {
            .container-custom {
                padding-left: 32px;
                padding-right: 32px;
                max-width: 1024px;
            }
        }
        
        @media (min-width: 1280px) {
            .container-custom {
                max-width: 1280px;
            }
        }
        
        /* ===== NAVBAR ===== */
        .navbar {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 50;
            width: 100%;
        }
        
        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 56px;
        }
        
        @media (min-width: 768px) {
            .navbar-container {
                height: 64px;
            }
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .logo-image {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            object-fit: contain;
        }
        
        @media (min-width: 768px) {
            .logo-image {
                width: 42px;
                height: 42px;
            }
        }
        
        .logo-text {
            font-size: 16px;
            font-weight: 700;
            color: white;
        }
        
        @media (min-width: 768px) {
            .logo-text {
                font-size: 18px;
            }
        }
        
        .logo-text span:first-child {
            color: #10b981;
        }
        
        /* ===== NAV LINK ===== */
        .nav-links {
            display: none;
        }
        
        @media (min-width: 768px) {
            .nav-links {
                display: flex;
                align-items: center;
                gap: 24px;
            }
        }
        
        .nav-link {
            font-size: 14px;
            font-weight: 500;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            position: relative;
            padding: 4px 0;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: #10b981;
        }
        
        .nav-link.active {
            color: #10b981;
            font-weight: 600;
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: #10b981;
            border-radius: 2px;
        }
        
        /* ===== RIGHT MENU ===== */
        .right-menu {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        @media (min-width: 768px) {
            .right-menu {
                gap: 16px;
            }
        }
        
        .icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            background: rgba(255,255,255,0.1);
            border: none;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }
        
        @media (min-width: 768px) {
            .icon-btn {
                width: 40px;
                height: 40px;
            }
        }
        
        .icon-btn:hover {
            background: rgba(255,255,255,0.2);
        }
        
        .cart-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 600;
            min-width: 18px;
            height: 18px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            border: 2px solid rgba(0,0,0,0.3);
        }
        
        /* ===== CARD ===== */
        .card {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 20px;
            color: white;
        }
        
        /* ===== BUTTON ===== */
        .btn-primary {
            background: linear-gradient(135deg, #10b981, #047857);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.3);
        }
        
        /* ===== FOOTER ===== */
        .footer {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255,255,255,0.1);
            padding: 40px 0;
            margin-top: 60px;
        }
        
        .footer-title {
            color: white;
            font-weight: 600;
            margin-bottom: 12px;
        }
        
        .footer-link {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }
        
        .footer-link:hover {
            color: #10b981;
            transform: translateX(5px);
        }
        
        .footer-copyright {
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.4);
            font-size: 12px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar" x-data="{ mobileMenu: false }">
        <div class="container-custom">
            <div class="navbar-container">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Warung Online" class="logo-image">
                    <span class="logo-text">
                        <span>Warung</span> Online
                    </span>
                </a>

                <!-- Desktop Navigation -->
                <div class="nav-links">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('customer.products.index') }}" class="nav-link {{ request()->routeIs('customer.products.*') ? 'active' : '' }}">Produk</a>
                    @auth
                        <a href="{{ route('customer.orders') }}" class="nav-link {{ request()->routeIs('customer.orders.*') ? 'active' : '' }}">Pesanan</a>
                    @endauth
                </div>

                <!-- Right Menu -->
                <div class="right-menu">
                    <!-- Cart -->
                    @auth
                        <a href="{{ route('customer.cart') }}" class="icon-btn">
                            <i class="fas fa-shopping-cart"></i>
                            @php
                                $cartCount = App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
                            @endphp
                            @if($cartCount > 0)
                                <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    @endauth

                    <!-- User Menu -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="icon-btn">
                                <i class="fas fa-user"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-black/70 backdrop-blur-lg border border-white/10 rounded-xl py-2 z-50">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-white hover:bg-white/10">Dashboard Admin</a>
                                @else
                                    <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-sm text-white hover:bg-white/10">Dashboard</a>
                                    <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-sm text-white hover:bg-white/10">Profil</a>
                                @endif
                                <hr class="my-2 border-white/10">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-white/10">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="px-3 py-1 text-sm text-white hover:text-green-400">Login</a>
                            <a href="{{ route('register') }}" class="px-3 py-1 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700">Daftar</a>
                        </div>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button class="md:hidden icon-btn" @click="mobileMenu = !mobileMenu">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" class="md:hidden border-t border-white/10 bg-black/70 backdrop-blur-lg">
            <div class="container-custom py-3">
                <a href="{{ route('home') }}" class="block py-2 px-4 text-white hover:bg-white/10 rounded-lg">Beranda</a>
                <a href="{{ route('customer.products.index') }}" class="block py-2 px-4 text-white hover:bg-white/10 rounded-lg">Produk</a>
                @auth
                    <a href="{{ route('customer.orders') }}" class="block py-2 px-4 text-white hover:bg-white/10 rounded-lg">Pesanan</a>
                    @if(!Auth::user()->isAdmin())
                        <a href="{{ route('customer.dashboard') }}" class="block py-2 px-4 text-white hover:bg-white/10 rounded-lg">Dashboard</a>
                        <a href="{{ route('customer.profile') }}" class="block py-2 px-4 text-white hover:bg-white/10 rounded-lg">Profil</a>
                    @endif
                    <hr class="my-2 border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 px-4 text-red-400 hover:bg-white/10 rounded-lg">Logout</button>
                    </form>
                @else
                    <hr class="my-2 border-white/10">
                    <a href="{{ route('login') }}" class="block py-2 px-4 text-white hover:bg-white/10 rounded-lg">Login</a>
                    <a href="{{ route('register') }}" class="block py-2 px-4 text-green-400 hover:bg-white/10 rounded-lg">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="container-custom py-4">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-500/20 backdrop-blur-lg border border-green-500/30 text-green-400 p-3 rounded-lg flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.style.display='none'" class="text-green-400">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-500/20 backdrop-blur-lg border border-red-500/30 text-red-400 p-3 rounded-lg flex justify-between items-center">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.style.display='none'" class="text-red-400">&times;</button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container-custom">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <!-- FIX: Tanda kutip diperbaiki -->
                        <img src="{{ asset('images/logo.png') }}" alt="Warung Online" class="w-8 h-8">
                        <span class="text-white font-bold">Warung Online</span>
                    </div>
                    <p class="text-white/60 text-sm">EST 2025 · ORGANIC · FRESH</p>
                </div>
                <div>
                    <h3 class="footer-title">Tautan</h3>
                    <a href="{{ route('home') }}" class="footer-link">Beranda</a>
                    <a href="{{ route('customer.products.index') }}" class="footer-link">Produk</a>
                </div>
                <div>
                    <h3 class="footer-title">Bantuan</h3>
                    <a href="#" class="footer-link">FAQ</a>
                    <a href="#" class="footer-link">Kebijakan Privasi</a>
                </div>
                <div>
                    <h3 class="footer-title">Kontak</h3>
                    <p class="text-white/60 text-sm"><i class="fas fa-phone text-green-500 mr-2"></i>0812-9015-6531</p>
                    <p class="text-white/60 text-sm"><i class="fas fa-envelope text-green-500 mr-2"></i>warungonline@gmail.com</p>
                </div>
            </div>
            <div class="footer-copyright">
                &copy; {{ date('Y') }} Warung Online. All rights reserved.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>