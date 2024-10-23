<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseOrderController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [SupplierController::class, 'index']);
Route::resource('suppliers', SupplierController::class);
Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
Route::get('/item/create', [ItemController::class, 'create'])->name('Item.create');
Route::resource('item', ItemController::class);
Route::resource('orders', PurchaseOrderController::class);
Route::get('/suppliers/{supplier}/items', [PurchaseOrderController::class, 'getItemsBySupplier']);
