<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Notification;  // ← ADD THIS
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        // Stock check + decrement
        $updated = Product::where('id', $product->id)
            ->where('stock', '>=', $quantity)
            ->decrement('stock', $quantity);

        if (!$updated) {
            return back()->with('error', 'Not enough stock or stock changed.');
        }

        $product->refresh();

        if ($product->stock <= 0) {
            $product->status = 'sold_out';
        } else {
            $product->status = 'available';
        }

        $product->save();

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $quantity,
            'status' => 'pending',
            'total_price' => $product->price * $quantity,
        ]);

        // 🔔 NOTIFY THE SELLER (add these 4 lines)
        Notification::create([
            'user_id' => $product->user_id,  // seller who owns the product
            'type' => 'new_order',
            'subject' => 'New Order #' . $order->id,
            'message' => 'You have a new order for ₱' . number_format($order->total_price, 2),
            'link' => '/seller/orders/' . $order->id,
        ]);

        return back()->with('success', 'Order placed successfully!');
    }
}