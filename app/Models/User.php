<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'shop_name',
        'grade_level',
        'monthly_budget',
        'spent_amount',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // =========================
    // ROLE HELPERS
    // =========================
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSeller()
    {
        return $this->role === 'seller';
    }

    public function isBuyer()
    {
        return $this->role === 'buyer';
    }

    // =========================
    // RELATIONSHIPS
    // =========================

    /**
     * Seller: products
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    /**
     * Orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Buyer cart items
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    // =========================
    // 💰 SMART BUDGET SYSTEM
    // =========================

    public function addSpent($amount)
    {
        $this->spent_amount += $amount;
        $this->save();
    }
}