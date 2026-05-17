<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Handle the checkout process: Convert Cart to Orders and Notify Sellers.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Fetch cart items with product and seller info
        $cartItems = Cart::where('user_id', $user->id)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty!');
        }

        // Use a Database Transaction to ensure data integrity
        DB::transaction(function () use ($user, $cartItems) {
            foreach ($cartItems as $item) {
                // 1. Create the formal Order
                Order::create([
                    'user_id'     => $user->id,
                    'product_id'  => $item->product_id,
                    'seller_id'   => $item->product->user_id, 
                    'quantity'    => $item->quantity,
                    'total_price' => $item->product->price * $item->quantity,
                    'status'      => 'pending',
                    'category'    => $item->product->category, 
                ]);

                // 2. Notify the Seller (Updated to include 'subject')
                Notification::create([
                    'user_id' => $item->product->user_id,
                    'subject' => 'New Order Received', // Added this to fix the error in image_bfa41c.png
                    'message' => "New Order! {$user->name} purchased '{$item->product->name}'.",
                    'is_read' => false,
                ]);
            }

            // 3. Clear the buyer's cart after successful order creation
            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()->route('buyer.home')->with('success', 'Checkout successful! Sellers have been notified.');
    }
}