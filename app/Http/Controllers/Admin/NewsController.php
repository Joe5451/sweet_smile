<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\News;

class NewsController extends Controller
{
    public function addItem(Request $request) {
        $file_url = null;

        if (!is_null($request->file('cover_img')) && $request->file('cover_img')->isValid()) {
            $upload_file = $request->file('cover_img');

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
            'title' => 'required|string',
            'date' => 'required|date',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'display' => 'required|int',
        ]);

        if (!$validator->fails()) {
            $data['cover_img'] = $file_url;
            News::create($data);

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

        $news = News::orderBy('date', 'desc')
        ->orderBy('id', 'desc')
        ->select(['id', 'title', 'date', 'display'])
        ->offset($offset)
        ->limit($limit)
        ->get();

        $total = News::count();
        
        return response()->json([
            'news' => $news,
            'total' => $total,
        ]);
    }

    public function getItem($id, Request $request) {
        $new = News::find($id);

        return response()->json([
            'new' => $new
        ]);
    }

    public function updateItem($id, Request $request) {
        $data = $request->input();
        unset($data['_method']);

        $data['is_cover_img_update'] = ($data['is_cover_img_update'] === 'true') ? true : false;

        $validator = Validator::make($data,
        [
            'is_cover_img_update' => 'required|boolean',
            'title' => 'required|string',
            'date' => 'required|string',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'display' => 'required|int'
        ]);

        if (!$validator->fails()) {
            if ($data['is_cover_img_update']) {
                if (!is_null($request->file('cover_img_update_file')) && $request->file('cover_img_update_file')->isValid()) {
                    $upload_file = $request->file('cover_img_update_file');
        
                    $file_path = Storage::disk('s3')->putFile('img', $upload_file, ['visibility' => 'public']);
                    $file_url = Storage::disk('s3')->url($file_path);
                    $data['cover_img'] = $file_url;
                } else {
                    return response()->json([
                        'status' => 'fail',
                        'message' => '商品圖片上傳失敗，請重新嘗試'
                    ]);
                }
            }

            unset($data['cover_img_update_file']); // 沒上傳檔案會是 null，含在 $data
            unset($data['is_cover_img_update']);

            News::where('id', $id)->update($data);

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
        News::find($id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => ''
        ]);
    }
}