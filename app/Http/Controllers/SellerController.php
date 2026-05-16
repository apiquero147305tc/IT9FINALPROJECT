<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class SellerController extends Controller
{
    //////////////////////////////////////////////////
    // SELLER DASHBOARD
    //////////////////////////////////////////////////
    public function dashboard()
    {
        $sellerId = Auth::id();

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

            } catch (\Exception $e) {

                $orders = collect();
                $totalEarnings = 0;
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

    //////////////////////////////////////////////////
    // SELLER ORDERS PAGE
    //////////////////////////////////////////////////
    public function orders()
    {
        $sellerId = Auth::id();

        // IF NO ORDERS TABLE
        if (!Schema::hasTable('orders')) {

            return view('seller.orders', [
                'orders' => collect()
            ]);
        }

        // GET ORDERS
        $orders = Order::whereHas('product', function ($query) use ($sellerId) {

                $query->where('user_id', $sellerId);

            })
            ->with(['user', 'product'])
            ->latest()
            ->paginate(15);

        return view('seller.orders', compact('orders'));
    }

    //////////////////////////////////////////////////
    // UPDATE ORDER STATUS
    //////////////////////////////////////////////////
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $sellerId = Auth::id();

        // VERIFY SELLER OWNS PRODUCT
        $order = Order::whereHas('product', function ($query) use ($sellerId) {

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