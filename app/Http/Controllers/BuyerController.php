<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BuyerController extends Controller
{
    /**
     * Display the buyer's home page with products and notifications.
     */
    public function index(Request $request)
    {
        $query = Product::query()
            ->with([
                'images',
                'ratings',
                'reviews'
            ]);

        /*
        |-----------------------------------
        | CATEGORY FILTER
        |-----------------------------------
        */
        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        /*
        |-----------------------------------
        | SEARCH FILTER
        |-----------------------------------
        */
       if ($request->filled('search')) {
    $query->where(function ($q) use ($request) {
        $q->where('name', 'like', '%' . $request->search . '%')
          ->orWhereHas('seller', function ($q2) use ($request) {
              $q2->where('shop_name', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%');
          });
    });
}

        /*
        |-----------------------------------
        | SORTING SYSTEM (SAFE + CLEAN)
        |-----------------------------------
        */
        $sort = $request->sort ?? 'latest';

        if ($sort === 'rating') {
            $query->withAvg('ratings', 'rating')
                  ->orderByDesc('ratings_avg_rating');
        } elseif ($sort === 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_high') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->get();

        /*
        |-----------------------------------
        | NOTIFICATIONS
        |-----------------------------------
        */
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('buyer.home', [
            'products' => $products,
            'notifications' => $notifications,
            'showMenu' => false,
            'search' => $request->search,
            'category' => $request->category ?? 'All',
            'sort' => $sort
        ]);
    }

    /**
     * Show a specific product detail page.
     */
    public function show($id)
    {
        $product = Product::with([
            'images',
            'seller',
            'ratings',
            'reviews.user'
        ])->findOrFail($id);

        return view('buyer.product-show', compact('product'));
    }

    /**
     * Display a specific seller's shop and their products.
     */
    public function sellerShop($id)
    {
        $seller = User::findOrFail($id);

        $products = Product::where('user_id', $id)
            ->with([
                'images',
                'ratings',
                'reviews'
            ])
            ->latest()
            ->get();

        return view('buyer.seller-shop', compact('seller', 'products'));
    }

    /**
     * Display buyer profile with budget tracking.
     */
    public function profile()
    {
        $user = Auth::user();

        $budget = (float) str_replace(['₱', ',', ' '], '', $user->monthly_budget ?? 0);

        $orders = $user->orders ?? collect();

        $spent = $orders->sum('total_price');

        $remaining = $budget - $spent;

        $percent = $budget > 0
            ? ($spent / $budget) * 100
            : 0;

        $spending = $orders->groupBy('category')->map(function ($items) {
            return $items->sum('total_price');
        });

        return view('buyer.profile', compact(
            'budget',
            'spent',
            'remaining',
            'percent',
            'spending'
        ));
    }

    /**
     * Display the Smart Budget tracking page.
     */
    public function smartBudget()
    {
        $user = Auth::user();

        $orders = $user->orders ?? collect();

        $budget = $user->monthly_budget ?? 0;

        $spent = $orders->sum('total_price');

        $budget = (float) $budget;
        $spent = (float) $spent;

        $remaining = $budget - $spent;

        $percent = $budget > 0
            ? ($spent / $budget) * 100
            : 0;

        $spending = $orders->groupBy('category')->map(function ($items) {
            return $items->sum('total_price');
        });

        return view('buyer.smartbudget', compact(
            'budget',
            'spent',
            'remaining',
            'percent',
            'spending'
        ));
    }
        /**
     * Display buyer's order history.
     */
    public function orders()
    {
        $user = Auth::user();

        $orders = \App\Models\Order::where('user_id', $user->id)
            ->with(['product.images', 'product.user'])
            ->latest()
            ->get();

        return view('buyer.orders', compact('orders'));
    }

    public function updateProfile(Request $request)
{
    /** @var \App\Models\User $user */
$user = Auth::user();

    $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6|confirmed',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return back()->with('success', 'Profile updated successfully!');
}

public function deleteAccount()
{
   /** @var \App\Models\User $user */
$user = Auth::user();

    Auth::logout();

    $user->delete();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('home')
        ->with('success', 'Your account has been deleted.');
}
}