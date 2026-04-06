<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Menampilkan form review untuk produk
     */
    public function create(Product $product)
    {
        // Cek apakah user sudah membeli produk ini
        $hasPurchased = Auth::user()->orders()
            ->whereHas('items', function($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->where('status', 'delivered')
            ->exists();

        if (!$hasPurchased) {
            return redirect()->route('customer.products.show', $product->slug)
                ->with('error', 'Anda hanya bisa mereview produk yang sudah dibeli.');
        }

        // Cek apakah user sudah pernah mereview
        $existingReview = Auth::user()->reviews()->where('product_id', $product->id)->first();
        
        return view('customer.reviews.create', compact('product', 'existingReview'));
    }

    /**
     * Menyimpan review baru
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Cek apakah user sudah pernah mereview
        if (Auth::user()->reviews()->where('product_id', $product->id)->exists()) {
            return redirect()->route('customer.products.show', $product->slug)
                ->with('error', 'Anda sudah pernah mereview produk ini.');
        }

        // Cek apakah user sudah membeli produk
        $hasPurchased = Auth::user()->orders()
            ->whereHas('items', function($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->where('status', 'delivered')
            ->exists();

        if (!$hasPurchased) {
            return redirect()->route('customer.products.show', $product->slug)
                ->with('error', 'Anda hanya bisa mereview produk yang sudah dibeli.');
        }

        // Simpan review
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false,
        ]);

        return redirect()->route('customer.products.show', $product->slug)
            ->with('success', 'Terima kasih! Review Anda akan ditampilkan setelah disetujui admin.');
    }

    /**
     * Mengupdate review
     */
    public function update(Request $request, Review $review)
    {
        // Pastikan user hanya bisa mengupdate review miliknya
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false,
        ]);

        return redirect()->route('customer.products.show', $review->product->slug)
            ->with('success', 'Review berhasil diperbarui dan akan ditampilkan setelah disetujui admin.');
    }

    /**
     * Menghapus review
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $productSlug = $review->product->slug;
        $review->delete();

        return redirect()->route('customer.products.show', $productSlug)
            ->with('success', 'Review berhasil dihapus.');
    }
}