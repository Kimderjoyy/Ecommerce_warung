<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Schema;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah tabel ada
        if (!Schema::hasTable('payment_methods')) {
            $this->command->error('Tabel payment_methods belum ada. Jalankan migrasi terlebih dahulu!');
            return;
        }

        $methods = [
            [
                'name' => 'Transfer Bank',
                'code' => 'transfer',
                'icon' => 'fa-university',
                'description' => 'Bayar melalui transfer bank',
                'instructions' => 'Transfer ke rekening bank yang tersedia',
                'config' => json_encode(['banks' => ['BCA', 'BNI', 'BRI', 'Mandiri']]),
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'COD (Bayar di Tempat)',
                'code' => 'cod',
                'icon' => 'fa-money-bill-wave',
                'description' => 'Bayar saat pesanan diterima',
                'instructions' => 'Bayar tunai saat kurir sampai',
                'config' => null,
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'QRIS',
                'code' => 'qris',
                'icon' => 'fa-qrcode',
                'description' => 'Bayar menggunakan scan QRIS',
                'instructions' => 'Scan QRIS menggunakan aplikasi mobile banking',
                'config' => json_encode([
                    'merchant_name' => 'WARUNG ONLINE',
                    'nmiid' => 'ID1026477913564',
                    'version' => 'v0.0.2026.01.28',
                    'printed_by' => '93600914'
                ]),
                'sort_order' => 3,
                'is_active' => true
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::firstOrCreate(
                ['code' => $method['code']],
                $method
            );
        }

        $this->command->info('Payment methods seeded successfully!');
    }
}