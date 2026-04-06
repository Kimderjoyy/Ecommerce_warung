<?php
// Load Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Product;
use Illuminate\Support\Facades\DB;

echo "<h1 style='color: #10b981;'>🔧 FIX GAMBAR PRODUK - VERSION 2.0</h1>";

// 1. Buat folder product-images
$targetFolder = __DIR__ . '/product-images';
if (!is_dir($targetFolder)) {
    mkdir($targetFolder, 0777, true);
    echo "<p style='color:green'>✅ Folder product-images berhasil dibuat</p>";
}

// 2. Cek semua produk
$products = Product::all();
echo "<p>Total produk: " . $products->count() . "</p>";

echo "<table border='1' cellpadding='8' style='border-collapse: collapse; width: 100%;'>";
echo "<tr style='background: #f0fdf4;'>
        <th>ID</th>
        <th>Nama</th>
        <th>Path Lama</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>";

foreach ($products as $product) {
    echo "<tr>";
    echo "<td>{$product->id}</td>";
    echo "<td>{$product->name}</td>";
    echo "<td>" . ($product->image ?? '-') . "</td>";
    
    // Cek apakah gambar ada
    $imageExists = false;
    $oldPath = '';
    
    if ($product->image) {
        // Cek di berbagai lokasi
        $possiblePaths = [
            public_path('storage/' . $product->image),
            public_path($product->image),
            storage_path('app/public/' . $product->image),
            public_path('product-images/' . basename($product->image))
        ];
        
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $imageExists = true;
                $oldPath = $path;
                break;
            }
        }
    }
    
    if ($imageExists) {
        echo "<td style='color:green'>✅ File ada</td>";
        
        // Copy ke folder product-images
        $newFilename = time() . '_' . $product->id . '_' . basename($oldPath);
        $newPath = $targetFolder . '/' . $newFilename;
        
        if (!file_exists($newPath)) {
            copy($oldPath, $newPath);
            
            // Update database
            DB::table('products')
                ->where('id', $product->id)
                ->update(['image' => 'product-images/' . $newFilename]);
                
            echo "<td style='color:blue'>✅ Dicopy & diupdate</td>";
        } else {
            echo "<td>Sudah ada</td>";
        }
    } else {
        echo "<td style='color:red'>❌ File tidak ditemukan</td>";
        echo "<td><a href='/admin/products/{$product->id}/edit' style='color:blue;'>Upload Ulang</a></td>";
    }
    
    echo "</tr>";
}

echo "</table>";

echo "<h3>📝 INSTRUKSI:</h3>";
echo "<ol>";
echo "<li>Upload gambar baru melalui halaman admin</li>";
echo "<li>Gambar akan otomatis tersimpan di <code>public/product-images/</code></li>";
echo "<li>Refresh halaman untuk melihat hasil</li>";
echo "</ol>";

echo "<p><a href='/admin/products' style='background: #10b981; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>➡️ KE HALAMAN ADMIN</a></p>";
?>