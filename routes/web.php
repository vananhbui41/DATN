<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Management\CategoryController;
use App\Http\Controllers\Management\ItemController;
use App\Http\Controllers\Management\TableController;
use App\Http\Controllers\Cashier\CashierController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Management\UserController;


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


Auth::routes(['register' => false, 'reset' => false]);



Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('home');
    });    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('cashier', [CashierController::class, 'index']);
    Route::get('cashier/getTable', [CashierController::class, 'getTables']);
    Route::get('cashier/getSaleDetailsByTable/{table_id}', [CashierController::class, 'getSaleDetailsByTable']);
    Route::get('cashier/getItemByCategory/{category_id}', [CashierController::class, 'getItemByCategory']);
    Route::post('cashier/orderFood', [CashierController::class, 'orderFood']);
    Route::post('cashier/confirmOrderStatus', [CashierController::class, 'confirmOrderStatus']);
    Route::post('cashier/deleteSaleDetail', [CashierController::class, 'deleteSaleDetail']);
    Route::post('cashier/increaseItemQty', [CashierController::class, 'increaseItemQty']);
    Route::post('cashier/decreaseItemQty', [CashierController::class, 'decreaseItemQty']);
    Route::post('cashier/savePayment', [CashierController::class, 'savePayment']);
    Route::get('cashier/showReceipt/{saleID}', [CashierController::class, 'showReceipt']);
});

Route::middleware(['auth', 'VerifyAdmin'])->group(function () {
    Route::get('/management', [CategoryController::class, 'index']);

    Route::resource('management/categories', CategoryController::class);

    Route::resource('management/items', ItemController::class);

    Route::resource('management/tables', TableController::class);


    Route::get('report', [ReportController::class, 'show']);
    Route::get('report/show', [ReportController::class, 'show']);

    Route::get('report/show/export', [ReportController::class, 'export']);

    Route::resource('management/users', UserController::class);

    Route::get('report/chart', [ReportController::class, 'chart']);
});