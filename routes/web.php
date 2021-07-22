<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsCont;
use App\Http\Controllers\ImagesController;


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
        $title = 'Product';
        $home = 'Product';
        $routes = 'dashboard.products';
        return view('content.admin.products', compact(['title', 'routes', 'home']));
    })->name('dashboard.products');

    Route::get('create', function () {
        $title = 'Add Product';
        $home = 'Product';
        $routes = 'dashboard.products';
        return view('content.admin.productsCreate', compact(['title', 'routes', 'home']));
    })->name('dashboard.products.create');

    Route::get('test', function () {
        $cart = session()->get('cart');
        return $cart;
    });

    Route::get('/{sku}/edit', function () {
        $title = 'Edit Product';
        $home = 'Product';
        $routes = 'dashboard.products';
        return view('content.admin.productsEdit', compact(['title', 'routes', 'home']));
    })->name('dashboard.products.edit');
});
