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

    // Store new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'custom_category' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle custom category
        $category = $request->category === 'custom' 
            ? $request->custom_category 
            : $request->category;

        // Create product
        $product = Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'category' => $category,
            'image' => null,
            'status' => 'available',
        ]);

        // Multiple images
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

    // Update product
    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'custom_category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle custom category
        $category = $request->category === 'custom' 
            ? $request->custom_category 
            : $request->category;

        // Update product
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $category,
            'description' => $request->description ?? $product->description,
            'status' => $request->stock <= 0 ? 'sold_out' : 'available',
        ]);

        // Add new images
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

    // Delete product
    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete all images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete image records and product
        $product->images()->delete();
        $product->delete();

        return redirect()->route('seller.dash')
            ->with('success', 'Product deleted successfully!');
    }

    // Delete single image
    public function deleteImage(ProductImage $image)
    {
        // Check if user owns the product
        if ($image->product->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete from storage
        Storage::disk('public')->delete($image->image_path);

        // Delete from database
        $image->delete();

        return response()->json(['success' => true]);
    }
}