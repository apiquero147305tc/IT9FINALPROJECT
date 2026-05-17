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
                    $query->where('user_id', $sellerId);
                })
                ->with(['user', 'product'])
                ->latest()
                ->take(5)
                ->get();

            $totalEarnings = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->where('seller_status', 'accepted')  // ← CHANGED: only count accepted orders
                ->sum('total_price');
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
        ->get();  // ← CHANGED: use get() instead of paginate for your design

        return view('seller.orders', compact('orders'));
    }

    /**
     * Accept Order
     */
    public function acceptOrder($id)
    {
        $seller = Auth::user();

        $order = Order::whereHas('product', function($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })->findOrFail($id);

        $order->update([
            'seller_status' => 'accepted',
            'status' => 'processing',
        ]);

        // Notify buyer
        if (Schema::hasTable('notifications')) {
            Notification::create([
                'user_id' => $order->user_id,
                'type' => 'new_order',
                'subject' => 'Order Accepted',
                'message' => 'Your order #' . $order->id . ' has been accepted by ' . $seller->shop_name,
                'link' => '/buyer/orders/' . $order->id,
            ]);
        }

        return back()->with('success', 'Order accepted!');
    }

    /**
     * Reject Order
     */
    public function rejectOrder(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $seller = Auth::user();

        $order = Order::whereHas('product', function($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })->findOrFail($id);

        // Restore stock
        $product = $order->product;
        $product->increment('stock', $order->quantity);
        $product->update(['status' => 'available']);

        $order->update([
            'seller_status' => 'rejected',
            'status' => 'cancelled',
            'rejection_reason' => $request->reason,
        ]);

        // Notify buyer
        if (Schema::hasTable('notifications')) {
            Notification::create([
                'user_id' => $order->user_id,
                'type' => 'new_order',
                'subject' => 'Order Rejected',
                'message' => 'Your order #' . $order->id . ' was rejected. Reason: ' . $request->reason,
                'link' => '/buyer/orders/' . $order->id,
            ]);
        }

        return back()->with('error', 'Order rejected.');
    }

    /**
     * Update Order Status (Legacy - keep for backwards compatibility)
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $seller = Auth::user();

        $order = Order::whereHas('product', function($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })->findOrFail($id);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated to ' . $request->status);
    }
}