<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Sembako', 'slug' => 'sembako', 'description' => 'Kebutuhan pokok sehari-hari'],
            ['name' => 'Minuman', 'slug' => 'minuman', 'description' => 'Berbagai jenis minuman'],
            ['name' => 'Makanan Ringan', 'slug' => 'makanan-ringan', 'description' => 'Snack dan cemilan'],
            ['name' => 'Perlengkapan Mandi', 'slug' => 'perlengkapan-mandi', 'description' => 'Sabun, shampoo, dll'],
            ['name' => 'Alat Rumah Tangga', 'slug' => 'alat-rumah-tangga', 'description' => 'Peralatan dapur dan rumah'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}