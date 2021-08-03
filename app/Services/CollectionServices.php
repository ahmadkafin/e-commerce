<?php

namespace App\Services;

use Exception;
use App\Repositories\CollectionRepo;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CollectionServices extends CollectionRepo
{
    public function create(Request $request)
    {
        try {
            if ($request->hasfile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $date = Carbon::now($tz = 'Asia/Jakarta');
                $imagename = $this->base64url_encode($request->name) . '-' . $date->toDateString() . '.' . $extension;
                $image->move(public_path('/img/collections'), $imagename);
                $data = [
                    'name'      => $request->name,
                    'slugs'     => $request->slugs,
                    '_isActive' => 1,
                    'image'     => $imagename,
                ];
                $this->createCollection($data);
            }
            return response()->json([
                'status'    => 200,
                'msg'       => "OK"
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 500,
                'msg'       => $e->getMessage()
            ]);
        }
    }

    public function update($request, $id)
    {
        try {
            if ($request->hasfile('images')) {
                $image = $request->file('images');
                $extension = $image->getClientOriginalExtension();
                $date = Carbon::now($tz = 'Asia/Jakarta');
                $imagename = $this->base64url_encode($request->name) . '-' . $date->toDateString() . '.' . $extension;
                $image->move(public_path('/img/collections'), $imagename);
                $data = [
                    'name'      => $request->nameupdate,
                    'slugs'     => $request->slugsupdate,
                    'image'     => $imagename,
                ];
                $this->updateCollection($id, $data);
            } else {
                $data = [
                    'name'      => $request->nameupdate,
                    'slugs'     => $request->slugsupdate,
                ];
                $this->updateCollection($id, $data);
            }
            return response()->json([
                'status'    => 200,
                'msg'       => "OK"
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 500,
                'msg'       => $e->getMessage()
            ]);
        }
    }

    public function updatestat(string $id)
    {
        try {
            $id_int = (int)$id;
            $collection = $this->findCollection($id_int);
            $status = $collection->_isActive == 1 ? 0 : 1;
            $data = [
                '_isActive' => $status
            ];
            $this->updateCollection($id, $data);
            return response()->json([
                'status'    => 200,
                'msg'       => 'OK'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 500,
                'msg'       => $e->getMessage(),
            ]);
        }
    }

    private function base64url_encode($plainText)
    {
        return strtr(base64_encode($plainText), '+/=', '-_,');
    }
}
