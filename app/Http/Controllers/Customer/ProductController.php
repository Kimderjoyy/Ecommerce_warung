<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk
     */
    public function index(Request $request)
    {
        $query = Product::active();
        
        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'latest':
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }
        
        $products = $query->paginate(12);
        $categories = Category::all();
        
        return view('customer.products.index', compact('products', 'categories'));
    }

    /**
     * Menampilkan detail produk
     */
    public function show(Product $product)
    {
        // Pastikan produk aktif
        if (!$product->is_active) {
            abort(404, 'Produk tidak ditemukan');
        }

        // Ambil semua review yang sudah disetujui dengan data user
        $approvedReviews = $product->reviews()
                                  ->approved()
                                  ->with('user')
                                  ->latest()
                                  ->get();

        // Cek apakah user sudah login dan sudah pernah review
        $userReview = null;
        $hasPurchased = false;
        
        if (Auth::check()) {
            $userReview = $product->reviews()
                                 ->where('user_id', Auth::id())
                                 ->first();
            
            $hasPurchased = Auth::user()->orders()
                ->whereHas('items', function($query) use ($product) {
                    $query->where('product_id', $product->id);
                })
                ->where('status', 'delivered')
                ->exists();
        }

        // Ambil produk terkait (kategori sama)
        $relatedProducts = Product::active()
                                 ->where('category_id', $product->category_id)
                                 ->where('id', '!=', $product->id)
                                 ->limit(4)
                                 ->get();

        return view('customer.products.show', compact(
            'product', 
            'relatedProducts', 
            'approvedReviews', 
            'userReview', 
            'hasPurchased'
        ));
    }

    /**
     * Menampilkan detail produk berdasarkan ID (untuk testing)
     */
    public function showById($id)
    {
        $product = Product::findOrFail($id);
        
        if (!$product->is_active) {
            abort(404);
        }

        return redirect()->route('customer.products.show', $product->slug);
    }
}