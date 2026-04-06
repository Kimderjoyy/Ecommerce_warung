@extends('layouts.admin')

@section('title', 'Manajemen Ulasan')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white">Manajemen Ulasan</h1>
        
        <div class="flex gap-2">
            <a href="{{ route('admin.reviews.index') }}" 
               class="px-4 py-2 rounded-lg bg-white/10 text-white hover:bg-white/20 transition-all">
                Semua
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-lg bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500 hover:text-white transition-all">
                Pending
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" 
               class="px-4 py-2 rounded-lg bg-green-500/20 text-green-400 hover:bg-green-500 hover:text-white transition-all">
                Disetujui
            </a>
        </div>
    </div>

    <div class="rounded-2xl bg-gray-800/50 border border-green-500/20 overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/10 bg-white/5">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-white/40">Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-white/40">User</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-white/40">Rating</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-white/40">Ulasan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-white/40">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-white/40">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                <tr class="border-b border-white/5 hover:bg-white/5">
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.products.edit', $review->product) }}" class="text-green-400 hover:underline">
                            {{ $review->product->name }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="text-white">{{ $review->user->name }}</p>
                            <p class="text-xs text-white/40">{{ $review->user->email }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1 text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'opacity-100' : 'opacity-30' }} text-sm"></i>
                            @endfor
                        </div>
                    </td>
                    <td class="px-6 py-4 max-w-xs">
                        <p class="text-white/70 text-sm line-clamp-2">{{ $review->comment }}</p>
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
                                        class="px-3 py-1 rounded-lg bg-green-500/20 text-green-400 border border-green-500/30 hover:bg-green-500 hover:text-white transition-all"
                                        title="Setujui">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif
                            
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-3 py-1 rounded-lg bg-red-500/20 text-red-400 border border-red-500/30 hover:bg-red-500 hover:text-white transition-all"
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

    <div class="mt-6">
        {{ $reviews->links() }}
    </div>
</div>
@endsection