@extends('layouts.app')

@section('title', 'Checkout')

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
        --bg-dark: #0f172a;
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
    =            HEADER STYLES (DARK THEME)        =
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
    
    .header-accent {
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #10b981, #047857);
        border-radius: 2px;
        margin-top: 12px;
    }

    /*==============================================
    =            CHECKOUT CARD (DARK THEME)        =
    ==============================================*/
    .checkout-card {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(8px);
        border-radius: 24px;
        padding: 28px;
        border: 1px solid rgba(16, 185, 129, 0.2);
        transition: all 0.3s ease;
    }
    
    .checkout-card:hover {
        box-shadow: 0 20px 40px -15px rgba(16, 185, 129, 0.3);
        border-color: rgba(16, 185, 129, 0.4);
    }
    
    .card-title {
        font-size: 20px;
        font-weight: 700;
        color: white;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .title-icon {
        width: 40px;
        height: 40px;
        background: rgba(16, 185, 129, 0.15);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .title-icon i {
        font-size: 18px;
        color: #10b981;
    }
    
    /*==============================================
    =            FORM STYLES (DARK THEME)          =
    ==============================================*/
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 8px;
    }
    
    .form-label i {
        color: #10b981;
        margin-right: 6px;
    }
    
    .form-label .required {
        color: #ef4444;
        margin-left: 2px;
    }
    
    .form-input {
        width: 100%;
        padding: 12px 16px;
        background: rgba(55, 65, 81, 0.5);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 16px;
        color: white;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        background: rgba(55, 65, 81, 0.8);
    }
    
    .form-input::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }
    
    .form-input.error {
        border-color: #ef4444;
    }
    
    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    /*==============================================
    =            PAYMENT METHODS (DARK THEME)       =
    ==============================================*/
    .payment-method {
        background: rgba(55, 65, 81, 0.3);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 20px;
        padding: 20px;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    
    .payment-method:hover {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.1);
        transform: translateY(-2px);
    }
    
    .payment-method.selected {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.15);
        box-shadow: 0 10px 20px -10px rgba(16, 185, 129, 0.3);
    }
    
    .payment-method input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .payment-method .check-indicator {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }
    
    .payment-method.selected .check-indicator {
        border-color: #10b981;
        background: #10b981;
    }
    
    .payment-method.selected .check-indicator::after {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        color: white;
        font-size: 14px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    
    .payment-icon {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .payment-icon.transfer {
        background: rgba(37, 99, 235, 0.15);
        color: #3b82f6;
    }
    
    .payment-icon.cod {
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
    }
    
    .payment-icon.qris {
        background: linear-gradient(135deg, #10b981, #047857);
        color: white;
    }
    
    .payment-title {
        font-weight: 600;
        color: white;
        margin-bottom: 4px;
    }
    
    .payment-desc {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.5);
    }
    
    .qris-badge {
        background: #10b981;
        color: white;
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 999px;
        display: inline-block;
        margin-left: 8px;
        vertical-align: middle;
        font-weight: 600;
    }
    
    /*==============================================
    =            PAYMENT INFO (DARK THEME)         =
    ==============================================*/
    .payment-info {
        background: rgba(55, 65, 81, 0.5);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 20px;
        padding: 20px;
        margin-top: 16px;
    }
    
    .payment-info-title {
        font-size: 14px;
        font-weight: 600;
        color: #10b981;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .payment-info-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed rgba(16, 185, 129, 0.2);
        font-size: 14px;
    }
    
    .payment-info-item:last-child {
        border-bottom: none;
    }
    
    .payment-info-label {
        color: rgba(255, 255, 255, 0.5);
    }
    
    .payment-info-value {
        font-weight: 600;
        color: white;
    }
    
    /*==============================================
    =            ORDER SUMMARY (DARK THEME)        =
    ==============================================*/
    .order-summary {
        background: rgba(31, 41, 55, 0.9);
        backdrop-filter: blur(8px);
        border-radius: 24px;
        padding: 28px;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
    }
    
    .summary-item:last-child {
        border-bottom: none;
    }
    
    .summary-product-name {
        font-weight: 600;
        color: white;
        margin-bottom: 2px;
    }
    
    .summary-product-detail {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.4);
    }
    
    .summary-product-price {
        font-weight: 600;
        color: #10b981;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
    }
    
    .summary-label {
        color: rgba(255, 255, 255, 0.6);
        font-size: 14px;
    }
    
    .summary-value {
        font-weight: 600;
        color: white;
    }
    
    .summary-value.green {
        color: #10b981;
    }
    
    .total-section {
        display: flex;
        justify-content: space-between;
        padding: 16px 0 8px;
        margin-top: 8px;
        border-top: 2px solid rgba(16, 185, 129, 0.3);
    }
    
    .total-label {
        font-size: 18px;
        font-weight: 700;
        color: white;
    }
    
    .total-price {
        font-size: 28px;
        font-weight: 800;
        color: #10b981;
    }
    
    .sticky-sidebar {
        position: sticky;
        top: 100px;
    }
    
    /*==============================================
    =            BUTTON STYLES (DARK THEME)        =
    ==============================================*/
    .btn-checkout {
        background: linear-gradient(135deg, #10b981, #047857);
        color: white;
        padding: 16px 32px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 16px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        border: none;
        cursor: pointer;
        box-shadow: 0 10px 25px -10px rgba(16, 185, 129, 0.5);
    }
    
    .btn-checkout:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 20px 30px -10px rgba(16, 185, 129, 0.7);
    }
    
    .btn-checkout:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .terms-text {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.4);
        text-align: center;
        margin-top: 16px;
    }
    
    .terms-text a {
        color: #10b981;
        font-weight: 600;
        transition: color 0.3s ease;
    }
    
    .terms-text a:hover {
        color: white;
    }
    
    .terms-text i {
        color: #10b981;
    }
    
    /*==============================================
    =            SCROLLBAR STYLES                   =
    ==============================================*/
    .max-h-80::-webkit-scrollbar {
        width: 6px;
    }
    
    .max-h-80::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
    }
    
    .max-h-80::-webkit-scrollbar-thumb {
        background: rgba(16, 185, 129, 0.3);
        border-radius: 10px;
    }
    
    .max-h-80::-webkit-scrollbar-thumb:hover {
        background: #10b981;
    }
    
    /* Alpine.js x-cloak */
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header dengan tema dark -->
    <div class="page-header" data-aos="fade-down">
        <h1>Checkout</h1>
        <p>Selesaikan pesanan Anda dengan mengisi data berikut</p>
        <div class="header-accent"></div>
    </div>

    <form action="{{ route('customer.checkout.process') }}" method="POST" id="checkoutForm">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- LEFT COLUMN - Form Checkout -->
            <div class="lg:col-span-2 space-y-6" data-aos="fade-right">
                
                <!-- INFORMASI PENGIRIMAN -->
                <div class="checkout-card">
                    <h2 class="card-title">
                        <div class="title-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        Informasi Pengiriman
                    </h2>
                    
                    <div class="space-y-4">
                        <!-- Alamat Pengiriman -->
                        <div>
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Alamat Lengkap <span class="required">*</span>
                            </label>
                            <textarea name="shipping_address" rows="3" required
                                      class="form-input @error('shipping_address') error @enderror"
                                      placeholder="Masukkan alamat lengkap">{{ old('shipping_address', $user->address) }}</textarea>
                            @error('shipping_address')
                                <p class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- No Telepon -->
                        <div>
                            <label class="form-label">
                                <i class="fas fa-phone-alt"></i>
                                No. Telepon <span class="required">*</span>
                            </label>
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone', $user->phone) }}" required
                                   class="form-input @error('shipping_phone') error @enderror"
                                   placeholder="08xxxxxxxxxx">
                            @error('shipping_phone')
                                <p class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- METODE PEMBAYARAN -->
                <div class="checkout-card" x-data="{ 
                    paymentMethod: '{{ old('payment_method') }}'
                }">
                    <h2 class="card-title">
                        <div class="title-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        Metode Pembayaran
                    </h2>
                    
                    <div class="space-y-3">
                        <!-- Transfer Bank -->
                        <label class="payment-method block" :class="{ 'selected': paymentMethod === 'transfer' }">
                            <input type="radio" name="payment_method" value="transfer" x-model="paymentMethod" required>
                            <div class="flex items-center">
                                <div class="payment-icon transfer mr-4">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div class="flex-1">
                                    <span class="payment-title">Transfer Bank</span>
                                    <span class="payment-desc">Bayar melalui transfer bank BCA</span>
                                </div>
                            </div>
                            <span class="check-indicator"></span>
                        </label>

                        <!-- COD -->
                        <label class="payment-method block" :class="{ 'selected': paymentMethod === 'cod' }">
                            <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" required>
                            <div class="flex items-center">
                                <div class="payment-icon cod mr-4">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div class="flex-1">
                                    <span class="payment-title">COD (Bayar di Tempat)</span>
                                    <span class="payment-desc">Bayar saat pesanan diterima</span>
                                </div>
                            </div>
                            <span class="check-indicator"></span>
                        </label>

                        <!-- QRIS -->
                        <label class="payment-method block" :class="{ 'selected': paymentMethod === 'qris' }">
                            <input type="radio" name="payment_method" value="qris" x-model="paymentMethod" required>
                            <div class="flex items-center">
                                <div class="payment-icon qris mr-4">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                                <div class="flex-1">
                                    <span class="payment-title">QRIS</span>
                                    <span class="payment-desc">Bayar menggunakan scan QRIS</span>
                                    <span class="qris-badge">SATU QRIS UNTUK SEMUA</span>
                                </div>
                            </div>
                            <span class="check-indicator"></span>
                        </label>

                        <!-- Informasi QRIS (muncul saat dipilih) -->
                        <div x-show="paymentMethod === 'qris'" x-cloak class="payment-info">
                            <div class="payment-info-title">
                                <i class="fas fa-info-circle"></i>
                                Informasi Pembayaran QRIS
                            </div>
                            <div class="payment-info-item">
                                <span class="payment-info-label">Nama Merchant</span>
                                <span class="payment-info-value">WARUNG ONLINE</span>
                            </div>
                            <div class="payment-info-item">
                                <span class="payment-info-label">NMIID</span>
                                <span class="payment-info-value font-mono">ID1026477913564</span>
                            </div>
                            <div class="payment-info-item">
                                <span class="payment-info-label">Versi Cetak</span>
                                <span class="payment-info-value">v0.0.2026.01.28</span>
                            </div>
                            <div class="payment-info-item">
                                <span class="payment-info-label">Dicetak oleh</span>
                                <span class="payment-info-value">93600914</span>
                            </div>
                            <div class="payment-info-item" style="border-bottom: none;">
                                <span class="payment-info-label">Scan QRIS menggunakan</span>
                                <span class="payment-info-value">Mobile Banking / E-Wallet</span>
                            </div>
                        </div>

                        @error('payment_method')
                            <p class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- CATATAN -->
                <div class="checkout-card">
                    <h2 class="card-title">
                        <div class="title-icon">
                            <i class="fas fa-pen"></i>
                        </div>
                        Catatan (Opsional)
                    </h2>
                    
                    <textarea name="notes" rows="3" 
                              class="form-input"
                              placeholder="Contoh: Warna, ukuran, atau instruksi khusus lainnya">{{ old('notes') }}</textarea>
                </div>
            </div>

            <!-- RIGHT COLUMN - Order Summary -->
            <div class="lg:col-span-1" data-aos="fade-left">
                <div class="sticky-sidebar space-y-6">
                    
                    <!-- RINGKASAN PESANAN -->
                    <div class="order-summary">
                        <h2 class="card-title" style="margin-bottom: 16px;">
                            <div class="title-icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            Ringkasan Pesanan
                        </h2>
                        
                        <!-- Daftar Produk -->
                        <div class="max-h-80 overflow-y-auto mb-4 space-y-3 pr-2">
                            @foreach($cartItems as $item)
                            <div class="summary-item">
                                <div class="flex-1">
                                    <p class="summary-product-name">{{ $item->product->name }}</p>
                                    <p class="summary-product-detail">
                                        {{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <span class="summary-product-price">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                            @endforeach
                        </div>

                        <!-- Total -->
                        <div class="space-y-2 pt-4 border-t border-gray-700">
                            <div class="summary-row">
                                <span class="summary-label">Subtotal</span>
                                <span class="summary-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Ongkos Kirim</span>
                                <span class="summary-value green">Gratis</span>
                            </div>
                            <div class="total-section">
                                <span class="total-label">Total</span>
                                <span class="total-price">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- TOMBOL CHECKOUT -->
                    <button type="submit" class="btn-checkout" id="submitBtn">
                        <i class="fas fa-check-circle"></i>
                        Buat Pesanan
                    </button>
                    
                    <p class="terms-text">
                        <i class="fas fa-lock"></i>
                        Dengan melanjutkan, Anda menyetujui 
                        <a href="#">Syarat & Ketentuan</a>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Copy QRIS information
    function copyQrisInfo() {
        const qrisInfo = `QRIS Warung Online
NMIID: ID1026477913564
SATU QRIS UNTUK SEMUA
www.aspi-qris.id`;
        
        navigator.clipboard.writeText(qrisInfo).then(() => {
            showNotification('Informasi QRIS berhasil disalin!', 'success');
        }).catch(() => {
            showNotification('Informasi QRIS:\n' + qrisInfo, 'info');
        });
    }

    // Fungsi untuk menampilkan notifikasi mewah
    function showNotification(message, type = 'success') {
        // Hapus notifikasi yang sudah ada
        const existingNotification = document.querySelector('.notification-toast');
        if (existingNotification) {
            existingNotification.remove();
        }
        
        // Buat elemen notifikasi
        const notification = document.createElement('div');
        notification.className = 'notification-toast';
        
        // Set icon berdasarkan tipe
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        const bgColor = type === 'success' ? 'linear-gradient(135deg, #10b981, #047857)' : 'linear-gradient(135deg, #ef4444, #b91c1c)';
        
        notification.innerHTML = `
            <div class="notification-content" style="background: ${bgColor};">
                <div class="notification-icon">
                    <i class="fas ${icon}"></i>
                </div>
                <div class="notification-message">
                    <div class="notification-title">${type === 'success' ? 'Berhasil!' : 'Informasi'}</div>
                    <div class="notification-text">${message}</div>
                </div>
                <button class="notification-close" onclick="this.closest('.notification-toast').remove()">
                    <i class="fas fa-times"></i>
                </button>
                <div class="notification-progress"></div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto hide setelah 4 detik
        setTimeout(() => {
            if (notification && notification.parentElement) {
                notification.classList.add('hide');
                setTimeout(() => {
                    if (notification && notification.parentElement) {
                        notification.remove();
                    }
                }, 500);
            }
        }, 4000);
    }

    // Prevent double submit
    document.getElementById('checkoutForm')?.addEventListener('submit', function(e) {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
    });

    // Tampilkan notifikasi error jika ada dari session
    @if(session('error'))
        showNotification('{{ session('error') }}', 'error');
    @endif

    @if(session('success'))
        showNotification('{{ session('success') }}', 'success');
    @endif
</script>
@endpush