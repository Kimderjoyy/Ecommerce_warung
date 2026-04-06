<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
            
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        
        return view('customer.cart.index', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Cek stok
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock
            ]);
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cart) {
            // Update quantity jika produk sudah ada di cart
            $newQuantity = $cart->quantity + $request->quantity;
            if ($product->stock >= $newQuantity) {
                $cart->update(['quantity' => $newQuantity]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Maksimal ' . $product->stock
                ]);
            }
        } else {
            // Tambah produk baru ke cart
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        // Hitung total item di cart
        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cart_count' => $cartCount
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::with('product')->findOrFail($request->cart_id);
        
        // Cek kepemilikan
        if ($cart->user_id != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        // Cek stok
        if ($cart->product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $cart->product->stock
            ]);
        }

        $cart->update(['quantity' => $request->quantity]);
        
        // Hitung ulang subtotal
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diperbarui!',
            'subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
            'item_total' => 'Rp ' . number_format($cart->subtotal, 0, ',', '.')
        ]);
    }

    public function remove($id)
    {
        $cart = Cart::findOrFail($id);
        
        if ($cart->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }
        
        $cart->delete();
        
        return redirect()->route('customer.cart')
            ->with('success', 'Produk dihapus dari keranjang!');
    }
}