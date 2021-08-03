<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $table = "collections";
    protected $fillable = ['name', 'slugs', '_isActive', 'image'];

    public function pivots()
    {
        return $this->hasMany(ProductCollection::class, 'fid_col');
    }
}
