<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function SingleProduct(){
        return view("front.single-product");
    }
}
