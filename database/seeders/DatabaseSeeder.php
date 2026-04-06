<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Truncate tables (hapus semua data)
        DB::table('users')->truncate();
        DB::table('categories')->truncate();
        DB::table('products')->truncate();
        DB::table('payment_methods')->truncate();
        DB::table('bank_accounts')->truncate();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Jalankan seeder
        $this->call([
            AdminUserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class, // <-- TAMBAHKAN INI
            PaymentMethodSeeder::class,
            BankAccountSeeder::class,
        ]);
    }
}