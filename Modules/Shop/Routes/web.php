<?php

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

use Illuminate\Support\Facades\Route;
use Modules\Shop\Http\Controllers\CartController;
use Modules\Shop\Http\Controllers\ProductController;
use Modules\Shop\Http\Controllers\OrderController;
use Modules\Shop\Http\Controllers\PaymentController;

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/category/{categorySlug}', [ProductController::class, 'category'])->name('products.category');
Route::get('/tag/{tagSlug}', [ProductController::class, 'tag'])->name('products.tag');

Route::post('/payments/midtrans', [PaymentController::class, 'midtrans'])->name('payments.midtrans');

Route::middleware(['auth'])->group(function() {
    Route::get('orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('orders/checkout', [OrderController::class, 'store'])->name('orders.store');
    Route::post('orders/shipping-fee', [OrderController::class, 'shippingFee'])->name('orders.shipping_fee');
    Route::post('orders/choose-package', [OrderController::class, 'choosePackage'])->name('orders.choose_package');

    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
    Route::get('/carts/{id}/remove', [CartController::class, 'destroy'])->name('carts.destroy');
    Route::post('/carts', [CartController::class, 'store'])->name('carts.store');
    Route::put('/carts', [CartController::class, 'update'])->name('carts.update');
});

Route::get('/{categorySlug}/{productSlug}', [ProductController::class, 'show'])->name('products.show');