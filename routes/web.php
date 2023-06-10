<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/goods', [App\Http\Controllers\GoodsController::class, 'index'])->name('goods');

Route::post('/goods/add', [App\Http\Controllers\GoodsController::class, 'add'])->name('add_goods');
Route::post('/goods/search', [App\Http\Controllers\GoodsController::class, 'search'])->name('search_goods');
Route::post('/goods/in_out/{id}', [App\Http\Controllers\GoodsController::class, 'in_out'])->name('in_out_goods');
Route::get('/gudang_barang', [App\Http\Controllers\HomeController::class, 'index'])->name('gudang_barang');
Route::get('/report', [App\Http\Controllers\GoodsController::class, 'report'])->name('report');
Route::get('/report/export', [App\Http\Controllers\GoodsController::class, 'export'])->name('report_export');
