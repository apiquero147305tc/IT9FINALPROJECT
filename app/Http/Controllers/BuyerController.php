<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
<<<<<<< HEAD
use App\Models\Notification;
use Illuminate\Http\Request;
=======
>>>>>>> origin/smart-budget-control
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
<<<<<<< HEAD
    /**
     * Display the buyer's home page with products and notifications.
     */
    public function index(Request $request)
    {
        // =========================
        // PRODUCTS
        // =========================
        $query = Product::query()->with('images'); // Eager load images for performance

=======
    public function index(Request $request)
    {
        $query = Product::query()
            ->with([
                'ratings',
                'reviews'
            ]); // SAFE preload

        /*
        |-----------------------------------
        | CATEGORY FILTER
        |-----------------------------------
        */
>>>>>>> origin/smart-budget-control
        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

<<<<<<< HEAD
=======
        /*
        |-----------------------------------
        | SEARCH FILTER
        |-----------------------------------
        */
>>>>>>> origin/smart-budget-control
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

<<<<<<< HEAD
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
=======
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

        return view('buyer.home', [
            'products' => $products,
            'showMenu' => false,
            'search' => $request->search,
            'category' => $request->category,
            'sort' => $sort
        ]);
    }

    public function show($id)
    {
        $product = Product::with([
            'images',
            'seller',
            'ratings',
            'reviews.user'
        ])->findOrFail($id);
>>>>>>> origin/smart-budget-control

        return view('buyer.product-show', compact('product'));
    }

<<<<<<< HEAD
    /**
     * Display a specific seller's shop and their products.
     */
=======
>>>>>>> origin/smart-budget-control
    public function sellerShop($id)
    {
        $seller = User::findOrFail($id);

        $products = Product::where('user_id', $id)
<<<<<<< HEAD
            ->with('images')
=======
            ->with([
                'images',
                'ratings',
                'reviews'
            ])
>>>>>>> origin/smart-budget-control
            ->latest()
            ->get();

        return view('buyer.seller-shop', compact('seller', 'products'));
    }

<<<<<<< HEAD
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

=======
    public function profile()
    {
      $user = Auth::user();

        $budget = $user->monthly_budget ?? 0;

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

>>>>>>> origin/smart-budget-control
        return view('buyer.smartbudget', compact(
            'budget',
            'spent',
            'remaining',
            'percent',
            'spending'
        ));
    }
}