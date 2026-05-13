<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Show all reviews for a product.
     * Route: GET /products/{product}/reviews
     */
    public function index(Request $request, Product $product)
    {
        $query = Review::with('user')
            ->where('product_id', $product->id);

        // Filter by star rating
        if ($request->filled('stars') && $request->stars !== 'all') {
            $query->where('stars', $request->stars);
        }

        // Filter: with media (future — for now, just return all)
        // Search keyword inside review body
        if ($request->filled('search')) {
            $query->where('body', 'like', '%' . $request->search . '%');
        }

        $reviews = $query->latest()->get();

        $avgRating = Review::where('product_id', $product->id)->avg('stars') ?? 0;
        $totalCount = Review::where('product_id', $product->id)->count();

        return view('buyer.reviews', compact('product', 'reviews', 'avgRating', 'totalCount'));
    }

    /**
     * Store a new review.
     * Route: POST /products/{product}/reviews
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'stars' => 'required|integer|min:1|max:5',
            'body'  => 'required|string|max:1000',
        ]);

        // One review per buyer per product
        $existing = Review::where('user_id', Auth::id())
                          ->where('product_id', $product->id)
                          ->first();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        Review::create([
            'user_id'    => Auth::id(),
            'product_id' => $product->id,
            'stars'      => $request->stars,
            'body'       => $request->body,
        ]);

        return back()->with('success', 'Review submitted! Thank you 🎉');
    }

    /**
     * Mark a review as helpful (+1).
     * Route: POST /reviews/{review}/helpful
     */
    public function helpful(Review $review)
    {
        $review->increment('helpful');
        return back();
    }
}