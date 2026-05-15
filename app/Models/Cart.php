<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

=======
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
>>>>>>> origin/SellerStartup2.0
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

<<<<<<< HEAD
    public function user()
=======
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
>>>>>>> origin/SellerStartup2.0
    {
        return $this->belongsTo(User::class);
    }

<<<<<<< HEAD
    public function product()
    {
        return $this->belongsTo(Product::class);
=======
    /**
     * Accessor Helper: Calculate the subtotal for this specific line item.
     * Use in Blade like: ₱{{ number_format($item->subtotal, 2) }}
     */
    public function getSubtotalAttribute()
    {
        // This ensures that even if a product is deleted, the site doesn't crash
        return $this->product ? $this->product->price * $this->quantity : 0;
>>>>>>> origin/SellerStartup2.0
    }
}