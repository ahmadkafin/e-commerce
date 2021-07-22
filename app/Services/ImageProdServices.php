<?php

namespace App\Services;

use App\Repositories\ImageProdRepo;
use Exception;
use Illuminate\Http\Request;

class ImageProdServices extends ImageProdRepo
{

    public function imageCreate(Request $request)
    {
        try {
            $i = 0;
            $id = [];
            if ($request->hasfile('file')) {
                foreach ($request->file('file') as $image) {
                    $name = $image->getClientOriginalName();
                    // $path = $image->storeAs('img/uploads', $name, 'public');
                    $image->move(public_path('/img/products/'), $name);
                    $s = $this->createImage($this->dataPayload($name));
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
}
