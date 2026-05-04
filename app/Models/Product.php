<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Allowed mass-assignable fields
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'stock',
        'category',
        'image',
        'status', // ✅ FIX: IMPORTANT (this was missing)
    ];

    /**
     * Default attributes for new products
     * This prevents "available" or NULL issues
     */
    protected $attributes = [
        'status' => 'pending', // ✅ FIX: standardize system
    ];

    /**
     * Relationship: A product belongs to a Seller (User)
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: A product can be in many orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Force-safe status setter (prevents "available" leaking in)
     */
    public function setStatusAttribute($value)
    {
        $allowed = ['pending', 'approved', 'rejected'];

        // normalize old bad value
        if ($value === 'available') {
            $value = 'pending';
        }

        // fallback safety
        if (!in_array($value, $allowed)) {
            $value = 'pending';
        }

        $this->attributes['status'] = $value;
    }
}