<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('products', [ProductController::class, 'index'])->middleware('auth:sanctum');
Route::get('products/{id}', [ProductController::class, 'show'])->middleware('auth:sanctum');
Route::post('products', [ProductController::class, 'store'])->middleware('auth:sanctum');
Route::put('products/{id}', [ProductController::class, 'update'])->middleware('auth:sanctum');
Route::delete('products/{id}', [ProductController::class, 'destroy'])->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
