<?php

use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/catalog/{path?}', [CategoryController::class, 'show'])
    ->where('path', '.*')
    ->name('categories.show');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
