<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function index(Request $request)
{
    $query = Product::query();

    // Category filter
    if ($request->has('category') && $request->category !== 'All') {
        $query->where('category', $request->category);
    }

    // Search filter
    if ($request->has('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $products = $query->latest()->get();

    return view('buyer.home', [
        'products' => $products,
        'showMenu' => false
    ]);
}
    
}

