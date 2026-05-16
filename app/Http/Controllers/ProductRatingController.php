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

    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Please login first.');
    }

    ProductRating::updateOrCreate(
        [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ],
        [
            'rating' => $request->rating,
        ]
    );

    return back()->with('success', 'Rating saved successfully!');
}
}