<?php

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;


Route::get('/', [HomeController::class, 'index']);

//Product Controller
Route::get('/product/{slug}', [ProductController::class, 'SingleProduct'])->name('single-product');
Route::get('/get-remaining-quantity', [ProductController::class, 'getRemainingQuantity'])->name("get-ramaining-quantity");
//Cart Controller
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'Cart'])->name('cart');
Route::delete('/cart/remove/{id}', [CartController::class, 'CartRemove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/update-shipping', [CartController::class, 'updateShipping'])->name('cart.updateShipping');
//Checkout Controller
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');

Route::get('/test-observer', function () {
    // Create a product
    $product = Product::create(['name' => 'Test Product', 'category_id' => 3, 'brand_id' => 1]);
    Log::info('Product created manually:', ['id' => $product->id]);

    // Update the product
    $product->update(['name' => 'updated Product', 'category_id' => 3, 'brand_id' => 1]);
    Log::info('Product updated manually:', ['id' => $product->id]);

    // Delete the product
    $product->delete();
    Log::info('Product deleted manually:', ['id' => $product->id]);

    return 'Observer test complete. Check Laravel logs.';
});
