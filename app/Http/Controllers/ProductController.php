<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Show the form to add a new product
    public function create()
    {
        return view('seller.products.create');
    }

    // Save the product to the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Saves image to storage/app/public/products
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'user_id' => Auth::id(), // Automatically assign to the logged-in seller
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category,
            'image' => $imagePath,
            'status' => 'pending',
        ]);

        return redirect()->route('seller.dash')->with('success', 'Product added successfully!');
    }

    // Show the edit form
    public function edit(Product $product)
    {
        // Security: Ensure the seller owns this product
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }
        return view('seller.products.edit', compact('product'));
    }

    // Update the product details
    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) abort(403);

        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update($request->only(['name', 'description', 'price', 'stock', 'category']));
        $product->save();

        return redirect()->route('seller.dash')->with('success', 'Product updated!');
    }
}