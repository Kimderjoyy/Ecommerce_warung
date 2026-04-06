<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $productId = $_POST['product_id'];
    $product = Product::find($productId);
    
    if ($product) {
        $file = $_FILES['image'];
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = time() . '_' . Str::slug($product->name) . '.' . $extension;
        
        $uploadPath = storage_path('app/public/products/' . $filename);
        
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Hapus gambar lama
            if ($product->image) {
                $oldFile = storage_path('app/public/' . $product->image);
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }
            
            // Update database
            $product->image = 'products/' . $filename;
            $product->save();
            
            // Copy ke public
            $publicPath = public_path('storage/products/' . $filename);
            if (!is_dir(public_path('storage/products'))) {
                mkdir(public_path('storage/products'), 0777, true);
            }
            copy($uploadPath, $publicPath);
            
            echo "<p style='color:green'>✅ Gambar untuk {$product->name} berhasil diupload!</p>";
        }
    }
}

$products = Product::all();
?>

<h1>Upload Ulang Gambar Produk</h1>

<form method="POST" enctype="multipart/form-data">
    <select name="product_id" required>
        <option value="">Pilih Produk</option>
        <?php foreach ($products as $product): ?>
        <option value="<?= $product->id ?>"><?= $product->name ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <input type="file" name="image" accept="image/*" required>
    <br><br>
    <button type="submit">Upload</button>
</form>