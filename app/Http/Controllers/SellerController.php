<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
use App\Models\Order;
use App\Models\Notification;

class SellerController extends Controller
{
    /**
     * Check seller status and redirect if not active
     */
    private function checkSellerStatus()
    {
        $user = Auth::user();

        if ($user->status === 'pending') {
            return redirect()->route('seller.pending');
        }

        if ($user->status === 'approved') {
            return redirect()->route('seller.confirm');
        }

        return null;
    }

    /**
     * Show the pending approval page
     */
    public function pending()
    {
        $user = Auth::user();

        if ($user->status === 'approved') {
            return redirect()->route('seller.confirm');
        }

        if ($user->status === 'active') {
            return redirect()->route('seller.dash');
        }

        return view('seller.pending-approval');
    }

    /**
     * Show the confirmation page after admin approval
     */
    public function confirm()
    {
        $user = Auth::user();

        if ($user->status === 'pending') {
            return redirect()->route('seller.pending')
                ->with('info', 'Your account is still pending admin approval.');
        }

        if ($user->status === 'active') {
            return redirect()->route('seller.dash');
        }

        return view('seller.confirm');
    }

    /**
     * User confirms YES - activate seller account
     */
    public function confirmYes()
    {
        $user = \App\Models\User::find(Auth::id());

        if ($user->role !== 'seller' || $user->status !== 'approved') {
            return redirect()->route('seller.pending');
        }

        $user->status = 'active';
        $user->save();

        return redirect()->route('seller.dash')
            ->with('success', 'Welcome to CraveCart!');
    }

    /**
     * User confirms NO - delete account
     */
    public function confirmNo()
    {
        $user = \App\Models\User::find(Auth::id());

        Auth::logout();
        $user->delete();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home')
            ->with('info', 'Your account has been deleted. We hope to see you again!');
    }

    // ✅ FIX: Added selfApprove method for pending sellers
    /**
     * Self-approve a pending seller account
     */
    public function selfApprove()
    {
        $user = \App\Models\User::find(Auth::id());

        // Only pending sellers can self-approve
        if ($user->role !== 'seller' || $user->status !== 'pending') {
            return redirect()->route('seller.pending')
                ->with('error', 'You are not eligible for self-approval.');
        }

        $user->status = 'approved';
        $user->save();

        return redirect()->route('seller.confirm')
            ->with('success', 'You have been approved! Please confirm your account to start selling.');
    }

    // ✅ FIX: Added deleteAccount method for pending sellers
    /**
     * Delete seller account from pending approval page
     */
    public function deleteAccount()
    {
        $user = \App\Models\User::find(Auth::id());

        if ($user->role !== 'seller') {
            return redirect()->route('home')
                ->with('error', 'Unauthorized action.');
        }

        Auth::logout();
        $user->delete();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home')
            ->with('info', 'Your account has been deleted. We hope to see you again!');
    }

    /**
     * Seller Dashboard View
     */
    public function dashboard()
    {
        $redirect = $this->checkSellerStatus();
        if ($redirect) return $redirect;

        $seller = Auth::user();
        $sellerId = $seller->id;

       $products = Product::with([
            'images',
            'reviews.user'
        ])
        ->where('user_id', $sellerId)
        ->get();

        $orders = collect();
        $totalEarnings = 0;
        $notifCount = 0;
        $notifications = collect();

        if (Schema::hasTable('notifications')) {
            $notifications = Notification::where('user_id', $sellerId)
                ->latest()
                ->get();
            $notifCount = Notification::where('user_id', $sellerId)->count();
        }

        if (class_exists('App\Models\Order') && Schema::hasTable('orders')) {
            try {
                $orders = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->with(['user', 'product.images'])
                ->latest()
                ->take(5)
                ->get();

                $totalEarnings = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->whereIn('status', ['accepted', 'completed'])
                ->sum('total_price');

                $notifCount = Order::whereHas('product', function ($query) use ($sellerId) {
                    $query->where('user_id', $sellerId);
                })
                ->where('status', 'pending')
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
            'notifications',
            'notifCount'
        ));
    }

    /**
     * Seller Profile View
     */
    public function profile()
    {
        $redirect = $this->checkSellerStatus();
        if ($redirect) return $redirect;

        return view('seller.profile', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update Seller Shop Information
     */
    public function updateProfile(Request $request)
    {
        $redirect = $this->checkSellerStatus();
        if ($redirect) return $redirect;

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
        $redirect = $this->checkSellerStatus();
        if ($redirect) return $redirect;

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
        $redirect = $this->checkSellerStatus();
        if ($redirect) return $redirect;

        $request->validate([
            'status' => 'required|in:pending,completed,cancelled,accepted,declined'
        ]);

        $seller = Auth::user();
        $sellerId = $seller->id;

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

        return back()->with('success', 'Order status updated to ' . $request->status);
    }
}