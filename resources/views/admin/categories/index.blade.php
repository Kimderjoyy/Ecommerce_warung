@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="space-y-6">
    <!-- HEADER SECTION -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen Kategori</h1>
            <p class="text-sm text-white/50 mt-1">Kelola kategori produk Anda</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" 
           class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-green-500 to-green-700 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-green-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all">
            <i class="fas fa-plus"></i>
            Tambah Kategori Baru
        </a>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Total Kategori -->
        <div class="rounded-2xl bg-gray-800/50 p-6 border border-green-500/20 backdrop-blur-sm">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-green-500/20 border border-green-500/30 text-green-400 text-2xl">
                    <i class="fas fa-tags"></i>
                </div>
                <div>
                    <p class="text-sm text-white/50">Total Kategori</p>
                    <h3 class="text-2xl font-bold text-white">{{ $categories->total() }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Produk -->
        <div class="rounded-2xl bg-gray-800/50 p-6 border border-blue-500/20 backdrop-blur-sm">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-blue-500/20 border border-blue-500/30 text-blue-400 text-2xl">
                    <i class="fas fa-boxes"></i>
                </div>
                <div>
                    <p class="text-sm text-white/50">Total Produk</p>
                    <h3 class="text-2xl font-bold text-white">{{ $totalProducts }}</h3>
                </div>
            </div>
        </div>

        <!-- Kategori Aktif -->
        <div class="rounded-2xl bg-gray-800/50 p-6 border border-purple-500/20 backdrop-blur-sm">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-purple-500/20 border border-purple-500/30 text-purple-400 text-2xl">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <p class="text-sm text-white/50">Kategori dengan Produk</p>
                    <h3 class="text-2xl font-bold text-white">{{ $activeCategories }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- CATEGORIES GRID -->
    @if($categories->isEmpty())
        <!-- EMPTY STATE -->
        <div class="rounded-2xl bg-gray-800/50 p-12 border border-green-500/20 backdrop-blur-sm text-center">
            <div class="flex justify-center mb-4">
                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-white/5 border border-white/10">
                    <i class="fas fa-tags text-3xl text-white/30"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-white mb-2">Belum ada kategori</h3>
            <p class="text-sm text-white/40 mb-6">Mulai dengan menambahkan kategori pertama Anda</p>
            <a href="{{ route('admin.categories.create') }}" 
               class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-green-500 to-green-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-green-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all">
                <i class="fas fa-plus"></i>
                Tambah Kategori
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($categories as $category)
            <div class="group rounded-2xl bg-gray-800/50 p-6 border border-green-500/20 backdrop-blur-sm hover:border-green-500/40 hover:-translate-y-1 transition-all duration-300">
                <!-- Header Card -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-gradient-to-r from-green-500 to-green-700 text-white text-2xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <i class="fas {{ $category->icon ?? 'fa-folder' }}"></i>
                    </div>
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold 
                        {{ $category->products_count > 0 
                            ? 'bg-green-500/20 text-green-400 border border-green-500/30' 
                            : 'bg-white/10 text-white/40 border border-white/10' }}">
                        <i class="fas fa-box mr-1 text-xs"></i>
                        {{ $category->products_count }} Produk
                    </span>
                </div>

                <!-- Content -->
                <h3 class="text-lg font-semibold text-white mb-2">{{ $category->name }}</h3>
                
                @if($category->description)
                    <p class="text-sm text-white/50 mb-4 line-clamp-2">{{ $category->description }}</p>
                @else
                    <p class="text-sm text-white/30 mb-4 line-clamp-2 italic">Tidak ada deskripsi</p>
                @endif

                <!-- Footer -->
                <div class="flex items-center justify-end gap-2 pt-4 border-t border-white/10">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="flex items-center gap-2 rounded-lg bg-blue-500/20 px-4 py-2 text-xs font-semibold text-blue-400 border border-blue-500/30 hover:bg-blue-500 hover:text-white transition-all">
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                    
                    @if($category->products_count == 0)
                    <form action="{{ route('admin.categories.destroy', $category) }}" 
                          method="POST" 
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Yakin ingin menghapus kategori ini?')"
                                class="flex items-center gap-2 rounded-lg bg-red-500/20 px-4 py-2 text-xs font-semibold text-red-400 border border-red-500/30 hover:bg-red-500 hover:text-white transition-all">
                            <i class="fas fa-trash"></i>
                            Hapus
                        </button>
                    </form>
                    @else
                    <button type="button" 
                            class="flex items-center gap-2 rounded-lg bg-white/5 px-4 py-2 text-xs font-semibold text-white/30 border border-white/10 cursor-not-allowed"
                            title="Tidak dapat menghapus kategori yang memiliki produk">
                        <i class="fas fa-trash"></i>
                        Hapus
                    </button>
                    @endif
                </div>

                <!-- Info Produk -->
                @if($category->products_count > 0)
                <div class="mt-4 pt-3 text-xs text-white/30 border-t border-dashed border-white/10">
                    <i class="fas fa-box mr-1"></i>
                    {{ $category->products_count }} produk dalam kategori ini
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- PAGINATION -->
        @if($categories->hasPages())
        <div class="mt-8">
            {{ $categories->withQueryString()->links() }}
        </div>
        @endif
    @endif
</div>
@endsection