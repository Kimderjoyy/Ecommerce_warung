<!-- Payment Info (untuk QRIS) -->
<div class="bg-blue-50 rounded-xl p-4 text-sm text-blue-800" x-show="paymentMethod === 'qris'">
    <div class="flex items-start gap-3">
        <i class="fas fa-info-circle mt-1"></i>
        <div>
            <p class="font-semibold mb-1">Informasi Pembayaran QRIS:</p>
            <ul class="list-disc list-inside text-xs space-y-1">
                <li>Scan QRIS menggunakan aplikasi mobile banking atau dompet digital</li>
                <li>Pastikan NMIID: <span class="font-mono font-bold">ID1026477913564</span></li>
                <li>Pesanan akan diproses setelah pembayaran terverifikasi</li>
                <li>Batas waktu pembayaran 24 jam</li>
            </ul>
        </div>
    </div>
</div>