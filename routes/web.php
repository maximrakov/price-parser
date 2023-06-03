<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/product', [\App\Http\Controllers\IndexController::class, 'product'])->name('product');
Route::get('/register', [\App\Http\Controllers\IndexController::class, 'register'])->name('register');
Route::get('/login', [\App\Http\Controllers\IndexController::class, 'login'])->name('login');
Route::get('/test', function () {
    $parser = new \App\Parser\RegardCatalogParser();
    return $parser->crawlingPages();
});
