<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EditorController extends Controller
{
    public function upload(Request $request) {
        if (!is_null($request->file('upload')) && $request->file('upload')->isValid()) {
            $extension = $request->file('upload')->extension();
            $path = "storage/" . $request->file('upload')->store('uploads', 'public');
        }
        
        // DB::table('test_log')->insert([
        //     'title' => '測試 ckeditor 上傳圖片',
        //     'content' => json_encode($path),
        //     'datetime' => date('Y-m-d H:i:s')
        // ]);
        
        return response()->json([
            'url' => $path
        ]);
    }
}