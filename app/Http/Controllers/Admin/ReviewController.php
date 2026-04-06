<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Menampilkan daftar review
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product']);

        // Filter berdasarkan status
        if ($request->has('status')) {
            if ($request->status === 'pending') {
                $query->where('is_approved', false);
            } elseif ($request->status === 'approved') {
                $query->where('is_approved', true);
            }
        }

        $reviews = $query->latest()->paginate(15);
        
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Menyetujui review
     */
    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        
        return redirect()->back()->with('success', 'Review berhasil disetujui.');
    }

    /**
     * Menyetujui semua review yang pending
     */
    public function approveAll()
    {
        $count = Review::where('is_approved', false)->count();
        
        if ($count == 0) {
            return redirect()->back()->with('info', 'Tidak ada review pending.');
        }
        
        Review::where('is_approved', false)->update(['is_approved' => true]);
        
        return redirect()->back()->with('success', "Berhasil menyetujui {$count} review.");
    }

    /**
     * Menolak review (menghapus)
     */
    public function reject(Review $review)
    {
        $review->delete();
        
        return redirect()->back()->with('success', 'Review berhasil ditolak.');
    }

    /**
     * Menghapus review
     */
    public function destroy(Review $review)
    {
        $review->delete();
        
        return redirect()->back()->with('success', 'Review berhasil dihapus.');
    }
}