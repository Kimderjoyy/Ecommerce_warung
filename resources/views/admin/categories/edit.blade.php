@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- HEADER SECTION -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Edit Kategori</h1>
            <p class="text-sm text-white/50 mt-1">Edit informasi kategori {{ $category->name }}</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" 
           class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-5 py-2.5 text-sm font-semibold text-white border border-white/20 hover:bg-white/20 transition-all">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <!-- FORM CARD -->
    <div class="rounded-2xl bg-gray-800/50 p-8 border border-green-500/20 backdrop-blur-sm">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Nama Kategori -->
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $category->name) }}" 
                           required 
                           class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 px-4 text-sm text-white placeholder:text-white/30 focus:border-green-500 focus:outline-none focus:ring-1 focus:ring-green-500 @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama kategori">
                    @error('name')
                        <p class="text-xs text-red-400 mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="description" 
                              rows="4" 
                              class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 px-4 text-sm text-white placeholder:text-white/30 focus:border-green-500 focus:outline-none focus:ring-1 focus:ring-green-500 @error('description') border-red-500 @enderror"
                              placeholder="Masukkan deskripsi kategori (opsional)">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-400 mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- GAMBAR SAAT INI -->
                @if($category->image)
                <div class="rounded-xl bg-white/5 p-6 border border-green-500/20">
                    <label class="block text-sm font-medium text-white/80 mb-4">
                        Gambar Saat Ini
                    </label>
                    
                    @php
                        $imagePath = null;
                        $imageExists = false;
                        
                        if ($category->image) {
                            $possiblePaths = [
                                'storage/' . $category->image,
                                'categories-images/' . $category->image,
                                'uploads/categories/' . $category->image,
                                'images/categories/' . $category->image,
                                $category->image
                            ];
                            
                            foreach ($possiblePaths as $path) {
                                if (file_exists(public_path($path))) {
                                    $imageExists = true;
                                    $imagePath = asset($path);
                                    break;
                                }
                            }
                        }
                    @endphp
                    
                    <div class="flex items-center gap-6">
                        @if($imageExists)
                            <div>
                                <img src="{{ $imagePath }}" 
                                     alt="{{ $category->name }}" 
                                     class="h-32 w-32 rounded-xl border border-green-500/30 object-cover">
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-white/50 break-all">{{ basename($category->image) }}</p>
                                <p class="text-xs text-green-400 mt-2 flex items-center gap-1">
                                    <i class="fas fa-check-circle"></i>
                                    File tersedia
                                </p>
                            </div>
                        @else
                            <div class="flex items-center gap-4">
                                <div class="flex h-32 w-32 items-center justify-center rounded-xl bg-white/5 border border-white/10">
                                    <i class="fas fa-image text-3xl text-white/30"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-yellow-400 flex items-center gap-2">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        File gambar tidak ditemukan
                                    </p>
                                    <p class="text-xs text-white/40 mt-1">{{ $category->image }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- GANTI GAMBAR -->
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        Ganti Gambar
                    </label>
                    <div class="border-2 border-dashed border-green-500/20 rounded-xl p-6 text-center hover:border-green-500 transition-colors">
                        <input type="file" 
                               name="image" 
                               accept="image/*" 
                               class="hidden" 
                               id="imageInput"
                               onchange="previewImage(event)">
                        
                        <label for="imageInput" class="cursor-pointer">
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-16 h-16 rounded-xl bg-green-500/20 border border-green-500/30 flex items-center justify-center">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-green-400"></i>
                                </div>
                                <span class="text-sm font-medium text-white/70">Klik untuk upload gambar baru</span>
                                <span class="text-xs text-white/40">Format: JPG, PNG. Maks: 2MB</span>
                            </div>
                        </label>
                    </div>

                    <!-- Preview Image -->
                    <div id="imagePreview" class="mt-4 hidden">
                        <p class="text-sm text-white/50 mb-2">Preview:</p>
                        <img src="" alt="Preview" class="h-32 w-32 rounded-xl border border-green-500/30 object-cover">
                    </div>

                    <p class="text-xs text-white/30 mt-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        Kosongkan jika tidak ingin mengubah gambar
                    </p>

                    @error('image')
                        <p class="text-xs text-red-400 mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- ACTION BUTTONS -->
                <div class="flex justify-end gap-3 pt-4 border-t border-white/10">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="px-8 py-3 rounded-xl bg-white/10 text-white/70 border border-white/20 hover:bg-white/20 transition-all">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold shadow-lg shadow-green-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all">
                        <i class="fas fa-save mr-2"></i>
                        Update Kategori
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');
    const previewImg = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection