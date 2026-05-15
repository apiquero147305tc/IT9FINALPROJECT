<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        ProductReview::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'comment' => $request->comment,
            'rating' => 5 // SAFE default for now
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }
}