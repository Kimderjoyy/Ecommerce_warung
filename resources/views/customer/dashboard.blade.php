@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    /*==============================================
    =            VARIABLES                          =
    ==============================================*/
    :root {
        --primary: #10b981;
        --primary-dark: #047857;
        --primary-light: rgba(16, 185, 129, 0.15);
        --bg-card: rgba(31, 41, 55, 0.8);
    }

    /*==============================================
    =            WELCOME SECTION (DARK THEME)      =
    ==============================================*/
    .welcome-section {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(4, 120, 87, 0.3) 100%);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: 32px;
        padding: 32px;
        position: relative;
        overflow: hidden;
        margin-bottom: 32px;
    }
    
    .welcome-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 20s infinite;
    }
    
    .welcome-section::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 15s infinite reverse;
    }
    
    @keyframes float {
        0% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(30px, -30px) rotate(120deg); }
        66% { transform: translate(-30px, 30px) rotate(240deg); }
        100% { transform: translate(0, 0) rotate(360deg); }
    }
    
    .welcome-content {
        position: relative;
        z-index: 10;
    }
    
    .welcome-title {
        font-size: 32px;
        font-weight: 700;
        color: white;
        margin-bottom: 8px;
    }
    
    .welcome-text {
        color: rgba(255, 255, 255, 0.8);
        font-size: 18px;
    }
    
    /*==============================================
    =            STATISTICS CARDS (DARK THEME)     =
    ==============================================*/
    .stat-card {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 24px;
        padding: 24px;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -15px rgba(16, 185, 129, 0.3);
        border-color: rgba(16, 185, 129, 0.4);
    }
    
    .stat-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 14px;
        margin-bottom: 8px;
    }
    
    .stat-value {
        font-size: 36px;
        font-weight: 700;
        color: white;
        line-height: 1.2;
    }
    
    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .stat-icon.primary {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
    }
    
    .stat-icon.warning {
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
    }
    
    .stat-icon.purple {
        background: rgba(139, 92, 246, 0.15);
        color: #a78bfa;
    }
    
    .stat-icon i {
        font-size: 24px;
    }
    
    .gradient-text {
        background: linear-gradient(135deg, #10b981, #047857);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /*==============================================
    =            RECENT ORDERS TABLE (DARK THEME)  =
    ==============================================*/
    .recent-orders-card {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 24px;
        padding: 24px;
        transition: all 0.3s ease;
    }
    
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }
    
    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: white;
        margin: 0;
    }
    
    .section-subtitle {
        color: rgba(255, 255, 255, 0.5);
        font-size: 14px;
        margin-top: 4px;
    }
    
    .view-all-btn {
        padding: 10px 20px;
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: 999px;
        color: #10b981;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .view-all-btn:hover {
        background: #10b981;
        color: white;
        border-color: transparent;
        transform: translateX(5px);
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .orders-table th {
        text-align: left;
        padding: 16px 12px;
        font-size: 12px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .orders-table td {
        padding: 16px 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
    }
    
    .orders-table tr:hover td {
        background: rgba(55, 65, 81, 0.5);
    }
    
    .order-number {
        font-family: monospace;
        font-weight: 600;
        color: white;
    }
    
    .order-amount {
        font-weight: 600;
        color: #10b981;
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge i {
        font-size: 8px;
    }
    
    .badge-success {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .badge-info {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
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
    
    .badge-gray {
        background: rgba(107, 114, 128, 0.15);
        color: #9ca3af;
        border: 1px solid rgba(107, 114, 128, 0.3);
    }
    
    .action-link {
        color: #10b981;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .action-link:hover {
        color: white;
        transform: translateX(3px);
    }
    
    /*==============================================
    =            EMPTY STATE (DARK THEME)          =
    ==============================================*/
    .empty-state {
        text-align: center;
        padding: 48px 24px;
    }
    
    .empty-icon {
        width: 80px;
        height: 80px;
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .empty-icon i {
        font-size: 36px;
        color: #10b981;
    }
    
    .empty-title {
        font-size: 18px;
        font-weight: 600;
        color: white;
        margin-bottom: 8px;
    }
    
    .empty-text {
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 20px;
    }
    
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        background: linear-gradient(135deg, #10b981, #047857);
        color: white;
        border-radius: 999px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px -10px rgba(16, 185, 129, 0.5);
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 30px -10px rgba(16, 185, 129, 0.7);
    }
    
    /*==============================================
    =            QUICK ACTIONS (DARK THEME)        =
    ==============================================*/
    .quick-action-card {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 20px;
        padding: 20px;
        transition: all 0.3s ease;
        display: block;
    }
    
    .quick-action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -15px rgba(16, 185, 129, 0.3);
        border-color: rgba(16, 185, 129, 0.4);
    }
    
    .quick-action-content {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    
    .quick-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .quick-action-card:hover .quick-icon {
        transform: scale(1.1);
    }
    
    .quick-icon.green {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
    }
    
    .quick-icon.blue {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
    }
    
    .quick-icon.purple {
        background: rgba(139, 92, 246, 0.15);
        color: #a78bfa;
    }
    
    .quick-icon i {
        font-size: 24px;
    }
    
    .quick-title {
        font-weight: 600;
        color: white;
        margin-bottom: 4px;
    }
    
    .quick-subtitle {
        color: rgba(255, 255, 255, 0.5);
        font-size: 13px;
    }
</style>
@endpush

@section('content')
<div class="space-y-8">

    <!-- Welcome Section dengan tema dark -->
    <div class="welcome-section" data-aos="fade-down">
        <div class="welcome-content">
            <h1 class="welcome-title">Halo, {{ Auth::user()->name }}! 👋</h1>
            <p class="welcome-text">Selamat datang di dashboard Anda. Kelola pesanan dan profile Anda di sini.</p>
        </div>
    </div>

    <!-- Statistics Cards dengan tema dark -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-label">Total Pesanan</p>
                    <h3 class="stat-value">{{ $totalOrders }}</h3>
                </div>
                <div class="stat-icon primary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-label">Menunggu</p>
                    <h3 class="stat-value">{{ $pendingOrders }}</h3>
                </div>
                <div class="stat-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-label">Selesai</p>
                    <h3 class="stat-value">{{ $completedOrders }}</h3>
                </div>
                <div class="stat-icon primary">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="stat-label">Total Belanja</p>
                    <h3 class="stat-value gradient-text">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h3>
                </div>
                <div class="stat-icon purple">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders dengan tema dark -->
    <div class="recent-orders-card" data-aos="fade-up">
        <div class="section-header">
            <div>
                <h2 class="section-title">Pesanan Terbaru</h2>
                <p class="section-subtitle">5 pesanan terakhir Anda</p>
            </div>
            <a href="{{ route('customer.orders') }}" class="view-all-btn">
                Lihat Semua
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        @if($recentOrders->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <h3 class="empty-title">Belum ada pesanan</h3>
            <p class="empty-text">Yuk, mulai belanja kebutuhan Anda!</p>
            <a href="{{ route('customer.products.index') }}" class="btn-primary">
                <i class="fas fa-store mr-2"></i>
                Belanja Sekarang
            </a>
        </div>
        @else
        <div class="table-container">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>No. Order</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>
                            <span class="order-number">#{{ $order->order_number }}</span>
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td class="order-amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge 
                                @if($order->status == 'delivered') badge-success
                                @elseif($order->status == 'processing') badge-info
                                @elseif($order->status == 'shipped') badge-warning
                                @elseif($order->status == 'cancelled') badge-danger
                                @else badge-gray @endif">
                                <i class="fas fa-circle"></i>
                                @if($order->status == 'pending') Menunggu
                                @elseif($order->status == 'processing') Diproses
                                @elseif($order->status == 'shipped') Dikirim
                                @elseif($order->status == 'delivered') Selesai
                                @elseif($order->status == 'cancelled') Dibatalkan
                                @endif
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('customer.orders.show', $order) }}" class="action-link">
                                <i class="fas fa-eye"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <!-- Quick Actions dengan tema dark -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('customer.products.index') }}"
           class="quick-action-card"
           data-aos="fade-up" data-aos-delay="100">
            <div class="quick-action-content">
                <div class="quick-icon green">
                    <i class="fas fa-store"></i>
                </div>
                <div>
                    <h4 class="quick-title">Belanja Lagi</h4>
                    <p class="quick-subtitle">Jelajahi produk terbaru</p>
                </div>
            </div>
        </a>

        <a href="{{ route('customer.profile') }}"
           class="quick-action-card"
           data-aos="fade-up" data-aos-delay="200">
            <div class="quick-action-content">
                <div class="quick-icon blue">
                    <i class="fas fa-user-cog"></i>
                </div>
                <div>
                    <h4 class="quick-title">Edit Profil</h4>
                    <p class="quick-subtitle">Perbarui data diri</p>
                </div>
            </div>
        </a>

        <a href="{{ route('customer.orders') }}"
           class="quick-action-card"
           data-aos="fade-up" data-aos-delay="300">
            <div class="quick-action-content">
                <div class="quick-icon purple">
                    <i class="fas fa-history"></i>
                </div>
                <div>
                    <h4 class="quick-title">Riwayat Pesanan</h4>
                    <p class="quick-subtitle">Lihat semua pesanan</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection