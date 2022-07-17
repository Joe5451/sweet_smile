<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSlider;

class HomeSliderController extends Controller
{
    public function getItems(Request $request) {
        $home_slider = HomeSlider::where('display', 1)
        ->orderBy('sequence', 'asc')
        ->select(['id', 'slider_img', 'link'])->get();
        
        return response()->json([
            'home_slider' => $home_slider
        ]);
    }
}