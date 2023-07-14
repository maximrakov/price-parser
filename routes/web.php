<?php

use App\Events\PriceUpdated;
use App\Http\Controllers\IndexController;
use App\Models\Product;
use App\Models\User;
use App\Parser\Dom\Strategy\Catalog\ParseCatalogPageManager;
use App\Parser\Dom\Strategy\Catalog\RegardParseCatalogPageStrategy;
use http\Client\Response;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Psr\Http\Message\ResponseInterface;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\IndexController::class, 'index'])->name('home');
Route::get('/register', [\App\Http\Controllers\IndexController::class, 'register'])->name('register');
Route::get('/login', [\App\Http\Controllers\IndexController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/subscriptions/{page}', [\App\Http\Controllers\IndexController::class, 'subscriptions'])->name('subscriptions');
    Route::get('/product', [\App\Http\Controllers\IndexController::class, 'product'])->name('product');
    Route::get('/notifications', [\App\Http\Controllers\IndexController::class, 'notifications'])->name('notifications');
});
Route::get('/test', function () {
});
