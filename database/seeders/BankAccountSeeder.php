<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BankAccount;
use Illuminate\Support\Facades\DB;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama jika ada
        DB::table('bank_accounts')->truncate();

        // Insert data baru
        BankAccount::create([
            'bank_name' => 'BCA',
            'account_number' => '1673016921',
            'account_name' => 'MUHAMMAD AHDANIL HAKIM',
            'branch' => 'KCU Jakarta',
            'is_active' => true
        ]);

        BankAccount::create([
            'bank_name' => 'Mandiri',
            'account_number' => '1234567890',
            'account_name' => 'WarungOnline',
            'branch' => 'KCU Sudirman',
            'is_active' => true
        ]);

        BankAccount::create([
            'bank_name' => 'BRI',
            'account_number' => '0987654321',
            'account_name' => 'WarungOnline',
            'branch' => 'KCU Thamrin',
            'is_active' => true
        ]);

        BankAccount::create([
            'bank_name' => 'BNI',
            'account_number' => '5555555555',
            'account_name' => 'WarungOnline',
            'branch' => 'KCU Gatot Subroto',
            'is_active' => true
        ]);

        $this->command->info('Bank accounts seeded successfully!');
    }
}