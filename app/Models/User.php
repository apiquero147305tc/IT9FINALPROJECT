<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'is_blocked',
        'shop_name',
        'contact_number',
        'age',
        'valid_id',
        'grade_level',
        'monthly_budget',
        'spent_amount',
    ];

    /**
     * Default values for model attributes.
     */
    protected $attributes = [
        'is_blocked' => false,
        'status' => 'pending',
        'spent_amount' => 0,
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_blocked' => 'boolean',
        'spent_amount' => 'decimal:2',
    ];

    // =========================================================================
    // 🛡️ ROLE HELPERS
    // =========================================================================

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    public function isBuyer(): bool
    {
        return $this->role === 'buyer';
    }

    // =========================================================================
    // 💰 SMART BUDGET SYSTEM
    // =========================================================================

    /**
     * Extracts the numeric value from the formatted budget string (e.g., "₱1,500.00" -> 1500.00)
     */
    public function getNumericBudget(): float
    {
        if (!$this->monthly_budget) return 0.0;
        return (float) str_replace(['₱', ',', ' '], '', $this->monthly_budget);
    }

    /**
     * Get the remaining balance for the student.
     */
    public function getRemainingBudgetAttribute(): float
    {
        return max(0, $this->getNumericBudget() - $this->spent_amount);
    }

    /**
     * Add an amount to the total spent.
     */
    public function addSpent(float $amount): void
    {
        $this->increment('spent_amount', $amount);
    }

    // =========================================================================
    // 🔗 RELATIONSHIPS
    // =========================================================================

    /**
     * A seller has many products.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    /**
     * A user (buyer) has many orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * A buyer has many items in their cart.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }
}