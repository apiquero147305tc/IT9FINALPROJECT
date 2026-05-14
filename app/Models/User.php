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
        'status',
        'is_blocked', // Added for the block/unblock system
        'shop_name',
        'contact_number',
        'age',
        'valid_id',
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
        'is_blocked' => 'boolean', // Cast to boolean for easier logic
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

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

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