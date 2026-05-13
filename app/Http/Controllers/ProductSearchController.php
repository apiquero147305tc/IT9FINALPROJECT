<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Search by keyword
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // Filter by rating
        if ($request->filled('min_rating')) {
            $minRating = $request->input('min_rating');
            $query->whereHas('reviews', function ($q) use ($minRating) {
                $q->where('approved', true)
                  ->havingRaw('AVG(rating) >= ?', [$minRating])
                  ->groupBy('product_id');
            });
        }

        // Sort options
        $sortBy = $request->input('sort_by', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')
                      ->orderByDesc('reviews_avg_rating');
                break;
            case 'latest':
            default:
                $query->orderByDesc('created_at');
                break;
        }

        // Pagination
        $products = $query->paginate(12);
        $categories = Category::all();
        $maxPrice = Product::max('price');

        return view('products.search', compact('products', 'categories', 'maxPrice'));
    }

    // Get filter options (for AJAX)
    public function getFilters()
    {
        $categories = Category::withCount('products')->get();
        $maxPrice = Product::max('price');
        $minPrice = Product::min('price');

        return response()->json([
            'categories' => $categories,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ]);
    }
}
