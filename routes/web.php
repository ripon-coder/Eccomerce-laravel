<?php

use App\Http\Controllers\HomeController;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class,'index']);

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
