<?php

namespace App\Http\Controllers;

use App\Models\Product;
<<<<<<< HEAD
use App\Models\Order; 
use App\Models\Notification;
=======
use App\Models\Order;
>>>>>>> origin/smart-budget-control
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class SellerController extends Controller
{
<<<<<<< HEAD
    /**
     * Seller Dashboard Overview
     */
=======
    //////////////////////////////////////////////////
    // SELLER DASHBOARD
    //////////////////////////////////////////////////
>>>>>>> origin/smart-budget-control
    public function dashboard()
    {
        $sellerId = Auth::id();

<<<<<<< HEAD
        // 1. PRODUCTS: Fetch products owned by the seller
        $products = Product::where('user_id', $sellerId)
            ->with('images')
            ->get();

        // Initialize defaults for safety
        $orders = collect();
        $totalEarnings = 0;
        $notifCount = 0;
        $notifications = collect();

        // NOTIFICATIONS (always safe)
        if (Schema::hasTable('notifications')) {
            $notifications = Notification::where('user_id', $sellerId)
                ->latest()
                ->get();

            $notifCount = Notification::where('user_id', $sellerId)->count();
        }

        // Ensure the orders table exists before querying
        if (class_exists('App\Models\Order') && Schema::hasTable('orders')) {
            try {
                // 2. ORDERS: Fetch most recent orders for this seller's products
                $orders = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->with(['user', 'product.images'])
                ->latest()
                ->get();

                // 3. EARNINGS: Sum from accepted or completed orders
                $totalEarnings = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->whereIn('status', ['accepted', 'completed'])
                ->sum('total_price');
=======
        // PRODUCTS
        $products = Product::where('user_id', $sellerId)
            ->latest()
            ->get();

        // DEFAULT VALUES
        $orders = collect();
        $totalEarnings = 0;
        $notifCount = 0;

        // CHECK IF ORDERS TABLE EXISTS
        if (Schema::hasTable('orders')) {

            try {

                //////////////////////////////////////////////////
                // RECENT ORDERS
                //////////////////////////////////////////////////
                $orders = Order::whereHas('product', function ($query) use ($sellerId) {

                        // PRODUCT OWNER
                        $query->where('user_id', $sellerId);

                    })
                    ->with(['user', 'product'])
                    ->latest()
                    ->take(5)
                    ->get();

                //////////////////////////////////////////////////
                // TOTAL EARNINGS
                //////////////////////////////////////////////////
                $totalEarnings = Order::whereHas('product', function ($query) use ($sellerId) {

                        $query->where('user_id', $sellerId);

                    })
                    ->where('status', 'completed')
                    ->sum('total_price');

                //////////////////////////////////////////////////
                // NOTIFICATION COUNT
                //////////////////////////////////////////////////
                $notifCount = Order::whereHas('product', function ($query) use ($sellerId) {

                        $query->where('user_id', $sellerId);

                    })
                    ->where('is_seen', false)
                    ->count();
>>>>>>> origin/smart-budget-control

                // 4. NOTIFICATIONS: Count pending orders the seller hasn't processed
                $notifCount = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->where('status', 'pending')
                ->count();

            } catch (\Exception $e) {
<<<<<<< HEAD
                // Fail gracefully if relations aren't perfect
                $orders = collect();
=======

                $orders = collect();
                $totalEarnings = 0;
                $notifCount = 0;

>>>>>>> origin/smart-budget-control
            }
        }

        return view('seller.dashboard', compact(
            'products',
            'orders',
            'totalEarnings',
<<<<<<< HEAD
            'notifications',
=======
>>>>>>> origin/smart-budget-control
            'notifCount'
        ));
    }

<<<<<<< HEAD
    /**
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
     */
    public function orders()
    {
        $seller = Auth::user();

=======
    //////////////////////////////////////////////////
    // SELLER ORDERS PAGE
    //////////////////////////////////////////////////
    public function orders()
    {
        $sellerId = Auth::id();

        // IF NO ORDERS TABLE
>>>>>>> origin/smart-budget-control
        if (!Schema::hasTable('orders')) {

            return view('seller.orders', [
                'orders' => collect()
            ]);
        }

<<<<<<< HEAD
        $orders = Order::whereHas('product', function($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })
        ->with(['user', 'product.images'])
        ->latest()
        ->paginate(15);
=======
        // GET ORDERS
        $orders = Order::whereHas('product', function ($query) use ($sellerId) {

                $query->where('user_id', $sellerId);

            })
            ->with(['user', 'product'])
            ->latest()
            ->paginate(15);
>>>>>>> origin/smart-budget-control

        return view('seller.orders', compact('orders'));
    }

<<<<<<< HEAD
    /**
     * Update Order Status & Handle Inventory Returns
     */
=======
    //////////////////////////////////////////////////
    // UPDATE ORDER STATUS
    //////////////////////////////////////////////////
>>>>>>> origin/smart-budget-control
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled,accepted,declined'
        ]);

<<<<<<< HEAD
        $seller = Auth::user();
        $sellerId = $seller->id;

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
=======
        $sellerId = Auth::id();

        // VERIFY SELLER OWNS PRODUCT
        $order = Order::whereHas('product', function ($query) use ($sellerId) {
>>>>>>> origin/smart-budget-control

                $query->where('user_id', $sellerId);

            })
            ->findOrFail($id);

        // UPDATE STATUS
        $order->status = $request->status;
        $order->save();

        return back()->with(
            'success',
            'Order status updated successfully.'
        );
    }
}