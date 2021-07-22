<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $guarded = [];

    public function ukurans() {
        return $this->hasMany(UkuranProducts::class, 'uid_skuP', 'sku');
    }

    public function images() {
        return $this->hasMany(ImageProducts::class, 'uid_products', 'sku');
    }
}
