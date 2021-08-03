<?php

namespace App\Services;

use App\Models\ProductCollection;
use App\Repositories\ProductRepo;
use App\Repositories\SizeProductRepo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductServices extends ProductRepo
{

    /**
     * Insert to product
     */
    public function dataCreate(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = $this->rules($request->all(), $this->message());
            $size = new SizeProductRepo();
            $image = new ImageProdServices();

            if ($rules->fails()) {
                $err = $rules->errors()->all();
                return response()->json([
                    'status'    => 500,
                    'error'     => $err
                ]);
            }

            // init for total on product table
            $sizes = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
            $total = 0;
            for ($i = 0; $i < count($sizes); $i++) {
                $total += $request->size[$i];
            }

            // insert into product table
            $this->createProduct($this->dataPayload($request, $total));

            // insert into size table
            for ($i = 0; $i < count($sizes); $i++) {
                $data  = [
                    'uid_skuP' => $request->sku,
                    'size'     => $sizes[$i],
                    'jumlah'   => $request->size[$i]
                ];
                $size->createSize($data);
            }

            //insert into image table
            $imageID    = $request->imageID;
            for ($i = 0; $i < count($imageID); $i++) {
                $data       = ['uid_products' => $request->sku];
                $image->updateImage($imageID[$i], $data);
            }

            // insert into collection
            ProductCollection::create([
                'fid_prod'          => $request->sku,
                'fid_col'           => $request->collection
            ]);
            DB::commit();
            return response()->json([
                'status'    => 200,
                'message'   => 'Ok',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'    => 500,
                'msg'       => $e->getMessage()
            ]);
        }
    }

    /**
     * update ptoduct
     */
    public function dataUpdate(Request $request, $sku)
    {
        DB::beginTransaction();
        try {
            $rules = $this->rules($request->all(), $this->message());
            $size = new SizeProductRepo();
            $image = new ImageProdServices();
            $total = 0;

            if ($rules->fails()) {
                $err = $rules->errors()->all();
                return response()->json([
                    'status'    => 500,
                    'error'     => $err
                ]);
            }

            // init total on product table
            $sizes = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
            for ($i = 0; $i < count($sizes); $i++) {
                $total += $request->size[$i];
            }

            // update to product table
            $this->updateProduct($this->dataPayload($request, $total), $sku);

            // update to size table
            for ($i = 0; $i < count($sizes); $i++) {
                $data  = [
                    'uid_skuP' => $request->sku,
                    'size'     => $sizes[$i],
                    'jumlah'   => $request->size[$i]
                ];
                $size->createSize($data);
                $total += $size[$i];
            }

            // Image update
            $imageID    = $request->imageID;
            for ($i = 0; $i < count($imageID); $i++) {
                $data       = ['uid_products' => $request->sku];
                $image->updateImage($imageID[$i], $data);
            }

            // insert into collection
            ProductCollection::create([
                'fid_prod'          => $request->sku,
                'fid_collection'    => $request->collection
            ]);

            DB::commit();
            return response()->json([
                'status'    => 200,
                'message'   => 'Ok'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'    => 500,
                'msg'       => $e->getMessage()
            ]);
        }
    }


    private function rules($request, array $msg)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $rules = Validator::make(
            $request,
            [
                'sku'           => 'required|string|unique:products',
                'slugs'         => $method == 'PUT' ? 'bail|required' : 'bail|required|unique:products',
                'nama'          => 'bail|required',
                'harga'         => 'bail|required|numeric',
                'deskripsi'     => 'bail|required',
            ],
            $msg
        );
        return $rules;
    }

    private function dataPayload($request, $size)
    {
        return [
            'sku'           => $request->sku,
            'slugs'         => $request->slugs,
            'nama'          => $request->nama,
            'warna'         => $request->warna,
            'total'         => $size,
            'harga'         => $request->harga,
            'deskripsi'     => $request->deskripsi,
        ];
    }


    private function message()
    {
        return [
            'required'      => ':attribute tidak boleh kosong',
            'slugs.unique'  => 'maaf slugs sudah ada, coba slugs yang lain',
            'numeric'       => ':attribute hanya boleh diisi oleh angka'
        ];
    }
}
