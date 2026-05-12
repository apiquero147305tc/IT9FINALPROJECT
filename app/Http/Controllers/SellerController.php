<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order; 
use App\Models\User;
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

        // 1. PRODUCTS: Fetch products owned by the seller
        // ✅ ADDED ->with('images') to ensure photos show up on the dashboard
        $products = Product::where('user_id', $sellerId)
            ->with('images') 
            ->get();

        // Initialize defaults
        $orders = collect();
        $totalEarnings = 0;
        $notifCount = 0;

        if (class_exists('App\Models\Order') && Schema::hasTable('orders')) {
            try {
                // 2. ORDERS: Fetch recent orders
                $orders = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->with(['user', 'product.images']) // ✅ Also eager load images here
                ->latest()
                ->take(10)
                ->get();

                // 3. EARNINGS: Sum total price from accepted/completed orders
                $totalEarnings = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->whereIn('status', ['accepted', 'completed'])
                ->sum('total_price');

                // 4. NOTIFICATION COUNT: Specifically pending orders
                $notifCount = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->where('status', 'pending')
                ->count();

            } catch (\Exception $e) {
                $orders = collect();
                $notifCount = 0;
            }
        }

        return view('seller.dashboard', compact(
            'products',
            'orders',
            'totalEarnings',
            'notifCount'
        ));
    }

    /**
     * ✅ Show Seller Profile Settings
     */
    public function profile()
    {
        return view('seller.profile', [
            'user' => Auth::user()
        ]);
    }

    /**
     * ✅ Update Seller Profile Information
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'shop_name' => 'nullable|string|max:255',
        ]);

        // Update user details
        $user->name = $request->name;
        $user->shop_name = $request->shop_name;
        
        /** @var \App\Models\User $user */
        $user->save();

        return back()->with('success', 'Profile and Shop settings updated successfully!');
    }

    /**
     * Full Orders Management List
     */
    public function orders()
    {
        $sellerId = Auth::id();
        
        if (!Schema::hasTable('orders')) {
            return view('seller.orders', ['orders' => collect()]);
        }

        $orders = Order::whereHas('product', function($query) use ($sellerId) {
            $query->where('user_id', $sellerId);
        })
        ->with(['user', 'product.images']) // ✅ Load images for order list too
        ->latest()
        ->paginate(15);

        return view('seller.orders', compact('orders'));
    }

    /**
     * Update Order Status
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,completed,cancelled,declined'
        ]);

        $sellerId = Auth::id();

        $order = Order::whereHas('product', function($query) use ($sellerId) {
            $query->where('user_id', $sellerId);
        })->with('product')->findOrFail($id);

        if ($request->status === 'declined' && $order->status !== 'declined') {
            $order->product->increment('stock', $order->quantity);
            
            if ($order->product->status === 'sold_out') {
                $order->product->update(['status' => 'available']);
            }
        }

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated to ' . ucfirst($request->status));
    }
}