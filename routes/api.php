<?php

use App\Http\Controllers\JualController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\DatastockController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('products', ProductController::class);
// Route::apiResource('stock/{kode}', StockController::class);
Route::apiResource('pembelian', PembelianController::class);
Route::apiResource('jual', JualController::class);
Route::apiResource('gudang', GudangController::class);
// Route::apiResource('datastock', DatastockController::class);

// Route::prefix('stock')->group(function(){
//     Route::get('/{kode?}', 'App\Http\Controllers\StockController@index')->where('kode', '[A-Za-z]+');
// });
Route::controller(StockController::class)->group(function () {
    Route::get('/stock/{kode?}/{kodegudang?}', 'index');
        // Route::get('/stock/{kode?}/{kodegudang?}', 'index');
});
Route::controller(DatastockController::class)->group(function () {
    Route::post('/datastock', 'store');
        // Route::get('/stock/{kode?}/{kodegudang?}', 'index');
});