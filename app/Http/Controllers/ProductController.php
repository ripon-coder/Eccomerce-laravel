<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductVariant;

class ProductController extends Controller
{
    public function SingleProduct($slug)
    {
        $data['product'] = Product::where('slug', $slug)->where('is_published', true)->with(['variants.options.attributeOption.attribute'])->firstOrFail();
        $product = $data['product'];

        $data['sizes'] = $product->variants->flatMap(function ($variant) {
            return $variant->options->filter(function ($option) {
                return $option->attributeOption && $option->attributeOption->attribute->name === 'Size';
            })->map(function ($option) use ($variant) {
                return [
                    'id' => $option->attributeOption->id,
                    'value' => $option->attributeOption->value,
                    'variant_id' => $variant->id
                ];
            });
        })->unique('id')->values();


        $data['noSizesAvailable'] = $data['sizes']->isEmpty();
        $firstVariant = $product->variants->first();
        $data['price'] = $firstVariant ? $firstVariant->price : null;
        $data['first_variant_remaining_quantity'] =  $this->getRemainingQuantityResult($product->id,$firstVariant->id);

        return view("front.single-product", $data);
    }

    public function getRemainingQuantity(Request $request)
    {
        $productId = $request->product_id;
        $variantId = $request->variant_id;
        return $this->getRemainingQuantityResult($productId,$variantId);
    }

    public function getRemainingQuantityResult($productId,$variantId){
        $variant = ProductVariant::where('product_id', $productId)
            ->where('id', $variantId)
            ->first();

        if ($variant) {
             $orderedQuantity = Order_item::whereHas('order', function ($query) {
                $query->where('order_status', '!=', 'cancelled');
            })
                ->where('product_id', $productId)
                ->where('variant_id', $variantId)
                ->sum('quantity');
            $remainingQuantity = $variant->quantity - $orderedQuantity;

            return $remainingQuantity;
        }
        return 0;
    }
}
