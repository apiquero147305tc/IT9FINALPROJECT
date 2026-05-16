<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Show the form
    public function create()
    {
        return view('seller.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // CREATE PRODUCT
        $product = Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'category' => $request->category,
            'image' => null,
            'status' => 'available',
        ]);

        // MULTIPLE IMAGES
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                $product->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('seller.dash')
            ->with('success', 'Product added successfully!');
    }

    // Show edit form
    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        return view('seller.products.edit', compact('product'));
    }

    // UPDATE PRODUCT
    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category,
            'description' => $request->description ?? $product->description,
            'status' => $request->stock <= 0 ? 'sold_out' : 'available',
        ]);

        // NEW IMAGES (optional)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                $product->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('seller.dash')
            ->with('success', 'Product updated!');
    }

    // DELETE PRODUCT
    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->images()->delete();
        $product->delete();

        return redirect()->route('seller.dash');
    }

    /*
    -------------------------------------------------
    ⭐ ADDED FOR RATING SYSTEM (SAFE ADDITION ONLY)
    -------------------------------------------------
    */

    // SHOW PRODUCT (for buyer view with ratings)
    public function show(Product $product)
{
    $product->load('reviews.user', 'seller', 'images');

    $avgRating = $product->reviews->avg('rating');
    $totalReviews = $product->reviews->count();

    return view('buyer.product-show', compact(
        'product',
        'avgRating',
        'totalReviews'
    ));
}
}