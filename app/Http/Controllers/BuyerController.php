<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;

class BuyerController extends Controller
{
   public function index(Request $request)
{
    $query = Product::query();

    // ✅ Category filter (safe + cleaner check)
    if ($request->filled('category') && $request->category !== 'All') {
        $query->where('category', $request->category);
    }

    // ✅ Search filter (also safe)
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $products = $query->latest()->get();

    return view('buyer.home', [
        'products' => $products,
        'showMenu' => false,
        'search' => $request->search,
        'category' => $request->category
    ]);
}

public function show($id)
{
    $product = \App\Models\Product::with(['images', 'user'])
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

