<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/all-products', [ProductController::class, 'all']);
    Route::post('/product/store', [ProductController::class, 'store']);
    Route::get('/product/search', [ProductController::class, 'search']);
    Route::get('/product/{id}', [ProductController::class, 'edit']);
    Route::post('/product/update/{id}', [ProductController::class, 'update']);
    Route::get('/product/delete/{id}', [ProductController::class, 'destroy']);

    Route::get('/transactions', [TransactionController::class, 'index']);
});
Route::get('/transaction/create', [TransactionController::class, 'store']);
