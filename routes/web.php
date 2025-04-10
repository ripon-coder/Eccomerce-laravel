<?php

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;


Route::get('/', [HomeController::class,'index']);
Route::get('/product/{slug}', [ProductController::class,'SingleProduct'])->name('single-product');
Route::get('/cart', [CartController::class,'cart'])->name('cart');
Route::get('/checkout', [CheckoutController::class,'checkout'])->name('checkout');

Route::get('/test-observer', function () {
    // Create a product
    $product = Product::create(['name' => 'Test Product','category_id'=>3,'brand_id'=>1]);
    Log::info('Product created manually:', ['id' => $product->id]);

    // Update the product
    $product->update(['name' => 'updated Product','category_id'=>3,'brand_id'=>1]);
    Log::info('Product updated manually:', ['id' => $product->id]);

    // Delete the product
    $product->delete();
    Log::info('Product deleted manually:', ['id' => $product->id]);

    return 'Observer test complete. Check Laravel logs.';
});
