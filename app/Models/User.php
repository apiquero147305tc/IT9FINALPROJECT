<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- HELPER METHODS ---

    /**
     * Check if the user is a seller.
     */
    public function isSeller(): bool
    {
        return strtolower($this->role) === 'seller';
    }

    /**
     * Check if the user is a buyer.
     */
    public function isBuyer(): bool
    {
        return strtolower($this->role) === 'buyer';
    }

    // --- RELATIONSHIPS ---

    /**
     * Relationship: A user (seller) can have many products.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}