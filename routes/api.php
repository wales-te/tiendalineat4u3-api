<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('ping', fn () => ['ok' => true, 'ts' => now()]);

Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);

