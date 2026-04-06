<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        // Ambil produk untuk ditampilkan di section rekomendasi
        $featuredProducts = Product::with('category')
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->latest()
            ->take(5)
            ->get();
        
        // Ambil kategori untuk keperluan lain (opsional)
        $categories = Category::withCount('products')->get();
        
        // Hitung total produk dan pelanggan untuk statistik
        $totalProducts = Product::count();
        $totalCustomers = \App\Models\User::where('role', 'customer')->count();
        
        // Kirim semua variabel ke view
        return view('home', compact(
            'featuredProducts', 
            'categories', 
            'totalProducts', 
            'totalCustomers'
        ));
    }
}