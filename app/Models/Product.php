<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category',
    ];

    // --- RELATIONSHIPS ---

    /**
     * The seller who owns this product.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Users who have favorited this product.
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    /**
     * All reviews for this product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // --- REVIEW HELPERS ---

    public function approvedReviews()
    {
        return $this->reviews()->where('approved', true)->orderByDesc('created_at');
    }

    public function getAverageRating()
    {
        // Rounds to 1 decimal place for a cleaner UI (e.g., 4.5)
        return round($this->approvedReviews()->avg('rating') ?? 0, 1);
    }

    public function getReviewCount()
    {
        return $this->approvedReviews()->count();
    }
}