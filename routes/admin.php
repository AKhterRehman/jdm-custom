<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class)->except(['show']);
    Route::post('products/{product}/images', [ProductController::class, 'storeImage'])->name('products.images.store');
    Route::delete('products/{product}/images/{image}', [ProductController::class, 'destroyImage'])->name('products.images.destroy');
    Route::post('products/{product}/specifications', [ProductController::class, 'storeSpecification'])->name('products.specifications.store');
    Route::delete('products/{product}/specifications/{specification}', [ProductController::class, 'destroySpecification'])->name('products.specifications.destroy');
    Route::post('products/{product}/variations', [ProductController::class, 'storeVariation'])->name('products.variations.store');
    Route::delete('products/{product}/variations/{variation}', [ProductController::class, 'destroyVariation'])->name('products.variations.destroy');

    Route::resource('categories', CategoryController::class)->except(['show']);

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::get('orders/{order}/receipt', [OrderController::class, 'receipt'])->name('orders.receipt');
    Route::get('orders/{order}/pdf', [OrderController::class, 'pdf'])->name('orders.pdf');

    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::patch('customers/{customer}/toggle-admin', [CustomerController::class, 'toggleAdmin'])->name('customers.toggle-admin');

    Route::resource('coupons', CouponController::class)->except(['show']);
});
