<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema; // <-- TAMBAHKAN INI

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        $user = Auth::user();

        return view('customer.checkout.index', compact('cartItems', 'subtotal', 'user'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_phone' => 'required|string|max:20',
            'payment_method' => 'required|in:transfer,cod,qris',
            'notes' => 'nullable|string|max:500'
        ]);

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Cek stok
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->back()->with('error', 
                    "Stok {$item->product->name} tidak mencukupi. Tersedia: {$item->product->stock}");
            }
        }

        DB::beginTransaction();

        try {
            $totalAmount = $cartItems->sum(function($item) {
                return $item->quantity * $item->product->price;
            });

            // Data dasar order
            $orderData = [
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address,
                'shipping_phone' => $request->shipping_phone,
                'notes' => $request->notes
            ];

            // Cek apakah kolom payment_due ada sebelum mengisi
            if (Schema::hasColumn('orders', 'payment_due')) {
                $orderData['payment_due'] = now()->addHours(24);
            }

            // Buat order
            $order = Order::create($orderData);

            // Buat order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->quantity * $item->product->price
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            // Hapus cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('customer.orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}