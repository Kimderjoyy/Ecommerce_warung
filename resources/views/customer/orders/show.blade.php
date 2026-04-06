@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number)

@push('styles')
<style>
    /*==============================================
    =            VARIABLES & UTILITY                =
    ==============================================*/
    :root {
        --primary: #10b981;
        --primary-dark: #047857;
        --primary-light: rgba(16, 185, 129, 0.15);
        --secondary: #f59e0b;
        --danger: #ef4444;
        --success: #10b981;
        --warning: #f59e0b;
        --info: #3b82f6;
        --bg-dark: #0f172a;
        --card-dark: rgba(31, 41, 55, 0.8);
    }

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
    =            CARD STYLES (DARK THEME)           =
    ==============================================*/
    .detail-card {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(8px);
        border-radius: 24px;
        padding: 24px;
        border: 1px solid rgba(16, 185, 129, 0.2);
        transition: all 0.3s ease;
        height: fit-content;
    }
    
    .detail-card:hover {
        box-shadow: 0 20px 40px -15px rgba(16, 185, 129, 0.3);
        border-color: rgba(16, 185, 129, 0.4);
    }
    
    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }
    
    .section-icon {
        width: 40px;
        height: 40px;
        background: rgba(16, 185, 129, 0.15);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #10b981;
        font-size: 18px;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .section-title h2 {
        font-size: 20px;
        font-weight: 700;
        color: white;
        margin: 0;
    }
    
    .section-title p {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.5);
        margin: 2px 0 0 0;
    }
    
    /*==============================================
    =            HEADER STYLES                      =
    ==============================================*/
    .page-header {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 32px;
    }
    
    @media (min-width: 768px) {
        .page-header {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }
    
    .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .header-icon {
        width: 56px;
        height: 56px;
        background: rgba(16, 185, 129, 0.15);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .header-icon i {
        font-size: 24px;
        color: #10b981;
    }
    
    .header-title {
        font-size: 28px;
        font-weight: 700;
        color: white;
        margin-bottom: 4px;
    }
    
    .header-subtitle {
        display: flex;
        align-items: center;
        gap: 12px;
        color: rgba(255, 255, 255, 0.5);
        font-size: 14px;
    }
    
    .header-subtitle i {
        color: #10b981;
    }
    
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: rgba(31, 41, 55, 0.6);
        border: 1px solid rgba(16, 185, 129, 0.2);
        backdrop-filter: blur(8px);
        border-radius: 999px;
        color: rgba(255, 255, 255, 0.7);
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .back-button:hover {
        border-color: #10b981;
        color: white;
        transform: translateX(-5px);
        background: rgba(31, 41, 55, 0.8);
    }
    
    /*==============================================
    =            BADGE STYLES (DARK THEME)          =
    ==============================================*/
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        backdrop-filter: blur(4px);
    }
    
    .badge i {
        font-size: 8px;
    }
    
    .badge.pending {
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    
    .badge.processing {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }
    
    .badge.shipped {
        background: rgba(139, 92, 246, 0.15);
        color: #a78bfa;
        border: 1px solid rgba(139, 92, 246, 0.3);
    }
    
    .badge.delivered {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .badge.cancelled {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    .badge.paid {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .badge.unpaid {
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    
    /*==============================================
    =            TIMELINE STYLES (DARK THEME)       =
    ==============================================*/
    .timeline-wrapper {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(8px);
        border-radius: 32px;
        padding: 32px;
        border: 1px solid rgba(16, 185, 129, 0.2);
        margin-bottom: 32px;
    }
    
    .timeline-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 40px;
    }
    
    .timeline-header-icon {
        width: 56px;
        height: 56px;
        background: rgba(16, 185, 129, 0.15);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .timeline-header-icon i {
        font-size: 24px;
        color: #10b981;
    }
    
    .timeline-header h3 {
        font-size: 20px;
        font-weight: 700;
        color: white;
        margin: 0;
    }
    
    .timeline-header p {
        color: rgba(255, 255, 255, 0.5);
        font-size: 14px;
        margin: 4px 0 0 0;
    }
    
    .timeline-grid {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-step {
        flex: 1;
        text-align: center;
        position: relative;
        z-index: 2;
    }
    
    .timeline-marker {
        width: 64px;
        height: 64px;
        border-radius: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 24px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .timeline-marker.completed {
        background: linear-gradient(135deg, #10b981, #047857);
        color: white;
        box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
    }
    
    .timeline-marker.current {
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
        border: 2px solid #fbbf24;
        animation: pulse 2s infinite;
    }
    
    .timeline-marker.pending {
        background: rgba(75, 85, 99, 0.3);
        color: rgba(255, 255, 255, 0.3);
        border: 2px solid rgba(255, 255, 255, 0.1);
    }
    
    .timeline-label {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 4px;
    }
    
    .timeline-label.completed {
        color: white;
    }
    
    .timeline-label.pending {
        color: rgba(255, 255, 255, 0.3);
    }
    
    .timeline-date {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.3);
    }
    
    .timeline-progress {
        position: absolute;
        top: 32px;
        left: 0;
        right: 0;
        height: 2px;
        background: rgba(255, 255, 255, 0.1);
        z-index: 1;
    }
    
    .timeline-progress-fill {
        height: 2px;
        background: linear-gradient(90deg, #10b981, #047857);
        transition: width 0.5s ease;
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 0 0 10px rgba(245, 158, 11, 0);
        }
    }
    
    /*==============================================
    =            TABLE STYLES (DARK THEME)          =
    ==============================================*/
    .product-table-container {
        overflow-x: auto;
        margin-top: 16px;
    }
    
    .product-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .product-table th {
        text-align: left;
        padding: 12px 16px;
        font-size: 12px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: rgba(55, 65, 81, 0.5);
        border-bottom: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .product-table td {
        padding: 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.8);
    }
    
    .product-table tbody tr:hover {
        background: rgba(55, 65, 81, 0.3);
    }
    
    .product-table tfoot td {
        background: rgba(55, 65, 81, 0.5);
        padding: 16px;
        font-weight: 600;
        border-top: 2px solid rgba(16, 185, 129, 0.2);
        color: white;
    }
    
    .product-name {
        font-weight: 600;
        color: white;
    }
    
    .product-price, .product-qty {
        color: rgba(255, 255, 255, 0.6);
    }
    
    .product-subtotal {
        font-weight: 700;
        color: #10b981;
    }
    
    .total-amount {
        font-size: 20px;
        font-weight: 800;
        color: #10b981;
    }
    
    /*==============================================
    =            INFO CARD STYLES (DARK THEME)      =
    ==============================================*/
    .info-grid {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    
    .info-icon-wrapper {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .info-icon-wrapper.shipping {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
    }
    
    .info-icon-wrapper.payment {
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
    }
    
    .info-content {
        flex: 1;
    }
    
    .info-label {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    
    .info-value {
        font-size: 16px;
        font-weight: 600;
        color: white;
        line-height: 1.4;
    }
    
    /*==============================================
    =            NOTES STYLES                       =
    ==============================================*/
    .notes-content {
        background: rgba(55, 65, 81, 0.5);
        border-radius: 20px;
        padding: 20px;
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.6;
    }
    
    /*==============================================
    =            PAYMENT INSTRUCTION (DARK THEME)   =
    ==============================================*/
    .instruction-card {
        background: rgba(55, 65, 81, 0.5);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 20px;
        padding: 20px;
        margin-top: 20px;
    }
    
    .instruction-title {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #10b981;
        font-weight: 600;
        font-size: 15px;
        margin-bottom: 16px;
    }
    
    .bank-detail {
        background: rgba(31, 41, 55, 0.8);
        border-radius: 16px;
        padding: 16px;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .bank-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .bank-row:last-child {
        border-bottom: none;
    }
    
    .bank-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 14px;
    }
    
    .bank-value {
        font-weight: 600;
        color: white;
    }
    
    .deadline {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 16px;
        font-size: 14px;
        color: #fbbf24;
        background: rgba(245, 158, 11, 0.1);
        padding: 12px;
        border-radius: 12px;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }
    
    .copy-btn {
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #10b981;
        padding: 10px 20px;
        border-radius: 999px;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
        margin-top: 16px;
        width: 100%;
        justify-content: center;
    }
    
    .copy-btn:hover {
        background: #10b981;
        color: white;
        border-color: transparent;
    }
    
    .qris-display {
        text-align: center;
    }
    
    .qris-display img {
        max-width: 200px;
        margin: 0 auto 16px;
        border-radius: 20px;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .qris-display p {
        color: rgba(255, 255, 255, 0.8);
    }
    
    .qris-display .text-xs {
        color: rgba(255, 255, 255, 0.4);
    }
    
    /*==============================================
    =            ACTION BUTTONS (DARK THEME)        =
    ==============================================*/
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 24px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        width: 100%;
        backdrop-filter: blur(4px);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #10b981, #047857);
        color: white;
        box-shadow: 0 10px 20px -10px rgba(16, 185, 129, 0.5);
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 30px -10px rgba(16, 185, 129, 0.7);
    }
    
    .btn-danger {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    .btn-danger:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-3px);
        border-color: transparent;
    }
    
    .btn-wa {
        background: rgba(37, 211, 102, 0.15);
        color: #25D366;
        border: 1px solid rgba(37, 211, 102, 0.3);
    }
    
    .btn-wa:hover {
        background: #25D366;
        color: white;
        transform: translateY(-3px);
        border-color: transparent;
    }
    
    /*==============================================
    =            MODAL STYLES (DARK THEME)          =
    ==============================================*/
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(8px);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    
    .modal-content {
        background: rgba(31, 41, 55, 0.95);
        backdrop-filter: blur(8px);
        border-radius: 32px;
        padding: 32px;
        max-width: 450px;
        width: 100%;
        text-align: center;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    .modal-icon {
        width: 80px;
        height: 80px;
        background: rgba(239, 68, 68, 0.15);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    .modal-icon i {
        font-size: 36px;
        color: #ef4444;
    }
    
    .modal-title {
        font-size: 24px;
        font-weight: 700;
        color: white;
        margin-bottom: 12px;
    }
    
    .modal-text {
        color: rgba(255, 255, 255, 0.6);
        margin-bottom: 24px;
        font-size: 15px;
        line-height: 1.6;
    }
    
    .modal-actions {
        display: flex;
        gap: 12px;
    }
    
    .modal-btn {
        flex: 1;
        padding: 14px;
        border-radius: 999px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        font-size: 14px;
    }
    
    .modal-btn.cancel {
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .modal-btn.cancel:hover {
        background: rgba(255, 255, 255, 0.15);
        color: white;
    }
    
    .modal-btn.confirm {
        background: #ef4444;
        color: white;
    }
    
    .modal-btn.confirm:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -10px rgba(239, 68, 68, 0.5);
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header dengan tema dark -->
    <div class="page-header">
        <div class="flex items-start gap-4">
            <div class="header-icon">
                <i class="fas fa-receipt"></i>
            </div>
            <div>
                <h1 class="header-title">Detail Pesanan</h1>
                <div class="header-subtitle">
                    <span><i class="fas fa-hashtag"></i> No. Pesanan: {{ $order->order_number }}</span>
                    <span class="badge {{ $order->status }}">
                        <i class="fas fa-circle"></i>
                        @if($order->status == 'pending') Menunggu Konfirmasi
                        @elseif($order->status == 'processing') Sedang Diproses
                        @elseif($order->status == 'shipped') Dalam Pengiriman
                        @elseif($order->status == 'delivered') Selesai
                        @elseif($order->status == 'cancelled') Dibatalkan
                        @endif
                    </span>
                </div>
            </div>
        </div>
        <a href="{{ route('customer.orders') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Timeline dengan tema dark -->
    <div class="timeline-wrapper">
        <div class="timeline-header">
            <div class="timeline-header-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <h3>Status Pesanan</h3>
                <p>Lacak status pesanan Anda</p>
            </div>
        </div>
        
        <div class="timeline-grid">
            <!-- Pending -->
            <div class="timeline-step">
                <div class="timeline-marker 
                    {{ in_array($order->status, ['pending', 'processing', 'shipped', 'delivered']) ? 'completed' : 'pending' }}">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="timeline-label {{ in_array($order->status, ['pending', 'processing', 'shipped', 'delivered']) ? 'completed' : 'pending' }}">
                    Pending
                </div>
                <div class="timeline-date">{{ $order->created_at->format('d/m/Y') }}</div>
            </div>

            <!-- Processing -->
            <div class="timeline-step">
                <div class="timeline-marker 
                    {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : 
                       ($order->status == 'pending' ? 'pending' : '') }}">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="timeline-label {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : 'pending' }}">
                    Diproses
                </div>
                <div class="timeline-date">-</div>
            </div>

            <!-- Shipped -->
            <div class="timeline-step">
                <div class="timeline-marker 
                    {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : 
                       ($order->status == 'processing' ? 'current' : 'pending') }}">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="timeline-label {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : 'pending' }}">
                    Dikirim
                </div>
                <div class="timeline-date">-</div>
            </div>

            <!-- Delivered -->
            <div class="timeline-step">
                <div class="timeline-marker 
                    {{ $order->status == 'delivered' ? 'completed' : 
                       ($order->status == 'shipped' ? 'current' : 'pending') }}">
                    <i class="fas fa-check"></i>
                </div>
                <div class="timeline-label {{ $order->status == 'delivered' ? 'completed' : 'pending' }}">
                    Selesai
                </div>
                <div class="timeline-date">-</div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="timeline-progress">
            <div class="timeline-progress-fill" style="width: 
                @if($order->status == 'delivered') 100%
                @elseif($order->status == 'shipped') 75%
                @elseif($order->status == 'processing') 50%
                @elseif($order->status == 'pending') 25%
                @else 0% @endif">
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Products -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Products Detail -->
            <div class="detail-card">
                <div class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div>
                        <h2>Detail Produk</h2>
                        <p>Daftar produk yang dipesan</p>
                    </div>
                </div>
                
                <div class="product-table-container">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="product-name">{{ $item->product_name }}</td>
                                <td class="product-price">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="product-qty">{{ $item->quantity }}</td>
                                <td class="product-subtotal">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right font-semibold">Total</td>
                                <td class="total-amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Notes -->
            @if($order->notes)
            <div class="detail-card">
                <div class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-pen"></i>
                    </div>
                    <div>
                        <h2>Catatan Pesanan</h2>
                        <p>Instruksi khusus dari pembeli</p>
                    </div>
                </div>
                <div class="notes-content">
                    {{ $order->notes }}
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Info & Actions -->
        <div class="space-y-6">
            <!-- Shipping Info -->
            <div class="detail-card">
                <div class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div>
                        <h2>Pengiriman</h2>
                        <p>Informasi pengiriman pesanan</p>
                    </div>
                </div>
                
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-icon-wrapper shipping">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Alamat Pengiriman</div>
                            <div class="info-value">{{ $order->shipping_address }}</div>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-icon-wrapper shipping">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">No. Telepon</div>
                            <div class="info-value">{{ $order->shipping_phone }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="detail-card">
                <div class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div>
                        <h2>Pembayaran</h2>
                        <p>Informasi metode pembayaran</p>
                    </div>
                </div>
                
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-icon-wrapper payment">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Metode</div>
                            <div class="info-value">
                                @if($order->payment_method == 'transfer') Transfer Bank
                                @elseif($order->payment_method == 'cod') COD (Bayar di Tempat)
                                @elseif($order->payment_method == 'qris') QRIS
                                @else {{ ucfirst($order->payment_method) }}
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-icon-wrapper payment">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Status</div>
                            <div>
                                <span class="badge {{ $order->payment_status == 'paid' ? 'paid' : 'unpaid' }}">
                                    <i class="fas fa-circle"></i>
                                    @if($order->payment_status == 'paid') Lunas
                                    @elseif($order->payment_status == 'failed') Gagal
                                    @else Menunggu
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Instructions -->
                @if($order->payment_method == 'transfer' && $order->payment_status == 'pending')
                <div class="instruction-card">
                    <div class="instruction-title">
                        <i class="fas fa-info-circle"></i>
                        Instruksi Pembayaran
                    </div>
                    
                    <div class="bank-detail">
                        <div class="bank-row">
                            <span class="bank-label">Bank</span>
                            <span class="bank-value">BCA</span>
                        </div>
                        <div class="bank-row">
                            <span class="bank-label">No. Rekening</span>
                            <span class="bank-value font-mono">1673016921</span>
                        </div>
                        <div class="bank-row">
                            <span class="bank-label">Atas Nama</span>
                            <span class="bank-value">MUHAMMAD AHDANIL HAKIM</span>
                        </div>
                        <div class="bank-row">
                            <span class="bank-label">Total Transfer</span>
                            <span class="bank-value text-green-500 font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="deadline">
                        <i class="fas fa-clock"></i>
                        <span>Lakukan pembayaran sebelum {{ $order->created_at->addHours(24)->format('d M Y H:i') }}</span>
                    </div>
                    
                    <button onclick="copyBankInfo()" class="copy-btn">
                        <i class="fas fa-copy"></i>
                        Salin Info Bank
                    </button>
                </div>
                @endif

                @if($order->payment_method == 'qris' && $order->payment_status == 'pending')
                <div class="instruction-card qris-display">
                    <img src="{{ asset('images/qris-warungonline.png') }}" alt="QRIS">
                    <p class="font-semibold text-green-500 mb-1">Scan QRIS untuk membayar</p>
                    <p class="text-xs text-gray-400">Gunakan aplikasi mobile banking</p>
                </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="action-buttons">
                @if($order->status == 'pending')
                <button onclick="showCancelModal()" class="btn btn-danger">
                    <i class="fas fa-times"></i>
                    Batalkan Pesanan
                </button>
                @endif

                @if($order->status == 'shipped')
                <form action="{{ route('customer.orders.received', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i>
                        Pesanan Diterima
                    </button>
                </form>
                @endif

                @if(in_array($order->status, ['pending', 'processing', 'shipped']))
                <a href="https://wa.me/6281234567890?text=Halo%20admin,%20saya%20ingin%20bertanya%20tentang%20pesanan%20#{{ $order->order_number }}" 
                   target="_blank"
                   class="btn btn-wa">
                    <i class="fab fa-whatsapp"></i>
                    Hubungi Admin
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal dengan tema dark -->
<div id="cancelModal" class="fixed inset-0 z-50 hidden" style="display: none;">
    <div class="modal-overlay" onclick="closeCancelModal()">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="modal-title">Batalkan Pesanan?</h3>
            <p class="modal-text">
                Apakah Anda yakin ingin membatalkan pesanan #{{ $order->order_number }}? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="modal-actions">
                <button onclick="closeCancelModal()" class="modal-btn cancel">
                    Tidak, Kembali
                </button>
                <form action="{{ route('customer.orders.cancel', $order) }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="modal-btn confirm">
                        Ya, Batalkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Copy bank information
    function copyBankInfo() {
        const bankInfo = `BCA
No. Rekening: 1673016921
Atas Nama: MUHAMMAD AHDANIL HAKIM
Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}`;
        
        navigator.clipboard.writeText(bankInfo).then(() => {
            alert('Informasi bank berhasil disalin!');
        }).catch(() => {
            alert('Informasi bank:\n' + bankInfo);
        });
    }

    // Cancel modal functions
    function showCancelModal() {
        document.getElementById('cancelModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeCancelModal() {
        document.getElementById('cancelModal').style.display = 'none';
        document.body.style.overflow = '';
    }

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCancelModal();
        }
    });
</script>
@endpush