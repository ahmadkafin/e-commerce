<?php

namespace App\Services;

use App\Repositories\ImageProdRepo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ImageProdServices extends ImageProdRepo
{

    public function imageCreate(Request $request)
    {
        try {
            $id = [];
            if ($request->hasfile('file')) {
                foreach ($request->file('file') as $image) {
                    $extension = $image->getClientOriginalExtension();
                    $date = Carbon::now($tz = 'Asia/Jakarta');
                    $imagename = $this->base64url_encode($request->name) . '-' . $date->toDateString() . '.' . $extension;
                    // $path = $image->storeAs('img/uploads', $name, 'public');
                    $image->move(public_path('/img/products/'), $imagename);
                    $s = $this->createImage($this->dataPayload($imagename));
                    array_push($id, $s->id);
                }
            }
            return $id;
        } catch (Exception $e) {
            return response()->json([
                'status'    => 500,
                'msg'       => $e->getMessage()
            ]);
        }
    }

    private function dataPayload($name)
    {
        return [
            'image_name'    => $name,
            'alt'           => $name,
        ];
    }

    public function imageUpdate($request)
    {
        try {
            $array = $request->img_id;
            for ($i = 0; $i < count($array); $i++) {
                $this->updateImage($array[$i], [
                    "uid_products" => $request->uid_products
                ]);
            }
            return response()->json([
                'status'    => 200,
                'msg'       => "sukses"
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 200,
                'msg'       => $e->getMessage()
            ]);
        }
    }

    private function base64url_encode($plainText)
    {
        return strtr(base64_encode($plainText), '+/=', '-_,');
    }
}
