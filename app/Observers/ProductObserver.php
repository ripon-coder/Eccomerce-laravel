<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "updateding" event.
     */

    public function updating(Product $product): void
    {
        Log::info("updating work");
    }

    /**
     * Handle the Product "updated" event.
     */

    public function updated(Product $product): void
    {
        dd("Observer triggered!"); // Check if this appears
        Log::info("Product updated: " . $product->id);

    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
