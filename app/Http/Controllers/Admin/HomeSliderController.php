<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\HomeSlider;

class HomeSliderController extends Controller
{
    public function addItem(Request $request) {
        $data = $request->input();

        $validator = Validator::make($data,
        [
            'link' => 'nullable|string',
            'sequence' => 'required|int',
            'display' => 'required|int'
        ]);

        if (!$validator->fails()) {
            $file_url = null;

            if (!is_null($request->file('slider_img')) && $request->file('slider_img')->isValid()) {
                $upload_file = $request->file('slider_img');

                $file_path = Storage::disk('s3')->putFile('img', $upload_file, ['visibility' => 'public']);
                $file_url = Storage::disk('s3')->url($file_path);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'message' => '圖片上傳失敗，請重新嘗試'
                ]);
            }

            $data['slider_img'] = $file_url;
            HomeSlider::create($data);

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

    public function getItems(Request $request) {
        $page = (int) $request->query('page', 1);
        $limit = (int) $request->query('limit', 15);
        $offset = ($page - 1) * $limit;

        $sliders = HomeSlider::orderBy('sequence', 'asc')
        ->select(['id', 'slider_img', 'link', 'sequence', 'display'])
        ->offset($offset)
        ->limit($limit)
        ->get();

        $total = HomeSlider::count();
        
        return response()->json([
            'sliders' => $sliders,
            'total' => $total,
        ]);
    }

    public function getItem($id, Request $request) {
        $slider = HomeSlider::find($id);

        return response()->json([
            'slider' => $slider
        ]);
    }

    public function updateItem($id, Request $request) {
        $data = $request->input();
        unset($data['_method']);

        $data['is_slider_img_update'] = ($data['is_slider_img_update'] === 'true') ? true : false;

        $validator = Validator::make($data,
        [
            'is_slider_img_update' => 'required|boolean',
            'link' => 'nullable|string',
            'sequence' => 'required|int',
            'display' => 'required|int'
        ]);

        if (!$validator->fails()) {
            if ($data['is_slider_img_update']) {
                if (!is_null($request->file('slider_img_update_file')) && $request->file('slider_img_update_file')->isValid()) {
                    $upload_file = $request->file('slider_img_update_file');
        
                    $file_path = Storage::disk('s3')->putFile('img', $upload_file, ['visibility' => 'public']);
                    $file_url = Storage::disk('s3')->url($file_path);
                    $data['slider_img'] = $file_url;
                } else {
                    return response()->json([
                        'status' => 'fail',
                        'message' => '圖片上傳失敗，請重新嘗試'
                    ]);
                }
            }

            unset($data['slider_img_update_file']); // 沒上傳檔案會是 null，含在 $data
            unset($data['is_slider_img_update']);

            HomeSlider::find($id)->update($data);

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

    public function deleteItem($id, Request $request) {
        HomeSlider::find($id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => ''
        ]);
    }
}