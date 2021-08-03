<?php

use App\Http\Controllers\CollectionCont;
use App\Http\Controllers\DiscountCont;
use App\Http\Controllers\ProductsCont;
use App\Http\Controllers\ImagesController;
use App\Models\Collection;
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


// products
Route::get('products', [ProductsCont::class, 'index'])->name('products.index');
Route::get('products/{product}', [ProductsCont::class, 'show'])->name('products.show');
Route::post('products', [ProductsCont::class, 'store'])->name('products.store'); //middleware _isAdmin
Route::put('products/{product}', [ProductsCont::class, 'update'])->name('products.update'); //middleware _isAdmin
Route::post('products/slugs', [ProductsCont::class, 'slugs'])->name('products.slug'); //middleware _isAdmin
Route::delete('products/{product}', [ProductsCont::class, 'destroy'])->name('products.destroy'); //middleware _isAdmin
Route::post('cksku', [ProductsCont::class, 'checks'])->name('products.cks'); //middleware _isAdmin
Route::post('import/excel', [ProductsCont::class, 'import'])->name('products.import'); // middleware _isAdmin

// collection
Route::get('collections', [CollectionCont::class, 'index'])->name('collections.index');
Route::get('collections/{id}', [CollectionCont::class, 'show'])->name('collections.show');
Route::post('ckcol', [CollectionCont::class, 'checks'])->name('collections.cks'); //middleware _isAdmin
Route::post('collections', [CollectionCont::class, 'store'])->name('collections.store');
Route::patch('collections/{id}', [CollectionCont::class, 'update'])->name('collections.patch');
Route::post('collection/{id}', [CollectionCont::class, 'edit'])->name('collections.update');
Route::delete('collections/{id}', [CollectionCont::class, 'destroy'])->name('collections.destroy');

// Discounts
Route::get('discounts', [DiscountCont::class, 'index'])->name('discounts.index');
Route::post('discounts', [DiscountCont::class, 'store'])->name('discounts.store'); //middleware _isAdmin
Route::post('discounts/slugs', [DiscountCont::class, 'slugs'])->name('discounts.slug'); //middleware _isAdmin
Route::post('discounts/products', [DiscountCont::class, 'searchProduct'])->name('discounts.product'); //middleware _isAdmin




// images
Route::get('images', [ImagesController::class, 'index'])->name('images.getAll');
Route::post('images', [ImagesController::class, 'store'])->name('images.store');
Route::patch("images", [ImagesController::class, 'update'])->name('images.update');
Route::get('imagesData', [ImagesController::class, 'show'])->name('images.get');
