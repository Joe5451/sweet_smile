<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{

    
    public function test(Request $request) {
        if (!is_null($request->file('demo')) && $request->file('demo')->isValid()) {
            $upload_file = $request->file('demo');

            $file_path = Storage::disk('s3')->putFile('img', $upload_file, ['visibility' => 'public']);
            $file_url = Storage::disk('s3')->url($file_path);

            return response()->json([
                'status' => 'success',
                'file_path' => $file_path,
                'file_url' => $file_url,
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => '失敗'
            ]);
        }
    }

}