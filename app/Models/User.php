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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ✔ ROLE HELPERS
    public function isAdmin() { return $this->role === 'admin'; }
    public function isSeller() { return $this->role === 'seller'; }
    public function isBuyer() { return $this->role === 'buyer'; }

<<<<<<< HEAD
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

    /**
     * Custom helper for University of Mindanao student logic
     */
    public function isStudent(): bool
    {
        return in_array($this->grade_level, ['High School', 'SHS', 'College']);
    }

    // --- RELATIONSHIPS ---

    /**
     * Seller Side: A seller has many products.
     */
=======
    // ✔ RELATIONSHIPS

>>>>>>> mergeTesting
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
<<<<<<< HEAD

    /**
     * Buyer Side: A buyer has many items in their cart.
     * This links to the Cart model using the 'user_id' column.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }
=======
>>>>>>> mergeTesting
}