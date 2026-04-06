@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen Pengguna</h1>
            <p class="text-sm text-white/50 mt-1">Kelola semua pengguna aplikasi</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="rounded-xl bg-green-500/20 px-5 py-3 border border-green-500/30">
                <i class="fas fa-users text-green-400 mr-2"></i>
                <span class="font-semibold text-white">Total: {{ $users->total() }}</span>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Total Users --}}
        <div class="rounded-2xl bg-gray-800/50 p-6 border border-green-500/20">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-green-500/20 border border-green-500/30 text-green-400 text-2xl">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <p class="text-sm text-white/50">Total Pengguna</p>
                    <h3 class="text-2xl font-bold text-white">{{ $totalUsers }}</h3>
                    <p class="text-xs text-green-400 mt-1 flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i>
                        +{{ $newUsers }} bulan ini
                    </p>
                </div>
            </div>
        </div>

        {{-- Total Reviews --}}
        <div class="rounded-2xl bg-gray-800/50 p-6 border border-yellow-500/20">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-yellow-500/20 border border-yellow-500/30 text-yellow-400 text-2xl">
                    <i class="fas fa-star"></i>
                </div>
                <div>
                    <p class="text-sm text-white/50">Total Ulasan</p>
                    <h3 class="text-2xl font-bold text-white">{{ $totalReviews ?? 0 }}</h3>
                    <p class="text-xs text-yellow-400 mt-1 flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i>
                        +{{ $pendingReviews ?? 0 }} pending
                    </p>
                </div>
            </div>
        </div>

        {{-- Admin Users --}}
        <div class="rounded-2xl bg-gray-800/50 p-6 border border-red-500/20">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-red-500/20 border border-red-500/30 text-red-400 text-2xl">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <p class="text-sm text-white/50">Administrator</p>
                    <h3 class="text-2xl font-bold text-white">{{ $adminCount }}</h3>
                    <p class="text-xs text-white/40 mt-1">Dengan akses penuh</p>
                </div>
            </div>
        </div>

        {{-- Customer Users --}}
        <div class="rounded-2xl bg-gray-800/50 p-6 border border-blue-500/20">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-blue-500/20 border border-blue-500/30 text-blue-400 text-2xl">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <p class="text-sm text-white/50">Pelanggan</p>
                    <h3 class="text-2xl font-bold text-white">{{ $customerCount }}</h3>
                    <p class="text-xs text-green-400 mt-1 flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i>
                        +{{ $newCustomers }} baru
                    </p>
                </div>
            </div>
        </div>

        {{-- Active Users --}}
        <div class="rounded-2xl bg-gray-800/50 p-6 border border-purple-500/20">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-purple-500/20 border border-purple-500/30 text-purple-400 text-2xl">
                    <i class="fas fa-user-check"></i>
                </div>
                <div>
                    <p class="text-sm text-white/50">Aktif Hari Ini</p>
                    <h3 class="text-2xl font-bold text-white">{{ $activeToday }}</h3>
                    <p class="text-xs text-green-400 mt-1 flex items-center gap-1">
                        <i class="fas fa-circle text-green-500 text-[6px]"></i>
                        Online sekarang
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="rounded-2xl bg-gray-800/50 p-6 border border-green-500/20">
        <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Search --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        <i class="fas fa-search text-green-400 mr-2"></i>
                        Cari Pengguna
                    </label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/30 text-sm"></i>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 pl-11 pr-4 text-sm text-white placeholder:text-white/30 focus:border-green-500 focus:outline-none"
                               placeholder="Nama atau email pengguna...">
                    </div>
                </div>

                {{-- Role Filter --}}
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        <i class="fas fa-tag text-green-400 mr-2"></i>
                        Role
                    </label>
                    <select name="role" 
                            class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 px-4 text-sm text-white focus:border-green-500 focus:outline-none">
                        <option value="" class="bg-gray-800">Semua Role</option>
                        <option value="admin" class="bg-gray-800" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                        <option value="customer" class="bg-gray-800" {{ request('role') == 'customer' ? 'selected' : '' }}>Pelanggan</option>
                    </select>
                </div>

                {{-- Status Filter --}}
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-2">
                        <i class="fas fa-circle text-green-400 mr-2"></i>
                        Status
                    </label>
                    <select name="status" 
                            class="w-full rounded-xl border border-green-500/20 bg-white/5 py-3 px-4 text-sm text-white focus:border-green-500 focus:outline-none">
                        <option value="" class="bg-gray-800">Semua Status</option>
                        <option value="active" class="bg-gray-800" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" class="bg-gray-800" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                @if(request()->anyFilled(['search', 'role', 'status']))
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-6 py-3 rounded-xl bg-white/10 text-white/70 border border-white/20 hover:bg-white/20 transition-all">
                        <i class="fas fa-times mr-2"></i>
                        Reset Filter
                    </a>
                @endif
                <button type="submit" 
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold shadow-lg shadow-green-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    <i class="fas fa-filter mr-2"></i>
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    {{-- View Toggle --}}
    <div class="flex justify-end">
        <div class="rounded-xl bg-white/5 p-1 border border-white/10">
            <button class="view-toggle-btn active px-5 py-2 rounded-lg text-sm font-medium text-white bg-green-600 transition-all" data-view="grid">
                <i class="fas fa-grid-2 mr-2"></i>
                Grid
            </button>
            <button class="view-toggle-btn px-5 py-2 rounded-lg text-sm font-medium text-white/70 hover:text-white transition-all" data-view="table">
                <i class="fas fa-table mr-2"></i>
                Tabel
            </button>
        </div>
    </div>

    {{-- Grid View --}}
    <div id="gridView" class="view-container">
        @if($users->isEmpty())
            {{-- Empty State --}}
            <div class="rounded-2xl bg-gray-800/50 p-12 border border-green-500/20 text-center">
                <div class="flex justify-center mb-4">
                    <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-white/5 border border-white/10">
                        <i class="fas fa-users-slash text-3xl text-white/30"></i>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Tidak ada pengguna</h3>
                <p class="text-sm text-white/40">Belum ada pengguna yang terdaftar di sistem</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($users as $user)
                <div class="group rounded-2xl bg-gray-800/50 p-6 border border-green-500/20 hover:border-green-500/40 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    {{-- Role Badge --}}
                    <div class="absolute top-4 right-4">
                        @php
                            $roleClasses = [
                                'admin' => 'bg-red-500/20 text-red-400 border-red-500/30',
                                'customer' => 'bg-green-500/20 text-green-400 border-green-500/30',
                            ];
                            $roleClass = $roleClasses[$user->role] ?? 'bg-white/10 text-white/40 border-white/10';
                            $roleDot = $user->role === 'admin' ? 'bg-red-500' : 'bg-green-500';
                        @endphp
                        <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold border {{ $roleClass }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $roleDot }}"></span>
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                    {{-- Avatar --}}
                    <div class="flex justify-center">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                 alt="{{ $user->name }}" 
                                 class="h-20 w-20 rounded-2xl border-2 border-green-500/30 object-cover group-hover:scale-105 group-hover:rotate-3 transition-all duration-300">
                        @else
                            <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-r from-green-500 to-green-700 text-white text-3xl font-bold border-2 border-green-500/30 group-hover:scale-105 group-hover:rotate-3 transition-all duration-300">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    {{-- User Info --}}
                    <div class="text-center my-4">
                        <h3 class="font-semibold text-white text-lg mb-1">{{ $user->name }}</h3>
                        <p class="text-sm text-white/50">{{ $user->email }}</p>
                        <p class="text-xs text-white/30 mt-2">
                            <i class="far fa-calendar-alt mr-1 text-green-400"></i>
                            Bergabung {{ $user->created_at->format('d M Y') }}
                        </p>
                    </div>

                    {{-- Stats with REAL review count --}}
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="text-center p-3 rounded-xl bg-white/5 border border-white/10">
                            <div class="font-bold text-white">{{ $user->orders_count ?? 0 }}</div>
                            <div class="text-xs text-white/40">Pesanan</div>
                        </div>
                        <div class="text-center p-3 rounded-xl bg-white/5 border border-white/10">
                            <div class="font-bold text-white">{{ $user->reviews_count ?? 0 }}</div>
                            <div class="text-xs text-white/40">Ulasan</div>
                        </div>
                    </div>

                    {{-- Contact Info --}}
                    <div class="space-y-2 mb-4">
                        @if($user->phone)
                        <div class="flex items-center text-sm text-white/70">
                            <i class="fas fa-phone-alt w-5 text-green-400"></i>
                            <span class="ml-2">{{ $user->phone }}</span>
                        </div>
                        @endif
                        
                        @if($user->address)
                        <div class="flex items-center text-sm text-white/70">
                            <i class="fas fa-map-marker-alt w-5 text-green-400"></i>
                            <span class="ml-2 truncate">{{ $user->address }}</span>
                        </div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-center gap-2 pt-4 border-t border-white/10">
                        {{-- Edit Button (semua user) --}}
                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-500/20 border border-blue-500/30 text-blue-400 hover:bg-blue-500 hover:text-white hover:scale-110 transition-all"
                           title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        {{-- Delete Button (hanya untuk customer) --}}
                        @if($user->role === 'customer')
                        <form action="{{ route('admin.users.destroy', $user) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-500/20 border border-red-500/30 text-red-400 hover:bg-red-500 hover:text-white hover:scale-110 transition-all"
                                    title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                        
                        {{-- Detail Button (hanya untuk customer) --}}
                        @if($user->role === 'customer')
                        <button type="button"
                                onclick="showUserDetail({{ $user->id }})"
                                class="flex h-9 w-9 items-center justify-center rounded-lg bg-green-500/20 border border-green-500/30 text-green-400 hover:bg-green-500 hover:text-white hover:scale-110 transition-all"
                                title="Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Table View --}}
    <div id="tableView" class="view-container hidden">
        <div class="rounded-2xl bg-gray-800/50 border border-green-500/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase">User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase">Kontak</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase">Bergabung</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($users as $user)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" 
                                             alt="{{ $user->name }}" 
                                             class="h-8 w-8 rounded-lg border border-green-500/30 object-cover">
                                    @else
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-r from-green-500 to-green-700 text-white text-sm font-bold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-white">{{ $user->name }}</p>
                                        <p class="text-xs text-white/40">{{ $user->email }}</p>
                                        <p class="text-xs text-yellow-400/70 mt-1">
                                            <i class="fas fa-star mr-1"></i>
                                            {{ $user->reviews_count ?? 0 }} ulasan
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-white/70">
                                {{ $user->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $roleClasses = [
                                        'admin' => 'bg-red-500/20 text-red-400 border-red-500/30',
                                        'customer' => 'bg-green-500/20 text-green-400 border-green-500/30',
                                    ];
                                    $roleClass = $roleClasses[$user->role] ?? 'bg-white/10 text-white/40 border-white/10';
                                    $roleDot = $user->role === 'admin' ? 'bg-red-500' : 'bg-green-500';
                                @endphp
                                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold border {{ $roleClass }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $roleDot }}"></span>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        true => 'bg-green-500/20 text-green-400 border-green-500/30',
                                        false => 'bg-red-500/20 text-red-400 border-red-500/30',
                                    ];
                                    $statusClass = $statusClasses[$user->is_active] ?? 'bg-white/10 text-white/40 border-white/10';
                                    $statusDot = $user->is_active ? 'bg-green-500' : 'bg-red-500';
                                @endphp
                                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold border {{ $statusClass }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $statusDot }}"></span>
                                    {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-white/50">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    {{-- Edit Button (semua user) --}}
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-500/20 border border-blue-500/30 text-blue-400 hover:bg-blue-500 hover:text-white hover:scale-110 transition-all"
                                       title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    
                                    {{-- Delete Button (hanya untuk customer) --}}
                                    @if($user->role === 'customer')
                                    <form action="{{ route('admin.users.destroy', $user) }}" 
                                          method="POST" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-500/20 border border-red-500/30 text-red-400 hover:bg-red-500 hover:text-white hover:scale-110 transition-all"
                                                title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    {{-- Detail Button (hanya untuk customer) --}}
                                    @if($user->role === 'customer')
                                    <button type="button"
                                            onclick="showUserDetail({{ $user->id }})"
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-green-500/20 border border-green-500/30 text-green-400 hover:bg-green-500 hover:text-white hover:scale-110 transition-all"
                                            title="Detail">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
    <div class="mt-8">
        {{ $users->withQueryString()->links() }}
    </div>
    @endif
</div>

{{-- User Detail Modal --}}
<div id="userDetailModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeUserModal()"></div>
    
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl">
        <div class="rounded-2xl bg-gray-800 p-8 border border-green-500/20">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Detail Pengguna</h3>
                <button onclick="closeUserModal()" class="text-white/50 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div id="userDetailContent" class="text-center py-8">
                <i class="fas fa-spinner fa-spin text-3xl text-green-400"></i>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function() {
        // Toggle Grid/Table View
        const viewBtns = document.querySelectorAll('.view-toggle-btn');
        const gridView = document.getElementById('gridView');
        const tableView = document.getElementById('tableView');
        
        if (viewBtns.length && gridView && tableView) {
            viewBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    viewBtns.forEach(b => {
                        b.classList.remove('active', 'bg-green-600', 'text-white');
                        b.classList.add('text-white/70');
                    });
                    
                    // Add active class to clicked button
                    this.classList.add('active', 'bg-green-600', 'text-white');
                    this.classList.remove('text-white/70');
                    
                    // Show corresponding view
                    const view = this.dataset.view;
                    if (view === 'grid') {
                        gridView.classList.remove('hidden');
                        tableView.classList.add('hidden');
                    } else {
                        gridView.classList.add('hidden');
                        tableView.classList.remove('hidden');
                    }
                });
            });
        }

        // User Detail Modal Functions
        window.showUserDetail = function(userId) {
            const modal = document.getElementById('userDetailModal');
            const content = document.getElementById('userDetailContent');
            
            if (!modal || !content) return;
            
            modal.classList.remove('hidden');
            content.innerHTML = '<i class="fas fa-spinner fa-spin text-3xl text-green-400"></i>';
            
            fetch(`/admin/users/${userId}/detail`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    content.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    content.innerHTML = `
                        <div class="text-center text-red-400">
                            <i class="fas fa-exclamation-circle text-3xl mb-3"></i>
                            <p>Gagal memuat detail pengguna</p>
                        </div>
                    `;
                });
        };

        window.closeUserModal = function() {
            const modal = document.getElementById('userDetailModal');
            const content = document.getElementById('userDetailContent');
            
            if (modal) {
                modal.classList.add('hidden');
            }
            
            if (content) {
                content.innerHTML = '<i class="fas fa-spinner fa-spin text-3xl text-green-400"></i>';
            }
        };

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.closeUserModal();
            }
        });
    })();
</script>
@endpush
@endsection