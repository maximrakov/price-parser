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
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('/user/{userId}/product/{productId}', [\App\Http\Controllers\UserController::class, 'addProduct']);
    Route::delete('/user/{userId}/product/{productId}', [\App\Http\Controllers\UserController::class, 'deleteProduct']);
    Route::get('/user/{userId}/product/{productId}', [\App\Http\Controllers\UserController::class, 'getProduct']);
    Route::post('/telegramBinding', [\App\Http\Controllers\TelegramController::class, 'telegramBinding']);
});
