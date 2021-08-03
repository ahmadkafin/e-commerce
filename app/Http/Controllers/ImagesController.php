<?php

namespace App\Http\Controllers;

use App\Repositories\ImageProdRepo;
use App\Services\ImageProdServices;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    private $_imageRepo;
    public function __construct()
    {
        $imageRepo = new ImageProdRepo;
        $this->_imageRepo = $imageRepo;
    }


    public function index()
    {
        $images = $this->_imageRepo->getImage();
        return response()->json([
            'status'    => 200,
            'data'      => $images
        ]);
    }

    public function store(Request $request)
    {
        $imServ = new ImageProdServices();
        $id = $imServ->imageCreate($request);
        return response()->json([
            'status'    => 200,
            'msg'       => 'sukses',
            'id'        => $id,
        ]);
    }

    public function show(Request $request)
    {
        $id = json_encode($request['idImage']);
        $id = json_decode($id);
        $images = $this->_imageRepo->showImage($id);
        return response()->json([
            'status'    => 200,
            'data'      => $images
        ]);
    }

    public function update(Request $request)
    {
        $srv = new ImageProdServices();
        $image = $srv->imageUpdate($request);
        return $image;
    }
}
