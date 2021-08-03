<?php

use App\Http\Controllers\DiscountCont;
use Illuminate\Support\Facades\Route;
use App\Models\Products;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', function () {
        $title = 'Dashboard';
        $routes = 'dashboard.index';
        $home = 'Dashboard';
        return view('content.admin.dashboard', compact(['title', 'routes', 'home']));
    })->name('dashboard.index');
});

Route::prefix('produk')->group(function () {
    // products
    Route::get('/', function () {
        $title = 'Products';
        $home = 'Products';
        $routes = 'dashboard.products';
        return view('content.admin.products', compact(['title', 'routes', 'home']));
    })->name('dashboard.products');

    Route::get('create', function () {
        $title = 'Add Product';
        $home = 'Products';
        $routes = 'dashboard.products';
        return view('content.admin.productsCreate', compact(['title', 'routes', 'home']));
    })->name('dashboard.products.create');

    Route::get('test', function () {
        $cart = session()->get('cart');
        return $cart;
    });

    Route::get('/{sku}/edit', function () {
        $title = 'Edit Product';
        $home = 'Products';
        $routes = 'dashboard.products';
        return view('content.admin.productsEdit', compact(['title', 'routes', 'home']));
    })->name('dashboard.products.edit');

    Route::get('images', function () {
        $title = "Image Products";
        $home = "Products";
        $routes = "dashboard.products";
        $datas  = Products::select('id', 'nama', 'sku')->with(['images'])->get();
        return view('content.admin.images', compact(['title', 'routes', 'home', 'datas']));
    })->name('dashboard.images');

    Route::get('collections', function () {
        $title = "Collections";
        $home = "Products";
        $routes = "dashboard.products";
        return view('content.admin.collections', compact(['title', 'routes', 'home']));
    })->name('dashboard.collections');

    Route::get('discounts', function () {
        $title = "Discounts";
        $home = "Products";
        $routes = "dashboard.products";
        return view('content.admin.discount', compact(['title', 'routes', 'home']));
    })->name('dashboard.discount');

    Route::get('discounts/create', function () {
        $title = "Create Discount";
        $home = "Discounts";
        $routes = "dashboard.discount";
        $datas  = Products::select('id', 'nama', 'sku', 'harga')->with(['images'])->orderBy('created_at', 'desc')->get();
        return view('content.admin.discount-create', compact(['title', 'routes', 'home', 'datas']));
    })->name('dashboard.discount.create');

    Route::get('discounts/edit/{sku}', [DiscountCont::class, 'edit'])->name('dashboard.discount.edit');
});
