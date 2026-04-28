<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    /**
     * Show the Seller Dashboard
     */
    public function index()
    {
        // The 'auth' and 'checkRole' middleware in web.php already handle the check.
        // We just need to fetch the data.
        $myProducts = Product::where('user_id', Auth::id())->latest()->get();

        // Ensure the file is resources/views/seller_dashboard.blade.php
        return view('seller_dashboard', compact('myProducts'));
    }

    /**
     * Save product to database
     */
    public function store(Request $request)
    {
        // 1. Validate
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'category' => ['required', 'string'],
            'image' => ['nullable', 'url'],
            'description' => ['nullable', 'string'], // Added to validation
        ]);

        // 2. Create
        // Ensure 'user_id', 'description', 'stock', and 'status' are in Product.php $fillable array
        Product::create([
            'user_id'     => Auth::id(),
            'name'        => $request->name,
            'description' => $request->description ?? 'No description provided.',
            'price'       => $request->price,
            'category'    => $request->category,
            'image'       => $request->image,
            'stock'       => 10,
            'status'      => 'active',
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Item listed!');
    }
}