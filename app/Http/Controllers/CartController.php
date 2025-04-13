<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttributeOption;
use App\Models\ShippingCharge;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $cart = Session::get('cart', []);

        // Retrieve data from request
        $productId = $request->product_id;
        $variantId = $request->variant_id;
        $sizeId    = $request->size_id;
        $quantity = $request->quantity;

        // Check if product already exists in cart
        if (isset($cart[$productId][$variantId])) {
            $cart[$productId][$variantId]['quantity'] += $quantity;
        } else {
            $cart[$productId][$variantId] = [
                'product_id' => $productId,
                'variant_id' => $variantId,
                'size_id' => $sizeId,
                'quantity' => $quantity
            ];
        }

        // Store updated cart in session
        Session::put('cart', $cart);

        return $this->cartUpdate();
        // Return response (you can also return a JSON response for AJAX)
        //return response()->json(['message' => 'Item Added Successfully!']);
    }

    public function Cart()
    {
        // Get the cart data from session (assuming it's nested like cart[productId][variantId] = item)
        $cart = session()->get('cart', []); // Nested cart
        $shipping_id = session('shipping_id', null);

        $items = [];
        $total = 0;

        // Iterate through each product in the cart
        foreach ($cart as $productId => $variants) {
            foreach ($variants as $variantId => $item) {
                if (!isset($item['product_id'], $item['variant_id'], $item['quantity'], $item['size_id'])) {
                    continue; // Skip invalid entries
                }

                // Retrieve the size, product, and variant using IDs
                $size = AttributeOption::find($item['size_id']);
                $product = \App\Models\Product::find($item['product_id']);
                $variant = \App\Models\ProductVariant::find($item['variant_id']);

                if ($product && $variant) {
                    // Calculate the price and subtotal
                    $price = $variant->discount_price ?? $variant->price;
                    $subtotal = $price * $item['quantity'];

                    // Add the item to the list
                    $items[] = [
                        'product' => $product,
                        'variant' => $variant,
                        'image' => $product->thumbnail,
                        'size'  => $size ? $size->value : 'N/A', // Add size name if available
                        'quantity' => $item['quantity'],
                        'subtotal' => $subtotal,
                    ];

                    // Add subtotal to total
                    $total += $subtotal;
                }
            }
        }
        $shipping_charge = ShippingCharge::where("is_published", true)->get();
        // Return the view with cart items and total
        return view('front.cart', [
            'cartItems' => $items,
            'shipping_charge' => $shipping_charge,
            'shipping_id' => $shipping_id,
            'total' => $total
        ]);
    }


    public function CartRemove($variantId)
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $productId => $variants) {
            if (isset($variants[$variantId])) {
                unset($cart[$productId][$variantId]);

                // If no more variants under this product, remove the product key
                if (empty($cart[$productId])) {
                    unset($cart[$productId]);
                }

                // Save the updated cart back to session
                session()->put('cart', $cart);

                return redirect()->back()->with('success', 'Item removed from cart.');
            }
        }

        return redirect()->back()->with('error', 'Item not found in cart.');
    }

    public function updateCart(Request $request)
    {
        $cartData = $request->input('cart'); // e.g., ['6' => ['quantity' => '1'], ...]

        $cart = session()->get('cart', []);

        foreach ($cartData as $variantId => $data) {
            foreach ($cart as $productId => &$variants) {
                if (isset($variants[$variantId])) {
                    $quantity = max(1, (int) $data['quantity']); // ensure at least 1
                    $variants[$variantId]['quantity'] = $quantity;
                }
            }
        }

        session()->put('cart', $cart);
        return back();
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
        return view('front.inc.header-cart', compact('cartItems', 'total'));
    }

    // Method to update the shipping ID and recalculate the total
    public function updateShipping(Request $request)
    {
        // Get the selected shipping ID from the request
        $shippingId = $request->input('shipping_id');

        // Find the selected shipping charge from the database (called once outside the loop)
        $shippingCharge = ShippingCharge::findOrFail($shippingId);

        // Store the shipping ID in session
        $request->session()->put('shipping_id', $shippingId);

        // Retrieve the cart items from session
        $cart = Session::get('cart', []);
        $total = 0;

        // Iterate through each product and variant in the cart
        foreach ($cart as $productId => $variants) {
            foreach ($variants as $variantId => $item) {
                // Ensure the necessary data exists to avoid errors
                if (!isset($item['product_id'], $item['variant_id'], $item['quantity'])) {
                    continue; // Skip invalid entries
                }

                // Retrieve product and variant in one go (Eloquent relationship would be better)
                $product = \App\Models\Product::find($item['product_id']);
                $variant = \App\Models\ProductVariant::find($item['variant_id']);

                // Skip if product or variant not found
                if (!$product || !$variant) {
                    continue;
                }

                // Calculate price and subtotal
                $price = $variant->discount_price ?? $variant->price;
                $subtotal = $price * $item['quantity'];

                // Add to total
                $total += $subtotal;
            }
        }

        // Return the updated shipping cost and total price
        return response()->json([
            'shipping_cost' => $shippingCharge->charge,
            'total_price' => $total + $shippingCharge->charge // Adding the shipping cost to the total
        ]);
    }
}
