<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product.images')
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('buyer.cart', compact('cartItems', 'total'));
    }

    public function add(Request $request, $productId)
    {
        $user = Auth::user();

        if ($user->role !== 'buyer') {
            return back()->with('error', 'Only buyers can add items to cart.');
        }

        $product = Product::findOrFail($productId);

        if ($product->stock <= 0) {
            return back()->with('error', 'Product is out of stock.');
        }

        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            if ($cartItem->quantity + 1 > $product->stock) {
                return back()->with('error', 'Cannot add more. Maximum stock reached.');
            }
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $quantity = $request->input('quantity', 1);

        if ($quantity <= 0) {
            $cartItem->delete();
            return back()->with('success', 'Item removed from cart.');
        }

        if ($quantity > $cartItem->product->stock) {
            return back()->with('error', 'Quantity exceeds available stock.');
        }

        $cartItem->update(['quantity' => $quantity]);
        return back()->with('success', 'Cart updated!');
    }

    public function destroy($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $cartItem->delete();
        return back()->with('success', 'Item removed from cart.');
    }

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

            $order = \App\Models\Order::create([
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