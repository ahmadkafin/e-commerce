<?php

namespace App\Services;

use App\Models\Products;
use App\Repositories\DiscountProductsRepo;
use App\Repositories\DiscountRepo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DiscountServices extends DiscountRepo
{
    public function createDiscount(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = $this->rules($request->all(), $this->message());
            $dp = new DiscountProductsRepo();
            if ($rules->fails()) {
                $err = $rules->errors();
                return response()->json([
                    'status'    => 500,
                    'error'     => $err
                ]);
            }
            if ($request->hasfile('images')) {
                $image = $request->file('images');
                $extension = $image->getClientOriginalExtension();
                $date = Carbon::now($tz = 'Asia/Jakarta');
                $imagename = $this->base64url_encode($request->event_name) . '-' . $date->toDateString() . '.' . $extension;
                $image->move(public_path('/img/discounts/'), $imagename);

                $discountID = $this->createDiscounts($this->dataPayload($request, $imagename));

                $p = $request->products;
                $d = $request->diskon;
                for ($index = 0; $index < count($p); $index++) {
                    $data = [
                        "uid_products"          => $p[$index],
                        "disc_percent"          => $d[$index],
                        "uid_disc"              => $discountID->id
                    ];
                    $dp->createDiscountProd($data);
                }
                DB::commit();
            }
            return response()->json([
                'status'    => 200,
                'msg'       => "ok"
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
                'event_name'    => 'required',
                'slugs'         => $method == 'PUT' ? 'bail|required' : 'bail|required|unique:products',
                'images'        => 'required|file|image|mimes:jpeg,png,jpg',
                'start_date'    => 'required',
                'end_date'      => 'required',
                "products"      => 'required',
            ],
            $msg
        );
        return $rules;
    }

    private function dataPayload($request, $imagename)
    {
        return [
            'event_name'    => $request->event_name,
            'slugs'         => $request->slugs,
            'images'        => $imagename,
            'start_date'    => date("Y-m-d", strtotime($request->start_date)),
            'end_date'      => date("Y-m-d", strtotime($request->end_date))
        ];
    }

    private function message()
    {
        return [
            'required'              => ':attribute tidak boleh kosong',
            'slugs.unique'          => 'maaf slugs sudah ada, coba slugs yang lain',
            'products.required'     => 'setidaknya kamu harus pilih salah satu produk di bawah',

        ];
    }

    private function base64url_encode($plainText)
    {
        return strtr(base64_encode($plainText), '+/=', '-_,');
    }


    public function searchProducts(Request $request)
    {
        $sku = $request->search;
        $nama = $request->search;
        $output = "";
        $products = Products::select(['id', 'sku', 'nama', 'harga'])->where('sku', 'like', "%" . $sku . "%")->orWhere('nama', 'like', "%" . $nama . "%")->limit(5)->get();
        foreach ($products as $product) {
            $output .= "
                <li class='list-group-item' onclick='addtotbl(this)' data-id='" . $product->id . "' data-nama='" . $product->nama . "' data-sku='" . $product->sku . "' data-harga='" . $product->harga . "' >
                    <a href='javascript:void(0)' class='input'> " . $product->nama . "</a>
                </li>
            ";
        }
        return $output;
    }
}
