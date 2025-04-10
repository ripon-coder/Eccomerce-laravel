<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function SingleProduct($slug)
    {
        $data['product'] = Product::where('slug', $slug)->where('is_published', true)->with(['variants.options.attributeOption.attribute'])->firstOrFail();
        $product = $data['product'];

        $data['sizes'] = $product->variants->flatMap(function ($variant) {
            return $variant->options->filter(function ($option) {
                return $option->attributeOption && $option->attributeOption->attribute->name === 'Size';
            })->map(function ($option) {
                return [
                    'id' => $option->attributeOption->id,
                    'value' => $option->attributeOption->value,
                ];
            });
        })->unique('id')->values();


        $data['noSizesAvailable'] = $data['sizes']->isEmpty();
        $firstVariant = $product->variants->first();
        $data['price'] = $firstVariant ? $firstVariant->price : null;

        return view("front.single-product", $data);
    }
}
