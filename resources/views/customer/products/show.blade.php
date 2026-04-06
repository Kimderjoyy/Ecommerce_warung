@extends('layouts.app')

@section('title', $product->name)

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
    =            STYLE KHUSUS DETAIL PRODUK        =
    ==============================================*/
    /* Breadcrumb */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
        font-size: 14px;
    }
    
    .breadcrumb a {
        color: rgba(255, 255, 255, 0.6);
        transition: color 0.3s ease;
    }
    
    .breadcrumb a:hover {
        color: #10b981;
    }
    
    .breadcrumb span {
        color: rgba(255, 255, 255, 0.3);
    }
    
    .breadcrumb .current {
        color: white;
        font-weight: 500;
    }
    
    /* Product Detail Container */
    .product-detail-container {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(8px);
        border-radius: 32px;
        border: 1px solid rgba(16, 185, 129, 0.2);
        padding: 32px;
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.3);
    }
    
    .product-image-container {
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid rgba(16, 185, 129, 0.2);
        aspect-ratio: 1/1;
        background: rgba(55, 65, 81, 0.5);
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .product-image:hover {
        transform: scale(1.05);
    }
    
    .product-info {
        color: white;
    }
    
    .product-title {
        font-size: 28px;
        font-weight: 700;
        color: white;
        margin-bottom: 16px;
    }
    
    .price-tag {
        font-size: 32px;
        font-weight: 700;
        color: #10b981;
        margin-right: 16px;
    }
    
    .stock-badge {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        padding: 6px 16px;
        border-radius: 999px;
        font-size: 14px;
        font-weight: 600;
        border: 1px solid rgba(16, 185, 129, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .stock-badge.out-of-stock {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.3);
    }
    
    .category-info {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.6);
        margin: 20px 0;
    }
    
    .category-info i {
        color: #10b981;
    }
    
    .category-info a {
        color: #10b981;
        transition: color 0.3s ease;
    }
    
    .category-info a:hover {
        color: #047857;
        text-decoration: underline;
    }
    
    .description-section {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 24px 0;
        margin: 24px 0;
    }
    
    .description-section h3 {
        font-weight: 600;
        color: white;
        margin-bottom: 12px;
        font-size: 18px;
    }
    
    .description-section p {
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.7;
        font-size: 15px;
    }
    
    .quantity-control {
        display: inline-flex;
        align-items: center;
        background: rgba(55, 65, 81, 0.5);
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 4px;
    }
    
    .quantity-btn {
        width: 44px;
        height: 44px;
        border-radius: 999px;
        background: rgba(31, 41, 55, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.7);
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .quantity-btn:hover:not(:disabled) {
        background: #10b981;
        color: white;
        border-color: transparent;
        transform: scale(1.1);
    }
    
    .quantity-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }
    
    .quantity-input {
        width: 70px;
        height: 44px;
        border: none;
        text-align: center;
        font-weight: 600;
        font-size: 16px;
        background: transparent;
        color: white;
    }
    
    .quantity-input:focus {
        outline: none;
    }
    
    .btn-beli {
        background: linear-gradient(135deg, #10b981, #047857);
        color: white;
        padding: 14px 32px;
        border-radius: 999px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 10px 20px -10px rgba(16, 185, 129, 0.5);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-beli:hover:not(:disabled) {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 20px 30px -10px rgba(16, 185, 129, 0.7);
    }
    
    .btn-beli:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .login-prompt {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 24px;
        padding: 32px;
        text-align: center;
    }
    
    .login-prompt p {
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 20px;
        font-size: 16px;
    }
    
    .login-prompt .btn-beli {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        box-shadow: 0 10px 20px -10px rgba(59, 130, 246, 0.5);
    }
    
    .login-prompt .btn-beli:hover {
        box-shadow: 0 20px 30px -10px rgba(59, 130, 246, 0.7);
    }
    
    /* Related Products Section */
    .related-section {
        margin-top: 48px;
    }
    
    .related-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }
    
    .related-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: white;
    }
    
    .related-header a {
        color: #10b981;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
    }
    
    .related-header a:hover {
        color: white;
        transform: translateX(5px);
    }
    
    .related-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    
    @media (min-width: 768px) {
        .related-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
    }
    
    .related-product-card {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(8px);
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(16, 185, 129, 0.2);
        transition: all 0.3s ease;
        height: 100%;
        display: block;
        text-decoration: none;
    }
    
    .related-product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 30px -10px rgba(16, 185, 129, 0.3);
        border-color: rgba(16, 185, 129, 0.4);
    }
    
    .related-product-image {
        aspect-ratio: 1/1;
        width: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .related-product-card:hover .related-product-image {
        transform: scale(1.1);
    }
    
    .related-product-content {
        padding: 12px;
    }
    
    .related-product-name {
        font-size: 14px;
        font-weight: 600;
        color: white;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.3s ease;
    }
    
    .related-product-card:hover .related-product-name {
        color: #10b981;
    }
    
    .related-product-price {
        font-size: 16px;
        font-weight: 700;
        color: #10b981;
    }
    
    /* Maksimal pembelian text */
    .max-order-text {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.4);
        margin-top: 8px;
    }

    /*==============================================
    =            REVIEW SECTION STYLES             =
    ==============================================*/
    .review-section {
        margin-top: 48px;
    }

    .review-summary-card {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(8px);
        border-radius: 24px;
        padding: 24px;
        border: 1px solid rgba(16, 185, 129, 0.2);
        margin-bottom: 24px;
    }

    .rating-large {
        font-size: 48px;
        font-weight: 700;
        color: #10b981;
        line-height: 1;
    }

    .rating-stars {
        color: #fbbf24;
        font-size: 20px;
        letter-spacing: 2px;
    }

    .rating-bar {
        flex: 1;
        height: 8px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 999px;
        overflow: hidden;
    }

    .rating-bar-fill {
        height: 100%;
        background: #fbbf24;
        border-radius: 999px;
    }

    .review-card {
        background: rgba(31, 41, 55, 0.5);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 20px;
        padding: 20px;
        transition: all 0.3s ease;
        margin-bottom: 16px;
    }

    .review-card:hover {
        border-color: rgba(16, 185, 129, 0.4);
        background: rgba(31, 41, 55, 0.7);
    }

    .review-avatar {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #10b981, #047857);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 18px;
        flex-shrink: 0;
    }

    .review-user-name {
        font-weight: 600;
        color: white;
    }

    .review-date {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.4);
    }

    .review-rating {
        color: #fbbf24;
        font-size: 14px;
        letter-spacing: 1px;
    }

    .review-comment {
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
        line-height: 1.6;
        margin-top: 12px;
    }

    .btn-review {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
        padding: 10px 20px;
        border-radius: 999px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-review:hover {
        background: #10b981;
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
    }

    .user-review-card {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid #10b981;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 24px;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span>/</span>
        <a href="{{ route('customer.products.index') }}">Produk</a>
        <span>/</span>
        <span class="current">{{ Str::limit($product->name, 30) }}</span>
    </nav>

    <!-- Product Detail -->
    <div class="product-detail-container">
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Image -->
            <div class="product-image-container">
                @php
                    $imageUrl = null;
                    $imageExists = false;
                    
                    if ($product->image) {
                        $possiblePaths = [
                            public_path('storage/' . $product->image),
                            public_path($product->image),
                            public_path('product-images/' . basename($product->image)),
                            public_path('uploads/products/' . basename($product->image))
                        ];
                        
                        foreach ($possiblePaths as $path) {
                            if (file_exists($path)) {
                                $imageExists = true;
                                if (strpos($path, 'storage/') !== false) {
                                    $imageUrl = asset('storage/' . $product->image);
                                } elseif (strpos($path, 'product-images/') !== false) {
                                    $imageUrl = asset('product-images/' . basename($product->image));
                                } elseif (strpos($path, 'uploads/products/') !== false) {
                                    $imageUrl = asset('uploads/products/' . basename($product->image));
                                } else {
                                    $imageUrl = asset($product->image);
                                }
                                break;
                            }
                        }
                    }
                @endphp
                
                @if($imageExists)
                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-green-900/50 to-green-800/30 flex flex-col items-center justify-center p-8">
                        <i class="fas fa-box-open text-6xl mb-4 text-white/30"></i>
                        <h3 class="text-xl font-bold text-white/50">{{ $product->name }}</h3>
                        <p class="text-sm text-white/30 mt-2">Gambar tidak tersedia</p>
                    </div>
                @endif
                
                @if($product->created_at->diffInDays(now()) < 7)
                <div class="absolute top-4 left-4 z-10">
                    <span class="bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg flex items-center gap-1">
                        <i class="fas fa-fire text-xs"></i> NEW
                    </span>
                </div>
                @endif
            </div>

            <!-- Info -->
            <div class="product-info">
                <h1 class="product-title">{{ $product->name }}</h1>
                
                <div class="flex flex-wrap items-center gap-3">
                    <span class="price-tag">Rp {{ number_format($product->price,0,',','.') }}</span>
                    @if($product->stock > 0)
                        <span class="stock-badge">
                            <i class="fas fa-check-circle"></i>Stok {{ $product->stock }}
                        </span>
                    @else
                        <span class="stock-badge out-of-stock">
                            <i class="fas fa-times-circle"></i>Stok Habis
                        </span>
                    @endif
                </div>

                <div class="category-info">
                    <i class="fas fa-tag"></i>
                    <span>Kategori: </span>
                    <a href="{{ route('customer.products.index', ['category' => $product->category_id]) }}">
                        {{ $product->category->name ?? 'Kategori' }}
                    </a>
                </div>

                <div class="description-section">
                    <h3>Deskripsi Produk</h3>
                    <p>{{ $product->description ?: 'Tidak ada deskripsi untuk produk ini.' }}</p>
                </div>

                @auth
                    @if($product->stock > 0)
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <div class="quantity-control">
                                <button class="quantity-btn" onclick="decrement()" id="decrementBtn">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                       class="quantity-input" readonly>
                                <button class="quantity-btn" onclick="increment()" id="incrementBtn">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <button class="btn-beli w-full sm:w-auto flex-1" onclick="addToCart()" id="addToCartBtn">
                                <i class="fas fa-cart-plus"></i>Tambah ke Keranjang
                            </button>
                        </div>
                        <p class="max-order-text">Maksimal pembelian {{ $product->stock }} item</p>
                    @endif
                @else
                    <div class="login-prompt">
                        <p>Silakan login untuk membeli produk ini</p>
                        <a href="{{ route('login') }}" class="btn-beli inline-flex">
                            <i class="fas fa-sign-in-alt"></i>Login Sekarang
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    {{-- REVIEW SECTION --}}
    <div class="review-section">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-white">Ulasan Pelanggan</h2>
            
            @auth
                @if($hasPurchased && !$userReview)
                    <a href="{{ route('customer.reviews.create', $product) }}" 
                       class="btn-review">
                        <i class="fas fa-star"></i>
                        Tulis Ulasan
                    </a>
                @endif
            @endauth
        </div>

        {{-- Review Summary --}}
        @if($product->total_reviews > 0)
        <div class="review-summary-card">
            <div class="grid md:grid-cols-3 gap-6">
                {{-- Average Rating --}}
                <div class="text-center">
                    <div class="rating-large">{{ number_format($product->average_rating, 1) }}</div>
                    <div class="rating-stars mt-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($product->average_rating))
                                <i class="fas fa-star"></i>
                            @elseif($i - $product->average_rating <= 0.5)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="text-sm text-white/50 mt-2">{{ $product->total_reviews }} ulasan</div>
                </div>

                {{-- Rating Breakdown --}}
                <div class="md:col-span-2 space-y-2">
                    @for($i = 5; $i >= 1; $i--)
                        @php
                            $count = $product->reviews()->where('is_approved', true)->where('rating', $i)->count();
                            $percentage = $product->total_reviews > 0 ? ($count / $product->total_reviews) * 100 : 0;
                        @endphp
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-white/70 w-3">{{ $i }}</span>
                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                            <div class="rating-bar">
                                <div class="rating-bar-fill" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="text-xs text-white/50 w-8">{{ $count }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
        @endif

        {{-- User's Review --}}
        @auth
            @if($userReview)
            <div class="user-review-card">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="review-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="review-user-name">{{ Auth::user()->name }}</h4>
                            <p class="review-date">{{ $userReview->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="review-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $userReview->rating ? '' : 'text-white/20' }}"></i>
                        @endfor
                    </div>
                </div>
                <p class="review-comment">{{ $userReview->comment }}</p>
                @if(!$userReview->is_approved)
                    <p class="text-xs text-yellow-400 mt-3 flex items-center gap-1">
                        <i class="fas fa-clock"></i>
                        Ulasan Anda sedang menunggu persetujuan admin
                    </p>
                @endif
                <div class="flex justify-end gap-2 mt-4 pt-3 border-t border-green-500/20">
                    <a href="{{ route('customer.reviews.create', $product) }}" 
                       class="text-sm px-3 py-1.5 rounded-lg bg-blue-500/20 text-blue-400 border border-blue-500/30 hover:bg-blue-500 hover:text-white transition-all">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <form action="{{ route('customer.reviews.destroy', $userReview) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="text-sm px-3 py-1.5 rounded-lg bg-red-500/20 text-red-400 border border-red-500/30 hover:bg-red-500 hover:text-white transition-all"
                                onclick="return confirm('Hapus ulasan Anda?')">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endif
        @endauth

        {{-- All Reviews from Other Customers --}}
        <div class="space-y-4 mt-6">
            <h3 class="text-lg font-semibold text-white mb-4">Ulasan dari Pembeli Lain</h3>
            
            @php
                $otherReviews = $product->reviews()
                    ->where('is_approved', true)
                    ->with('user')
                    ->latest()
                    ->get();
            @endphp
            
            @forelse($otherReviews as $review)
                @if(!Auth::check() || (Auth::check() && $review->user_id !== Auth::id()))
                <div class="review-card">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="review-avatar">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="review-user-name">{{ $review->user->name }}</h4>
                                <p class="review-date">{{ $review->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="review-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-white/20' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="review-comment">{{ $review->comment }}</p>
                </div>
                @endif
            @empty
                <div class="text-center py-8 text-white/40">
                    <i class="fas fa-star text-4xl mb-3 opacity-30"></i>
                    <p>Belum ada ulasan untuk produk ini</p>
                    @auth
                        @if($hasPurchased && !$userReview)
                            <a href="{{ route('customer.reviews.create', $product) }}" 
                               class="btn-review mt-4">
                                Jadilah yang pertama memberi ulasan
                            </a>
                        @endif
                    @endauth
                </div>
            @endforelse
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="related-section">
        <div class="related-header">
            <h2>Produk Terkait</h2>
            <a href="{{ route('customer.products.index', ['category' => $product->category_id]) }}">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="related-grid">
            @foreach($relatedProducts as $related)
            <a href="{{ route('customer.products.show', $related->slug) }}" class="related-product-card">
                <div class="relative">
                    @php
                        $relatedImageUrl = null;
                        $relatedImageExists = false;
                        
                        if ($related->image) {
                            $possiblePaths = [
                                public_path('storage/' . $related->image),
                                public_path($related->image),
                                public_path('product-images/' . basename($related->image)),
                                public_path('uploads/products/' . basename($related->image))
                            ];
                            
                            foreach ($possiblePaths as $path) {
                                if (file_exists($path)) {
                                    $relatedImageExists = true;
                                    if (strpos($path, 'storage/') !== false) {
                                        $relatedImageUrl = asset('storage/' . $related->image);
                                    } elseif (strpos($path, 'product-images/') !== false) {
                                        $relatedImageUrl = asset('product-images/' . basename($related->image));
                                    } elseif (strpos($path, 'uploads/products/') !== false) {
                                        $relatedImageUrl = asset('uploads/products/' . basename($related->image));
                                    } else {
                                        $relatedImageUrl = asset($related->image);
                                    }
                                    break;
                                }
                            }
                        }
                    @endphp
                    
                    @if($relatedImageExists)
                        <img src="{{ $relatedImageUrl }}" alt="{{ $related->name }}" class="related-product-image">
                    @else
                        <div class="related-product-image bg-gradient-to-br from-green-900/50 to-green-800/30 flex items-center justify-center">
                            <i class="fas fa-box text-3xl text-white/30"></i>
                        </div>
                    @endif
                    
                    @if($related->created_at->diffInDays(now()) < 7)
                    <div class="absolute top-2 left-2 z-10">
                        <span class="bg-gradient-to-r from-green-500 to-green-600 text-white text-xs px-2 py-1 rounded-full">
                            NEW
                        </span>
                    </div>
                    @endif
                </div>
                <div class="related-product-content">
                    <h3 class="related-product-name">{{ $related->name }}</h3>
                    <p class="related-product-price">Rp {{ number_format($related->price,0,',','.') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Fungsi increment
    function increment() {
        const input = document.getElementById('quantity');
        const incrementBtn = document.getElementById('incrementBtn');
        const decrementBtn = document.getElementById('decrementBtn');
        
        if (input) {
            const currentValue = parseInt(input.value);
            const maxValue = parseInt(input.getAttribute('max'));
            if (currentValue < maxValue) {
                input.value = currentValue + 1;
            }
            if (decrementBtn) decrementBtn.disabled = false;
            if (incrementBtn) incrementBtn.disabled = currentValue + 1 >= maxValue;
        }
    }
    
    // Fungsi decrement
    function decrement() {
        const input = document.getElementById('quantity');
        const incrementBtn = document.getElementById('incrementBtn');
        const decrementBtn = document.getElementById('decrementBtn');
        
        if (input) {
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
            if (incrementBtn) incrementBtn.disabled = false;
            if (decrementBtn) decrementBtn.disabled = currentValue - 1 <= 1;
        }
    }
    
    // Disable tombol decrement awal jika quantity = 1
    document.addEventListener('DOMContentLoaded', function() {
        const decrementBtn = document.getElementById('decrementBtn');
        const quantity = document.getElementById('quantity');
        if (decrementBtn && quantity && quantity.value === '1') {
            decrementBtn.disabled = true;
        }
    });
    
    // Fungsi add to cart
    function addToCart() {
        const quantityInput = document.getElementById('quantity');
        const quantity = quantityInput ? quantityInput.value : 1;
        const button = document.getElementById('addToCartBtn');
        
        if (!button) return;
        
        const originalText = button.innerHTML;
        
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>Menambahkan...';
        button.disabled = true;
        
        fetch('{{ route("customer.cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: {{ $product->id }},
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const cartBadges = document.querySelectorAll('.cart-badge');
                cartBadges.forEach(badge => {
                    badge.textContent = data.cart_count;
                    badge.classList.add('animate-ping');
                    setTimeout(() => badge.classList.remove('animate-ping'), 500);
                });
                
                showNotification('Produk berhasil ditambahkan ke keranjang!', 'success');
                
                button.innerHTML = originalText;
                button.disabled = false;
            } else {
                showNotification(data.message, 'error');
                button.innerHTML = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }

    // Fungsi notifikasi
    function showNotification(message, type = 'success') {
        const existingNotification = document.querySelector('.notification-toast');
        if (existingNotification) {
            existingNotification.remove();
        }
        
        const notification = document.createElement('div');
        notification.className = 'notification-toast';
        
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        const bgColor = type === 'success' ? 'linear-gradient(135deg, #10b981, #047857)' : 'linear-gradient(135deg, #ef4444, #b91c1c)';
        
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
                setTimeout(() => {
                    if (notification && notification.parentElement) {
                        notification.remove();
                    }
                }, 500);
            }
        }, 4000);
    }
</script>
@endpush