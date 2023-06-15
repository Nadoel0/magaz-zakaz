<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderStoreController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PersonStoreController;
use App\Http\Controllers\ProductStoreController;
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


Route::get('/main', [MainController::class, '__invoke'])->name('main');
Route::get('/history', [HistoryController::class, '__invoke'])->name('history');
Route::get('/person', [PersonController::class, '__invoke'])->name('person');
Route::post('/person', [PersonStoreController::class, '__invoke'])->name('person.store');
Route::post('/order', [OrderStoreController::class, '__invoke'])->name('order.store');
Route::get('/product', [ProductStoreController::class, '__invoke'])->name('product.store');
