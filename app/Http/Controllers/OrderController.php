<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
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

        // =========================
        // SAFE STOCK DECREMENT
        // =========================
        $updated = Product::where('id', $product->id)
            ->where('stock', '>=', $quantity)
            ->decrement('stock', $quantity);

        if (!$updated) {
            return back()->with('error', 'Not enough stock or stock changed.');
        }

        // refresh product data
        $product->refresh();

        // update product status
        if ($product->stock <= 0) {
            $product->status = 'sold_out';
        } else {
            $product->status = 'available';
        }

        $product->save();

        // =========================
        // ORDER CREATION
        // =========================
        $totalPrice = $product->price * $quantity;

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $quantity,
            'status' => 'pending',
            'total_price' => $totalPrice,
        ]);

        // =========================
        // 💰 SMART BUDGET UPDATE
        // =========================
        $user = Auth::user();

        if ($user && $user->role === 'buyer') {

            // total spent update
            $user->spent_amount += $totalPrice;

            // category tracking (safe fallback)
            $category = $product->category ?? 'others';

            $spending = json_decode($user->category_spending ?? '{}', true);

            $spending[$category] = ($spending[$category] ?? 0) + $totalPrice;

            $user->category_spending = json_encode($spending);

            $user->save();
        }

        return back()->with('success', 'Order placed successfully!');
    }
}