<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProductImage;
use App\Models\Favorite;

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

    /*
    |-------------------------
    | RELATIONSHIPS
    |-------------------------
    */

    // Owner of product (seller)
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Product images
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Orders containing this product
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    //Favorites
    public function favorites()
   {
    return $this->hasMany(Favorite::class, 'product_id'); 
   }
}