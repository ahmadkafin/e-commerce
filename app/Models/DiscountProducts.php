<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountProducts extends Model
{
    use HasFactory;
    protected $table = 'discount_products';
    protected $guarded = [];


    public function products()
    {
        return $this->belongsTo(Products::class, 'uid_products');
    }

    public function discounts()
    {
        return $this->belongsTo(Discount::class, 'uid_disc');
    }
}
