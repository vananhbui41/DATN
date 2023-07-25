<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Management\CategoryController;
use App\Http\Controllers\Management\ItemController;
use App\Http\Controllers\Management\TableController;

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

Route::get('/management', [CategoryController::class, 'index']);

Route::resource('management/categories', CategoryController::class);

Route::resource('management/items', ItemController::class);

Route::resource('management/tables', TableController::class);
