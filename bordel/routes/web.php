<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Orders\OrderController;
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
    Route::get('/{order_id}', 'show')->name('order.show');
    Route::post('/', 'store')->name('order.store');
    Route::get('/{order_id}/users', 'user')->name('order.users');
    Route::get('/{order_id}/basket', 'basket')->name('order.basket');
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
