@extends('layouts.app')

@section('title', 'Pesanan Saya')

@push('styles')
<style>
    /*==============================================
    =            NOTIFICATION TOAST MEWAH           =
    ==============================================*/
    .notification-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 380px;
        width: calc(100% - 40px);
        animation: slideInRight 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.2));
    }

    .notification-toast.hide {
        animation: slideOutRight 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
    }

    .notification-content {
        position: relative;
        border-radius: 20px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        color: white;
        overflow: hidden;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .notification-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        animation: bounceIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .notification-message {
        flex: 1;
    }

    .notification-title {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 4px;
        letter-spacing: 0.5px;
    }

    .notification-text {
        font-size: 14px;
        opacity: 0.9;
        line-height: 1.4;
    }

    .notification-close {
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 50%;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }

    .notification-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .notification-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 4px;
        background: rgba(255, 255, 255, 0.5);
        width: 100%;
        animation: progress 4s linear forwards;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100%) scale(0.8);
        }
        to {
            opacity: 1;
            transform: translateX(0) scale(1);
        }
    }

    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0) scale(1);
        }
        to {
            opacity: 0;
            transform: translateX(100%) scale(0.8);
        }
    }

    @keyframes bounceIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes progress {
        from {
            width: 100%;
        }
        to {
            width: 0%;
        }
    }

    /* Responsive untuk mobile */
    @media (max-width: 640px) {
        .notification-toast {
            top: 10px;
            right: 10px;
            left: 10px;
            max-width: none;
            width: auto;
        }
        
        .notification-content {
            padding: 12px 16px;
        }
        
        .notification-icon {
            width: 40px;
            height: 40px;
            font-size: 20px;
        }
        
        .notification-title {
            font-size: 15px;
        }
        
        .notification-text {
            font-size: 13px;
        }
    }

    /*==============================================
    =            ORDER CARD STYLES (DARK THEME)    =
    ==============================================*/
    .page-header {
        margin-bottom: 32px;
    }
    
    .page-header h1 {
        font-size: 32px;
        font-weight: 700;
        color: white;
        margin-bottom: 8px;
    }
    
    .page-header p {
        color: rgba(255, 255, 255, 0.6);
        font-size: 16px;
    }
    
    .page-header .header-accent {
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #10b981, #047857);
        border-radius: 2px;
        margin-top: 12px;
    }
    
    .order-card {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    
    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -15px rgba(16, 185, 129, 0.3);
        border-color: rgba(16, 185, 129, 0.4);
    }
    
    .order-header {
        background: rgba(55, 65, 81, 0.5);
        border-bottom: 1px solid rgba(16, 185, 129, 0.2);
        padding: 20px 24px;
    }
    
    .order-body {
        padding: 24px;
    }
    
    .order-footer {
        background: rgba(55, 65, 81, 0.3);
        border-top: 1px solid rgba(16, 185, 129, 0.2);
        padding: 20px 24px;
    }
    
    /*==============================================
    =            STATUS BADGES (DARK THEME)        =
    ==============================================*/
    .status-badge {
        padding: 6px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        backdrop-filter: blur(4px);
    }
    
    .status-pending {
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    
    .status-processing {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }
    
    .status-shipped {
        background: rgba(139, 92, 246, 0.15);
        color: #a78bfa;
        border: 1px solid rgba(139, 92, 246, 0.3);
    }
    
    .status-delivered {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .status-cancelled {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    /*==============================================
    =            FILTER TABS (DARK THEME)          =
    ==============================================*/
    .filter-tabs {
        background: rgba(31, 41, 55, 0.6);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 999px;
        padding: 4px;
        display: inline-flex;
        flex-wrap: wrap;
        gap: 4px;
        margin-bottom: 32px;
    }
    
    .filter-tab {
        padding: 10px 20px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.6);
    }
    
    .filter-tab:hover {
        color: white;
        background: rgba(255, 255, 255, 0.1);
    }
    
    .filter-tab.active {
        background: linear-gradient(135deg, #10b981, #047857);
        color: white;
        box-shadow: 0 10px 20px -10px rgba(16, 185, 129, 0.5);
    }
    
    /*==============================================
    =            EMPTY STATE (DARK THEME)          =
    ==============================================*/
    .empty-state {
        text-align: center;
        padding: 60px 24px;
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(8px);
        border-radius: 32px;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .empty-state-icon {
        width: 120px;
        height: 120px;
        background: rgba(16, 185, 129, 0.1);
        border-radius: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .empty-state-icon i {
        font-size: 56px;
        color: #10b981;
    }
    
    .empty-state h3 {
        font-size: 24px;
        font-weight: 700;
        color: white;
        margin-bottom: 12px;
    }
    
    .empty-state p {
        color: rgba(255, 255, 255, 0.6);
        margin-bottom: 24px;
    }
    
    /*==============================================
    =            ITEM LIST (DARK THEME)            =
    ==============================================*/
    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
    }
    
    .order-item:not(:last-child) {
        border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
    }
    
    .item-name {
        font-weight: 600;
        color: white;
        margin-bottom: 4px;
    }
    
    .item-detail {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.5);
    }
    
    .item-subtotal {
        font-weight: 700;
        color: #10b981;
        font-size: 16px;
    }
    
    /*==============================================
    =            ACTION BUTTONS (DARK THEME)       =
    ==============================================*/
    .btn-detail {
        padding: 10px 20px;
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: 999px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-detail:hover {
        background: #10b981;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -10px rgba(16, 185, 129, 0.5);
        border-color: transparent;
    }
    
    .btn-cancel {
        padding: 10px 20px;
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 999px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-cancel:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -10px rgba(239, 68, 68, 0.5);
        border-color: transparent;
    }
    
    /*==============================================
    =            ORDER INFO                         =
    ==============================================*/
    .order-number {
        font-size: 16px;
        font-weight: 600;
        color: white;
        margin-bottom: 4px;
    }
    
    .order-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        color: rgba(255, 255, 255, 0.5);
        font-size: 13px;
    }
    
    .order-meta i {
        color: #10b981;
        margin-right: 4px;
    }
    
    .order-icon {
        width: 48px;
        height: 48px;
        background: rgba(16, 185, 129, 0.15);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .order-icon i {
        font-size: 20px;
        color: #10b981;
    }
    
    .total-amount {
        font-size: 24px;
        font-weight: 700;
        color: #10b981;
    }
    
    .total-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 14px;
    }
    
    /*==============================================
    =            PAGINATION (DARK THEME)           =
    ==============================================*/
    .pagination {
        display: flex;
        gap: 8px;
        justify-content: center;
        margin-top: 40px;
    }
    
    .pagination a, .pagination span {
        padding: 10px 16px;
        border-radius: 999px;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    
    .pagination a {
        background: rgba(31, 41, 55, 0.8);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: rgba(255, 255, 255, 0.7);
    }
    
    .pagination a:hover {
        background: #10b981;
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
    }
    
    .pagination .active span {
        background: linear-gradient(135deg, #10b981, #047857);
        color: white;
        border: none;
        box-shadow: 0 10px 20px -10px rgba(16, 185, 129, 0.5);
    }
    
    .pagination .disabled span {
        background: rgba(75, 85, 99, 0.3);
        color: rgba(255, 255, 255, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        cursor: not-allowed;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header dengan aksen hijau -->
    <div class="page-header" data-aos="fade-down">
        <h1>Pesanan Saya</h1>
        <p>Kelola dan pantau semua pesanan Anda</p>
        <div class="header-accent"></div>
    </div>

    <!-- Filter Status dengan tema dark -->
    <div class="filter-tabs" data-aos="fade-up">
        <a href="{{ route('customer.orders') }}" 
           class="filter-tab {{ !request('status') ? 'active' : '' }}">
            <i class="fas fa-list-ul"></i>
            Semua
        </a>
        <a href="{{ route('customer.orders', ['status' => 'pending']) }}" 
           class="filter-tab {{ request('status') == 'pending' ? 'active' : '' }}">
            <i class="fas fa-clock"></i>
            Pending
        </a>
        <a href="{{ route('customer.orders', ['status' => 'processing']) }}" 
           class="filter-tab {{ request('status') == 'processing' ? 'active' : '' }}">
            <i class="fas fa-cog"></i>
            Diproses
        </a>
        <a href="{{ route('customer.orders', ['status' => 'shipped']) }}" 
           class="filter-tab {{ request('status') == 'shipped' ? 'active' : '' }}">
            <i class="fas fa-truck"></i>
            Dikirim
        </a>
        <a href="{{ route('customer.orders', ['status' => 'delivered']) }}" 
           class="filter-tab {{ request('status') == 'delivered' ? 'active' : '' }}">
            <i class="fas fa-check-circle"></i>
            Selesai
        </a>
        <a href="{{ route('customer.orders', ['status' => 'cancelled']) }}" 
           class="filter-tab {{ request('status') == 'cancelled' ? 'active' : '' }}">
            <i class="fas fa-times-circle"></i>
            Dibatalkan
        </a>
    </div>

    <!-- Daftar Pesanan -->
    @if($orders->isEmpty())
        <div class="empty-state" data-aos="fade-up">
            <div class="empty-state-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <h3>Belum ada pesanan</h3>
            <p>Yuk, mulai belanja kebutuhan warung Anda!</p>
            <a href="{{ route('customer.products.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-green-500 to-green-700 text-white rounded-xl font-semibold hover:shadow-xl transition transform hover:-translate-y-1">
                <i class="fas fa-store"></i>
                Belanja Sekarang
            </a>
        </div>
    @else
        <div class="space-y-4" data-aos="fade-up">
            @foreach($orders as $order)
            <div class="order-card">
                <!-- Header Order -->
                <div class="order-header">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="order-icon">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div>
                                <div class="order-number">#{{ $order->order_number }}</div>
                                <div class="order-meta">
                                    <span>
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $order->created_at->format('d M Y') }}
                                    </span>
                                    <span>
                                        <i class="far fa-clock"></i>
                                        {{ $order->created_at->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Badge dengan tema dark -->
                        <div class="status-badge 
                            @if($order->status == 'pending') status-pending
                            @elseif($order->status == 'processing') status-processing
                            @elseif($order->status == 'shipped') status-shipped
                            @elseif($order->status == 'delivered') status-delivered
                            @elseif($order->status == 'cancelled') status-cancelled
                            @endif">
                            <i class="fas fa-circle"></i>
                            @if($order->status == 'pending') Menunggu Konfirmasi
                            @elseif($order->status == 'processing') Sedang Diproses
                            @elseif($order->status == 'shipped') Dalam Pengiriman
                            @elseif($order->status == 'delivered') Selesai
                            @elseif($order->status == 'cancelled') Dibatalkan
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Items -->
                <div class="order-body">
                    @foreach($order->items as $item)
                    <div class="order-item">
                        <div>
                            <p class="item-name">{{ $item->product_name }}</p>
                            <p class="item-detail">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <span class="item-subtotal">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <!-- Footer -->
                <div class="order-footer">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="total-label">Total Pesanan:</span>
                            <span class="total-amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('customer.orders.show', $order) }}" class="btn-detail">
                                <i class="fas fa-eye"></i>
                                Detail
                            </a>
                            @if($order->status == 'pending')
                            <form action="{{ route('customer.orders.cancel', $order) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn-cancel" onclick="return confirm('Batalkan pesanan ini?')">
                                    <i class="fas fa-times"></i>
                                    Batalkan
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination dengan tema dark -->
        <div class="pagination">
            {{ $orders->withQueryString()->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Animasi untuk status badges
    document.addEventListener('DOMContentLoaded', function() {
        const badges = document.querySelectorAll('.status-badge');
        badges.forEach((badge, index) => {
            badge.style.animation = `fadeIn 0.5s ease forwards ${index * 0.1}s`;
            badge.style.opacity = '0';
        });
    });

    // Style untuk animasi fadeIn
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush