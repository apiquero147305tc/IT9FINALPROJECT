<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // The Seller's ID
        'name',
        'description',
        'price',
        'category',
        'image',
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
}