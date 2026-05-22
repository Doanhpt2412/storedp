<?php

use App\Http\Controllers\Admin\HomeDisplayController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\CheckoutController;
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

Route::get('/dat-hang', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/dat-hang/ma-khuyen-mai', [CheckoutController::class, 'applyPromotion'])->name('checkout.promotion.apply');
Route::delete('/dat-hang/ma-khuyen-mai', [CheckoutController::class, 'removePromotion'])->name('checkout.promotion.remove');
Route::post('/dat-hang', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/dat-hang/thanh-cong/{order_code}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/tra-cuu-don-hang', [CheckoutController::class, 'search'])->name('checkout.search');

Route::get('/tin-tuc', [\App\Http\Controllers\Frontend\BlogController::class, 'index'])->name('blog.index');
Route::get('/tin-tuc/{category_slug}', [\App\Http\Controllers\Frontend\BlogController::class, 'category'])->name('blog.category');
Route::get('/tin-tuc/{category_slug}/{post_slug}', [\App\Http\Controllers\Frontend\BlogController::class, 'show'])->name('blog.show');

Route::get('/catalog/{path?}', [CategoryController::class, 'show'])
    ->where('path', '.*')
    ->name('categories.show');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/password/reset', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/password/reset', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/password/reset/{token}', [AuthController::class, 'resetPassword'])->name('password.update');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::patch('users/{user}/toggle-lock', [App\Http\Controllers\Admin\UserController::class, 'toggleLock'])->name('users.toggle-lock');

        Route::resource('product-categories', App\Http\Controllers\Admin\ProductCategoryController::class);
        Route::resource('product-brands', App\Http\Controllers\Admin\ProductBrandController::class);
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class)->except(['show']);
        Route::resource('promotion-codes', App\Http\Controllers\Admin\PromotionCodeController::class)->except(['show']);

        Route::get('orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::delete('orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('orders.destroy');

        Route::resource('post-categories', App\Http\Controllers\Admin\PostCategoryController::class);
        Route::resource('posts', App\Http\Controllers\Admin\PostController::class);

        Route::get('homepage/display', [HomeDisplayController::class, 'edit'])->name('homepage.display.edit');
        Route::put('homepage/display', [HomeDisplayController::class, 'update'])->name('homepage.display.update');

        Route::get('settings/general', [SiteSettingController::class, 'edit'])->name('settings.general.edit');
        Route::put('settings/general', [SiteSettingController::class, 'update'])->name('settings.general.update');
    });
});
