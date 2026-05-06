<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    /**
     * Relationship: A cart item belongs to a product.
     * This allows you to do $cartItem->product->name
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Relationship: A cart item belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper: Calculate the subtotal for this specific line item.
     * Use in Blade like: ₱{{ number_format($item->subtotal, 2) }}
     */
    public function getSubtotalAttribute()
    {
        return $this->product ? $this->product->price * $this->quantity : 0;
    }
}