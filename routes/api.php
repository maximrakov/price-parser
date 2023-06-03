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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::get('/product', [\App\Http\Controllers\ProductController::class, 'getProductByLink']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [\App\Http\Controllers\AuthController::class, 'user']);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('/subscribeProduct', [\App\Http\Controllers\UserController::class, 'subscribeProduct']);
    Route::post('/unsubscribeProduct', [\App\Http\Controllers\UserController::class, 'unsubscribeProduct']);
    Route::get('/hasProduct', [\App\Http\Controllers\UserController::class, 'hasProduct']);
});
