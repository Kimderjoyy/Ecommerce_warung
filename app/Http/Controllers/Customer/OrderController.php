<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- PENTING: INI YANG DIBUTUHKAN
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of user orders.
     */
    public function index(Request $request)
    {
        $query = Order::where('user_id', Auth::id())->with('items');
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Ensure user only sees their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $order->load('items.product');
        
        return view('customer.orders.show', compact('order'));
    }

    /**
     * Cancel an order (only if pending).
     */
    public function cancel(Order $order)
    {
        // Ensure user only cancels their own orders
        if ($order->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Only pending orders can be cancelled
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya pesanan dengan status pending yang dapat dibatalkan.');
        }

        DB::beginTransaction();

        try {
            // Restore stock for each item
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            // Update order status
            $order->update([
                'status' => 'cancelled',
                'payment_status' => 'failed'
            ]);

            DB::commit();

            return redirect()->route('customer.orders.show', $order)
                ->with('success', 'Pesanan berhasil dibatalkan.');

        } catch (\Exception $e) {
            DB::rollback();
            
            // Log error for debugging
            Log::error('Order cancellation failed for order #' . $order->order_number . ': ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membatalkan pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Mark order as received (for COD orders).
     */
    public function received(Order $order)
    {
        // Ensure user only marks their own orders
        if ($order->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Only shipped orders can be marked as received
        if ($order->status !== 'shipped') {
            return redirect()->back()->with('error', 'Pesanan harus dalam status dikirim.');
        }

        DB::beginTransaction();

        try {
            $order->update([
                'status' => 'delivered',
                'payment_status' => 'paid'
            ]);

            DB::commit();

            return redirect()->route('customer.orders.show', $order)
                ->with('success', 'Pesanan telah diterima. Terima kasih!');

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Order received failed: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /**
     * Track order (optional method)
     */
    public function track(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.orders.track', compact('order'));
    }
}