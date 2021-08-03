<?php

namespace App\Repositories;

use App\Models\DiscountProducts;
use App\Services\ModelService;

class DiscountProductsRepo
{
    private $_dp = DiscountProducts::class;
    private $_service;
    public function __construct()
    {
        $service = new ModelService();
        $this->_service = $service;
    }

    /**
     * create discount products
     */
    public function createDiscountProd(array $data)
    {
        return $this->_service->create($this->_dp, $data);
    }
}
