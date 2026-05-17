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
        'category',
        'image',
        'status'
    ];

    /**
     * Seller who owns this product
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Alias for seller (used in home.blade)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Product images
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Orders for this product
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}