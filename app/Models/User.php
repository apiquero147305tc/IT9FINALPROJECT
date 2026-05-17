<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'grade_level',
        'monthly_budget',
        'shop_name',
        'contact_number',
        'age',
        'valid_id',
        'is_blocked',
        'spent_amount',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_blocked' => 'boolean',
    ];

    /*
    |-------------------------
    | ROLE HELPERS
    |-------------------------
    */
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

    /*
    |-------------------------
    | RELATIONSHIPS
    |-------------------------
    */

    // Products owned by seller
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    // Orders made by user
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    // Cart items
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    // Favorite products
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favorites');
    }

    // Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /*
    |-------------------------
    | SMART BUDGET
    |-------------------------
    */

    public function addSpent($amount)
    {
        $this->spent_amount += $amount;
        $this->save();
    }
}