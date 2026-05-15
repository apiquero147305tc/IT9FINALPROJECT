<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductRatingController extends Controller
{
    // ⭐ CREATE OR UPDATE RATING
    public function rate(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $userId = Auth::id();

        // check if user already rated this product
        $existing = ProductRating::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            // update existing rating
            $existing->update([
                'rating' => $request->rating,
            ]);
        } else {
            // create new rating
            ProductRating::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'rating' => $request->rating,
            ]);
        }

        return back()->with('success', 'Rating saved successfully!');
    }
}