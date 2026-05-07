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
<<<<<<< HEAD
    public function dashboard()
    {
        $sellerId = Auth::id();

        // FIXED: Changed 'seller_id' to 'user_id' to resolve SQLSTATE[42S22] error
        $products = Product::where('user_id', $sellerId) 
=======
  public function dashboard()
{
    $sellerId = Auth::id();
    

    // PRODUCTS
    $products = Product::where('user_id', Auth::id())->get();

    // ORDERS
    $orders = collect();
    $totalEarnings = 0;
    $notifCount = 0;

    if (class_exists('App\Models\Order') && Schema::hasTable('orders')) {
        try {

            $orders = Order::whereHas('product', function ($query) use ($sellerId) {
                $query->where('seller_id', $sellerId);
            })
            ->with(['user', 'product'])
>>>>>>> mergeTesting
            ->latest()
            ->get();

        $orders = collect();
        $totalEarnings = 0;

<<<<<<< HEAD
        if (class_exists('App\Models\Order') && Schema::hasTable('orders')) {
            try {
                // FIXED: Using 'user_id' for consistency across all relationship queries
                $orders = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId); 
                })
                ->with(['user', 'product'])
                ->latest()
                ->take(5)
                ->get();

                $totalEarnings = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->where('status', 'completed')
                ->sum('total_price');

            } catch (\Exception $e) {
                $orders = collect();
            }
=======
            // NOTIFICATION COUNT
            $notifCount = Order::whereHas('product', function ($query) use ($sellerId) {
                $query->where('seller_id', $sellerId);
            })
            ->where('is_seen', false)
            ->count();

        } catch (\Exception $e) {
            $orders = collect();
            $notifCount = 0;
>>>>>>> mergeTesting
        }

        return view('seller.dashboard', compact(
            'products',
            'orders',
            'totalEarnings'
        ));
    }

<<<<<<< HEAD
=======
  return view('seller.dashboard', compact(
    'products',
    'orders',
    'totalEarnings',
    'notifCount'
));
}
>>>>>>> mergeTesting
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
            // FIXED: Ensured this remains 'user_id' to match the dashboard
            $query->where('user_id', $seller->id);
        })
        ->with(['user', 'product'])
        ->latest()
        ->paginate(15);

        return view('seller.orders', compact('orders'));
    }

    /**
     * Update Order Status
     * Allows sellers to mark items as 'completed' or 'cancelled'
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $seller = Auth::user();

        // Find the order and verify the seller owns the product via 'user_id'
        $order = Order::whereHas('product', function($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })->findOrFail($id);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated to ' . $request->status);
    }
}