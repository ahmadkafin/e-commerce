<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory, Sluggable;
    protected $table = 'discount';
    protected $fillable = [
        'event_name',
        'slugs',
        'images',
        'start_date',
        'end_date',
        '_isActive'
    ];

    public function discount_products()
    {
        return $this->hasMany(DiscountProducts::class, 'uid_disc');
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
                'source' => 'event_name'
            ]
        ];
    }
}
