<?php

namespace App\Http\Controllers;

use App\Repositories\CollectionRepo;
use App\Services\CollectionServices;
use Illuminate\Http\Request;

class CollectionCont extends Controller
{
    private $_colRepo;
    public function __construct()
    {
        $colRepo = new CollectionRepo();
        $this->_colRepo = $colRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection = $this->_colRepo->getCollection();
        return response()->json([
            'status'        => 200,
            'msg'           => 'Ok',
            'collections'   => $collection
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
    public function store(Request $request)
    {
        $serv = new CollectionServices();
        $add = $serv->create($request);
        return $add;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $collection = $this->_colRepo->findCollection($id);
        return response()->json([
            'status'    => 200,
            'data'      => $collection
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $serv = new CollectionServices();
        $update = $serv->update($request, $id);
        return $update;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $serv = new CollectionServices();
        $update = $serv->updatestat($id);
        return $update;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->_colRepo->deleteCollection($id);
        return response()->json([
            'status'    => 200,
            "msg"       => 'OK',
        ]);
    }

    public function checks(Request $request)
    {
        $name = $request->name;
        $rp = $this->_colRepo->ck($name);
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
}
