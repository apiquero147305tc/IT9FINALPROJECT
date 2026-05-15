<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    /**
     * Display the buyer's home page with products and notifications.
     */
    public function index(Request $request)
    {
        // =========================
        // PRODUCTS
        // =========================
        $query = Product::query()->with('images'); // Eager load images for performance

        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->get();

        // =========================
        // NOTIFICATIONS
        // =========================
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('buyer.home', [
            'products' => $products,
            'notifications' => $notifications,
            'showMenu' => false,
            'search' => $request->search,
            'category' => $request->category ?? 'All'
        ]);
    }

    /**
     * Show a specific product detail page.
     */
    public function show($id)
    {
        $product = Product::with(['images', 'user'])
            ->findOrFail($id);

        return view('buyer.product-show', compact('product'));
    }

    /**
     * Display a specific seller's shop and their products.
     */
    public function sellerShop($id)
    {
        $seller = User::findOrFail($id);

        $products = Product::where('user_id', $id)
            ->with('images')
            ->latest()
            ->get();

        return view('buyer.seller-shop', compact('seller', 'products'));
    }

    /**
     * Display the Smart Budget tracking page.
     */
    public function smartBudget()
    {
        $user = Auth::user();

        $budget = $user->monthly_budget ?? 0;

        // Ensure orders relationship is loaded
        $orders = $user->orders()->latest()->get() ?? collect();

        $spent = $orders->sum('total_price');

        $remaining = max(0, $budget - $spent);

        $percent = $budget > 0
            ? min(100, ($spent / $budget) * 100) // Caps at 100% for UI progress bars
            : 0;

        // Category breakdown from orders
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
}