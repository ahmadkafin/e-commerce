<?php

namespace App\Repositories;

use App\Models\Discount;
use App\Services\ModelService;
use Cviebrock\EloquentSluggable\Services\SlugService;

class DiscountRepo
{
    private $_discount = Discount::class;
    private $_service;
    public function __construct()
    {
        $service = new ModelService();
        $this->_service = $service;
    }

    /**
     * Get all Discount
     */
    public function getDiscounts()
    {
        $select = ['*'];
        $relation = ['discount_products'];
        return $this->_service->get($this->_discount, $relation, $select);
    }

    /**
     * Create Discount
     * @param array $data
     */
    public function createDiscounts(array $data)
    {
        return $this->_service->create($this->_discount, $data);
    }

    /**
     * find discount
     * @param int $id
     */
    public function findDiscount(int $id)
    {
        $relation = ['discount_products'];
        return $this->_service->find($this->_discount, $relation, 'id', $id);
    }

    /**
     * Slugs
     */
    public function slugs($request)
    {
        $slug = SlugService::createSlug($this->_discount, 'slugs', $request->event_name);
        return $slug;
    }
}
