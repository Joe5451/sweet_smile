<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\ProductSubCategoryAndProduct;
use App\Models\Product;

class ProductController extends Controller
{
    public function getSubcategoryProducts($subcategory_id, Request $request) {
        $page = (int) $request->query('page', 1);
        $limit = (int) $request->query('limit', 15);
        $offset = ($page - 1) * $limit;

        $product_subcategory = ProductSubCategory::where('subcategory_display', 1)->find($subcategory_id);

        $products = ProductSubCategoryAndProduct::where('product_subcategory_id', $subcategory_id)
        ->orderBy('product_sequence', 'asc')
        ->join('products', 'products.id', '=', 'product_subcategory_and_product.product_id')
        ->where('products.display', 1)
        ->offset($offset)
        ->limit($limit)
        ->get();

        $total = ProductSubCategoryAndProduct::where('product_subcategory_id', $subcategory_id)
        ->join('products', 'products.id', '=', 'product_subcategory_and_product.product_id')
        ->where('products.display', 1)
        ->count();
        
        return response()->json([
            'subcategory_name' => (!is_null($product_subcategory)) ? $product_subcategory->subcategory_name : '',
            'products' => $products,
            'total' => $total
        ]);
    }

    public function getCategories(Request $request) {
        $product_categories = ProductCategory::orderBy('category_sequence', 'asc')
        ->orderBy('product_category_id', 'desc')
        ->where('category_display', 1)
        ->select(['product_category_id', 'category_name'])
        ->get();

        $product_categories->each(function ($item) {
            // 添加 product_subcategories
            $item->enabled_product_subcategories;
        });

        return response()->json([
            'product_categories' => $product_categories
        ]);
    }

    public function getItem($id, Request $request) {
        $product = Product::where('display', 1)->find($id);

        return response()->json([
            'product' => $product
        ]);
    }
}