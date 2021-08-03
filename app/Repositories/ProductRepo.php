<?php

namespace App\Repositories;

use App\Models\Products;
use App\Services\ModelService;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ProductRepo
{
    /**
     * this class for take data from products table
     */

    private string $products = Products::class;
    private $_service;
    public function __construct()
    {
        $service = new ModelService();
        $this->_service = $service;
    }

    public function getProduct()
    {
        $relation = ['ukurans', 'images'];
        $select = ['*'];
        $products = $this->_service->get($this->products, $relation, $select);
        return $products;
    }

    public function findProduct(string $cond1, string $cond2)
    {
        $relation = ['ukurans', 'images'];
        $product = $this->_service->find($this->products, $relation, $cond1, $cond2);
        return $product;
    }

    /**
     * @return void
     */
    public function createProduct(array $data)
    {
        $create = $this->_service->create($this->products, $data);
        return $create;
    }

    /**
     * @param array $data
     * @param string $sku
     * @return void
     */
    public function updateProduct(array $data, string $sku)
    {
        $update = $this->_service->update($this->products, 'sku', $sku, $data);
        return $update;
    }

    /**
     * @param $sku
     * @return void
     */
    public function deleteProduct(string $sku)
    {
        $delete = $this->_service->delete($this->products, 'sku', $sku);
        return $delete;
    }

    public function ck($sku)
    {
        return Products::where('sku', $sku)->first();
    }

    public function slugs($request)
    {
        $slug = SlugService::createSlug($this->products, 'slugs', $request->nama);
        return $slug;
    }
}
