<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Store a review
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
                               ->where('product_id', $product->id)
                               ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'approved' => false, // Requires moderation
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }

    // Get reviews for a product (API endpoint)
    public function getProductReviews(Product $product)
    {
        $reviews = $product->approvedReviews()
                          ->with('user')
                          ->paginate(10);

        return response()->json($reviews);
    }

    // Delete a review (by user or admin)
    public function destroy(Review $review)
    {
        if (Auth::id() !== $review->user_id && !Auth::user()->is_admin) {
            return back()->with('error', 'Unauthorized');
        }

        $review->delete();
        return back()->with('success', 'Review deleted');
    }
}
