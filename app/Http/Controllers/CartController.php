<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
=======
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
>>>>>>> origin/Kino
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
<<<<<<< HEAD
    public function add(Request $request, $productId)
    {
        $user = Auth::user();

        // Validation: Only Buyers should add to cart
        if ($user->role !== 'buyer') {
            return back()->with('error', 'Only buyers can add items to the cart.');
        }

        // Check if the item is already in the cart
        $cartItem = Cart::where('user_id', $user->id)
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => $user->id,
=======
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $shipping = 50;
        $tax = $subtotal * 0.12;
        $total = $subtotal + $shipping + $tax;

        return view('buyer.cart', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
>>>>>>> origin/Kino
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Added to cart!');
    }

<<<<<<< HEAD
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('buyer.cart', compact('cartItems', 'total'));
=======
    public function update(Request $request, $id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return back()->with('success', 'Cart updated!');
    }

    public function destroy($id)
    {
        Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'Removed from cart!');
>>>>>>> origin/Kino
    }
}