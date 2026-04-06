@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
<div class="space-y-6">
    <!-- HEADER SECTION -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen Produk</h1>
            <p class="text-sm text-white/50 mt-1">Kelola semua produk toko Anda</p>
        </div>
        <a href="{{ route('admin.products.create') }}" 
           class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-green-500 to-green-700 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-green-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all">
            <i class="fas fa-plus"></i>
            Tambah Produk
        </a>
    </div>

    <!-- FILTER SECTION -->
    <div class="rounded-2xl bg-gray-800/50 p-5 border border-green-500/20 backdrop-blur-sm">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/30 text-sm"></i>
                    <input type="text" 
                           name="search" 
                           placeholder="Cari produk..." 
                           value="{{ request('search') }}"
                           class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 pl-11 pr-4 text-sm text-white placeholder:text-white/30 focus:border-green-500 focus:outline-none focus:ring-1 focus:ring-green-500">
                </div>
            </div>

            <!-- Category Filter -->
            <div class="w-full md:w-48">
                <select name="category" 
                        class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 px-4 text-sm text-white focus:border-green-500 focus:outline-none focus:ring-1 focus:ring-green-500">
                    <option value="" class="bg-gray-800">Semua Kategori</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" 
                                class="bg-gray-800" 
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="w-full md:w-40">
                <select name="status" 
                        class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 px-4 text-sm text-white focus:border-green-500 focus:outline-none focus:ring-1 focus:ring-green-500">
                    <option value="" class="bg-gray-800">Semua Status</option>
                    <option value="active" class="bg-gray-800" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" class="bg-gray-800" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-6 py-3 text-sm font-semibold text-white hover:bg-green-700 transition-colors">
                <i class="fas fa-filter"></i>
                Filter
            </button>
        </form>
    </div>

    <!-- PRODUCTS TABLE -->
    <div class="rounded-2xl bg-gray-800/50 border border-green-500/20 backdrop-blur-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-white/5">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase tracking-wider">Gambar</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($products as $product)
                    <tr class="hover:bg-white/5 transition-colors">
                        <!-- Image -->
                        <td class="px-6 py-4">
                            @php
                                $imageUrl = null;
                                $imageExists = false;
                                
                                if ($product->image) {
                                    $possiblePaths = [
                                        'storage/' . $product->image,
                                        'products-images/' . $product->image,
                                        'uploads/products/' . $product->image,
                                        'product-images/' . $product->image,
                                        'images/products/' . $product->image,
                                        $product->image
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
                                <img src="{{ $imageUrl }}" 
                                     alt="{{ $product->name }}" 
                                     class="h-12 w-12 rounded-xl border border-green-500/30 object-cover">
                            @else
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/5 border border-white/10">
                                    <i class="fas fa-box text-white/30"></i>
                                </div>
                            @endif
                        </td>

                        <!-- Product Name -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-white">{{ $product->name }}</div>
                            <div class="text-xs text-white/40 mt-0.5">ID: #{{ $product->id }}</div>
                        </td>

                        <!-- Category -->
                        <td class="px-6 py-4">
                            <div class="text-sm text-white/70">{{ $product->category->name }}</div>
                        </td>

                        <!-- Price -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-green-400">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </td>

                        <!-- Stock -->
                        <td class="px-6 py-4">
                            <div class="text-sm text-white/70">{{ $product->stock }}</div>
                            @if($product->stock <= 5)
                                <span class="text-xs text-yellow-400 mt-0.5 block">Stok menipis</span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            @if($product->is_active)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-green-500/20 px-3 py-1 text-xs font-semibold text-green-400 border border-green-500/30">
                                    <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-500/20 px-3 py-1 text-xs font-semibold text-red-400 border border-red-500/30">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-500/20 border border-blue-500/30 text-blue-400 hover:bg-blue-500 hover:text-white hover:scale-110 transition-all">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Yakin ingin menghapus produk ini?')"
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-500/20 border border-red-500/30 text-red-400 hover:bg-red-500 hover:text-white hover:scale-110 transition-all">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <!-- Empty State -->
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex justify-center mb-4">
                                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-white/5 border border-white/10">
                                    <i class="fas fa-box-open text-3xl text-white/30"></i>
                                </div>
                            </div>
                            <p class="text-base font-medium text-white mb-1">Belum ada produk</p>
                            <p class="text-sm text-white/40">Mulai dengan menambahkan produk baru</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        @if($products->hasPages())
        <div class="border-t border-white/10 px-6 py-4">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection