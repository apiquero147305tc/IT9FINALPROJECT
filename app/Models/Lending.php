<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrower_id',
        'lender_id',
        'product_id',
        'duration_days',
        'collateral_type',
        'collateral_description',
        'collateral_value',
        'lending_fee',
        'purpose',
        'status',
        'borrowed_at',
        'due_date',
        'approved_at',
        'rejected_at',
        'returned_at',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'returned_at' => 'datetime',
        'collateral_value' => 'decimal:2',
        'lending_fee' => 'decimal:2',
    ];

    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }

    public function lender()
    {
        return $this->belongsTo(User::class, 'lender_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function isOverdue(): bool
    {
        if ($this->status !== 'approved') {
            return false;
        }
        return now()->greaterThan($this->due_date);
    }

    public function daysRemaining(): int
    {
        if ($this->status !== 'approved') {
            return 0;
        }
        return max(0, now()->diffInDays($this->due_date, false));
    }
}