<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class HeaderComposer
{
    public function compose(View $view)
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $productVariants) {
            foreach ($productVariants as $item) {
                // Get product and variant details from DB
                $product = \App\Models\Product::find($item['product_id']);
                $variant = \App\Models\ProductVariant::find($item['variant_id']);

                if ($product && $variant) {
                    $price = $variant->discount_price ?? $variant->price;
                    $subtotal = $price * $item['quantity'];
                    $total += $subtotal;

                    $cartItems[] = [
                        'product' => $product,
                        'variant' => $variant,
                        'quantity' => $item['quantity'],
                        'subtotal' => $subtotal,
                        'image' => 'storage/'.$product->thumbnail,
                    ];
                }
            }
        }

        $view->with('headerCartItems', $cartItems);
        $view->with('headerCartTotal', $total);
    }
}
