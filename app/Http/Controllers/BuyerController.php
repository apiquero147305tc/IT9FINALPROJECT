<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;

class BuyerController extends Controller
{
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
        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        /*
        |-----------------------------------
        | SEARCH FILTER
        |-----------------------------------
        */
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
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

        return view('buyer.product-show', compact('product'));
    }

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

    public function profile()
    {
        $user = auth()->user();

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
        $user = auth()->user();

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

        return view('buyer.smartbudget', compact(
            'budget',
            'spent',
            'remaining',
            'percent',
            'spending'
        ));
    }
}