<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'Discount';
    protected $guarded = [];

    public function products(){
        return $this->belongsTo(Products::class, 'products_id', 'id');
    }
}
