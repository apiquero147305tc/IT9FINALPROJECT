<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
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

    /**
     * Checkout - create orders from cart items
     */
    public function checkout(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $orderIds = [];
        foreach ($cartItems as $item) {
            $product = $item->product;

            if ($product->stock < $item->quantity) {
                return back()->with('error', "Not enough stock for {$product->name}.");
            }

            $product->decrement('stock', $item->quantity);

            if ($product->stock <= 0) {
                $product->update(['status' => 'sold_out']);
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $item->quantity,
                'status' => 'pending',
                'total_price' => $product->price * $item->quantity,
            ]);

            $orderIds[] = $order->id;
        }

        Cart::where('user_id', Auth::id())->delete();

        if (count($orderIds) === 1) {
            return redirect()->route('receipt.show', $orderIds[0])
                ->with('success', 'Order placed successfully!');
        }

        return redirect()->route('buyer.orders')
            ->with('success', 'Orders placed successfully!');
    }
}