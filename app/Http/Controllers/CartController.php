<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $cart = Session::get('cart', []);

        // Retrieve data from request
        $productId = $request->product_id;
        $variantId = $request->variant_id;
        $quantity = $request->quantity;

        // Check if product already exists in cart
        if (isset($cart[$productId][$variantId])) {
            $cart[$productId][$variantId]['quantity'] += $quantity;
        } else {
            $cart[$productId][$variantId] = [
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity
            ];
        }

        // Store updated cart in session
        Session::put('cart', $cart);

        return $this->cartUpdate();
        // Return response (you can also return a JSON response for AJAX)
        //return response()->json(['message' => 'Item Added Successfully!']);
    }
    public function cartUpdate()
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
                        'image' => 'storage/' . $product->thumbnail,
                    ];
                }
            }
        }
        return view('front.inc.header-cart',compact('cartItems','total'));
    }
    public function cart()
    {
        return view("front.cart");
    }
}
