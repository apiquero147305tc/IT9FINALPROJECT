<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Show the create form
    public function create()
    {
        return view('seller.products.create');
    }

    // ✅ STORE PRODUCT + MULTIPLE IMAGES
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category'    => 'required|string',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create the product
        $product = Product::create([
            'user_id'     => Auth::id(),
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock ?? 0,
            'category'    => $request->category,
            'status'      => ($request->stock > 0) ? 'available' : 'sold_out',
        ]);

        // Handle Multiple Image Uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                $product->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('seller.dash')
            ->with('success', 'Product added successfully to your studio!');
    }

    // Show edit form
    public function edit(Product $product)
    {
        // Security check
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        return view('seller.products.edit', compact('product'));
    }

    // ✅ UPDATE PRODUCT + ADD NEW IMAGES
    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category'    => 'required|string',
            'description' => 'nullable|string',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update product basic info
        $product->update([
            'name'        => $request->name,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'category'    => $request->category,
            'description' => $request->description,
            'status'      => ($request->stock <= 0) ? 'sold_out' : 'available',
        ]);

        // Add more images if uploaded
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('seller.dash')
            ->with('success', 'Product updated successfully!');
    }

    // ✅ DELETE PRODUCT & CLEAN STORAGE
    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete physical files from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete database records
        $product->images()->delete();
        $product->delete();

        return redirect()->route('seller.dash')
            ->with('success', 'Product and its images removed.');
    }
}