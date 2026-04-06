@extends('layouts.app')

@section('title', 'Tulis Ulasan - ' . $product->name)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('customer.products.show', $product->slug) }}" 
           class="inline-flex items-center gap-2 text-green-400 hover:text-white transition-colors mb-4">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Produk
        </a>
        <h1 class="text-2xl font-bold text-white">Tulis Ulasan</h1>
        <p class="text-sm text-white/50 mt-1">{{ $product->name }}</p>
    </div>

    {{-- Form Card --}}
    <div class="rounded-2xl bg-gray-800/50 p-8 border border-green-500/20 backdrop-blur-sm">
        <form action="{{ route('customer.reviews.store', $product) }}" method="POST">
            @csrf

            {{-- Rating --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-white/80 mb-3">
                    Rating <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center gap-2" x-data="{ rating: {{ $existingReview->rating ?? 5 }} }">
                    <template x-for="star in 5">
                        <button type="button" 
                                @click="rating = star"
                                class="text-3xl focus:outline-none transition-colors"
                                :class="star <= rating ? 'text-yellow-400' : 'text-white/20'">
                            <i class="fas fa-star"></i>
                        </button>
                    </template>
                    <input type="hidden" name="rating" x-model="rating">
                </div>
                @error('rating')
                    <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Comment --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-white/80 mb-2">
                    Ulasan
                </label>
                <textarea name="comment" 
                          rows="5" 
                          class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 px-4 text-sm text-white placeholder:text-white/30 focus:border-green-500 focus:outline-none"
                          placeholder="Bagikan pengalaman Anda menggunakan produk ini...">{{ old('comment', $existingReview->comment ?? '') }}</textarea>
                @error('comment')
                    <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('customer.products.show', $product->slug) }}" 
                   class="px-6 py-3 rounded-xl bg-white/10 text-white/70 border border-white/20 hover:bg-white/20 transition-all">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold shadow-lg shadow-green-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Kirim Ulasan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection