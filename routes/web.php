<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

// Customer Controllers
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\CartController as CustomerCartController;
use App\Http\Controllers\Customer\CheckoutController as CustomerCheckoutController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Customer\ReviewController as CustomerReviewController;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===== TEST ROUTE =====
Route::get('/test', function() {
    return 'Route test berhasil!';
});

// ===== DEBUG ROUTES =====
Route::get('/debug-products', function() {
    $products = Product::select('id', 'name', 'slug', 'is_active')->get();
    return response()->json($products);
});

Route::get('/debug-product/{slug}', function($slug) {
    $product = Product::where('slug', $slug)->first();
    if (!$product) {
        return response()->json([
            'error' => 'Produk tidak ditemukan',
            'slug' => $slug,
            'all_slugs' => Product::pluck('slug')
        ]);
    }
    return response()->json($product);
});

// ===== HALAMAN BERANDA (HOME) =====
Route::get('/', [HomeController::class, 'index'])->name('home');

// ===== PRODUK UNTUK SEMUA ORANG (TANPA LOGIN) =====
Route::prefix('products')->name('customer.products.')->group(function () {
    Route::get('/', [CustomerProductController::class, 'index'])->name('index');
    Route::get('/{product:slug}', [CustomerProductController::class, 'show'])->name('show');
    Route::get('/id/{id}', [CustomerProductController::class, 'showById'])->name('show.id');
});

// ===== ROUTE UNTUK CUSTOMER (PERLU LOGIN) =====
Route::middleware(['auth'])->group(function () {
    // Dashboard customer
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
    
    // Cart Routes
    Route::prefix('cart')->name('customer.cart.')->group(function () {
        Route::get('/', [CustomerCartController::class, 'index'])->name('index');
        Route::post('/add', [CustomerCartController::class, 'add'])->name('add');
        Route::put('/update', [CustomerCartController::class, 'update'])->name('update');
        Route::delete('/remove/{id}', [CustomerCartController::class, 'remove'])->name('remove');
    });
    
    // Alias Cart
    Route::get('/shopping-cart', [CustomerCartController::class, 'index'])->name('customer.cart');
    Route::post('/shopping-cart/add', [CustomerCartController::class, 'add'])->name('customer.cart.add');
    Route::put('/shopping-cart/update', [CustomerCartController::class, 'update'])->name('customer.cart.update');
    Route::delete('/shopping-cart/remove/{id}', [CustomerCartController::class, 'remove'])->name('customer.cart.remove');
    
    // Checkout Routes
    Route::prefix('checkout')->name('customer.checkout.')->group(function () {
        Route::get('/', [CustomerCheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CustomerCheckoutController::class, 'process'])->name('process');
    });
    
    // Alias Checkout
    Route::get('/checkout-now', [CustomerCheckoutController::class, 'index'])->name('customer.checkout');
    Route::post('/checkout-now/process', [CustomerCheckoutController::class, 'process'])->name('customer.checkout.process');
    
    // Orders Routes
    Route::prefix('orders')->name('customer.orders.')->group(function () {
        Route::get('/', [CustomerOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [CustomerOrderController::class, 'show'])->name('show');
        Route::post('/{order}/cancel', [CustomerOrderController::class, 'cancel'])->name('cancel');
        Route::post('/{order}/received', [CustomerOrderController::class, 'received'])->name('received');
    });
    
    // Alias Orders
    Route::get('/my-orders', [CustomerOrderController::class, 'index'])->name('customer.orders');
    Route::get('/my-orders/{order}', [CustomerOrderController::class, 'show'])->name('customer.orders.show');
    Route::post('/my-orders/{order}/cancel', [CustomerOrderController::class, 'cancel'])->name('customer.orders.cancel');
    Route::post('/my-orders/{order}/received', [CustomerOrderController::class, 'received'])->name('customer.orders.received');
    
    // Profile Routes
    Route::prefix('profile')->name('customer.profile.')->group(function () {
        Route::get('/', [CustomerProfileController::class, 'edit'])->name('edit');
        Route::put('/', [CustomerProfileController::class, 'update'])->name('update');
        Route::delete('/', [CustomerProfileController::class, 'destroy'])->name('delete');
    });
    
    // Alias Profile
    Route::get('/my-profile', [CustomerProfileController::class, 'edit'])->name('customer.profile');
    Route::put('/my-profile', [CustomerProfileController::class, 'update'])->name('customer.profile.update');
    Route::delete('/my-profile', [CustomerProfileController::class, 'destroy'])->name('customer.profile.delete');
    
    // Customer Reviews
    Route::prefix('reviews')->name('customer.reviews.')->group(function () {
        Route::get('/product/{product}', [CustomerReviewController::class, 'create'])->name('create');
        Route::post('/product/{product}', [CustomerReviewController::class, 'store'])->name('store');
        Route::put('/{review}', [CustomerReviewController::class, 'update'])->name('update');
        Route::delete('/{review}', [CustomerReviewController::class, 'destroy'])->name('destroy');
    });
});

// ===== ROUTE UNTUK ADMIN =====
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', AdminProductController::class);
    
    // Categories
    Route::resource('categories', AdminCategoryController::class);
    
    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        Route::put('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('status');
        Route::delete('/{order}', [AdminOrderController::class, 'destroy'])->name('destroy');
    });
    
    // Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        Route::get('/{user}/detail', [AdminUserController::class, 'detail'])->name('detail');
        Route::post('/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('toggle-status');
    });
    
    // ===== ADMIN REVIEWS =====
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [AdminReviewController::class, 'index'])->name('index');
        Route::post('/{review}/approve', [AdminReviewController::class, 'approve'])->name('approve');
        Route::post('/approve-all', [AdminReviewController::class, 'approveAll'])->name('approve-all');
        Route::delete('/{review}/reject', [AdminReviewController::class, 'reject'])->name('reject');
        Route::delete('/{review}', [AdminReviewController::class, 'destroy'])->name('destroy');
    });
});

// ===== ROUTE UNTUK FIX IMAGE (DEBUG ONLY) =====
Route::middleware(['auth', 'admin'])->prefix('fix-image')->name('fix.')->group(function () {
    Route::post('/single', function(Request $request) {
        $product = Product::find($request->product_id);
        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan');
        }
        
        $filename = basename($product->image);
        $storagePath = storage_path('app/public/products/' . $filename);
        $publicPath = public_path('storage/products/' . $filename);
        
        if (!is_dir(public_path('storage/products'))) {
            mkdir(public_path('storage/products'), 0777, true);
        }
        
        if (file_exists($storagePath)) {
            copy($storagePath, $publicPath);
            return back()->with('success', 'Gambar ' . $filename . ' berhasil diperbaiki');
        }
        
        return back()->with('error', 'File tidak ditemukan di storage');
    })->name('single');
    
    Route::post('/all', function() {
        $products = Product::whereNotNull('image')->get();
        $fixed = 0;
        
        if (!is_dir(public_path('storage/products'))) {
            mkdir(public_path('storage/products'), 0777, true);
        }
        
        foreach ($products as $product) {
            $filename = basename($product->image);
            $storagePath = storage_path('app/public/products/' . $filename);
            $publicPath = public_path('storage/products/' . $filename);
            
            if (file_exists($storagePath) && !file_exists($publicPath)) {
                copy($storagePath, $publicPath);
                $fixed++;
            }
        }
        
        return back()->with('success', "Berhasil memperbaiki {$fixed} gambar");
    })->name('all');
});

// ===== AUTH ROUTES =====
require __DIR__.'/auth.php';