<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Orders\BasketController;
use App\Http\Controllers\Orders\DebtController;
use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Orders\UserController;
use App\Http\Controllers\Shops\ShopController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::prefix('/order')->middleware('auth')->controller(OrderController::class)->group(function () {
    Route::get('/', 'index')->name('order.index');
    Route::get('/create', 'create')->name('order.create');
    Route::post('/', 'store')->name('order.store');
    Route::get('/{order_id}', 'show')->name('order.show');
    Route::put('/{order_id}', 'update')->name('order.update');
});

Route::prefix('debt')->middleware('auth')->controller(DebtController::class)->group(function () {
    Route::get('/{order_id}/debt', 'show')->name('order.debt');
    Route::put('{order_id}/debt', 'completedOrder')->name('order.complete');
});

Route::prefix('/user')->middleware('auth')->controller(UserController::class)->group(function () {
    Route::post('/{order_id}/{user_id}', 'store')->name('user.store');
    Route::delete('/{order_id}', 'destroy')->name('user.destroy');
});

Route::prefix('/basket')->middleware('auth')->controller(BasketController::class)->group(function () {
    Route::post('/{order_id}/store', 'store')->name('basket.store');
    Route::put('{order_id}/update', 'update')->name('basket.update');
    Route::delete('/{order_id}/destroy', 'destroy')->name('basket.destroy');
});

Route::prefix('/shop')->middleware('auth')->controller(ShopController::class)->group(function (){
    Route::get('/')->name('shop.index');
    Route::get('/{shop_id}')->name('shop.show');
    Route::get('/create')->name('shop.create');
    Route::post('/')->name('shop.store');
    Route::get('/{shop_id}/edit')->name('shop.edit');
    Route::patch('/{shop_id}')->name('shop.update');
    Route::delete('/{shop_id}')->name('shop.destroy');
});
