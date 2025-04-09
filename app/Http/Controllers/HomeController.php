<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view("front.home");
    }

    public function test(){
        $campaign = Campaign::find(1);
        $campaign->products()->attach(2, ['max_quantity' => 5]);
        
    }
}
