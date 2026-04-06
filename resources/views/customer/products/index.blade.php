@extends('layouts.app')

@section('title', 'Produk')

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
    =            STYLE KHUSUS HALAMAN PRODUK       =
    ==============================================*/
    .product-card {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(8px);
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid rgba(16, 185, 129, 0.2);
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -15px rgba(16, 185, 129, 0.3);
        border-color: rgba(16, 185, 129, 0.4);
        background: rgba(31, 41, 55, 0.95);
    }
    
    .product-image-container {
        aspect-ratio: 1/1;
        width: 100%;
        background: rgba(55, 65, 81, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.1);
    }
    
    .product-info {
        padding: 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .product-name {
        font-size: 16px;
        font-weight: 600;
        color: white;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
        transition: color 0.3s ease;
    }
    
    .product-card:hover .product-name {
        color: #10b981;
    }
    
    .product-category {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 8px;
    }
    
    .product-price {
        font-size: 18px;
        font-weight: 700;
        color: #10b981;
        margin-bottom: 12px;
    }
    
    .product-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
    }
    
    .product-stock {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.5);
    }
    
    .add-to-cart-btn {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #10b981;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }
    
    .add-to-cart-btn:hover {
        background: #10b981;
        color: white;
        transform: scale(1.1) rotate(3deg);
        border-color: transparent;
    }
    
    /* Tombol login di product card */
    .add-to-cart-btn.bg-gray-200 {
        background: rgba(59, 130, 246, 0.15) !important;
        color: #3b82f6 !important;
        border: 1px solid rgba(59, 130, 246, 0.3) !important;
    }
    
    .add-to-cart-btn.bg-gray-200:hover {
        background: #2563eb !important;
        color: white !important;
        transform: scale(1.1) rotate(3deg) !important;
        border-color: transparent !important;
    }
    
    .filter-section {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(8px);
        border-radius: 24px;
        padding: 24px;
        margin-bottom: 32px;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .filter-section input,
    .filter-section select {
        background: rgba(55, 65, 81, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .filter-section input:focus,
    .filter-section select:focus {
        border-color: #10b981;
        outline: none;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        background: rgba(55, 65, 81, 0.8);
    }
    
    .filter-section input::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }
    
    .filter-section select option {
        background: #1f2937;
        color: white;
    }
    
    .filter-section .btn-filter {
        background: #10b981;
        color: white;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
    }
    
    .filter-section .btn-filter:hover {
        background: #047857;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -10px rgba(16, 185, 129, 0.5);
    }
    
    .filter-section .btn-reset {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .filter-section .btn-reset:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }
    
    .grid-products {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    
    @media (min-width: 640px) {
        .grid-products {
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
    }
    
    @media (min-width: 768px) {
        .grid-products {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    
    @media (min-width: 1024px) {
        .grid-products {
            grid-template-columns: repeat(5, 1fr);
            gap: 24px;
        }
    }
    
    /* Pagination styling */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 40px;
    }
    
    .pagination .page-item {
        list-style: none;
    }
    
    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: rgba(255, 255, 255, 0.7);
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .pagination .page-link:hover {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.3);
        transform: translateY(-2px);
    }
    
    .pagination .active .page-link {
        background: #10b981;
        color: white;
        border-color: transparent;
    }
    
    .pagination .disabled .page-link {
        opacity: 0.3;
        cursor: not-allowed;
        pointer-events: none;
    }
    
    /* Empty state */
    .empty-state {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(8px);
        border-radius: 32px;
        padding: 60px 20px;
        border: 1px solid rgba(16, 185, 129, 0.2);
        text-align: center;
    }
    
    .empty-state i {
        color: rgba(16, 185, 129, 0.3);
        font-size: 64px;
        margin-bottom: 16px;
    }
    
    .empty-state h3 {
        color: white;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .empty-state p {
        color: rgba(255, 255, 255, 0.5);
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header dengan aksen hijau -->
    <div class="mb-8 flex items-center gap-3">
        <div class="w-1 h-10 bg-green-500 rounded-full"></div>
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-white">Produk Kami</h1>
            <p class="text-white/50 text-sm mt-1">Temukan kebutuhan warung Anda di sini</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('customer.products.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <!-- Search -->
                <div class="md:col-span-2">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari produk..." 
                           class="w-full">
                </div>
                
                <!-- Category Filter -->
                <div>
                    <select name="category" class="w-full">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Sort -->
                <div>
                    <select name="sort" class="w-full">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="submit" class="btn-filter">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                @if(request()->anyFilled(['search', 'category', 'sort']))
                    <a href="{{ route('customer.products.index') }}" class="btn-reset">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid-products">
            @foreach($products as $product)
            <div class="product-card">
                <a href="{{ route('customer.products.show', $product->slug) }}" class="block h-full">
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
                            <div class="w-full h-full bg-gradient-to-br from-green-900/50 to-green-800/30 flex items-center justify-center">
                                <i class="fas fa-box text-4xl text-white/30"></i>
                            </div>
                        @endif
                        
                        @if($product->created_at->diffInDays(now()) < 7)
                        <div class="absolute top-3 left-3 z-10">
                            <span class="bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg flex items-center gap-1">
                                <i class="fas fa-fire text-xs"></i> NEW
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <p class="product-category">{{ $product->category->name ?? 'Kategori' }}</p>
                        <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="product-actions">
                            <span class="product-stock">Stok: {{ $product->stock }}</span>
                            @auth
                                <button onclick="addToCart({{ $product->id }}, event)" class="add-to-cart-btn">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="add-to-cart-btn bg-gray-200">
                                    <i class="fas fa-sign-in-alt"></i>
                                </a>
                            @endauth
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-12">
            {{ $products->withQueryString()->links('pagination::tailwind') }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <h3>Belum Ada Produk</h3>
            <p>Maaf, belum ada produk yang tersedia saat ini</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Fungsi untuk menampilkan notifikasi mewah (SAMA PERSIS DENGAN HOME)
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

    // Fungsi add to cart
    function addToCart(productId, event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        const button = event.currentTarget;
        const originalHtml = button.innerHTML;
        
        // Loading state
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        button.classList.add('opacity-75');
        
        fetch('{{ route("customer.cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update cart count di navbar
                const cartBadges = document.querySelectorAll('.cart-badge');
                cartBadges.forEach(badge => {
                    badge.textContent = data.cart_count;
                    badge.classList.add('animate-ping');
                    setTimeout(() => badge.classList.remove('animate-ping'), 500);
                });
                
                // Tampilkan notifikasi sukses
                showNotification('Produk berhasil ditambahkan ke keranjang!', 'success');
                
                // Animasi sukses di button
                button.innerHTML = '<i class="fas fa-check"></i>';
                button.classList.remove('bg-green-600/20', 'text-green-400');
                button.classList.add('bg-green-600', 'text-white');
                
                setTimeout(() => {
                    button.innerHTML = originalHtml;
                    button.classList.remove('bg-green-600', 'text-white', 'opacity-75');
                    button.classList.add('bg-green-600/20', 'text-green-400');
                    button.disabled = false;
                }, 1500);
                
            } else {
                // Tampilkan notifikasi error
                showNotification(data.message, 'error');
                
                // Animasi error di button
                button.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
                button.classList.remove('bg-green-600/20', 'text-green-400');
                button.classList.add('bg-red-600', 'text-white');
                
                setTimeout(() => {
                    button.innerHTML = originalHtml;
                    button.classList.remove('bg-red-600', 'text-white', 'opacity-75');
                    button.classList.add('bg-green-600/20', 'text-green-400');
                    button.disabled = false;
                }, 1500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan', 'error');
            
            button.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
            button.classList.remove('bg-green-600/20', 'text-green-400');
            button.classList.add('bg-red-600', 'text-white');
            
            setTimeout(() => {
                button.innerHTML = originalHtml;
                button.classList.remove('bg-red-600', 'text-white', 'opacity-75');
                button.classList.add('bg-green-600/20', 'text-green-400');
                button.disabled = false;
            }, 1500);
        });
    }
</script>
@endpush