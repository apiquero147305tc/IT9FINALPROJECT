<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'status',
        'order_notes',
        'seller_status',        // ← ADDED
        'rejection_reason',     // ← ADDED
    ];

    /**
     * Relationship: The Buyer who placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: The Product that was purchased.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}