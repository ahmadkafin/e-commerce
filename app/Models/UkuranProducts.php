<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UkuranProducts extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'size_products';
    protected $fillable = ['uid_skuP', 'size', 'jumlah'];

    public function products()
    {
        return $this->belongsTo(Products::class, 'uid_skuP', 'sku');
    }
}
