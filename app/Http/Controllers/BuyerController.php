<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by minimum average star rating (requires reviews table)
        if ($request->filled('stars')) {
            $query->whereHas('reviews', function ($q) use ($request) {
                $q->selectRaw('AVG(stars) as avg_stars')
                  ->havingRaw('AVG(stars) >= ?', [$request->stars]);
            });
        }

        $products = $query->latest()->get();

        return view('buyer.home', [
            'products' => $products,
            'search'   => $request->search,
            'category' => $request->category,
        ]);
    }
}