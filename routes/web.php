<?php

use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/tim-kiem', SearchController::class)->name('search');
Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
Route::post('/gio-hang', [CartController::class, 'store'])->name('cart.store');
Route::patch('/gio-hang/{lineId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/gio-hang/{lineId}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/catalog/{path?}', [CategoryController::class, 'show'])
    ->where('path', '.*')
    ->name('categories.show');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Authentication Routes
Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard (Protected by auth middleware)
    Route::middleware(['auth'])->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Quản lý Tài khoản (CRUD + Khóa)
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::patch('users/{user}/toggle-lock', [App\Http\Controllers\Admin\UserController::class, 'toggleLock'])->name('users.toggle-lock');

        // Quản lý Danh mục sản phẩm (CRUD)
        Route::resource('product-categories', App\Http\Controllers\Admin\ProductCategoryController::class);

        // Quản lý Hãng sản xuất (CRUD)
        Route::resource('product-brands', App\Http\Controllers\Admin\ProductBrandController::class);
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class)->except(['show']);
    });
});
