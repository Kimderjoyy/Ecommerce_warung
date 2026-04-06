<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show customer dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $completedOrders = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->count();
        $totalSpent = Order::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->sum('total_amount');
        
        // Recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('customer.dashboard', compact(
            'user', 'totalOrders', 'pendingOrders', 
            'completedOrders', 'totalSpent', 'recentOrders'
        ));
    }
}