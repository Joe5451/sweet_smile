<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductController extends Controller
{
    public function add(Request $request) {
        $file_url = null;

        if (!is_null($request->file('product_cover_img')) && $request->file('product_cover_img')->isValid()) {
            $upload_file = $request->file('product_cover_img');

            $file_path = Storage::disk('s3')->putFile('img', $upload_file, ['visibility' => 'public']);
            $file_url = Storage::disk('s3')->url($file_path);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => '商品圖片上傳失敗，請重新嘗試'
            ]);
        }
        
        $data = $request->input();

        $validator = Validator::make($data,
        [
            'product_name' => 'required|string',
            'original_price' => 'nullable|int',
            'price' => 'required|int',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'display' => 'nullable|int',
        ]);

        if (!$validator->fails()) {
            $data['product_cover_img'] = $file_url;
            Product::create($data);

            return response()->json([
                'status' => 'success',
                'message' => '',
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => '資料缺少或格式錯誤，請重新嘗試'
            ]);
        }
    }

    public function getProductList(Request $request) {
        $page = (int) $request->query('page', 1);
        $limit = (int) $request->query('limit', 15);
        $offset = ($page - 1) * $limit;

        $products = Product::orderBy('created_at', 'desc')
        ->orderBy('id', 'desc')
        ->select(['id', 'product_name', 'price', 'display'])
        ->offset($offset)
        ->limit($limit)
        ->get();

        $total = Product::count();
        
        return response()->json([
            'products' => $products,
            'total' => $total,
        ]);
    }

    public function getProduct($id, Request $request) {
        $product = Product::find($id);

        return response()->json([
            'product' => $product
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