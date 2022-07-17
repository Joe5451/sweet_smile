<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Member;

class MemberController extends Controller
{
    public function add(Request $request) {
        $data = $request->input();

        $validator = Validator::make($data,
        [
            'name' => 'required|string',
            'mobile' => 'nullable|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!$validator->fails()) {
            $existMember = Member::where('email', $data['email'])->take(1)->get();

            if (count($existMember) > 0) {
                return response()->json([
                    'status' => 'fail',
                    'message' => '帳號已存在，請重新設置'
                ]);
            }
            
            $data['password'] = md5($data['password']);
            Member::create($data);

            return response()->json([
                'status' => 'success',
                'message' => ''
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

    public function getMember($id, Request $request) {
        $member = Member::select(['member_id', 'name', 'email', 'mobile', 'created_at'])
        ->find($id);

        return response()->json([
            'member' => $member
        ]);
    }

    public function updateMember($id, Request $request) {
        $data = $request->input();

        $existMember = Member::where('email', $data['email'])
        ->where('member_id', '!=', $id)
        ->take(1)->get();

        if (count($existMember) > 0) {
            return response()->json([
                'status' => 'fail',
                'message' => '帳號已存在，請重新設置'
            ]);
        }

        $validator = Validator::make($data,
        [
            'name' => 'required|string',
            'mobile' => 'nullable|string',
            'email' => 'required|string',
            'password' => 'nullable|string',
        ]);

        if (!$validator->fails()) {
            // 密碼非空白更改
            if (!is_null($data['password']))
                $data['password'] = md5($data['password']);
            else
                unset($data['password']);
                
            Member::where('member_id', $id)->update($data);

            return response()->json([
                'status' => 'success',
                'message' => ''
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => '資料缺少或格式錯誤，請重新嘗試'
            ]);
        }
    }
}