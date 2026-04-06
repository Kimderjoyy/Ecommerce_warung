<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CleanProductImages extends Command
{
    protected $signature = 'images:clean';
    protected $description = 'Membersihkan nama file gambar produk';

    public function handle()
    {
        $this->info('Mulai membersihkan nama file gambar...');
        
        $products = Product::whereNotNull('image')->get();
        $count = 0;
        
        foreach ($products as $product) {
            $oldImage = $product->image;
            
            // Ambil nama file saja
            $filename = basename($oldImage);
            
            // Bersihkan nama file dari karakter aneh
            $cleanFilename = preg_replace('/_[0-9]+x[0-9]+q[0-9]+\.jpg$/', '.jpg', $filename);
            $cleanFilename = preg_replace('/_[0-9]+x[0-9]+\.jpg$/', '.jpg', $cleanFilename);
            
            // Jika nama file berbeda, rename file
            if ($filename != $cleanFilename) {
                $oldPath = 'public/products/' . $filename;
                $newPath = 'public/products/' . $cleanFilename;
                
                if (Storage::exists($oldPath)) {
                    Storage::move($oldPath, $newPath);
                    $product->image = 'products/' . $cleanFilename;
                    $product->save();
                    
                    $this->info("File {$filename} -> {$cleanFilename}");
                    $count++;
                }
            }
        }
        
        $this->info("Selesai! {$count} file telah dibersihkan.");
    }
}