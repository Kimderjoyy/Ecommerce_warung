@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
<div class="space-y-6">
    <!-- HEADER SECTION -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Edit Pengguna</h1>
            <p class="text-sm text-white/50 mt-1">Edit informasi pengguna #{{ $user->id }}</p>
        </div>
        <div class="flex items-center gap-3">
            <!-- Role Badge -->
            @php
                $roleClasses = [
                    'admin' => 'bg-red-500/20 text-red-400 border-red-500/30',
                    'customer' => 'bg-green-500/20 text-green-400 border-green-500/30',
                ];
                $roleDots = [
                    'admin' => 'bg-red-500',
                    'customer' => 'bg-green-500',
                ];
                $roleClass = $roleClasses[$user->role] ?? 'bg-white/10 text-white/40 border-white/10';
                $roleDot = $roleDots[$user->role] ?? 'bg-gray-500';
            @endphp
            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold border {{ $roleClass }}">
                <span class="h-1.5 w-1.5 rounded-full {{ $roleDot }}"></span>
                {{ ucfirst($user->role) }}
            </span>

            <!-- Status Badge -->
            @php
                $statusClasses = [
                    true => 'bg-green-500/20 text-green-400 border-green-500/30',
                    false => 'bg-red-500/20 text-red-400 border-red-500/30',
                ];
                $statusDots = [
                    true => 'bg-green-500',
                    false => 'bg-red-500',
                ];
                $statusClass = $statusClasses[$user->is_active] ?? 'bg-white/10 text-white/40 border-white/10';
                $statusDot = $statusDots[$user->is_active] ?? 'bg-gray-500';
                $statusLabel = $user->is_active ? 'Aktif' : 'Tidak Aktif';
            @endphp
            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold border {{ $statusClass }}">
                <span class="h-1.5 w-1.5 rounded-full {{ $statusDot }}"></span>
                {{ $statusLabel }}
            </span>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="rounded-2xl bg-gray-800/50 p-8 border border-green-500/20 backdrop-blur-sm">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- AVATAR SECTION -->
            <div class="mb-8 rounded-xl bg-white/5 p-6 border border-green-500/20">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <!-- Avatar Preview -->
                    <div class="flex-shrink-0" x-data="avatarHandler()">
                        <template x-if="!preview">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" 
                                     alt="{{ $user->name }}" 
                                     class="h-24 w-24 rounded-2xl border-2 border-green-500/30 object-cover"
                                     id="currentAvatar">
                            @else
                                <div class="flex h-24 w-24 items-center justify-center rounded-2xl bg-gradient-to-r from-green-500 to-green-700 text-white text-3xl font-bold border-2 border-green-500/30">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </template>
                        <template x-if="preview">
                            <img :src="preview" alt="Preview" class="h-24 w-24 rounded-2xl border-2 border-green-500/30 object-cover">
                        </template>
                    </div>

                    <!-- Upload Controls -->
                    <div class="flex-1 text-center md:text-left">
                        <h3 class="text-lg font-semibold text-white mb-2">Foto Profil</h3>
                        <p class="text-sm text-white/50 mb-4">Format: JPG, PNG. Maks: 2MB.</p>

                        <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                            <label for="avatarInput" 
                                   class="cursor-pointer inline-flex items-center gap-2 rounded-xl bg-green-500/20 px-5 py-2.5 text-sm font-semibold text-green-400 border border-green-500/30 hover:bg-green-500 hover:text-white transition-all">
                                <i class="fas fa-cloud-upload-alt"></i>
                                Pilih Foto
                            </label>

                            @if($user->avatar)
                            <button type="button" 
                                    onclick="openAvatarModal()"
                                    class="inline-flex items-center gap-2 rounded-xl bg-red-500/20 px-5 py-2.5 text-sm font-semibold text-red-400 border border-red-500/30 hover:bg-red-500 hover:text-white transition-all">
                                <i class="fas fa-trash"></i>
                                Hapus Foto
                            </button>
                            @endif

                            <input type="file" 
                                   id="avatarInput" 
                                   name="avatar" 
                                   accept="image/*" 
                                   class="hidden"
                                   @change="handleUpload">
                        </div>

                        <p class="text-xs text-white/30 mt-3" x-text="fileName"></p>
                    </div>
                </div>
            </div>

            <!-- HIDDEN INPUT -->
            <input type="hidden" name="remove_avatar" id="removeAvatar" value="0">

            <!-- FORM GRID -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        <i class="fas fa-user text-green-400 w-5 mr-2"></i>
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-white/30 text-sm"></i>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               required
                               class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 pl-11 pr-4 text-sm text-white placeholder:text-white/30 focus:border-green-500 focus:outline-none @error('name') border-red-500 @enderror"
                               placeholder="Masukkan nama lengkap">
                    </div>
                    @error('name')
                        <p class="text-xs text-red-400 mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        <i class="fas fa-envelope text-green-400 w-5 mr-2"></i>
                        Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-white/30 text-sm"></i>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               required
                               class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 pl-11 pr-4 text-sm text-white placeholder:text-white/30 focus:border-green-500 focus:outline-none @error('email') border-red-500 @enderror"
                               placeholder="user@example.com">
                    </div>
                    @error('email')
                        <p class="text-xs text-red-400 mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- No Telepon -->
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        <i class="fas fa-phone-alt text-green-400 w-5 mr-2"></i>
                        No. Telepon
                    </label>
                    <div class="relative">
                        <i class="fas fa-phone-alt absolute left-4 top-1/2 -translate-y-1/2 text-white/30 text-sm"></i>
                        <input type="text" 
                               name="phone" 
                               value="{{ old('phone', $user->phone) }}" 
                               class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 pl-11 pr-4 text-sm text-white placeholder:text-white/30 focus:border-green-500 focus:outline-none @error('phone') border-red-500 @enderror"
                               placeholder="08xxxxxxxxxx">
                    </div>
                    @error('phone')
                        <p class="text-xs text-red-400 mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        <i class="fas fa-tag text-green-400 w-5 mr-2"></i>
                        Role <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-3">
                        <!-- Admin Option -->
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" 
                                   name="role" 
                                   value="admin" 
                                   class="hidden peer"
                                   {{ $user->role == 'admin' ? 'checked' : '' }}
                                   {{ $user->role == 'admin' ? 'disabled' : '' }}>
                            <div class="flex items-center justify-center gap-2 rounded-xl border py-3 px-4 text-sm font-semibold transition-all
                                peer-checked:bg-red-500 peer-checked:text-white peer-checked:border-red-500
                                {{ $user->role == 'admin' ? 'bg-red-500/20 text-red-400 border-red-500/30' : 'bg-white/5 text-white/50 border-white/10 hover:bg-white/10' }}">
                                <i class="fas fa-shield-alt"></i>
                                Admin
                            </div>
                        </label>

                        <!-- Customer Option -->
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" 
                                   name="role" 
                                   value="customer" 
                                   class="hidden peer"
                                   {{ $user->role == 'customer' ? 'checked' : '' }}>
                            <div class="flex items-center justify-center gap-2 rounded-xl border py-3 px-4 text-sm font-semibold transition-all
                                peer-checked:bg-green-500 peer-checked:text-white peer-checked:border-green-500
                                {{ $user->role == 'customer' ? 'bg-green-500/20 text-green-400 border-green-500/30' : 'bg-white/5 text-white/50 border-white/10 hover:bg-white/10' }}">
                                <i class="fas fa-user"></i>
                                Customer
                            </div>
                        </label>
                    </div>
                    @if($user->role == 'admin')
                        <p class="text-xs text-yellow-400/70 mt-2 flex items-center gap-1">
                            <i class="fas fa-info-circle"></i>
                            Role admin tidak dapat diubah
                        </p>
                    @endif
                    @error('role')
                        <p class="text-xs text-red-400 mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        <i class="fas fa-circle text-green-400 w-5 mr-2"></i>
                        Status Akun
                    </label>
                    <div class="flex items-center gap-4">
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1" 
                                   class="peer sr-only"
                                   {{ $user->is_active ? 'checked' : '' }}>
                            <div class="peer h-7 w-12 rounded-full border border-white/10 bg-white/5 after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white/30 after:transition-all after:content-[''] peer-checked:bg-green-500 peer-checked:after:translate-x-5 peer-checked:after:bg-white"></div>
                        </label>
                        <span class="text-sm font-medium {{ $user->is_active ? 'text-green-400' : 'text-red-400' }}">
                            {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                    <p class="text-xs text-white/30 mt-2">
                        <i class="fas fa-info-circle text-green-400 mr-1"></i>
                        Nonaktifkan akun jika pengguna tidak diizinkan login
                    </p>
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        <i class="fas fa-map-marker-alt text-green-400 w-5 mr-2"></i>
                        Alamat
                    </label>
                    <textarea name="address" 
                              rows="4" 
                              class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 px-4 text-sm text-white placeholder:text-white/30 focus:border-green-500 focus:outline-none @error('address') border-red-500 @enderror"
                              placeholder="Masukkan alamat lengkap">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="text-xs text-red-400 mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- DIVIDER -->
            <div class="flex items-center gap-4 my-8">
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-green-500/30 to-transparent"></div>
                <span class="text-xs font-semibold text-white/40 uppercase tracking-wider flex items-center gap-2">
                    <i class="fas fa-lock text-green-400"></i>
                    Ubah Password
                </span>
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-green-500/30 to-transparent"></div>
            </div>

            <!-- PASSWORD FIELDS -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- New Password -->
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        <i class="fas fa-key text-green-400 w-5 mr-2"></i>
                        Password Baru
                    </label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-white/30 text-sm"></i>
                        <input type="password" 
                               name="password" 
                               class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 pl-11 pr-4 text-sm text-white placeholder:text-white/30 focus:border-green-500 focus:outline-none @error('password') border-red-500 @enderror"
                               placeholder="Minimal 8 karakter">
                    </div>
                    <p class="text-xs text-white/30 mt-2">Kosongkan jika tidak ingin mengubah password</p>
                    @error('password')
                        <p class="text-xs text-red-400 mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        <i class="fas fa-check-circle text-green-400 w-5 mr-2"></i>
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-white/30 text-sm"></i>
                        <input type="password" 
                               name="password_confirmation" 
                               class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 pl-11 pr-4 text-sm text-white placeholder:text-white/30 focus:border-green-500 focus:outline-none"
                               placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>

            <!-- INFO CARD -->
            <div class="mt-8 rounded-xl bg-green-500/10 p-6 border border-green-500/20">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-500/20 border border-green-500/30 text-green-400 text-xl">
                        <i class="fas fa-info"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-green-400 mb-2">Informasi Akun</h4>
                        <ul class="text-sm text-green-400/70 space-y-2">
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-xs"></i>
                                ID Pengguna: <span class="font-mono font-bold text-white">{{ $user->id }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-xs"></i>
                                Bergabung: {{ $user->created_at->format('d M Y H:i') }}
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-xs"></i>
                                Terakhir update: {{ $user->updated_at->format('d M Y H:i') }}
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-xs"></i>
                                Total pesanan: {{ $user->orders_count ?? 0 }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- FORM ACTIONS -->
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-white/10">
                <a href="{{ route('admin.users.index') }}" 
                   class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-6 py-3 text-sm font-semibold text-white/70 border border-white/20 hover:bg-white/20 transition-all">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
                <div class="flex gap-3">
                    <button type="reset" 
                            class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-6 py-3 text-sm font-semibold text-white/70 border border-white/20 hover:bg-white/20 transition-all">
                        <i class="fas fa-undo"></i>
                        Reset
                    </button>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-green-500 to-green-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-green-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS AVATAR -->
<div id="avatarModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeAvatarModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md">
        <div class="rounded-2xl bg-gray-800 p-8 border border-red-500/20">
            <div class="text-center">
                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-red-500/20 border border-red-500/30 mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-3xl text-red-400"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Hapus Foto Profil?</h3>
                <p class="text-sm text-white/50 mb-6">
                    Apakah Anda yakin ingin menghapus foto profil pengguna ini?
                </p>
                <div class="flex gap-3">
                    <button onclick="closeAvatarModal()" 
                            class="flex-1 rounded-xl bg-white/10 px-6 py-3 text-sm font-semibold text-white/70 border border-white/20 hover:bg-white/20 transition-all">
                        Batal
                    </button>
                    <button onclick="removeAvatar()" 
                            class="flex-1 rounded-xl bg-red-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-red-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Avatar Handler
    function avatarHandler() {
        return {
            preview: null,
            fileName: '',
            
            handleUpload(event) {
                const file = event.target.files[0];
                if (!file) return;
                
                if (!file.type.match('image.*')) {
                    alert('File harus berupa gambar!');
                    return;
                }
                
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2MB!');
                    return;
                }
                
                this.preview = URL.createObjectURL(file);
                this.fileName = file.name;
                
                const currentAvatar = document.getElementById('currentAvatar');
                if (currentAvatar) currentAvatar.style.display = 'none';
            }
        }
    }

    // Modal Functions
    function openAvatarModal() {
        document.getElementById('avatarModal').classList.remove('hidden');
    }

    function closeAvatarModal() {
        document.getElementById('avatarModal').classList.add('hidden');
    }

    function removeAvatar() {
        document.getElementById('removeAvatar').value = '1';
        
        const currentAvatar = document.getElementById('currentAvatar');
        if (currentAvatar) currentAvatar.style.display = 'none';
        
        closeAvatarModal();
        document.getElementById('avatarInput').value = '';
    }

    // Status Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const statusToggle = document.querySelector('input[name="is_active"]');
        if (statusToggle) {
            statusToggle.addEventListener('change', function() {
                const label = this.nextElementSibling.nextElementSibling;
                if (this.checked) {
                    label.textContent = 'Aktif';
                    label.className = 'text-sm font-medium text-green-400';
                } else {
                    label.textContent = 'Tidak Aktif';
                    label.className = 'text-sm font-medium text-red-400';
                }
            });
        }
    });

    // ESC Key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeAvatarModal();
    });

    // Alpine
    document.addEventListener('alpine:init', () => {
        Alpine.data('avatarHandler', avatarHandler);
    });
</script>
@endpush
@endsection