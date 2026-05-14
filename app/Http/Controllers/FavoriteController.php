<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle($productId)
    {
        $user = auth()->user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Removed from favorites');
        }

        Favorite::create([
            'user_id' => $user->id,
            'product_id' => $productId,
        ]);

        return back()->with('success', 'Added to favorites');
    }
}