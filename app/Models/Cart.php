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
     * Access via: $cartItem->product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Relationship: A cart item belongs to a user.
     * Access via: $cartItem->user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor Helper: Calculate the subtotal for this specific line item.
     * Use in Blade like: ₱{{ number_format($item->subtotal, 2) }}
     */
    public function getSubtotalAttribute()
    {
        // This ensures that even if a product is deleted, the site doesn't crash
        return $this->product ? $this->product->price * $this->quantity : 0;
    }
}