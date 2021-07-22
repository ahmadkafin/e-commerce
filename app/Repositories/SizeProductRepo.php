<?php
namespace App\Repositories;

use App\Models\UkuranProducts;
use App\Services\ModelService;

class SizeProductRepo {

    private string $size = UkuranProducts::class;
    private $_service;
    public function __construct()
    {
        $service = new ModelService();
        $this->_service = $service;
    }

    /**
     * @param array $data
     * @return void
     */
    public function createSize(array $data)
    {
        $this->_service->create($this->size, $data);
    }
}