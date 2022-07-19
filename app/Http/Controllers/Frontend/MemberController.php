<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Member;

// JWT
use App\Http\Controllers\Frontend\JwtConfig as JwtConfig;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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

    public function login(Request $request)
    {
        $data = $request->input();

        $validator = Validator::make($data,
        [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (!$validator->fails()) {
            $member = Member::where('email', $data['email'])
            ->where('password', md5($data['password']))
            ->select('member_id', 'email', 'name', 'mobile')
            ->take(1)
            ->get();

            if (count($member) == 0) {
                return response()->json([
                    'status' => 'fail',
                    'message' => '帳號密碼錯誤'
                ]);
            }

            $member_id = $member[0]->member_id;
            unset($member[0]->member_id);
            
            $expires_in = date('Y-m-d H:i:s', strtotime('+1day'));

            $payload = [
                'member_id' => $member_id,
                'expires_in' => $expires_in
            ];

            $token = $this->createToken($payload);

            Member::where('member_id', $member_id)
            ->update([
                'token' => $token,
                'token_expires_in' => $expires_in
            ]);
                
            return response()->json([
                'status' => 'success',
                'access_token' => $token,
                'expires_in' => $expires_in,
                'member' => $member[0]
            ]);
        } else {
            $error = $validator->messages();

            return response()->json([
                'status' => 'fail',
                'message' => '請輸入帳號密碼',
                'error' => $error
            ]);
        }
    }

    public function getItem(Request $request) {
        $token = $request->query('token', null);

        $member = Member::select(['name', 'email', 'mobile'])
        ->where('token', $token)
        ->take(1)
        ->get();

        if (count($member) == 0) {
            return response()->json([
                'status' => 'fail',
                'message' => ''
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'member' => $member[0]
            ]);
        }
    }

    public function checkToken(Request $request) {
        $token = $request->input('token');

        if (is_null($token)) {
            return response()->json([
                'status' => 'fail',
                'message' => '無 token',
            ]);
        }

        $member = Member::where('token', $token)->take(1)->get();

        if (count($member) == 0) {
            return response()->json([
                'status' => 'fail',
                'message' => 'token 不存在',
            ]);
        } else if ($member[0]->token_expires_in < date('Y-m-d H:i:s')) {
            return response()->json([
                'status' => 'fail',
                'message' => 'token 已過期',
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => '',
            ]);
        }
    }

    public function updateItem(Request $request) {
        $token = $request->bearerToken();
        $data = $request->input();

        $validator = Validator::make($data,
        [
            'name' => 'required|string',
            'mobile' => 'nullable|string',
            'password' => 'nullable|string',
        ]);

        if (!$validator->fails()) {
            // 密碼非空白更改
            if (!is_null($data['password']))
                $data['password'] = md5($data['password']);
            else
                unset($data['password']);

            $decoded = JWT::decode($token, new Key(JwtConfig::JWT_KEY, JwtConfig::JWT_ALGO));

            $member_id = $decoded->member_id;
                
            Member::where('member_id', $member_id)->update($data);

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

    private function createToken($payload)
    {
        $jwt = JWT::encode($payload, JwtConfig::JWT_KEY, JwtConfig::JWT_ALGO);

        return $jwt;
    }
}