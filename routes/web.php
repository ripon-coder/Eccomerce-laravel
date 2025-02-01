<?php

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    Log::info("Product updated:");
    return view('welcome');
});

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
