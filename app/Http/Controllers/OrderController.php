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

    // ❌ SAFE SINGLE ATOMIC UPDATE
    $updated = Product::where('id', $product->id)
        ->where('stock', '>=', $quantity)
        ->decrement('stock', $quantity);

    if (!$updated) {
        return back()->with('error', 'Not enough stock or stock changed.');
    }

    // refresh product after update
    $product->refresh();

    // update status
    if ($product->stock <= 0) {
        $product->status = 'sold_out';
    } else {
        $product->status = 'available';
    }

    $product->save();

    // create order (IMPORTANT)
    Order::create([
    'user_id' => Auth::id(),
    'product_id' => $product->id,
    'quantity' => $quantity,
    'status' => 'pending',
    'total_price' => $product->price * $quantity, // ✅ ADD THIS
]);

    return back()->with('success', 'Order placed successfully!');
}
}
