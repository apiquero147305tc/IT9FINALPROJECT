<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order; 
use App\Models\Notification;
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

        // PRODUCTS: Fetch products owned by the seller
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
                // ORDERS: Fetch most recent orders for this seller's products
                $orders = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->with(['user', 'product.images'])
                ->latest()
                ->take(5)
                ->get();

                // EARNINGS: Sum from accepted or completed orders
                $totalEarnings = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->whereIn('status', ['accepted', 'completed'])
                ->sum('total_price');

                // NOTIFICATIONS: Count pending orders
                $notifCount = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->where('status', 'pending')
                ->count();

            } catch (\Exception $e) {
                // Fail gracefully if relations aren't perfect
                $orders = collect();
                $totalEarnings = 0;
                $notifCount = 0;
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

        if (!Schema::hasTable('orders')) {
            return view('seller.orders', ['orders' => collect()]);
        }

        $orders = Order::whereHas('product', function($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })
        ->with(['user', 'product.images'])
        ->latest()
        ->paginate(15);

        return view('seller.orders', compact('orders'));
    }

    /**
     * Update Order Status & Handle Inventory Returns
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled,accepted,declined'
        ]);

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

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated to ' . $request->status);
    }
}