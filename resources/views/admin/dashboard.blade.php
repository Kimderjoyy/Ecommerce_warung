@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- ===== WELCOME CARD ===== -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-green-600/20 to-green-800/30 p-8 backdrop-blur-sm border border-green-500/20">
        <div class="absolute -top-20 -right-20 h-64 w-64 rounded-full bg-green-500/20 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-green-500/20 blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Selamat datang, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-white/70">Kelola dan pantau kinerja toko Anda</p>
            </div>
            <div class="flex items-center gap-3 rounded-2xl bg-white/10 px-6 py-3 backdrop-blur-sm border border-white/20">
                <i class="far fa-calendar-alt text-green-400"></i>
                <span class="font-medium text-white">{{ now()->format('d F Y') }}</span>
            </div>
        </div>
    </div>

    <!-- ===== STATISTICS CARDS ===== -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Orders -->
        <div class="group rounded-2xl bg-gray-800/50 p-6 border border-green-500/20 backdrop-blur-sm hover:border-green-500/40 hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-white/50 mb-2">Total Pesanan</p>
                    <h3 class="text-3xl font-bold text-white">{{ number_format($totalOrders) }}</h3>
                    <p class="text-xs text-green-400 mt-2 flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> +12% dari bulan lalu
                    </p>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-green-500/20 border border-green-500/30 text-green-400 text-2xl group-hover:scale-110 group-hover:bg-green-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/10">
                <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between text-sm text-green-400 hover:text-white transition-colors">
                    <span>Lihat detail</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Total Products -->
        <div class="group rounded-2xl bg-gray-800/50 p-6 border border-blue-500/20 backdrop-blur-sm hover:border-blue-500/40 hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-white/50 mb-2">Total Produk</p>
                    <h3 class="text-3xl font-bold text-white">{{ number_format($totalProducts) }}</h3>
                    <p class="text-xs text-blue-400 mt-2 flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> +5 baru
                    </p>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-blue-500/20 border border-blue-500/30 text-blue-400 text-2xl group-hover:scale-110 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-box"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/10">
                <a href="{{ route('admin.products.index') }}" class="flex items-center justify-between text-sm text-blue-400 hover:text-white transition-colors">
                    <span>Kelola produk</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="group rounded-2xl bg-gray-800/50 p-6 border border-yellow-500/20 backdrop-blur-sm hover:border-yellow-500/40 hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-white/50 mb-2">Total Pelanggan</p>
                    <h3 class="text-3xl font-bold text-white">{{ number_format($totalCustomers) }}</h3>
                    <p class="text-xs text-yellow-400 mt-2 flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> +30 baru
                    </p>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-yellow-500/20 border border-yellow-500/30 text-yellow-400 text-2xl group-hover:scale-110 group-hover:bg-yellow-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/10">
                <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between text-sm text-yellow-400 hover:text-white transition-colors">
                    <span>Lihat pelanggan</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="group rounded-2xl bg-gray-800/50 p-6 border border-purple-500/20 backdrop-blur-sm hover:border-purple-500/40 hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-white/50 mb-2">Total Pendapatan</p>
                    <h3 class="text-3xl font-bold text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p class="text-xs text-purple-400 mt-2 flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> +18% dari bulan lalu
                    </p>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-purple-500/20 border border-purple-500/30 text-purple-400 text-2xl group-hover:scale-110 group-hover:bg-purple-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/10">
                <a href="#" class="flex items-center justify-between text-sm text-purple-400 hover:text-white transition-colors">
                    <span>Lihat laporan</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- ===== CHARTS & ANALYTICS ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <!-- Orders by Status -->
        <div class="rounded-2xl bg-gray-800/50 p-6 border border-green-500/20 backdrop-blur-sm">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-lg font-semibold text-white">Status Pesanan</h3>
                    <p class="text-xs text-white/40 mt-1">Distribusi status pesanan</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-500/20 border border-green-500/30 text-green-400">
                    <i class="fas fa-chart-pie"></i>
                </div>
            </div>
            
            <div class="space-y-3">
                @foreach($ordersByStatus as $status)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full 
                            @if($status->status == 'delivered') bg-green-500
                            @elseif($status->status == 'processing') bg-blue-500
                            @elseif($status->status == 'shipped') bg-yellow-500
                            @elseif($status->status == 'cancelled') bg-red-500
                            @else bg-gray-500 @endif">
                        </span>
                        <span class="text-sm capitalize text-white/70">{{ $status->status }}</span>
                    </div>
                    <span class="text-sm font-semibold text-white">{{ number_format($status->total) }}</span>
                </div>
                @endforeach
            </div>
            
            <div class="mt-5 pt-4 border-t border-white/10">
                <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between text-sm text-green-400 hover:text-white transition-colors">
                    <span>Total {{ number_format($totalOrders) }} pesanan</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Top Products -->
        <div class="rounded-2xl bg-gray-800/50 p-6 border border-green-500/20 backdrop-blur-sm">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-lg font-semibold text-white">Produk Terlaris</h3>
                    <p class="text-xs text-white/40 mt-1">5 produk dengan penjualan tertinggi</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-500/20 border border-green-500/30 text-green-400">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
            
            @if($topProducts->isNotEmpty())
            <div class="space-y-3">
                @foreach($topProducts as $index => $product)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-green-500/20 border border-green-500/30 text-xs font-semibold text-green-400">
                            {{ $index + 1 }}
                        </span>
                        <span class="text-sm text-white/80">{{ $product->product_name }}</span>
                    </div>
                    <span class="text-sm font-semibold text-green-400">{{ number_format($product->total_sold) }}</span>
                </div>
                @endforeach
            </div>
            
            <div class="mt-5 pt-4 border-t border-white/10">
                <a href="{{ route('admin.products.index') }}" class="flex items-center justify-between text-sm text-green-400 hover:text-white transition-colors">
                    <span>Total {{ number_format($totalProducts) }} produk</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            @else
            <div class="py-10 text-center">
                <div class="mb-3 flex justify-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/5 border border-white/10">
                        <i class="fas fa-chart-line text-2xl text-white/30"></i>
                    </div>
                </div>
                <p class="text-sm text-white/60">Belum ada data penjualan</p>
                <p class="text-xs text-white/30 mt-1">Produk akan muncul setelah ada pesanan</p>
            </div>
            @endif
        </div>
    </div>

    <!-- ===== RECENT ORDERS TABLE ===== -->
    <div class="rounded-2xl bg-gray-800/50 p-6 border border-green-500/20 backdrop-blur-sm">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-lg font-semibold text-white">Pesanan Terbaru</h3>
                <p class="text-xs text-white/40 mt-1">5 pesanan terakhir yang masuk</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-green-500 to-green-700 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-green-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all">
                <i class="fas fa-eye"></i>
                Lihat Semua
            </a>
        </div>

        @if($recentOrders->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="pb-3 text-left text-xs font-semibold text-white/40 uppercase tracking-wider">No. Order</th>
                        <th class="pb-3 text-left text-xs font-semibold text-white/40 uppercase tracking-wider">Pelanggan</th>
                        <th class="pb-3 text-left text-xs font-semibold text-white/40 uppercase tracking-wider">Total</th>
                        <th class="pb-3 text-left text-xs font-semibold text-white/40 uppercase tracking-wider">Status</th>
                        <th class="pb-3 text-left text-xs font-semibold text-white/40 uppercase tracking-wider">Pembayaran</th>
                        <th class="pb-3 text-left text-xs font-semibold text-white/40 uppercase tracking-wider">Tanggal</th>
                        <th class="pb-3 text-left text-xs font-semibold text-white/40 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                        <td class="py-3 text-sm font-mono text-white">#{{ $order->order_number }}</td>
                        <td class="py-3">
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-r from-green-500 to-green-700 text-sm font-semibold text-white">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-white">{{ $order->user->name }}</p>
                                    <p class="text-xs text-white/40">{{ $order->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <span class="text-sm font-semibold text-green-400">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </td>
                        <td class="py-3">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold
                                @if($order->status == 'delivered') bg-green-500/20 text-green-400 border border-green-500/30
                                @elseif($order->status == 'processing') bg-blue-500/20 text-blue-400 border border-blue-500/30
                                @elseif($order->status == 'shipped') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                                @elseif($order->status == 'cancelled') bg-red-500/20 text-red-400 border border-red-500/30
                                @else bg-gray-500/20 text-gray-400 border border-gray-500/30 @endif">
                                <span class="h-1.5 w-1.5 rounded-full
                                    @if($order->status == 'delivered') bg-green-500
                                    @elseif($order->status == 'processing') bg-blue-500
                                    @elseif($order->status == 'shipped') bg-yellow-500
                                    @elseif($order->status == 'cancelled') bg-red-500
                                    @else bg-gray-500 @endif">
                                </span>
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="py-3">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                @if($order->payment_status == 'paid') bg-green-500/20 text-green-400 border border-green-500/30
                                @elseif($order->payment_status == 'failed') bg-red-500/20 text-red-400 border border-red-500/30
                                @else bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 @endif">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="py-3">
                            <span class="flex items-center gap-1.5 text-sm text-white/60">
                                <i class="far fa-calendar-alt text-green-400 text-xs"></i>
                                {{ $order->created_at->format('d/m/Y') }}
                            </span>
                        </td>
                        <td class="py-3">
                            <a href="{{ route('admin.orders.show', $order) }}" class="flex h-8 w-8 items-center justify-center rounded-lg bg-green-500/20 border border-green-500/30 text-green-400 hover:bg-green-500 hover:text-white hover:scale-110 transition-all">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="py-12 text-center">
            <div class="mb-4 flex justify-center">
                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-white/5 border border-white/10">
                    <i class="fas fa-shopping-cart text-3xl text-white/30"></i>
                </div>
            </div>
            <h4 class="text-base font-semibold text-white mb-1">Belum ada pesanan</h4>
            <p class="text-sm text-white/40">Pesanan akan muncul di sini setelah pelanggan checkout</p>
        </div>
        @endif
    </div>

    <!-- ===== QUICK ACTIONS ===== -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <a href="{{ route('admin.products.create') }}" class="group flex items-center gap-4 rounded-2xl bg-gray-800/50 p-5 border border-green-500/20 backdrop-blur-sm hover:border-green-500 hover:-translate-y-1 transition-all duration-300">
            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-green-500/20 border border-green-500/30 text-green-400 text-2xl group-hover:scale-110 group-hover:bg-green-500 group-hover:text-white transition-all duration-300">
                <i class="fas fa-plus"></i>
            </div>
            <div>
                <h4 class="font-semibold text-white">Tambah Produk</h4>
                <p class="text-xs text-white/40 mt-1">Tambahkan produk baru</p>
            </div>
        </a>
        
        <a href="{{ route('admin.orders.index') }}" class="group flex items-center gap-4 rounded-2xl bg-gray-800/50 p-5 border border-green-500/20 backdrop-blur-sm hover:border-green-500 hover:-translate-y-1 transition-all duration-300">
            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-green-500/20 border border-green-500/30 text-green-400 text-2xl group-hover:scale-110 group-hover:bg-green-500 group-hover:text-white transition-all duration-300">
                <i class="fas fa-truck"></i>
            </div>
            <div>
                <h4 class="font-semibold text-white">Proses Pesanan</h4>
                <p class="text-xs text-white/40 mt-1">Kelola pesanan masuk</p>
            </div>
        </a>
        
        <a href="{{ route('admin.users.index') }}" class="group flex items-center gap-4 rounded-2xl bg-gray-800/50 p-5 border border-green-500/20 backdrop-blur-sm hover:border-green-500 hover:-translate-y-1 transition-all duration-300">
            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-green-500/20 border border-green-500/30 text-green-400 text-2xl group-hover:scale-110 group-hover:bg-green-500 group-hover:text-white transition-all duration-300">
                <i class="fas fa-users-cog"></i>
            </div>
            <div>
                <h4 class="font-semibold text-white">Kelola User</h4>
                <p class="text-xs text-white/40 mt-1">Atur data pelanggan</p>
            </div>
        </a>
    </div>
</div>
@endsection