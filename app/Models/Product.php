<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'stock',
        'category',
        'image',
        'status',
    ];

    /**
     * Get the seller that owns the product.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope a query to only include available products.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0)->where('status', 'active');
    }
}