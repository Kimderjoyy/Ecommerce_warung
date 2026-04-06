<!-- QRIS Preview (muncul jika pilih QRIS) -->
<div x-show="paymentMethod === 'qris'" x-cloak class="qris-preview">
    <div class="qris-code">
        @php
            $qrisPath = public_path('images/qris-warungonline.png');
            $qrisExists = file_exists($qrisPath);
            $qrisUrl = $qrisExists ? asset('images/qris-warungonline.png') . '?v=' . filemtime($qrisPath) : null;
        @endphp
        
        @if($qrisExists)
            <img src="{{ $qrisUrl }}" 
                 alt="QRIS WarungOnline"
                 class="mx-auto"
                 onerror="this.onerror=null; this.src='https://via.placeholder.com/250x250?text=QRIS+Error'; this.classList.add('border-2', 'border-red-500');">
        @else
            <!-- QRIS Dummy dengan informasi -->
            <div class="bg-gradient-to-r from-green-500 to-green-700 p-6 rounded-xl text-white mb-4">
                <i class="fas fa-qrcode fa-5x mb-3 opacity-80"></i>
                <p class="text-2xl font-bold mb-1">WARUNG ONLINE</p>
                <p class="text-sm opacity-90 mb-2">NMIID: ID1026477913564</p>
                <div class="bg-white/20 p-2 rounded-lg">
                    <p class="text-xs font-semibold">SATU QRIS UNTUK SEMUA</p>
                </div>
            </div>
            
            <!-- Upload Instruction -->
            <div class="bg-yellow-50 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg mb-3">
                <p class="text-sm flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Gambar QRIS belum tersedia. Silakan upload ke:</span>
                </p>
                <code class="block bg-yellow-100 px-3 py-2 rounded-lg text-xs mt-2">
                    public/images/qris-warungonline.png
                </code>
            </div>
        @endif
        
        <!-- QRIS Info (tetap ditampilkan) -->
        <div class="qris-info">
            <div class="qris-info-item">
                <div class="qris-info-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Nama Merchant</p>
                    <p class="font-semibold text-gray-800">WARUNG ONLINE</p>
                </div>
            </div>
            
            <div class="qris-info-item">
                <div class="qris-info-icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">NMIID</p>
                    <p class="font-semibold text-gray-800 font-mono">ID1026477913564</p>
                </div>
            </div>
            
            <div class="qris-info-item">
                <div class="qris-info-icon">
                    <i class="fas fa-qrcode"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Versi Cetak</p>
                    <p class="font-semibold text-gray-800">v0.0.2026.01.28</p>
                </div>
            </div>
            
            <div class="qris-info-item">
                <div class="qris-info-icon">
                    <i class="fas fa-print"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Dicetak oleh</p>
                    <p class="font-semibold text-gray-800">93600914</p>
                </div>
            </div>
        </div>
        
        <p class="text-sm text-green-600 font-semibold mt-3">SATU QRIS UNTUK SEMUA</p>
        <p class="text-xs text-gray-500 mb-3">Cek aplikasi penyelenggara di: www.aspi-qris.id</p>
        
        <button type="button" class="copy-btn" onclick="copyQrisInfo()">
            <i class="fas fa-copy"></i>
            Salin Info QRIS
        </button>
    </div>
    
    <p class="text-xs text-gray-400 text-center mt-3">
        <i class="fas fa-info-circle text-green-500 mr-1"></i>
        Scan QRIS menggunakan aplikasi mobile banking yang mendukung QRIS
    </p>
</div>