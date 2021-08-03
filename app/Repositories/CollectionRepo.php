<?php

namespace App\Repositories;

use App\Models\Collection;
use App\Services\ModelService;

class CollectionRepo
{
    private string $col = Collection::class;
    protected $_service;
    public function __construct()
    {
        $service = new ModelService();
        $this->_service = $service;
    }

    /**
     * Get collection
     */
    public function getCollection()
    {
        $relation = ['pivots'];
        $select = ['*'];
        $collection = $this->_service->get($this->col, $relation, $select);
        return $collection;
    }

    /**
     * create collection
     * @param array $data
     */
    public function createCollection(array $data)
    {
        return $this->_service->create($this->col, $data);
    }

    /**
     * update collection
     * @param array $data
     */
    public function updateCollection(int $id, array $data)
    {
        return $this->_service->update($this->col, 'id', $id, $data);
    }

    /**
     * Delete collection
     * @param int $id
     */
    public function deleteCollection(int $id)
    {
        return $this->_service->delete($this->col, 'id', $id);
    }

    /**
     * get collection
     * @param int $id
     */
    public function findCollection(int $id)
    {
        $relation = [];
        return $this->_service->find($this->col, $relation, 'id', $id);
    }

    public function ck($name)
    {
        return $this->col::where('name', $name)->first();
    }
}
