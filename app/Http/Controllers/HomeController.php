<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $data['feature_products'] = Product::with('variants')->where("feature_product",true)->orderBy("id","desc")->get();
        return view("front.home",$data);
    }

    public function test(){
        $campaign = Campaign::find(1);
        $campaign->products()->attach(2, ['max_quantity' => 5]);
        
    }
}
