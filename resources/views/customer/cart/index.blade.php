@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@push('styles')
<style>
    /*==============================================
    =                 VARIABLES CSS                 =
    ==============================================*/
    :root {
        --primary: #10b981;
        --primary-dark: #047857;
        --primary-light: rgba(16, 185, 129, 0.1);
        --bg-card: rgba(17, 24, 39, 0.8);
        --bg-dark: #0f172a;
        --text-primary: #f9fafb;
        --text-secondary: #94a3b8;
        --border-color: rgba(16, 185, 129, 0.2);
        --danger: #ef4444;
        --danger-light: rgba(239, 68, 68, 0.1);
        --success: #10b981;
        --warning: #fbbf24;
    }

    /*==============================================
    =              NOTIFICATION TOAST               =
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

    /* Animations */
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
        from { width: 100%; }
        to { width: 0%; }
    }

    /*==============================================
    =                PAGE HEADER                    =
    ==============================================*/
    .cart-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    
    .page-header {
        margin-bottom: 2.5rem;
        position: relative;
    }
    
    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }
    
    .page-header p {
        color: var(--text-secondary);
        font-size: 1rem;
    }
    
    .header-accent {
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        border-radius: 2px;
        margin-top: 1rem;
    }

    /*==============================================
    =              CART ITEMS SECTION               =
    ==============================================*/
    .cart-items-card {
        background: var(--bg-card);
        backdrop-filter: blur(8px);
        border-radius: 1.5rem;
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .cart-items-header {
        display: grid;
        grid-template-columns: 3fr 1fr 1fr 1fr 80px;
        padding: 1.25rem 1.5rem;
        background: rgba(55, 65, 81, 0.3);
        border-bottom: 1px solid var(--border-color);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-secondary);
    }
    
    /* Cart Item */
    .cart-item {
        display: grid;
        grid-template-columns: 3fr 1fr 1fr 1fr 80px;
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
        align-items: center;
    }
    
    .cart-item:last-child {
        border-bottom: none;
    }
    
    .cart-item:hover {
        background: rgba(255, 255, 255, 0.02);
    }
    
    /* Product Info */
    .product-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .product-image {
        width: 90px;
        height: 90px;
        border-radius: 1rem;
        overflow: hidden;
        border: 2px solid var(--border-color);
        transition: all 0.3s ease;
        flex-shrink: 0;
        background: linear-gradient(135deg, #1f2937, #111827);
    }
    
    .product-image:hover {
        border-color: var(--primary);
        transform: scale(1.02);
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-image-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #1f2937, #111827);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .product-image-placeholder i {
        font-size: 2rem;
        color: rgba(255, 255, 255, 0.2);
    }
    
    .product-details {
        flex: 1;
    }
    
    .product-name {
        font-size: 1.125rem;
        font-weight: 600;
        color: white;
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
        display: inline-block;
    }
    
    .product-name:hover {
        color: var(--primary);
    }
    
    .product-category {
        font-size: 0.75rem;
        color: var(--text-secondary);
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: rgba(55, 65, 81, 0.5);
        border-radius: 999px;
        border: 1px solid var(--border-color);
        margin-bottom: 0.5rem;
    }
    
    .stock-info {
        font-size: 0.75rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .stock-info i {
        color: var(--primary);
    }
    
    .stock-high {
        color: var(--primary);
        font-weight: 600;
    }
    
    .stock-low {
        color: var(--warning);
        font-weight: 600;
    }
    
    /* Price */
    .product-price {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--primary);
    }
    
    /* Quantity Control */
    .quantity-control {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        background: rgba(55, 65, 81, 0.3);
        border-radius: 2rem;
        border: 1px solid var(--border-color);
        padding: 0.25rem;
        width: fit-content;
    }
    
    .quantity-btn {
        width: 36px;
        height: 36px;
        border-radius: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: none;
        color: var(--text-secondary);
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .quantity-btn:hover:not(:disabled) {
        background: var(--primary);
        color: white;
    }
    
    .quantity-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }
    
    .quantity-input {
        width: 50px;
        text-align: center;
        background: transparent;
        border: none;
        color: white;
        font-weight: 600;
        font-size: 1rem;
    }
    
    .quantity-input:focus {
        outline: none;
    }
    
    /* Subtotal */
    .item-subtotal {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--primary);
    }
    
    /* Remove Button */
    .btn-remove {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--danger-light);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: var(--danger);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-remove:hover {
        background: var(--danger);
        color: white;
        transform: scale(1.1);
    }

    /*==============================================
    =                SUMMARY CARD                   =
    ==============================================*/
    .summary-card {
        background: var(--bg-card);
        backdrop-filter: blur(8px);
        border-radius: 1.5rem;
        border: 1px solid var(--border-color);
        padding: 1.5rem;
        position: sticky;
        top: 100px;
    }
    
    .summary-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.25rem;
        font-weight: 700;
        color: white;
        margin-bottom: 1.5rem;
    }
    
    .summary-icon {
        width: 44px;
        height: 44px;
        background: var(--primary-light);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-color);
    }
    
    .summary-icon i {
        font-size: 1.25rem;
        color: var(--primary);
    }
    
    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
    }
    
    .summary-item:last-of-type {
        border-bottom: none;
    }
    
    .summary-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }
    
    .summary-value {
        font-weight: 600;
        color: white;
    }
    
    .summary-total {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
        margin-top: 0.5rem;
        border-top: 2px solid var(--border-color);
    }
    
    .total-label {
        font-size: 1.125rem;
        font-weight: 700;
        color: white;
    }
    
    .total-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary);
    }

    /*==============================================
    =                  BUTTONS                      =
    ==============================================*/
    .btn-checkout {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 999px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        border: none;
        cursor: pointer;
        box-shadow: 0 10px 20px -10px rgba(16, 185, 129, 0.3);
        margin-top: 1.5rem;
    }
    
    .btn-checkout:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 30px -10px rgba(16, 185, 129, 0.5);
    }
    
    .btn-continue {
        background: transparent;
        color: var(--text-secondary);
        padding: 0.875rem 1.5rem;
        border-radius: 999px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        border: 1px solid var(--border-color);
        margin-top: 0.75rem;
    }
    
    .btn-continue:hover {
        background: var(--primary-light);
        color: var(--primary);
        border-color: var(--primary);
    }
    
    .btn-shop {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 999px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
        box-shadow: 0 10px 20px -10px rgba(16, 185, 129, 0.3);
    }
    
    .btn-shop:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 30px -10px rgba(16, 185, 129, 0.5);
    }

    /*==============================================
    =                EMPTY CART                     =
    ==============================================*/
    .empty-cart {
        max-width: 500px;
        margin: 3rem auto;
        text-align: center;
        background: var(--bg-card);
        backdrop-filter: blur(8px);
        border-radius: 2rem;
        border: 1px solid var(--border-color);
        padding: 3rem 2rem;
    }
    
    .empty-cart-icon {
        width: 120px;
        height: 120px;
        background: var(--primary-light);
        border-radius: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        border: 1px solid var(--border-color);
    }
    
    .empty-cart-icon i {
        font-size: 3.5rem;
        color: var(--primary);
    }
    
    .empty-cart h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        margin-bottom: 0.75rem;
    }
    
    .empty-cart p {
        color: var(--text-secondary);
        margin-bottom: 2rem;
    }

    /*==============================================
    =                RESPONSIVE                     =
    ==============================================*/
    @media (max-width: 1024px) {
        .cart-items-header {
            display: none;
        }
        
        .cart-item {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .product-info {
            grid-column: 1 / -1;
        }
        
        .product-price,
        .quantity-control,
        .item-subtotal,
        .btn-remove {
            justify-self: start;
        }
    }
    
    @media (max-width: 640px) {
        .page-header h1 {
            font-size: 2rem;
        }
        
        .cart-container {
            padding: 1rem;
        }
        
        .product-image {
            width: 70px;
            height: 70px;
        }
    }
</style>
@endpush

@section('content')
<div class="cart-container">
    {{-- Page Header --}}
    <div class="page-header" data-aos="fade-down">
        <h1>Keranjang Belanja</h1>
        <p>Kelola item belanjaan Anda sebelum checkout</p>
        <div class="header-accent"></div>
    </div>

    @if($cartItems->isEmpty())
        {{-- Empty Cart State --}}
        <div class="empty-cart" data-aos="fade-up">
            <div class="empty-cart-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h3>Keranjang Belanja Kosong</h3>
            <p>Yuk, mulai belanja kebutuhan warung Anda!</p>
            <a href="{{ route('customer.products.index') }}" class="btn-shop">
                <i class="fas fa-store mr-2"></i>
                Belanja Sekarang
            </a>
        </div>
    @else
        {{-- Cart Content --}}
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Cart Items Section --}}
            <div class="lg:col-span-2" data-aos="fade-right">
                <div class="cart-items-card">
                    {{-- Table Header (Desktop Only) --}}
                    <div class="cart-items-header">
                        <div>Produk</div>
                        <div>Harga</div>
                        <div>Jumlah</div>
                        <div>Subtotal</div>
                        <div></div>
                    </div>
                    
                    {{-- Cart Items List --}}
                    @foreach($cartItems as $item)
                    <div class="cart-item" data-cart-id="{{ $item->id }}">
                        {{-- Product Info --}}
                        <div class="product-info">
                            {{-- Product Image --}}
                            <a href="{{ route('customer.products.show', $item->product->slug) }}" class="product-image">
                                @php
                                    $imageUrl = null;
                                    $imageExists = false;
                                    $imagePath = $item->product->image;
                                    
                                    if (!empty($imagePath)) {
                                        $possiblePaths = [
                                            'storage/' . $imagePath,
                                            'storage/products/' . $imagePath,
                                            'product-images/' . $imagePath,
                                            'uploads/products/' . $imagePath,
                                            'images/products/' . $imagePath,
                                            $imagePath
                                        ];
                                        
                                        foreach ($possiblePaths as $path) {
                                            if (file_exists(public_path($path))) {
                                                $imageExists = true;
                                                $imageUrl = asset($path);
                                                break;
                                            }
                                        }
                                    }
                                @endphp
                                
                                @if($imageExists)
                                    <img src="{{ $imageUrl }}" alt="{{ $item->product->name }}">
                                @else
                                    <div class="product-image-placeholder">
                                        <i class="fas fa-box"></i>
                                    </div>
                                @endif
                            </a>
                            
                            {{-- Product Details --}}
                            <div class="product-details">
                                <a href="{{ route('customer.products.show', $item->product->slug) }}" class="product-name">
                                    {{ $item->product->name }}
                                </a>
                                <span class="product-category">{{ $item->product->category->name ?? 'Kategori' }}</span>
                                <div class="stock-info">
                                    <i class="fas fa-boxes"></i>
                                    Stok: 
                                    <span class="{{ $item->product->stock > 10 ? 'stock-high' : 'stock-low' }}">
                                        {{ $item->product->stock }} tersedia
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Price (Mobile Label) --}}
                        <div class="lg:hidden text-sm text-white/50 mb-1">Harga:</div>
                        <div class="product-price">
                            Rp {{ number_format($item->product->price, 0, ',', '.') }}
                        </div>
                        
                        {{-- Quantity Control --}}
                        <div class="lg:hidden text-sm text-white/50 mb-1">Jumlah:</div>
                        <div class="quantity-control">
                            <button onclick="updateQuantity({{ $item->id }}, 'decrease')" 
                                    class="quantity-btn"
                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" 
                                   value="{{ $item->quantity }}" 
                                   min="1" 
                                   max="{{ $item->product->stock }}"
                                   data-cart-id="{{ $item->id }}"
                                   class="quantity-input"
                                   readonly>
                            <button onclick="updateQuantity({{ $item->id }}, 'increase')" 
                                    class="quantity-btn"
                                    {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        
                        {{-- Subtotal --}}
                        <div class="lg:hidden text-sm text-white/50 mb-1">Subtotal:</div>
                        <div class="item-subtotal">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                        
                        {{-- Remove Button --}}
                        <div>
                            <form action="{{ route('customer.cart.remove', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn-remove" 
                                        onclick="return confirm('Hapus item ini dari keranjang?')"
                                        title="Hapus dari keranjang">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Cart Summary Section --}}
            <div class="lg:col-span-1" data-aos="fade-left">
                <div class="summary-card">
                    <div class="summary-title">
                        <div class="summary-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        Ringkasan Belanja
                    </div>
                    
                    <div class="summary-item">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value" id="cart-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-item">
                        <span class="summary-label">Total Item</span>
                        <span class="summary-value" id="total-items">{{ $cartItems->sum('quantity') }}</span>
                    </div>
                    
                    <div class="summary-item">
                        <span class="summary-label">Estimasi Pengiriman</span>
                        <span class="summary-value text-green-400">Gratis</span>
                    </div>

                    <div class="summary-total">
                        <span class="total-label">Total</span>
                        <span class="total-value" id="cart-total">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('customer.checkout.index') }}" class="btn-checkout">
                        <i class="fas fa-shopping-bag"></i>
                        Lanjut ke Checkout
                    </a>

                    <a href="{{ route('customer.products.index') }}" class="btn-continue">
                        <i class="fas fa-arrow-left"></i>
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    (function() {
        'use strict';

        // Notification System
        function showNotification(message, type = 'success') {
            const existingNotification = document.querySelector('.notification-toast');
            if (existingNotification) {
                existingNotification.remove();
            }
            
            const notification = document.createElement('div');
            notification.className = 'notification-toast';
            
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            const bgColor = type === 'success' 
                ? 'linear-gradient(135deg, #10b981, #047857)' 
                : 'linear-gradient(135deg, #ef4444, #b91c1c)';
            
            notification.innerHTML = `
                <div class="notification-content" style="background: ${bgColor};">
                    <div class="notification-icon">
                        <i class="fas ${icon}"></i>
                    </div>
                    <div class="notification-message">
                        <div class="notification-title">${type === 'success' ? 'Berhasil!' : 'Gagal!'}</div>
                        <div class="notification-text">${message}</div>
                    </div>
                    <button class="notification-close" onclick="this.closest('.notification-toast').remove()">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="notification-progress"></div>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification && notification.parentElement) {
                    notification.classList.add('hide');
                    setTimeout(() => notification.remove(), 500);
                }
            }, 4000);
        }

        // Update Quantity Function
        window.updateQuantity = function(cartId, action) {
            const row = document.querySelector(`[data-cart-id="${cartId}"]`);
            if (!row) return;
            
            const input = row.querySelector('.quantity-input');
            const currentQty = parseInt(input.value);
            const maxStock = parseInt(input.getAttribute('max'));
            
            let newQty = currentQty;
            if (action === 'increase' && newQty < maxStock) {
                newQty++;
            } else if (action === 'decrease' && newQty > 1) {
                newQty--;
            } else {
                return;
            }
            
            const buttons = row.querySelectorAll('.quantity-btn');
            buttons.forEach(btn => btn.disabled = true);
            
            fetch('{{ route("customer.cart.update") }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ cart_id: cartId, quantity: newQty })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI
                    input.value = newQty;
                    
                    const subtotalElement = row.querySelector('.item-subtotal');
                    if (subtotalElement) {
                        subtotalElement.textContent = data.item_total;
                    }
                    
                    const cartSubtotal = document.getElementById('cart-subtotal');
                    const cartTotal = document.getElementById('cart-total');
                    if (cartSubtotal && cartTotal) {
                        cartSubtotal.textContent = data.subtotal;
                        cartTotal.textContent = data.subtotal;
                    }
                    
                    const totalItemsElement = document.getElementById('total-items');
                    if (totalItemsElement) {
                        const currentTotal = parseInt(totalItemsElement.textContent);
                        totalItemsElement.textContent = currentTotal + (action === 'increase' ? 1 : -1);
                    }
                    
                    // Update button states
                    const decBtn = row.querySelector('button[onclick*="decrease"]');
                    const incBtn = row.querySelector('button[onclick*="increase"]');
                    
                    if (decBtn) decBtn.disabled = newQty <= 1;
                    if (incBtn) incBtn.disabled = newQty >= maxStock;
                    
                    // Success animation
                    row.style.backgroundColor = 'rgba(16, 185, 129, 0.1)';
                    setTimeout(() => {
                        row.style.backgroundColor = '';
                    }, 500);
                    
                    showNotification('Jumlah produk berhasil diperbarui!', 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
            })
            .finally(() => {
                buttons.forEach(btn => btn.disabled = false);
            });
        };

        // Handle Remove Form Submissions
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form[action*="cart.remove"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    if (!confirm('Hapus item ini dari keranjang?')) return;
                    
                    const button = this.querySelector('button');
                    const originalHtml = button.innerHTML;
                    
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    button.disabled = true;
                    
                    fetch(this.action, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Produk dihapus dari keranjang!', 'success');
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showNotification(data.message, 'error');
                            button.innerHTML = originalHtml;
                            button.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Terjadi kesalahan', 'error');
                        button.innerHTML = originalHtml;
                        button.disabled = false;
                    });
                });
            });
        });

    })();
</script>
@endpush