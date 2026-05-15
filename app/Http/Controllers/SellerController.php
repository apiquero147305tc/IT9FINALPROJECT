<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Notification;

class SellerController extends Controller
{
    /**
     * Seller Dashboard Overview
     */
  
public function dashboard()
{
    $sellerId = Auth::id();

    // PRODUCTS
    $products = Product::where('user_id', $sellerId)->get();

    // DEFAULTS
    $orders = collect();
    $totalEarnings = 0;
    $notifCount = 0;
    $notifications = collect();

<<<<<<< HEAD
    if (class_exists('App\Models\Order') && Schema::hasTable('orders')) {
        try {
            $orders = Order::whereHas('product', function ($query) use ($sellerId) {
                $query->where('user_id', $sellerId);  // ✅ Fixed: 'user_id' not 'seller_id'
=======
    // NOTIFICATIONS (always safe)
    if (Schema::hasTable('notifications')) {
        $notifications = Notification::where('user_id', $sellerId)
            ->latest()
            ->get();

        $notifCount = Notification::where('user_id', $sellerId)->count();
    }

    // ORDERS (safe check)
    if (class_exists(Order::class) && Schema::hasTable('orders')) {

        $orders = Order::whereHas('product', function ($query) use ($sellerId) {
                $query->where('user_id', $sellerId); // IMPORTANT FIX (was seller_id mismatch risk)
>>>>>>> origin/almostfinal
            })
            ->with(['user', 'product'])
            ->latest()
            ->get();

<<<<<<< HEAD
            // Calculate total earnings from completed orders
            $totalEarnings = $orders
                ->where('status', 'completed')
                ->sum(function ($order) {
                    return $order->quantity * $order->product->price;
                });

            // NOTIFICATION COUNT
            $notifCount = Order::whereHas('product', function ($query) use ($sellerId) {
                $query->where('user_id', $sellerId);
            })
            ->where('is_seen', false)
            ->count();

        } catch (\Exception $e) {
            $orders = collect();
            $totalEarnings = 0;
            $notifCount = 0;
        }
=======
        $totalEarnings = Order::whereHas('product', function ($query) use ($sellerId) {
                $query->where('user_id', $sellerId);
            })
            ->where('status', 'completed')
            ->sum('total_price');
>>>>>>> origin/almostfinal
    }

    return view('seller.dashboard', compact(
        'products',
        'orders',
        'totalEarnings',
<<<<<<< HEAD
        'notifCount'      // ✅ Added missing variable
=======
        'notifications',
        'notifCount'
>>>>>>> origin/almostfinal
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