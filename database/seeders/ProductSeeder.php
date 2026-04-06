<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua kategori
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $this->command->error('Tidak ada kategori. Jalankan CategorySeeder terlebih dahulu!');
            return;
        }

        // Mapping kategori
        $categoryMap = [];
        foreach ($categories as $category) {
            $categoryMap[$category->name] = $category->id;
        }

        // Data produk dummy
        $products = [
            // Sembako
            [
                'name' => 'Beras Premium 5kg',
                'description' => 'Beras kualitas premium, pulen dan wangi. Cocok untuk konsumsi sehari-hari.',
                'price' => 65000,
                'stock' => 50,
                'category_id' => $categoryMap['Sembako'] ?? 1,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Minyak Goreng Sania 2L',
                'description' => 'Minyak goreng kemasan 2 liter, jernih dan tahan panas.',
                'price' => 32000,
                'stock' => 45,
                'category_id' => $categoryMap['Sembako'] ?? 1,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Gula Pasir Gulaku 1kg',
                'description' => 'Gula pasir putih, manis dan berkualitas.',
                'price' => 15000,
                'stock' => 60,
                'category_id' => $categoryMap['Sembako'] ?? 1,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Tepung Terigu Segitiga Biru 1kg',
                'description' => 'Tepung terigu protein sedang, cocok untuk berbagai kebutuhan.',
                'price' => 12000,
                'stock' => 55,
                'category_id' => $categoryMap['Sembako'] ?? 1,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Telur Ayam Negeri 1kg',
                'description' => 'Telur ayam negeri segar, 1kg isi sekitar 15-17 butir.',
                'price' => 28000,
                'stock' => 40,
                'category_id' => $categoryMap['Sembako'] ?? 1,
                'is_active' => true,
                'image' => null
            ],
            
            // Minuman
            [
                'name' => 'Aqua Botol 600ml (1 dus)',
                'description' => 'Air mineral kemasan 600ml, 1 dus isi 24 botol.',
                'price' => 45000,
                'stock' => 30,
                'category_id' => $categoryMap['Minuman'] ?? 2,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Teh Botol Sosro 500ml',
                'description' => 'Teh botol siap minum, kemasan 500ml.',
                'price' => 5000,
                'stock' => 100,
                'category_id' => $categoryMap['Minuman'] ?? 2,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Kopi Kapal Api 200gr',
                'description' => 'Kopi bubuk dengan aroma khas, kemasan 200 gram.',
                'price' => 18000,
                'stock' => 35,
                'category_id' => $categoryMap['Minuman'] ?? 2,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Susu Kental Manis Frisian Flag 370gr',
                'description' => 'Susu kental manis, kemasan kaleng 370 gram.',
                'price' => 12000,
                'stock' => 45,
                'category_id' => $categoryMap['Minuman'] ?? 2,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Coca-Cola Kaleng 330ml (1 dus)',
                'description' => 'Minuman bersoda kemasan kaleng, 1 dus isi 24 kaleng.',
                'price' => 120000,
                'stock' => 20,
                'category_id' => $categoryMap['Minuman'] ?? 2,
                'is_active' => true,
                'image' => null
            ],
            
            // Snack
            [
                'name' => 'Indomie Goreng (1 dus)',
                'description' => 'Mie instan rasa goreng, 1 dus isi 40 bungkus.',
                'price' => 110000,
                'stock' => 25,
                'category_id' => $categoryMap['Snack'] ?? 3,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Chitato Sapi Panggang 68gr',
                'description' => 'Keripik kentang rasa sapi panggang, kemasan 68 gram.',
                'price' => 10000,
                'stock' => 80,
                'category_id' => $categoryMap['Snack'] ?? 3,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Oreo Coklat 133gr',
                'description' => 'Biskuit dengan krim rasa coklat, kemasan 133 gram.',
                'price' => 8500,
                'stock' => 70,
                'category_id' => $categoryMap['Snack'] ?? 3,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Qtela Singkong Pedas 80gr',
                'description' => 'Keripik singkong rasa pedas, kemasan 80 gram.',
                'price' => 7000,
                'stock' => 90,
                'category_id' => $categoryMap['Snack'] ?? 3,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'SilverQueen Coklat 45gr',
                'description' => 'Coklat batang dengan kacang almond, kemasan 45 gram.',
                'price' => 12000,
                'stock' => 50,
                'category_id' => $categoryMap['Snack'] ?? 3,
                'is_active' => true,
                'image' => null
            ],
            
            // Perlengkapan Mandi
            [
                'name' => 'Sabun Mandi Lifebuoy 135gr',
                'description' => 'Sabun mandi dengan perlindungan 10x lebih kuat.',
                'price' => 4000,
                'stock' => 120,
                'category_id' => $categoryMap['Perlengkapan Mandi'] ?? 4,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Shampoo Clear Cool Sport 170ml',
                'description' => 'Shampoo untuk rambut pria dengan sensasi dingin.',
                'price' => 18000,
                'stock' => 40,
                'category_id' => $categoryMap['Perlengkapan Mandi'] ?? 4,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Pasta Gigi Pepsodent 190gr',
                'description' => 'Pasta gigi dengan perlindungan ganda.',
                'price' => 9000,
                'stock' => 85,
                'category_id' => $categoryMap['Perlengkapan Mandi'] ?? 4,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Sabun Cuci Muka Garnier 100ml',
                'description' => 'Sabun cuci muka untuk kulit bersih dan segar.',
                'price' => 22000,
                'stock' => 30,
                'category_id' => $categoryMap['Perlengkapan Mandi'] ?? 4,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Deodorant Rexona Roll-On 50ml',
                'description' => 'Deodorant dengan perlindungan 48 jam.',
                'price' => 15000,
                'stock' => 45,
                'category_id' => $categoryMap['Perlengkapan Mandi'] ?? 4,
                'is_active' => true,
                'image' => null
            ],
            
            // Alat Rumah Tangga
            [
                'name' => 'Sabun Cuci Piring Sunlight 450ml',
                'description' => 'Sabun cuci piring dengan kekuatan membersihkan lemak.',
                'price' => 8000,
                'stock' => 75,
                'category_id' => $categoryMap['Alat Rumah Tangga'] ?? 5,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Sabun Cuci Baju Rinso 800gr',
                'description' => 'Deterjen bubuk untuk pakaian bersih dan wangi.',
                'price' => 20000,
                'stock' => 50,
                'category_id' => $categoryMap['Alat Rumah Tangga'] ?? 5,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Pewangi Pakaian Downy 540ml',
                'description' => 'Pewangi pakaian dengan aroma tahan lama.',
                'price' => 15000,
                'stock' => 60,
                'category_id' => $categoryMap['Alat Rumah Tangga'] ?? 5,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Lap Tangan Serbaguna (1 lusin)',
                'description' => 'Lap tangan berbahan katun, 1 lusin isi 12 pcs.',
                'price' => 30000,
                'stock' => 25,
                'category_id' => $categoryMap['Alat Rumah Tangga'] ?? 5,
                'is_active' => true,
                'image' => null
            ],
            [
                'name' => 'Sapu Ijuk',
                'description' => 'Sapu dari ijuk dengan gagang kayu.',
                'price' => 25000,
                'stock' => 15,
                'category_id' => $categoryMap['Alat Rumah Tangga'] ?? 5,
                'is_active' => true,
                'image' => null
            ],
        ];

        // Insert products
        foreach ($products as $product) {
            $product['slug'] = Str::slug($product['name']);
            
            // Cek apakah produk sudah ada
            $existing = Product::where('slug', $product['slug'])->first();
            
            if (!$existing) {
                Product::create($product);
                $this->command->info("Produk '{$product['name']}' berhasil ditambahkan.");
            } else {
                $this->command->warn("Produk '{$product['name']}' sudah ada, dilewati.");
            }
        }

        $this->command->info('Seeder produk selesai! Total produk: ' . count($products));
    }
}