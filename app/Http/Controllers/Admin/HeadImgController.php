<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\HeadImg;

class HeadImgController extends Controller
{
    public function getItems(Request $request) {
        $all_header = $request->header();
        $bearer_token = $request->bearerToken();

        // access-control-allow-origin

        $head_imgs = HeadImg::select(['id', 'page_name', 'img'])->get();
        
        return response()->json([
            'head_imgs' => $head_imgs,
            'all_header' => $all_header,
            'token' => $bearer_token
        ]);
    }

    public function getItem($id, Request $request) {
        $head_img = HeadImg::find($id);

        return response()->json([
            'head_img' => $head_img
        ]);
    }

    public function updateItem($id, Request $request) {
        $data = $request->input();
        unset($data['_method']);

        $data['is_img_update'] = ($data['is_img_update'] === 'true') ? true : false;

        $validator = Validator::make($data,
        [
            'is_img_update' => 'required|boolean'
        ]);

        if (!$validator->fails()) {
            if ($data['is_img_update']) {
                if (!is_null($request->file('img_update_file')) && $request->file('img_update_file')->isValid()) {
                    $upload_file = $request->file('img_update_file');
        
                    $file_path = Storage::disk('s3')->putFile('img', $upload_file, ['visibility' => 'public']);
                    $file_url = Storage::disk('s3')->url($file_path);
                    $data['img'] = $file_url;
                } else {
                    return response()->json([
                        'status' => 'fail',
                        'message' => '圖片上傳失敗，請重新嘗試'
                    ]);
                }
            }

            unset($data['img_update_file']); // 沒上傳檔案會是 null，含在 $data
            unset($data['is_img_update']);

            HeadImg::find($id)->update($data);

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
}