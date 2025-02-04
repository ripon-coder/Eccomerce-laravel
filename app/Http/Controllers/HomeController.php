<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function test(){
        $campaign = Campaign::find(1);
        $campaign->products()->attach(2, ['max_quantity' => 5]);
        
    }
}
