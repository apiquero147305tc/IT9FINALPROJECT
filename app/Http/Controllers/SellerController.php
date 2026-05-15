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

<<<<<<< HEAD
        // PRODUCTS
        $products = Product::where('user_id', $sellerId)->get();

        // DEFAULTS
=======
        // 1. PRODUCTS: Fetch products owned by the seller
        // Standardized to 'user_id' to match your Products table
        $products = Product::where('user_id', $sellerId)
            ->with('images') 
            ->get();

        // Initialize defaults for safety
>>>>>>> origin/SellerStartup2.0
        $orders = collect();
        $totalEarnings = 0;
        $notifCount = 0;
        $notifications = collect();

<<<<<<< HEAD
        // NOTIFICATIONS (always safe)
        if (Schema::hasTable('notifications')) {
            $notifications = Notification::where('user_id', $sellerId)
                ->latest()
                ->get();

            $notifCount = Notification::where('user_id', $sellerId)->count();
        }

        // ORDERS (safe check)
        if (class_exists(Order::class) && Schema::hasTable('orders')) {
            try {
                $orders = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->with(['user', 'product'])
=======
        // Ensure the orders table exists before querying
        if (class_exists('App\Models\Order') && Schema::hasTable('orders')) {
            try {
                // 2. ORDERS: Fetch 10 most recent orders for this seller's products
                $orders = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->with(['user', 'product.images'])
>>>>>>> origin/SellerStartup2.0
                ->latest()
                ->get();

<<<<<<< HEAD
                // Calculate total earnings from completed orders
                $totalEarnings = $orders
                    ->where('status', 'completed')
                    ->sum(function ($order) {
                        return $order->quantity * $order->product->price;
                    });
=======
                // 3. EARNINGS: Sum from accepted or completed orders
                $totalEarnings = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->whereIn('status', ['accepted', 'completed'])
                ->sum('total_price');

                // 4. NOTIFICATIONS: Count pending orders the seller hasn't processed
                $notifCount = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->where('status', 'pending')
                ->count();
>>>>>>> origin/SellerStartup2.0

            } catch (\Exception $e) {
                // Fail gracefully if relations aren't perfect
                $orders = collect();
<<<<<<< HEAD
                $totalEarnings = 0;
=======
>>>>>>> origin/SellerStartup2.0
            }
        }

        return view('seller.dashboard', compact(
            'products',
            'orders',
            'totalEarnings',
            'notifications',
            'notifCount'
        ));
    }

    /**
<<<<<<< HEAD
     * Full Orders Management List
=======
     * Seller Profile View
     */
    public function profile()
    {
        return view('seller.profile', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update Seller Shop Information
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'shop_name' => 'nullable|string|max:255',
        ]);

        $user->name = $request->name;
        $user->shop_name = $request->shop_name;
        
        /** @var \App\Models\User $user */
        $user->save();

        return back()->with('success', 'Profile and Shop settings updated successfully!');
    }

    /**
     * Full Orders Management List (Paginated)
>>>>>>> origin/SellerStartup2.0
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
<<<<<<< HEAD
        ->with(['user', 'product'])
=======
        ->with(['user', 'product.images'])
>>>>>>> origin/SellerStartup2.0
        ->latest()
        ->paginate(15);

        return view('seller.orders', compact('orders'));
    }

    /**
<<<<<<< HEAD
     * Update Order Status
     * Allows sellers to mark items as 'completed' or 'cancelled'
=======
     * Update Order Status & Handle Inventory Returns
>>>>>>> origin/SellerStartup2.0
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $seller = Auth::user();

<<<<<<< HEAD
        // Find the order and verify the seller owns the product via 'user_id'
        $order = Order::whereHas('product', function($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })->findOrFail($id);
=======
        // Find the order and verify the seller owns the product
        $order = Order::whereHas('product', function($query) use ($sellerId) {
            $query->where('user_id', $sellerId);
        })->with('product')->findOrFail($id);

        // If declining, return the stock to the inventory
        if ($request->status === 'declined' && $order->status !== 'declined') {
            $order->product->increment('stock', $order->quantity);
            
            if ($order->product->status === 'sold_out') {
                $order->product->update(['status' => 'available']);
            }
        }
>>>>>>> origin/SellerStartup2.0

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated to ' . $request->status);
    }
}