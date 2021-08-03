<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Products extends Model
{
    use HasFactory, Sluggable;
    protected $table = 'products';
    protected $guarded = [];

    public function ukurans()
    {
        return $this->hasMany(UkuranProducts::class, 'uid_skuP', 'sku');
    }

    public function images()
    {
        return $this->hasMany(ImageProducts::class, 'uid_products', 'sku');
    }

    public function pivot()
    {
        return $this->hasOne(ProductCollection::class, 'fid_prod');
    }

    public function discount_products()
    {
        return $this->hasMany(DiscountProducts::class, 'sku');
    }

    public function image()
    {
        return $this->hasOne(ImageProducts::class, 'uid_products', 'sku');
    }

    /**
     * Return the sluggable config array for this model
     * 
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slugs' => [
                'source' => 'nama'
            ]
        ];
    }
}
