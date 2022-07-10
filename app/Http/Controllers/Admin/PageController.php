<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Pages;

class PageController extends Controller
{
    public function getAbout(Request $request) {
        $page = Pages::find(1);

        return response()->json([
            'content' => $page->content
        ]);
    }

    public function updateAbout(Request $request) {
        $data = $request->input();
        unset($data['_method']);

        $validator = Validator::make($data,
        [
            'content' => 'nullable|string',
        ]);

        if (!$validator->fails()) {
            Pages::where('id', 1)->update($data);
            
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