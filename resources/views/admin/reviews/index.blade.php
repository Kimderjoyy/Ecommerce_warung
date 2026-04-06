@extends('layouts.admin')

@section('title', 'Manajemen Ulasan')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen Ulasan</h1>
            <p class="text-sm text-white/50 mt-1">Kelola semua ulasan dari pelanggan</p>
        </div>
        
        {{-- Filter dan Aksi --}}
        <div class="flex flex-wrap items-center gap-3">
            {{-- Tombol Approve All (hanya muncul jika ada pending) --}}
            @php
                $pendingCount = \App\Models\Review::where('is_approved', false)->count();
            @endphp
            @if($pendingCount > 0)
            <form action="{{ route('admin.reviews.approve-all') }}" method="POST" 
                  onsubmit="return confirm('Setujui semua {{ $pendingCount }} ulasan yang pending?')">
                @csrf
                <button type="submit" 
                        class="px-4 py-2.5 rounded-xl bg-green-600 text-white font-semibold hover:bg-green-700 transition-all flex items-center gap-2">
                    <i class="fas fa-check-double"></i>
                    Setujui Semua ({{ $pendingCount }})
                </button>
            </form>
            @endif
            
            {{-- Filter Status --}}
            <div class="flex rounded-xl bg-white/5 p-1 border border-white/10">
                <a href="{{ route('admin.reviews.index') }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all
                          {{ !request('status') ? 'bg-green-600 text-white' : 'text-white/70 hover:text-white' }}">
                    Semua
                </a>
                <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all
                          {{ request('status') == 'pending' ? 'bg-yellow-600 text-white' : 'text-white/70 hover:text-white' }}">
                    Pending
                </a>
                <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all
                          {{ request('status') == 'approved' ? 'bg-green-600 text-white' : 'text-white/70 hover:text-white' }}">
                    Disetujui
                </a>
            </div>
        </div>
    </div>

    {{-- Tabel Reviews --}}
    <div class="rounded-2xl bg-gray-800/50 border border-green-500/20 overflow-hidden">
        @if($reviews->isEmpty())
            <div class="text-center py-12">
                <div class="flex justify-center mb-4">
                    <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-white/5 border border-white/10">
                        <i class="fas fa-star text-3xl text-white/30"></i>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Tidak ada ulasan</h3>
                <p class="text-sm text-white/40">
                    @if(request('status') == 'pending')
                        Tidak ada ulasan pending.
                    @elseif(request('status') == 'approved')
                        Tidak ada ulasan disetujui.
                    @else
                        Belum ada ulasan yang masuk.
                    @endif
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase">Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase">Pelanggan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase">Rating</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase">Ulasan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/40 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($reviews as $review)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.products.edit', $review->product) }}" 
                                   class="text-green-400 hover:text-green-300 font-medium">
                                    {{ $review->product->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-r from-green-500 to-green-700 text-white text-sm font-bold">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-white">{{ $review->user->name }}</p>
                                        <p class="text-xs text-white/40">{{ $review->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1 text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-white/20' }} text-sm"></i>
                                    @endfor
                                </div>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <p class="text-sm text-white/70 line-clamp-2">{{ $review->comment ?: '-' }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-white/50">
                                {{ $review->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($review->is_approved)
                                    <span class="px-3 py-1 rounded-full text-xs bg-green-500/20 text-green-400 border border-green-500/30">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @if(!$review->is_approved)
                                    <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-green-500/20 border border-green-500/30 text-green-400 hover:bg-green-500 hover:text-white hover:scale-110 transition-all"
                                                title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-500/20 border border-red-500/30 text-red-400 hover:bg-red-500 hover:text-white hover:scale-110 transition-all"
                                                onclick="return confirm('Hapus ulasan ini?')"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            @if($reviews->hasPages())
            <div class="px-6 py-4 border-t border-white/10">
                {{ $reviews->withQueryString()->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection