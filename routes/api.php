<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


///Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/auth', [AuthController::class, 'index']);

Route::post('/products', [ProductController::class, 'store']);
Route::get('/products', [ProductController::class, 'showAll']);
Route::get('/products/{id}', [ProductController::class, 'showById']);
Route::get('/products/name/{product_name}', [ProductController::class, 'showByName']);
Route::get('/products/search/product_name={product_name}', [ProductController::class, 'showByName']);
Route::put('/products/{id}',[ProductController::class,'update']);
Route::delete('/products/{id}',[ProductController::class,'delete']);

Route::post('/login',[UserController::class,'login']);

Route::post('/login', [AuthController::class, 'login']); 

Route::middleware(['jwt-auth'])->group(function() {
    //route untuk menambahkan data produk
    Route::post('/product',[ProductController::class,'store']);

    //route untuk menampilkan data produk keseluruhan
    Route::get('/products', [ProductController::class, 'showAll']);

    //route untuk menampilkan data produk berdasarkan ID
    Route::get('/products/{id}', [ProductController::class, 'showById']);

    //route untuk menampilkan data produk berdasarkan nama
    Route::get('/products/search/product_name={product_name}', [ProductController::class, 'showByName']);

    //route untuk mengubah data produk berdasarkan ID produk
    Route::put('/products/{id}',[ProductController::class,'update']);

    //route untuk menghapus data produk berdasarkan ID produk
    Route::delete('/products/{id}',[ProductController::class,'delete']);
});
