<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'name',
    'description',
    'price',
    'stock',   // 🔥 THIS MUST EXIST
    'category',
    'image',
    'status'
];

    /**
     * Relationship: A product belongs to a Seller (User).
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: A product can be in many orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function images()
{
    return $this->hasMany(ProductImage::class);
}
}