<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Warung',
            'email' => 'admin@warung.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081290156531',
            'address' => 'Jl. Contoh No. 123'
        ]);

        // Buat sample customer
        User::create([
            'name' => 'Customer 1',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '089876543210',
            'address' => 'Jl. Pelanggan No. 456'
        ]);
    }
}