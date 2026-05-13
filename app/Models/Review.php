<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'stars',
        'body',
        'helpful',
    ];

    /** The buyer who wrote the review */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** The product being reviewed */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Returns a masked username like  j*****n
     * so buyer privacy is protected (same as Shopee style).
     */
    public function getMaskedNameAttribute(): string
    {
        $name = $this->user->name ?? 'Anonymous';
        if (strlen($name) <= 2) return $name;
        $first = $name[0];
        $last  = $name[strlen($name) - 1];
        return $first . str_repeat('*', 5) . $last;
    }
}