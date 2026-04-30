<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // 1. Handle the Category Filter (from your Gift/Food icons)
        if ($request->has('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        // 2. Handle Search bar queries
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 3. Fetch products and pass to the variable $products
        $products = $query->latest()->get();

        // 4. Send $products to buyer/home.blade.php
        return view('buyer.home', compact('products'));
    }
}