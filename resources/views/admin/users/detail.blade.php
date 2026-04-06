<div class="space-y-6">
    {{-- Profile Header --}}
    <div class="flex items-center gap-5">
        {{-- Avatar --}}
        @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" 
                 alt="{{ $user->name }}" 
                 class="h-20 w-20 rounded-2xl border-2 border-green-500/30 object-cover">
        @else
            <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-r from-green-500 to-green-700 text-white text-3xl font-bold border-2 border-green-500/30">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif

        {{-- User Info --}}
        <div>
            <h4 class="text-xl font-bold text-white">{{ $user->name }}</h4>
            <p class="text-sm text-white/50">{{ $user->email }}</p>
            <div class="flex items-center gap-2 mt-3">
                {{-- Role Badge --}}
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

                {{-- Status Badge --}}
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
            </div>
        </div>
    </div>

    {{-- Detail Grid --}}
    <div class="grid grid-cols-2 gap-4">
        {{-- Phone --}}
        <div class="rounded-xl bg-white/5 p-4 border border-white/10">
            <p class="text-xs text-white/50 mb-1 flex items-center gap-1">
                <i class="fas fa-phone-alt text-green-400 text-xs"></i>
                No. Telepon
            </p>
            <p class="text-sm font-medium text-white">{{ $user->phone ?? '-' }}</p>
        </div>

        {{-- Join Date --}}
        <div class="rounded-xl bg-white/5 p-4 border border-white/10">
            <p class="text-xs text-white/50 mb-1 flex items-center gap-1">
                <i class="far fa-calendar-alt text-green-400 text-xs"></i>
                Bergabung
            </p>
            <p class="text-sm font-medium text-white">{{ $user->created_at->format('d M Y') }}</p>
        </div>

        {{-- Address --}}
        <div class="col-span-2 rounded-xl bg-white/5 p-4 border border-white/10">
            <p class="text-xs text-white/50 mb-1 flex items-center gap-1">
                <i class="fas fa-map-marker-alt text-green-400 text-xs"></i>
                Alamat
            </p>
            <p class="text-sm font-medium text-white">{{ $user->address ?? '-' }}</p>
        </div>
    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-3 gap-4">
        {{-- Total Orders --}}
        <div class="rounded-xl bg-green-500/10 p-4 text-center border border-green-500/20">
            <div class="text-2xl font-bold text-green-400">{{ $orderCount ?? 0 }}</div>
            <div class="text-xs text-white/50 mt-1">Total Pesanan</div>
        </div>

        {{-- Total Spent --}}
        <div class="rounded-xl bg-blue-500/10 p-4 text-center border border-blue-500/20">
            <div class="text-2xl font-bold text-blue-400">Rp {{ number_format($totalSpent ?? 0, 0, ',', '.') }}</div>
            <div class="text-xs text-white/50 mt-1">Total Belanja</div>
        </div>

        {{-- Total Reviews --}}
        <div class="rounded-xl bg-purple-500/10 p-4 text-center border border-purple-500/20">
            <div class="text-2xl font-bold text-purple-400">{{ $user->reviews_count ?? 0 }}</div>
            <div class="text-xs text-white/50 mt-1">Total Ulasan</div>
        </div>
    </div>

    {{-- Last Order --}}
    @if(isset($lastOrder) && $lastOrder)
    <div class="rounded-xl bg-white/5 p-5 border border-white/10">
        <p class="text-sm font-semibold text-white mb-3 flex items-center gap-2">
            <i class="fas fa-clock text-green-400"></i>
            Pesanan Terakhir
        </p>
        
        <div class="flex items-center justify-between mb-3">
            <div>
                <p class="font-medium text-white">#{{ $lastOrder->order_number }}</p>
                <p class="text-xs text-white/40 mt-1">
                    <i class="far fa-calendar-alt mr-1 text-green-400"></i>
                    {{ $lastOrder->created_at->format('d M Y H:i') }}
                </p>
            </div>
            
            @php
                $orderStatusClasses = [
                    'delivered' => 'bg-green-500/20 text-green-400 border-green-500/30',
                    'cancelled' => 'bg-red-500/20 text-red-400 border-red-500/30',
                    'pending' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                    'processing' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                    'shipped' => 'bg-purple-500/20 text-purple-400 border-purple-500/30',
                ];
                $orderStatusDots = [
                    'delivered' => 'bg-green-500',
                    'cancelled' => 'bg-red-500',
                    'pending' => 'bg-yellow-500',
                    'processing' => 'bg-blue-500',
                    'shipped' => 'bg-purple-500',
                ];
                $statusClass = $orderStatusClasses[$lastOrder->status] ?? 'bg-white/10 text-white/40 border-white/10';
                $dotClass = $orderStatusDots[$lastOrder->status] ?? 'bg-gray-500';
            @endphp
            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold border {{ $statusClass }}">
                <span class="h-1.5 w-1.5 rounded-full {{ $dotClass }}"></span>
                {{ ucfirst($lastOrder->status) }}
            </span>
        </div>
        
        <div class="flex items-center justify-between pt-3 border-t border-white/10">
            <span class="text-xs text-white/50">Total</span>
            <span class="text-sm font-bold text-green-400">
                Rp {{ number_format($lastOrder->total_amount, 0, ',', '.') }}
            </span>
        </div>
    </div>
    @endif

    {{-- REVIEWS SECTION --}}
    @if(isset($reviews) && $reviews->count() > 0)
    <div class="rounded-xl bg-white/5 p-5 border border-white/10">
        <p class="text-sm font-semibold text-white mb-4 flex items-center gap-2">
            <i class="fas fa-star text-yellow-400"></i>
            Ulasan yang Diberikan ({{ $reviews->count() }})
        </p>
        
        <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
            @foreach($reviews as $review)
            <div class="bg-gray-800/30 rounded-xl p-4 border border-green-500/10">
                <div class="flex items-start justify-between mb-2">
                    <div>
                        <a href="{{ route('admin.products.edit', $review->product) }}" class="text-green-400 hover:text-green-300 font-medium text-sm">
                            {{ $review->product->name }}
                        </a>
                        <p class="text-xs text-white/40">{{ $review->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="flex items-center gap-1 text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $review->rating ? 'opacity-100' : 'opacity-30' }} text-xs"></i>
                        @endfor
                    </div>
                </div>
                <p class="text-sm text-white/70">{{ $review->comment }}</p>
                @if($review->is_approved)
                    <span class="inline-block mt-2 text-xs bg-green-500/20 text-green-400 px-2 py-0.5 rounded-full">Disetujui</span>
                @else
                    <span class="inline-block mt-2 text-xs bg-yellow-500/20 text-yellow-400 px-2 py-0.5 rounded-full">Pending</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Action Buttons --}}
    <div class="flex gap-3 pt-4 border-t border-white/10">
        <a href="{{ route('admin.users.edit', $user) }}" 
           class="flex-1 flex items-center justify-center gap-2 rounded-xl bg-green-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-green-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all">
            <i class="fas fa-edit"></i>
            Edit User
        </a>
        
        @if($user->role !== 'admin')
        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="flex-1">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 rounded-xl bg-red-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-red-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all"
                    onclick="return confirm('Yakin ingin menghapus user ini?')">
                <i class="fas fa-trash"></i>
                Hapus User
            </button>
        </form>
        @endif
    </div>
</div>