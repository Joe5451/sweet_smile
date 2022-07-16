<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages;
use App\Models\HeadImg;
use App\Models\HomeSlider;

class WebController extends Controller
{
    public function getData(Request $request) {
        $head_img = HeadImg::get();
        
        $home_slider = HomeSlider::where('display', 1)
        ->orderBy('sequence', 'asc')
        ->select(['id', 'slider_img', 'link'])->get();

        $about_page = Pages::find(1);

        return response()->json([
            'head_img' => $head_img,
            'home_slider' => $home_slider,
            'about_content' => $about_page->content
        ]);
    }
}