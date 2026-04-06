<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title') - Admin Warung Online</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    @stack('styles')
    
    <style>
        /*==============================================
        =            ROOT VARIABLES                     =
        ==============================================*/
        :root {
            --primary: #10b981;
            --primary-dark: #047857;
            --primary-light: rgba(16, 185, 129, 0.15);
            --bg-dark: #0f172a;
            --bg-card: #1f2937;
            --text-primary: #f9fafb;
            --text-secondary: #9ca3af;
            --border-color: rgba(16, 185, 129, 0.2);
        }
        
        /*==============================================
        =            GLOBAL STYLES                      =
        ==============================================*/
        body {
            background-color: var(--bg-dark);
            color: var(--text-primary);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        
        /*==============================================
        =            GRADIENTS                          =
        ==============================================*/
        .gradient-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /*==============================================
        =            FLOATING BACKGROUND                =
        ==============================================*/
        .floating-bg {
            position: fixed;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            filter: blur(100px);
            z-index: 0;
            pointer-events: none;
        }
        
        .floating-bg-1 { top: -200px; left: -200px; }
        .floating-bg-2 { bottom: -200px; right: -200px; }
        .floating-bg-3 { top: 50%; left: 50%; transform: translate(-50%, -50%); }
        
        /*==============================================
        =            SIDEBAR                            =
        ==============================================*/
        .sidebar {
            background-color: var(--bg-card);
            width: 280px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--border-color);
            position: relative;
            z-index: 30;
        }
        
        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 24px 16px;
        }
        
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            margin: 4px 0;
            border-radius: 12px;
            color: var(--text-secondary);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .sidebar-link i {
            width: 24px;
            font-size: 1.2rem;
        }
        
        .sidebar-link:hover {
            background-color: var(--primary-light);
            color: var(--primary);
            transform: translateX(5px);
        }
        
        .sidebar-link.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }
        
        .sidebar-link span {
            margin-left: 12px;
        }
        
        /* Badge untuk notifikasi */
        .sidebar-badge {
            margin-left: auto;
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 999px;
            min-width: 18px;
            text-align: center;
        }
        
        /*==============================================
        =            LOGO                               =
        ==============================================*/
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            margin-bottom: 24px;
        }
        
        .logo-image {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--primary-light);
            border: 1px solid var(--border-color);
            object-fit: cover;
        }
        
        .logo-text-main {
            font-size: 18px;
            font-weight: 700;
            color: white;
        }
        
        .logo-text-sub {
            font-size: 12px;
            color: var(--primary);
        }
        
        /*==============================================
        =            NAVBAR                             =
        ==============================================*/
        .navbar {
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 32px;
            position: sticky;
            top: 0;
            z-index: 20;
        }
        
        .navbar-button {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .navbar-button:hover {
            background: var(--primary);
            color: white;
            border-color: transparent;
        }
        
        /*==============================================
        =            CARD                               =
        ==============================================*/
        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 24px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            border-color: var(--primary);
        }
        
        /*==============================================
        =            BUTTONS                            =
        ==============================================*/
        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px var(--primary);
        }
        
        .btn-secondary {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }
        
        .btn-secondary:hover {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary);
        }
        
        /*==============================================
        =            LOGOUT BUTTON                       =
        ==============================================*/
        .logout-container {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logout-button {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 12px 20px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 10px;
            color: #ef4444;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .logout-button:hover {
            background: #ef4444;
            color: white;
        }
        
        .logout-button i {
            width: 24px;
        }
        
        .logout-button span {
            margin-left: 12px;
        }
        
        /*==============================================
        =            TABLE                              =
        ==============================================*/
        .table-container {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 20px;
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th {
            padding: 12px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        .table td {
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .table tr:hover td {
            background: rgba(255, 255, 255, 0.05);
        }
        
        /*==============================================
        =            FORM                               =
        ==============================================*/
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }
        
        .form-input {
            width: 100%;
            padding: 10px 14px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: white;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }
        
        /*==============================================
        =            BADGE                              =
        ==============================================*/
        .badge {
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }
        
        .badge-success {
            background: rgba(16, 185, 129, 0.15);
            color: var(--primary);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        
        .badge-warning {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }
        
        .badge-danger {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        
        .badge-info {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }
        
        /*==============================================
        =            AVATAR                             =
        ==============================================*/
        .avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .avatar-sm {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }
        
        /*==============================================
        =            DROPDOWN                           =
        ==============================================*/
        .dropdown {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.5);
        }
        
        /*==============================================
        =            ALERT                              =
        ==============================================*/
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--primary);
        }
        
        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }
        
        /*==============================================
        =            UTILITIES                          =
        ==============================================*/
        [x-cloak] { display: none !important; }
        
        .min-w-0 { min-width: 0; }
        .truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
    </style>
</head>

<body>
    <!-- Floating Background -->
    <div class="floating-bg floating-bg-1"></div>
    <div class="floating-bg floating-bg-2"></div>
    <div class="floating-bg floating-bg-3"></div>

    <!-- Main Layout -->
    <div class="flex h-screen relative z-10">
        <!-- Desktop Sidebar -->
        <aside class="sidebar hidden lg:block">
            <div class="sidebar-content">
                <!-- Logo -->
                <div class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-image">
                    <div>
                        <div class="logo-text-main">Warung Online</div>
                        <div class="logo-text-sub">Admin Dashboard</div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span>Produk</span>
                    </a>
                    
                    <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span>Kategori</span>
                    </a>
                    
                    <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Pesanan</span>
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Pengguna</span>
                    </a>
                    
                    {{-- TAMBAHAN: MENU REVIEWS --}}
                    <a href="{{ route('admin.reviews.index') }}" class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                        <i class="fas fa-star"></i>
                        <span>Ulasan</span>
                        @php
                            $pendingReviews = \App\Models\Review::where('is_approved', false)->count();
                        @endphp
                        @if($pendingReviews > 0)
                            <span class="sidebar-badge">{{ $pendingReviews }}</span>
                        @endif
                    </a>
                </nav>
            </div>

            <!-- User Profile -->
            <div class="p-6 border-t border-white/10">
                <div class="flex items-center gap-3">
                    <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-green-500">Administrator</p>
                    </div>
                </div>
            </div>

            <!-- Logout -->
            <div class="logout-container">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-button">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Navbar -->
            <header class="navbar">
                <div class="flex items-center justify-between">
                    <button class="navbar-button lg:hidden" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="flex items-center gap-3 ml-auto">
                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="navbar-button">
                                <i class="fas fa-bell"></i>
                                @if($pendingReviews > 0)
                                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                                @endif
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-80 dropdown p-4">
                                <p class="text-sm font-semibold text-white mb-2">Notifikasi</p>
                                @if($pendingReviews > 0)
                                    <div class="text-sm text-yellow-400 flex items-center gap-2">
                                        <i class="fas fa-star"></i>
                                        <span>{{ $pendingReviews }} ulasan pending</span>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-400">Tidak ada notifikasi</p>
                                @endif
                            </div>
                        </div>

                        <!-- Mobile User Menu -->
                        <div class="lg:hidden relative" x-data="{ open: false }">
                            <button @click="open = !open">
                                <div class="avatar avatar-sm">{{ substr(Auth::user()->name, 0, 1) }}</div>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-64 dropdown p-4">
                                <p class="font-semibold">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-green-500 mt-1">Administrator</p>
                                <hr class="my-3 border-white/10">
                                
                                {{-- Link Reviews di mobile --}}
                                <a href="{{ route('admin.reviews.index') }}" class="block px-3 py-2 text-sm text-white/70 hover:text-white hover:bg-white/5 rounded-lg transition-colors mb-2">
                                    <i class="fas fa-star mr-2"></i>
                                    Ulasan
                                    @if($pendingReviews > 0)
                                        <span class="ml-2 bg-yellow-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $pendingReviews }}</span>
                                    @endif
                                </a>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-red-400 hover:text-red-300 flex items-center gap-2 w-full px-3 py-2 hover:bg-white/5 rounded-lg transition-colors">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-6 lg:p-8">
                <!-- Alerts -->
                @if(session('success'))
                <div class="alert alert-success mb-6" x-data="{ show: true }" x-show="show">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="hover:opacity-70">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-error mb-6" x-data="{ show: true }" x-show="show">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="hover:opacity-70">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Sidebar -->
    <div id="mobileSidebar" class="fixed inset-0 z-50 hidden lg:hidden">
        <div class="absolute inset-0 bg-black/50" onclick="toggleSidebar()"></div>
        <div class="absolute left-0 top-0 bottom-0 w-80 sidebar">
            <div class="flex flex-col h-full">
                <div class="p-6 border-b border-white/10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 rounded-xl border border-green-500/30">
                            <div>
                                <div class="font-bold text-white">Warung Online</div>
                                <div class="text-xs text-green-500">Admin Dashboard</div>
                            </div>
                        </div>
                        <button onclick="toggleSidebar()" class="navbar-button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-6">
                    <nav>
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-pie"></i>
                            <span>Dashboard</span>
                        </a>
                        
                        <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <i class="fas fa-box"></i>
                            <span>Produk</span>
                        </a>
                        
                        <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i>
                            <span>Kategori</span>
                        </a>
                        
                        <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Pesanan</span>
                        </a>
                        
                        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Pengguna</span>
                        </a>
                        
                        {{-- TAMBAHAN: MENU REVIEWS DI MOBILE --}}
                        <a href="{{ route('admin.reviews.index') }}" class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                            <i class="fas fa-star"></i>
                            <span>Ulasan</span>
                            @php
                                $pendingReviews = \App\Models\Review::where('is_approved', false)->count();
                            @endphp
                            @if($pendingReviews > 0)
                                <span class="sidebar-badge">{{ $pendingReviews }}</span>
                            @endif
                        </a>
                    </nav>
                </div>

                <div class="p-6 border-t border-white/10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-green-500">Administrator</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-button">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        AOS.init({ duration: 800, once: true });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                document.getElementById('mobileSidebar').classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    </script>

    @stack('scripts')
</body>
</html>