<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // YOUR EXISTING STORE METHOD (Buyer Side)
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        $updated = Product::where('id', $product->id)
            ->where('stock', '>=', $quantity)
            ->decrement('stock', $quantity);

        if (!$updated) {
            return back()->with('error', 'Not enough stock or stock changed.');
        }

        $product->refresh();
        $product->status = ($product->stock <= 0) ? 'sold_out' : 'available';
        $product->save();

        Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $quantity,
            'status' => 'pending',
            'total_price' => $product->price * $quantity,
        ]);

        return back()->with('success', 'Order placed successfully!');
    }

    /**
     * ✅ NEW: SELLER ACTION METHOD
     * Handles Accept/Decline for CraveCart Sellers
     */
    public function updateStatus(Request $request, $id)
    {
        // 1. Find the order with product info to check ownership
        $order = Order::with('product')->findOrFail($id);

        // 2. Security: Ensure the logged-in seller actually owns the product
        if ($order->product->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access to this order.');
        }

        // 3. Process the Decision
        if ($request->action === 'accept') {
            $order->update(['status' => 'accepted']);
            return back()->with('success', 'Order accepted! Time to prepare the items.');
        } 
        
        if ($request->action === 'decline') {
            // Since we decremented stock in store(), we should return it if declined
            $order->product->increment('stock', $order->quantity);
            
            // Re-check status if it was 'sold_out'
            if ($order->product->status === 'sold_out') {
                $order->product->update(['status' => 'available']);
            }

            $order->update(['status' => 'declined']);
            return back()->with('info', 'Order declined. Stock has been returned to inventory.');
        }

        return back();
    }
}