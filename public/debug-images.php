<?php
echo "<h1>🔍 DEBUG GAMBAR PRODUK</h1>";

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

echo "<h2>1. CEK STORAGE LINK</h2>";
$storageLink = __DIR__ . '/storage';
if (is_link($storageLink)) {
    echo "✅ Storage link ADA<br>";
    echo "Link menuju: " . readlink($storageLink) . "<br>";
} elseif (is_dir($storageLink)) {
    echo "⚠️ Storage adalah folder biasa (bukan link)<br>";
} else {
    echo "❌ Storage link TIDAK ADA<br>";
    echo "Jalankan: php artisan storage:link<br>";
}

echo "<h2>2. CEK FOLDER PRODUCTS</h2>";
$productsFolder = __DIR__ . '/../storage/app/public/products';
if (is_dir($productsFolder)) {
    echo "✅ Folder products ADA<br>";
    $files = scandir($productsFolder);
    $fileCount = count($files) - 2; // kurangi . dan ..
    echo "Jumlah file: " . $fileCount . "<br>";
    
    if ($fileCount > 0) {
        echo "<h3>Daftar file di folder products:</h3>";
        echo "<ul>";
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $size = filesize($productsFolder . '/' . $file);
                echo "<li>{$file} - " . round($size/1024, 2) . " KB</li>";
            }
        }
        echo "</ul>";
    }
} else {
    echo "❌ Folder products TIDAK ADA<br>";
    echo "Membuat folder...<br>";
    mkdir($productsFolder, 0777, true);
    echo "✅ Folder products dibuat<br>";
}

echo "<h2>3. CEK DATA DI DATABASE</h2>";
$products = Product::whereNotNull('image')->get();
echo "Total produk dengan gambar: " . $products->count() . "<br>";

echo "<table border='1' cellpadding='8' style='border-collapse: collapse; margin-top: 20px;'>";
echo "<tr style='background: #f0f0f0;'>
        <th>ID</th>
        <th>Nama Produk</th>
        <th>Path di DB</th>
        <th>File exists?</th>
        <th>Preview</th>
        <th>Action</th>
      </tr>";

foreach ($products as $product) {
    echo "<tr>";
    echo "<td>{$product->id}</td>";
    echo "<td>{$product->name}</td>";
    echo "<td><code>{$product->image}</code></td>";
    
    // Cek file
    $filename = basename($product->image);
    $storagePath = $productsFolder . '/' . $filename;
    $publicPath = __DIR__ . '/storage/products/' . $filename;
    
    $storageExists = file_exists($storagePath);
    $publicExists = file_exists($publicPath);
    
    echo "<td>";
    echo "Storage: " . ($storageExists ? '✅' : '❌') . "<br>";
    echo "Public: " . ($publicExists ? '✅' : '❌');
    echo "</td>";
    
    echo "<td>";
    if ($storageExists) {
        echo "<img src='/storage/products/{$filename}' style='max-width: 100px; max-height: 100px;' onerror='this.style.display=\"none\"'>";
    } else {
        echo "-";
    }
    echo "</td>";
    
    echo "<td>";
    echo "<form method='POST' action='/fix-image' style='display: inline;'>";
    echo "<input type='hidden' name='product_id' value='{$product->id}'>";
    echo "<button type='submit' style='background: #10b981; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;'>Fix</button>";
    echo "</form>";
    echo "</td>";
    
    echo "</tr>";
}
echo "</table>";

echo "<h2>4. PERBAIKAN OTOMATIS</h2>";
echo "<form method='POST' action='/fix-all-images'>";
echo "<button type='submit' style='background: #3b82f6; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px;'>🔧 Perbaiki Semua Gambar</button>";
echo "</form>";

echo "<h2>5. INSTRUKSI</h2>";
echo "<ol>";
echo "<li>Jalankan: <code>php artisan storage:link</code> di terminal</li>";
echo "<li>Upload ulang gambar melalui admin</li>";
echo "<li>Pastikan folder <code>storage/app/public/products</code> ada dan writable</li>";
echo "<li>Permission folder: <code>chmod -R 777 storage</code> (Linux/Mac)</li>";
echo "</ol>";
?>