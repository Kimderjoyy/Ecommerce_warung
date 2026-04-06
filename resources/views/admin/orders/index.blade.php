@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="space-y-6">
    <!-- HEADER SECTION -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen Pesanan</h1>
            <p class="text-sm text-white/50 mt-1">Kelola dan pantau semua pesanan pelanggan</p>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="rounded-2xl bg-gray-800/50 p-5 border border-green-500/20 text-center">
            <p class="text-2xl font-bold text-white">{{ $totalOrders ?? 0 }}</p>
            <p class="text-xs text-white/50 mt-1">Total Pesanan</p>
        </div>
        <div class="rounded-2xl bg-gray-800/50 p-5 border border-yellow-500/20 text-center">
            <p class="text-2xl font-bold text-yellow-400">{{ $pendingOrders ?? 0 }}</p>
            <p class="text-xs text-white/50 mt-1">Pending</p>
        </div>
        <div class="rounded-2xl bg-gray-800/50 p-5 border border-blue-500/20 text-center">
            <p class="text-2xl font-bold text-blue-400">{{ $processingOrders ?? 0 }}</p>
            <p class="text-xs text-white/50 mt-1">Diproses</p>
        </div>
        <div class="rounded-2xl bg-gray-800/50 p-5 border border-green-500/20 text-center">
            <p class="text-2xl font-bold text-green-400">{{ $deliveredOrders ?? 0 }}</p>
            <p class="text-xs text-white/50 mt-1">Selesai</p>
        </div>
        <div class="rounded-2xl bg-gray-800/50 p-5 border border-red-500/20 text-center">
            <p class="text-2xl font-bold text-red-400">{{ $cancelledOrders ?? 0 }}</p>
            <p class="text-xs text-white/50 mt-1">Dibatalkan</p>
        </div>
    </div>

    <!-- FILTER SECTION -->
    <div class="rounded-2xl bg-gray-800/50 p-6 border border-green-500/20">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-white/80 mb-2">Cari Pesanan</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/30 text-sm"></i>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 pl-11 pr-4 text-sm text-white placeholder:text-white/30 focus:border-green-500 focus:outline-none"
                               placeholder="No. Order atau nama pelanggan...">
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">Status</label>
                    <select name="status" class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 px-4 text-sm text-white focus:border-green-500 focus:outline-none">
                        <option value="" class="bg-gray-800">Semua Status</option>
                        <option value="pending" class="bg-gray-800" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" class="bg-gray-800" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" class="bg-gray-800" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" class="bg-gray-800" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" class="bg-gray-800" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- Date Filter -->
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">Tanggal</label>
                    <input type="date" 
                           name="date" 
                           value="{{ request('date') }}" 
                           class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 px-4 text-sm text-white focus:border-green-500 focus:outline-none">
                </div>
            </div>

            <div class="flex justify-end gap-3">
                @if(request()->anyFilled(['search', 'status', 'date']))
                    <a href="{{ route('admin.orders.index') }}" 
                       class="px-6 py-3 rounded-xl bg-white/10 text-white/70 border border-white/20 hover:bg-white/20">
                        <i class="fas fa-times mr-2"></i>Reset Filter
                    </a>
                @endif
                <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    <i class="fas fa-filter mr-2"></i>Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- ORDERS LIST -->
    @if($orders->isEmpty())
        <!-- EMPTY STATE -->
        <div class="rounded-2xl bg-gray-800/50 p-12 border border-green-500/20 text-center">
            <div class="flex justify-center mb-4">
                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-white/5 border border-white/10">
                    <i class="fas fa-shopping-cart text-3xl text-white/30"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-white mb-2">Belum ada pesanan</h3>
            <p class="text-sm text-white/40">Pesanan akan muncul di sini setelah pelanggan checkout</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
            <!-- ORDER CARD -->
            <div class="rounded-2xl bg-gray-800/50 p-6 border border-green-500/20 hover:border-green-500/40 transition-all">
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-500/20 border border-green-500/30 text-green-400">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-semibold text-white">#{{ $order->order_number }}</h3>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                                        'processing' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                                        'shipped' => 'bg-purple-500/20 text-purple-400 border-purple-500/30',
                                        'delivered' => 'bg-green-500/20 text-green-400 border-green-500/30',
                                        'cancelled' => 'bg-red-500/20 text-red-400 border-red-500/30',
                                    ];
                                    $statusColor = $statusColors[$order->status] ?? 'bg-white/10 text-white/40 border-white/10';
                                    
                                    $statusDots = [
                                        'pending' => 'bg-yellow-500',
                                        'processing' => 'bg-blue-500',
                                        'shipped' => 'bg-purple-500',
                                        'delivered' => 'bg-green-500',
                                        'cancelled' => 'bg-red-500',
                                    ];
                                    $statusDot = $statusDots[$order->status] ?? 'bg-gray-500';
                                @endphp
                                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold border {{ $statusColor }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $statusDot }}"></span>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-white/50 mt-1">
                                <i class="far fa-calendar-alt text-green-400 mr-1"></i>
                                {{ $order->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xl font-bold text-green-400">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </span>
                        <a href="{{ route('admin.orders.show', $order) }}" 
                           class="inline-flex items-center gap-2 rounded-xl bg-green-500/20 px-5 py-2.5 text-sm font-semibold text-green-400 border border-green-500/30 hover:bg-green-500 hover:text-white transition-all">
                            <i class="fas fa-eye"></i>Detail
                        </a>
                    </div>
                </div>

                <!-- Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 pt-4 border-t border-white/10">
                    <!-- Customer -->
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-500/20 border border-green-500/30 text-green-400">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <p class="text-xs text-white/50">Pelanggan</p>
                            <p class="text-sm font-medium text-white">{{ $order->user->name }}</p>
                            <p class="text-xs text-white/40">{{ $order->user->email }}</p>
                        </div>
                    </div>

                    <!-- Payment -->
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-500/20 border border-green-500/30 text-green-400">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div>
                            <p class="text-xs text-white/50">Pembayaran</p>
                            <p class="text-sm font-medium text-white">{{ strtoupper($order->payment_method) }}</p>
                            @php
                                $paymentColors = [
                                    'paid' => 'bg-green-500/20 text-green-400 border-green-500/30',
                                    'pending' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                                    'failed' => 'bg-red-500/20 text-red-400 border-red-500/30',
                                ];
                                $paymentColor = $paymentColors[$order->payment_status] ?? 'bg-white/10 text-white/40 border-white/10';
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold border mt-1 {{ $paymentColor }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Items -->
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-500/20 border border-green-500/30 text-green-400">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div>
                            <p class="text-xs text-white/50">Total Item</p>
                            <p class="text-sm font-medium text-white">{{ $order->items->count() }} produk</p>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                @if(in_array($order->status, ['pending', 'processing', 'shipped']))
                @php
                    $progress = [
                        'pending' => 25,
                        'processing' => 50,
                        'shipped' => 75,
                    ];
                    $currentProgress = $progress[$order->status] ?? 0;
                @endphp
                <div class="mt-4 pt-4 border-t border-white/10">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-white/50">Progress Pesanan</span>
                        <span class="text-xs font-medium text-green-400">{{ $currentProgress }}%</span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-white/10">
                        <div class="h-full rounded-full bg-gradient-to-r from-green-500 to-green-700 transition-all" 
                             style="width: {{ $currentProgress }}%"></div>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- PAGINATION -->
        @if($orders->hasPages())
        <div class="mt-8">
            {{ $orders->withQueryString()->links() }}
        </div>
        @endif

        <!-- INFO -->
        <div class="text-center text-sm text-white/40">
            Menampilkan {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }} 
            dari {{ $orders->total() }} pesanan
        </div>
    @endif
</div>
@endsection