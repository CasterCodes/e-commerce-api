<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function() {
     Route::post('/products', [ProductController::class, 'store']);
     Route::put('/products/{product}', [ProductController::class, 'update']);
     Route::delete('/products/{product}', [ProductController::class, 'destroy']);

     // auth
     Route::get('/auth/logout', [AuthController::class, 'logout']);
});



// Route::resource('products', ProductController::class);

Route::get('/products/search/{query}', [ProductController::class, 'search']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);


// auth

Route::post('/auth/signup', [AuthController::class, 'signup']);

Route::post('/auth/signin', [AuthController::class, 'signin']);
