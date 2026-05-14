<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the buyer's cart with totals, tax, and shipping.
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Calculations
        $shipping = 50;
        $tax = $subtotal * 0.12; // 12% VAT
        $total = $subtotal + $shipping + $tax;

        return view('buyer.cart', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    /**
     * Add a product to the cart or increment quantity if it exists.
     */
    public function add(Request $request, $productId)
    {
        $user = Auth::user();

        // 🛡️ SECURITY: Only Buyers should be able to add to cart
        if ($user->role !== 'buyer') {
            return back()->with('error', 'Only buyers can add items to the cart.');
        }

        $product = Product::findOrFail($productId);

        // Check if the item is already in the cart for this user
        $cartItem = Cart::where('user_id', $user->id)
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            // If exists, just add one more
            $cartItem->increment('quantity');
        } else {
            // If new, create the entry
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    /**
     * Update the quantity of an item from the cart view.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return back()->with('success', 'Cart updated!');
    }

    /**
     * Remove an item from the cart.
     */
    public function destroy($id)
    {
        Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'Removed from cart!');
    }
    public function cartCount()
    {
        $count = Cart::where('user_id', Auth::id())->sum('quantity');
        return response()->json(['count' => $count]);
    }
}