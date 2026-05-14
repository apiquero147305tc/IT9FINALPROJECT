<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    protected $fillable = [
        'borrower_id',
        'lender_id',
        'product_id',
        'collateral_product_id',
        'quantity',
        'borrow_date',
        'return_date',
        'status',
        'purpose',
        'notes',
        'condition_on_return',
        'damage_description',
        'collateral_released',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'collateral_released' => 'boolean',
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

    public function collateralProduct()
    {
        return $this->belongsTo(Product::class, 'collateral_product_id');
    }
}