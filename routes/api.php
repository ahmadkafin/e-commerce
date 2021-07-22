<?php

use App\Http\Controllers\ProductsCont;
use App\Http\Controllers\ImagesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::resource('products', ProductsCont::class);


Route::get('products', [ProductsCont::class, 'index'])->name('products.index');
Route::get('products/{product}', [ProductsCont::class, 'show'])->name('products.show');
Route::post('products', [ProductsCont::class, 'store'])->name('products.store'); //middleware _isAdmin
Route::put('products/{product}', [ProductsCont::class, 'update'])->name('products.update'); //middleware _isAdmin
Route::delete('products/{product}', [ProductsCont::class, 'destroy'])->name('products.destroy'); //middleware _isAdmin
Route::post('cksku', [ProductsCont::class, 'checks'])->name('products.cks'); //middleware _isAdmin


Route::post('images', [ImagesController::class, 'store'])->name('images.store');
Route::get('imagesData', [ImagesController::class, 'show'])->name('images.get');
