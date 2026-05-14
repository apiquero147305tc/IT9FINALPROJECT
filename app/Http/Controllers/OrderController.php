<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * 🛒 BUYER: Place an Order
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
        $totalPrice = $product->price * $quantity;

        // 1. SAFE STOCK DECREMENT
        // We only decrement if the current stock is enough (prevents negative stock)
        $updated = Product::where('id', $product->id)
            ->where('stock', '>=', $quantity)
            ->decrement('stock', $quantity);

        if (!$updated) {
            return back()->with('error', 'Not enough stock available.');
        }

        // 2. REFRESH & UPDATE PRODUCT STATUS
        $product->refresh();
        if ($product->stock <= 0) {
            $product->status = 'sold_out';
        } else {
            $product->status = 'available';
        }
        $product->save();

        // 3. CREATE THE ORDER
        Order::create([
            'user_id'     => Auth::id(),
            'product_id'  => $product->id,
            'quantity'    => $quantity,
            'status'      => 'pending',
            'total_price' => $totalPrice,
        ]);

        // 4. 💰 SMART BUDGET UPDATE
        $user = Auth::user();
        if ($user && $user->role === 'buyer') {
            // Update total spent
            $user->spent_amount += $totalPrice;

            // Update category tracking
            $category = $product->category ?? 'others';
            $spending = json_decode($user->category_spending ?? '{}', true);
            $spending[$category] = ($spending[$category] ?? 0) + $totalPrice;
            
            $user->category_spending = json_encode($spending);
            $user->save();
        }

        return back()->with('success', 'Order placed successfully! Your Smart Budget has been updated.');
    }

    /**
     * 🏪 SELLER: Accept/Decline Order
     */
    public function updateStatus(Request $request, $id)
    {
        // 1. Find the order and check ownership
        $order = Order::with('product')->findOrFail($id);

        if ($order->product->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access to this order.');
        }

        // 2. Accept Action
        if ($request->action === 'accept') {
            $order->update(['status' => 'accepted']);
            return back()->with('success', 'Order accepted! Time to prepare the items.');
        } 
        
        // 3. Decline Action
        if ($request->action === 'decline') {
            // Return the stock to the seller's inventory
            $order->product->increment('stock', $order->quantity);
            
            // Re-open status if it was sold out
            if ($order->product->status === 'sold_out') {
                $order->product->update(['status' => 'available']);
            }

            $order->update(['status' => 'declined']);
            return back()->with('info', 'Order declined. Stock has been returned to inventory.');
        }

        return back();
    }
}