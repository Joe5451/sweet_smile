<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\ProductSubCategoryAndProduct;

class ProductCategoryController extends Controller
{
    public function add(Request $request) {
        $origin_data = $request->input();

        // json_decode() 第二參數設為 true 強制轉為陣列，才可透過 Validator 驗證及 insert DB
        $data = isset($origin_data['data']) ? json_decode($origin_data['data'], true) : null;

        // return response()->json([
        //     'status' => 'success',
        //     'message' => $data,
        // ]);

        $category_validator = Validator::make($data,
        [
            'category_name' => 'required|string',
            'category_display' => 'required|int',
            'category_sequence' => 'required|int',
            'subcategories' => 'required|array',
            // 巢狀陣列，如果為物件陣列則為 subcategories.subcategory_name
            'subcategories.*.subcategory_name' => 'required|string',
            'subcategories.*.subcategory_display' => 'required|int',
            'subcategories.*.subcategory_sequence' => 'required|int',
            'subcategories.*.subcategory_products' => 'array', // 允許空陣列
            // 綁定商品驗證
            'subcategories.*.subcategory_products.*.product_id' => 'required|alpha_num',
            'subcategories.*.subcategory_products.*.product_name' => 'required|string',
            'subcategories.*.subcategory_products.*.product_sequence' => 'required|int',
        ]);

        if ($category_validator->fails()) {
            $error = $category_validator->messages();

            return response()->json([
                'status' => 'fail',
                'message' => '資料缺少或格式錯誤，請重新嘗試',
                'error' => $error
            ]);
        }
        // else {
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => ''
        //     ]);
        // }

        $product_category = ProductCategory::create([
            'category_name' => $data['category_name'],
            'category_display' => $data['category_display'],
            'category_sequence' => $data['category_sequence']
        ]);

        foreach($data['subcategories'] as $subcategory) {
            $product_subcategory = ProductSubCategory::create([
                'product_category_id' => $product_category->product_category_id,
                'subcategory_name' => $subcategory['subcategory_name'],
                'subcategory_display' => $subcategory['subcategory_display'],
                'subcategory_sequence' => $subcategory['subcategory_sequence']
            ]);

            foreach($subcategory['subcategory_products'] as $subcategory_product) {
                ProductSubCategoryAndProduct::create([
                    'product_subcategory_id' => $product_subcategory->product_subcategory_id,
                    'product_id' => $subcategory_product['product_id'],
                    'product_sequence' => $subcategory_product['product_sequence']
                ]);
            }
        }
        
        return response()->json([
            'status' => 'success',
            'message' => '',
        ]);
    }

    public function getProductCategories(Request $request) {
        $page = (int) $request->query('page', 1);
        $limit = (int) $request->query('limit', 15);
        $offset = ($page - 1) * $limit;

        $product_categories = ProductCategory::orderBy('category_sequence', 'asc')
        ->orderBy('product_category_id', 'desc')
        ->select(['product_category_id', 'category_name', 'category_display', 'category_sequence'])
        ->offset($offset)
        ->limit($limit)
        ->get();
        
        $product_categories->each(function ($item) {
            $item->product_subcategories;
            
            /**
             * 可參考
             * 1. https://learnku.com/docs/laravel/8.x/eloquent-relationships/9407
             * 2. https://laravel.com/docs/8.x/eloquent-relationships
             */

            // 添加 products
            // $item->product_subcategories->each(function ($product_subcategory) {
            //     $product_subcategory->subcategory_products->makeHidden('pivot');
            // });
        });

        $total = ProductCategory::count();
        
        return response()->json([
            'product_categories' => $product_categories,
            'total' => $total,
        ]);
    }

    public function getProductCategory($id, Request $request) {
        $product_category = ProductCategory::select('category_display', 'category_name', 'category_sequence', 'product_category_id')->find($id);

        // 必須要 select 'product_category_id' 才能透過 model 的 hasMany() 去關聯 product_subcategories，但可以用 makeHidden 在輸出時隱藏
        $product_category->makeHidden('product_category_id');
        
        $product_category->product_subcategories->each(function ($product_subcategory) {
            $product_subcategory->subcategory_products->makeHidden('pivot');
        });

        return response()->json([
            'product_category' => $product_category
        ]);
    }

    public function updateProduct($id, Request $request) {
        $data = $request->input();
        unset($data['_method']);

        $data['is_product_cover_img_update'] = ($data['is_product_cover_img_update'] === 'true') ? true : false;

        $validator = Validator::make($data,
        [
            'is_product_cover_img_update' => 'required|boolean',
            'product_name' => 'required|string',
            'original_price' => 'nullable|int',
            'price' => 'required|int',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'display' => 'nullable|int'
        ]);

        if (!$validator->fails()) {
            if ($data['is_product_cover_img_update']) {
                if (!is_null($request->file('product_cover_img_update_file')) && $request->file('product_cover_img_update_file')->isValid()) {
                    $upload_file = $request->file('product_cover_img_update_file');
        
                    $file_path = Storage::disk('s3')->putFile('img', $upload_file, ['visibility' => 'public']);
                    $file_url = Storage::disk('s3')->url($file_path);
                    $data['product_cover_img'] = $file_url;
                } else {
                    return response()->json([
                        'status' => 'fail',
                        'message' => '商品圖片上傳失敗，請重新嘗試'
                    ]);
                }
            }

            unset($data['product_cover_img_update_file']); // 沒上傳檔案會是 null，含在 $data
            unset($data['is_product_cover_img_update']);

            Product::where('id', $id)->update($data);

            return response()->json([
                'status' => 'success',
                'message' => '',
            ]);
        } else {
            $error = $validator->messages();

            return response()->json([
                'status' => 'fail',
                'message' => '資料缺少或格式錯誤，請重新嘗試',
                'error' => $error
            ]);
        }
    }

    // public function deleteMember($id, Request $request) {
    //     $member = Product::where('member_id', $id)->delete();

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => ''
    //     ]);
    // }
}