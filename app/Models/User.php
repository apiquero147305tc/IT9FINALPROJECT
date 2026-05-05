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
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'grade_level',
        'monthly_budget',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- HELPER METHODS ---

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
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Buyer Side: A buyer has many orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

