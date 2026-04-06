<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'items');
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::whereIn('status', ['processing', 'shipped'])->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        
        return view('admin.orders.index', compact(
            'orders', 
            'totalOrders', 
            'pendingOrders', 
            'processingOrders', 
            'deliveredOrders', 
            'cancelledOrders'
        ));
    }
    
    public function show(Order $order)
    {
        $order->load('user', 'items.product', 'payment');
        return view('admin.orders.show', compact('order'));
    }
    
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed'
        ]);

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
    
    public function destroy(Order $order)
    {
        $order->items()->delete();
        if ($order->payment) {
            $order->payment()->delete();
        }
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }
}