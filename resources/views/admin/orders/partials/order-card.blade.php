<div class="order-card bg-white rounded-2xl p-6" data-aos="fade-up">
    <!-- Order Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-receipt text-xl text-green-600"></i>
            </div>
            <div>
                <div class="flex items-center gap-2 flex-wrap">
                    <h3 class="font-semibold text-gray-800">#{{ $order->order_number }}</h3>
                    <span class="badge 
                        @if($order->status == 'delivered') badge-success
                        @elseif($order->status == 'processing') badge-info
                        @elseif($order->status == 'shipped') badge-warning
                        @elseif($order->status == 'cancelled') badge-danger
                        @else badge-gray @endif">
                        <i class="fas fa-circle text-[8px] mr-1"></i>
                        {{ ucfirst($order->status) }}
                    </span>
                    
                    <!-- Tampilkan indikator jika user ini punya banyak pesanan -->
                    @php
                        $userOrderCount = \App\Models\Order::where('user_id', $order->user_id)->count();
                    @endphp
                    @if($userOrderCount > 1)
                    <span class="multiple-orders" title="User ini memiliki {{ $userOrderCount }} pesanan">
                        <i class="fas fa-layer-group"></i>
                        {{ $userOrderCount }} pesanan
                    </span>
                    @endif
                </div>
                <p class="text-sm text-gray-500">
                    <i class="far fa-calendar-alt mr-1"></i>
                    {{ $order->created_at->format('d M Y H:i') }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xl font-bold gradient-text">
                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
            </span>
            <a href="{{ route('admin.orders.show', $order) }}" 
               class="btn-primary">
                <i class="fas fa-eye"></i>
                Detail
            </a>
        </div>
    </div>

    <!-- Order Details -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 pt-4 border-t border-gray-100">
        <!-- Customer Info -->
        <div class="flex items-center">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                <i class="fas fa-user text-green-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500">Pelanggan</p>
                <p class="font-medium text-gray-800">{{ $order->user->name }}</p>
                <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="flex items-center">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                <i class="fas fa-credit-card text-green-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500">Pembayaran</p>
                <p class="font-medium text-gray-800">{{ strtoupper($order->payment_method) }}</p>
                <span class="badge 
                    @if($order->payment_status == 'paid') badge-success
                    @elseif($order->payment_status == 'failed') badge-danger
                    @else badge-warning @endif
                    text-xs mt-1">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </div>
        </div>

        <!-- Items Count -->
        <div class="flex items-center">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                <i class="fas fa-boxes text-green-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500">Total Item</p>
                <p class="font-medium text-gray-800">{{ $order->items->count() }} produk</p>
            </div>
        </div>
    </div>

    <!-- Progress Bar (for ongoing orders) -->
    @if(in_array($order->status, ['pending', 'processing', 'shipped']))
    <div class="mt-4 pt-4 border-t border-gray-100">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs text-gray-500">Progress Pesanan</span>
            <span class="text-xs font-medium text-green-600">
                @if($order->status == 'pending') 25%
                @elseif($order->status == 'processing') 50%
                @elseif($order->status == 'shipped') 75%
                @endif
            </span>
        </div>
        <div class="status-progress">
            <div class="status-progress-bar" 
                 style="width: @if($order->status == 'pending') 25% @elseif($order->status == 'processing') 50% @elseif($order->status == 'shipped') 75% @endif">
            </div>
        </div>
    </div>
    @endif
</div>