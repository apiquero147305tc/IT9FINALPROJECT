<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProductImage;
use App\Models\Favorite;
use App\Models\ProductRating;

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

    // Seller
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Images
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Favorites
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'product_id');
    }

    // reviews
 public function reviews()
{
    return $this->hasMany(Review::class);
}

   public function favoritedBy()
{
    return $this->belongsToMany(User::class, 'favorites');
}

public function ratings()
{
    return $this->hasMany(ProductRating::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}