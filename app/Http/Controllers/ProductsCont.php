<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use App\Repositories\ProductRepo;
use App\Services\ProductServices;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Maatwebsite\Excel\Facades\Excel;

class ProductsCont extends Controller
{

    private $_productRepo;
    public function __construct()
    {
        $productRepo = new ProductRepo;
        $this->_productRepo = $productRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->_productRepo->getProduct();
        return response()->json([
            'status'   => 200,
            'msg'      => 'Ok',
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProductServices $productService)
    {

        $p = $productService->dataCreate($request);
        return $p;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->_productRepo->findProduct('sku', $id);
        return response()->json([
            'status'   => 200,
            'msg'      => 'Ok',
            'produk'    => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductServices $productService, $sku)
    {
        $p = $productService->dataUpdate($request, $sku);
        return $p;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = $this->_productRepo->findProduct('sku', $id);
            $this->_productRepo->deleteProduct($id);
            return response()->json([
                'status'    => 200,
                'msg'       => $data->nama . ' berhasil di hapus'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'    => 404,
                'msg'       => 'Data tidak ditemukan, apakah nomor sku benar?'
            ]);
        }
    }

    public function checks(Request $request)
    {
        $sku = $request->sku;
        $rp = $this->_productRepo->ck($sku);
        if ($rp) {
            return response()->json([
                'msg'   => 'duplicate',
            ]);
        } else {
            return response()->json([
                'msg'   => 'aman',
            ]);
        }
    }

    public function slugs(Request $request)
    {
        $slug = $this->_productRepo->slugs($request);
        return response()->json([
            'slug' => $slug
        ]);
    }

    public function import(Request $request)
    {
        $excel = Excel::import(new ProductsImport, $request->file('excel'));
        return response()->json([
            'status'    => 200,
            'msg'       => "OK"
        ]);
    }
}
