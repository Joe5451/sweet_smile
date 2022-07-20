<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Contact;

class ContactController extends Controller
{
    public function add(Request $request) {
        $data = $request->input();

        $validator = Validator::make($data,
        [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'content' => 'required|string',
        ]);

        if (!$validator->fails()) {
            Contact::create($data);

            return response()->json([
                'status' => 'success',
                'message' => ''
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => '資料錯誤，請重新嘗試',
                'error' => $validator->messages()
            ]);
        }
    }

}
