<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);
    Route::post('products/{id}/categories', [ProductController::class, 'assignCategories']);
    Route::get('products/{id}/discount', [ProductController::class, 'showDiscount']);

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

