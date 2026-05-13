<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display all favorites
    public function index()
    {
        $favorites = Auth::user()->favorites()->paginate(12);
        return view('favorites.index', compact('favorites'));
    }

    // Add to favorites
    public function store(Product $product)
    {
        if (!Auth::user()->isFavorite($product->id)) {
            Auth::user()->favorites()->attach($product->id);
        }
        return back()->with('success', 'Product added to favorites');
    }

    // Remove from favorites
    public function destroy(Product $product)
    {
        Auth::user()->favorites()->detach($product->id);
        return back()->with('success', 'Product removed from favorites');
    }

    // AJAX endpoint - check if product is favorited
    public function check(Product $product)
    {
        return response()->json([
            'isFavorite' => Auth::user()->isFavorite($product->id)
        ]);
    }
}
