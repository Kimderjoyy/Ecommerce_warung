@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div class="space-y-6">
    <!-- HEADER SECTION -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Detail Pesanan</h1>
            <p class="text-sm text-white/50 mt-1">Informasi lengkap pesanan #{{ $order->order_number }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" 
           class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-5 py-2.5 text-sm font-semibold text-white border border-white/20 hover:bg-white/20 transition-all">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Daftar
        </a>
    </div>

    <!-- STATUS UPDATE CARD -->
    <div class="rounded-2xl bg-gray-800/50 p-6 border border-green-500/20 backdrop-blur-sm">
        <h3 class="text-lg font-semibold text-white mb-4">Update Status Pesanan</h3>
        <form action="{{ route('admin.orders.status', $order) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <select name="status" 
                            class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 px-4 text-sm text-white focus:border-green-500 focus:outline-none">
                        <option value="pending" class="bg-gray-800" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" class="bg-gray-800" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" class="bg-gray-800" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" class="bg-gray-800" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" class="bg-gray-800" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="flex-1">
                    <select name="payment_status" 
                            class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 px-4 text-sm text-white focus:border-green-500 focus:outline-none">
                        <option value="pending" class="bg-gray-800" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" class="bg-gray-800" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" class="bg-gray-800" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <button type="submit" 
                        class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold shadow-lg shadow-green-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    <i class="fas fa-save mr-2"></i>Update
                </button>
            </div>
        </form>
    </div>

    <!-- MAIN CONTENT GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- LEFT COLUMN - PRODUCT DETAILS -->
        <div class="lg:col-span-2 space-y-6">
            <!-- PRODUCTS CARD -->
            <div class="rounded-2xl bg-gray-800/50 p-6 border border-green-500/20 backdrop-blur-sm">
                <h3 class="text-lg font-semibold text-white mb-4">Detail Produk</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/10">
                                <th class="text-left py-3 text-xs font-semibold text-white/40 uppercase">Produk</th>
                                <th class="text-left py-3 text-xs font-semibold text-white/40 uppercase">Harga</th>
                                <th class="text-left py-3 text-xs font-semibold text-white/40 uppercase">Jumlah</th>
                                <th class="text-left py-3 text-xs font-semibold text-white/40 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($order->items as $item)
                            <tr>
                                <td class="py-4">
                                    <div class="text-sm font-medium text-white">{{ $item->product_name }}</div>
                                </td>
                                <td class="py-4 text-sm text-white/70">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="py-4 text-sm text-white/70">{{ $item->quantity }}</td>
                                <td class="py-4 text-sm font-semibold text-green-400">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t border-white/10">
                                <td colspan="3" class="text-right py-4 text-sm font-semibold text-white">Total:</td>
                                <td class="py-4 text-lg font-bold text-green-400">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN - CUSTOMER & PAYMENT INFO -->
        <div class="space-y-6">
            <!-- CUSTOMER INFO CARD -->
            <div class="rounded-2xl bg-gray-800/50 p-6 border border-green-500/20 backdrop-blur-sm">
                <h3 class="text-lg font-semibold text-white mb-4">Informasi Pelanggan</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-white/50 mb-1">Nama</p>
                        <p class="text-sm font-medium text-white">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-white/50 mb-1">Email</p>
                        <p class="text-sm font-medium text-white">{{ $order->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-white/50 mb-1">No. Telepon</p>
                        <p class="text-sm font-medium text-white">{{ $order->shipping_phone }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-white/50 mb-1">Alamat Pengiriman</p>
                        <p class="text-sm font-medium text-white">{{ $order->shipping_address }}</p>
                    </div>
                </div>
            </div>

            <!-- PAYMENT INFO CARD -->
            <div class="rounded-2xl bg-gray-800/50 p-6 border border-green-500/20 backdrop-blur-sm">
                <h3 class="text-lg font-semibold text-white mb-4">Informasi Pembayaran</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-white/50 mb-1">Metode Pembayaran</p>
                        <p class="text-sm font-medium text-white">{{ strtoupper($order->payment_method) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-white/50 mb-1">Status Pembayaran</p>
                        @php
                            $paymentColors = [
                                'paid' => 'bg-green-500/20 text-green-400 border-green-500/30',
                                'pending' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                                'failed' => 'bg-red-500/20 text-red-400 border-red-500/30',
                            ];
                            $paymentColor = $paymentColors[$order->payment_status] ?? 'bg-white/10 text-white/40 border-white/10';
                            
                            $paymentDots = [
                                'paid' => 'bg-green-500',
                                'pending' => 'bg-yellow-500',
                                'failed' => 'bg-red-500',
                            ];
                            $paymentDot = $paymentDots[$order->payment_status] ?? 'bg-gray-500';
                        @endphp
                        <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold border {{ $paymentColor }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $paymentDot }}"></span>
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- NOTES CARD -->
            @if($order->notes)
            <div class="rounded-2xl bg-gray-800/50 p-6 border border-green-500/20 backdrop-blur-sm">
                <h3 class="text-lg font-semibold text-white mb-4">Catatan</h3>
                <p class="text-sm text-white/70 leading-relaxed">{{ $order->notes }}</p>
            </div>
            @endif

            <!-- DELETE BUTTON CARD -->
            <div class="rounded-2xl bg-gray-800/50 p-6 border border-red-500/20 backdrop-blur-sm">
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-red-500/20 px-6 py-3 text-sm font-semibold text-red-400 border border-red-500/30 hover:bg-red-500 hover:text-white transition-all">
                        <i class="fas fa-trash"></i>
                        Hapus Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ORDER TIMELINE (Optional - bisa ditambahkan nanti) -->
    <div class="rounded-2xl bg-gray-800/50 p-6 border border-green-500/20 backdrop-blur-sm">
        <h3 class="text-lg font-semibold text-white mb-4">Riwayat Status</h3>
        <div class="flex items-center gap-2 flex-wrap">
            @php
                $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                $currentIndex = array_search($order->status, $statuses);
            @endphp
            
            @foreach($statuses as $index => $status)
            <div class="flex items-center">
                <div class="flex items-center gap-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full 
                        {{ $index <= $currentIndex ? 'bg-green-500/20 border-green-500/30 text-green-400' : 'bg-white/5 border-white/10 text-white/30' }} 
                        border">
                        @if($index < $currentIndex)
                            <i class="fas fa-check text-xs"></i>
                        @else
                            <span class="text-xs">{{ $index + 1 }}</span>
                        @endif
                    </div>
                    <span class="text-xs {{ $index <= $currentIndex ? 'text-green-400' : 'text-white/30' }} capitalize">{{ $status }}</span>
                </div>
                @if($index < count($statuses) - 1)
                <div class="w-12 h-px mx-2 {{ $index < $currentIndex ? 'bg-green-500/30' : 'bg-white/10' }}"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection