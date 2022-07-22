<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
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
    // products
     Route::post('/products', [ProductController::class, 'store']);
     Route::put('/products/{product}', [ProductController::class, 'update']);
     Route::delete('/products/{product}', [ProductController::class, 'destroy']);

     // categories
     Route::post('/categories', [CategoryController::class, 'store']);
     Route::get('/categories/{category}', [CategoryController::class, 'show']);
     Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
     Route::put('/categories/{category}', [CategoryController::class, 'update']);

     // reviews 
     Route::post('reviews/{product}', [ReviewController::class, 'store']);
     Route::delete('reviews/{review}', [ReviewController::class, 'destroy']);
     Route::put('reviews/{review}', [ReviewController::class, 'update']);


     // auth
     Route::get('/auth/logout', [AuthController::class, 'logout']);
});



// PUBLIC ROUTES

// product public routes
Route::get('/products/search/{query}', [ProductController::class, 'search']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// categories public routes
Route::get('/categories', [CategoryController::class, 'index']);


// reviews public routers
Route::get('reviews/{product}', [ReviewController::class, 'index']);


// auth public routes
Route::post('/auth/signup', [AuthController::class, 'signup']);

Route::post('/auth/signin', [AuthController::class, 'signin']);
