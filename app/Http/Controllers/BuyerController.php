<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    public function index(Request $request)
    {
        // =========================
        // PRODUCTS
        // =========================
        $query = Product::query();

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
            'category' => $request->category
        ]);
    }

    public function show($id)
    {
        $product = Product::with(['images', 'user'])
            ->findOrFail($id);

        return view('buyer.product-show', compact('product'));
    }

    public function sellerShop($id)
    {
        $seller = User::findOrFail($id);

        $products = Product::where('user_id', $id)
            ->with('images')
            ->latest()
            ->get();

        return view('buyer.seller-shop', compact('seller', 'products'));
    }
}