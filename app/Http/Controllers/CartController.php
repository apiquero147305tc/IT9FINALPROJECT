<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
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
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Added to cart!');
    }

    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('buyer.cart', compact('cartItems', 'total'));
    }
}