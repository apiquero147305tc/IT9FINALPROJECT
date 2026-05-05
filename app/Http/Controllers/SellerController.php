<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class SellerController extends Controller
{
    /**
     * Seller Dashboard Overview
     */
   public function dashboard()
{
    $sellerId = Auth::id();

    // IMPORTANT: use ONE correct column only (choose seller_id OR user_id)
    $products = Product::where('seller_id', $sellerId)
        ->latest()
        ->get();

    $orders = collect();
    $totalEarnings = 0;

    if (class_exists('App\Models\Order') && Schema::hasTable('orders')) {
        try {
            $orders = Order::whereHas('product', function ($query) use ($sellerId) {
                $query->where('seller_id', $sellerId); // keep consistent
            })
            ->with(['user', 'product'])
            ->latest()
            ->take(5)
            ->get();

            $totalEarnings = Order::whereHas('product', function ($query) use ($sellerId) {
                $query->where('seller_id', $sellerId);
            })
            ->where('status', 'completed')
            ->sum('total_price');

        } catch (\Exception $e) {
            $orders = collect();
        }
    }

    return view('seller.dashboard', compact(
        'products',
        'orders',
        'totalEarnings'
    ));
}
    /**
     * Full Orders Management List
     */
    public function orders()
    {
        $seller = Auth::user();
        
        if (!Schema::hasTable('orders')) {
            return view('seller.orders', ['orders' => collect()]);
        }

        $orders = Order::whereHas('product', function($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })
        ->with(['user', 'product'])
        ->latest()
        ->paginate(15);

        return view('seller.orders', compact('orders'));
    }

    /**
     * Update Order Status (New Method)
     * This allows sellers to mark items as 'Completed' or 'Cancelled'
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $seller = Auth::user();

        // Find the order and verify the seller actually owns the product being sold
        $order = Order::whereHas('product', function($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })->findOrFail($id);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated to ' . $request->status);
    }
}