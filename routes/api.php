<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\SaleApiController;
use App\Http\Controllers\Api\DashboardApiController;
 
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard/stats', [DashboardApiController::class, 'stats']);
    Route::get('/customers/search', [CustomerApiController::class, 'search']);
    Route::get('/products/search', [ProductApiController::class, 'search']);
    Route::get('/products/{id}/stock', [ProductApiController::class, 'stock']);
    Route::post('/sales/calculate', [SaleApiController::class, 'calculate']);
});