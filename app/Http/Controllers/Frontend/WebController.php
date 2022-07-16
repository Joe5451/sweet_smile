<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages;
use App\Models\HeadImg;
use App\Models\HomeSlider;
use App\Models\ProductCategory;

class WebController extends Controller
{
    public function getData(Request $request) {
        $head_img = HeadImg::get();
        
        $home_slider = HomeSlider::where('display', 1)
        ->orderBy('sequence', 'asc')
        ->select(['id', 'slider_img', 'link'])->get();

        $about_page = Pages::find(1);

        $product_categories = ProductCategory::orderBy('category_sequence', 'asc')
        ->orderBy('product_category_id', 'desc')
        ->where('category_display', 1)
        ->select(['product_category_id', 'category_name', 'category_display', 'category_sequence'])
        ->get();

        $product_categories->each(function ($item) {
            // 添加 product_subcategories
            $item->enabled_product_subcategories;
        });

        return response()->json([
            'head_img' => $head_img,
            'home_slider' => $home_slider,
            'about_content' => $about_page->content,
            'product_categories' => $product_categories
        ]);
    }
}