<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCollection extends Model
{
    use HasFactory;
    protected $table = "product_collections";
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Products::class, 'fid_prod');
    }

    public function collections()
    {
        return $this->belongsTo(Collection::class, 'fid_col');
    }
}
