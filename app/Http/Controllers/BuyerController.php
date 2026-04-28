<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    /**
     * Show the Buyer Dashboard / Marketplace
     */
    public function index()
    {
        // Fetch all products to display on the marketplace
        $products = Product::all();

        // This expects: resources/views/buyer_dashboard.blade.php
        return view('buyer_dashboard', compact('products'));
    }

    /**
     * Show the Shopping Cart
     */
    public function viewCart()
    {
        // This expects: resources/views/cart.blade.php
        return view('cart'); 
    }
}