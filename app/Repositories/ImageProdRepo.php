<?php

namespace App\Repositories;

use App\Models\ImageProducts;
use App\Services\ModelService;

class ImageProdRepo
{

    private string $image = ImageProducts::class;
    protected $_service;
    public function __construct()
    {
        $service = new ModelService();
        $this->_service = $service;
    }

    /**
     * get images
     * 
     */
    public function getImage()
    {
        $relation = ['products'];
        $select = ['*'];
        $image = $this->_service->get($this->image, $relation, $select);
        return $image;
    }

    /**
     * create Image
     * @param array $data
     * 
     */
    public function createImage(array $data)
    {
        $image = $this->_service->create($this->image, $data);
        return $image;
    }

    /**
     * update Image
     * @param int $id
     * @param array $data
     * @return void
     */
    public function updateImage(int $id, array $data)
    {
        $image = $this->_service->update($this->image, 'id', $id, $data);
        return $image;
    }

    /**
     * delete image
     * @param int $id
     * @return void
     */
    public function deleteImage(int $id)
    {
        $image = $this->_service->delete($this->image, 'id', $id);
        return $image;
    }

    /**
     * show image
     * @param array $idImage
     * 
     */
    public function showImage(array $idImage)
    {
        $image = ImageProducts::whereIn('id', $idImage)->get();
        return $image;
    }

    public function groupImage()
    {
        return ImageProducts::groupBy('uid_products')->get();
    }
}
