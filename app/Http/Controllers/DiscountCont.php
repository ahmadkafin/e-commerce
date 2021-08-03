<?php

namespace App\Http\Controllers;

use App\Repositories\DiscountRepo;
use App\Services\DiscountServices;
use Illuminate\Http\Request;

class DiscountCont extends Controller
{
    private $_repo;
    public function __construct()
    {
        $repo = new DiscountRepo();
        $this->_repo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = $this->_repo->getDiscounts();
        return response()->json([
            'status'            => 200,
            'discounts'         => $discounts
        ]);
    }

    /**
     * Store data.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $disc_service = new DiscountServices();
        $dsc = $disc_service->createDiscount($request);
        return $dsc;
    }


    /**
     * Store data.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Discount";
        $home = "Discounts";
        $routes = "dashboard.discount";
        $disc = $this->_repo->findDiscount($id);
        return view('content.admin.discount-update', compact(['title', 'routes', 'home', 'disc']));
    }

    /**
     * Slugs
     */
    public function slugs(Request $request)
    {
        $slug = $this->_repo->slugs($request);
        return response()->json([
            'slugs' => $slug
        ]);
    }

    /**
     * products
     */
    public function searchProduct(Request $request)
    {
        $disc_service = new DiscountServices();
        return $disc_service->searchProducts($request);
    }
}
