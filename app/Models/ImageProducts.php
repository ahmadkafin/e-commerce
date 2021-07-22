<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProducts extends Model
{
    use HasFactory;
    protected $table = 'image_products';
    protected $guarded = [];

    public function products()
    {
        return $this->belongsTo(Products::class, 'uid_products', 'sku');
    }
}
