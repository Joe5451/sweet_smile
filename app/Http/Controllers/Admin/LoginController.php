<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AdminToken;

// JWT
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class LoginController extends Controller
{
    var $jwt_key = '';
    var $jwt_algo = 'HS256';

    public function __construct()
    {
        $this->jwt_key = env('ADMIN_JWT_SECRET');
    }

    public function login(Request $request)
    {
        $data = $request->input();
        // return response()->json($data);

        $validator = Validator::make($data,
        [
            'account' => 'required|string',
            'password' => 'required|string'
        ]);

        if (!$validator->fails()) {
            if ($data['account'] === 'admin' && $data['password'] === '000') {
                $expires_in = date('Y-m-d H:i:s', strtotime('+1hour'));

                $payload = [
                    'expires_in' => $expires_in
                ];

                $token = $this->createToken($payload);

                AdminToken::create([
                    'token' => $token,
                    'expires_in' => $expires_in
                ]);
                
                return response()->json([
                    'status' => 'success',
                    'access_token' => $token,
                    'expires_in' => $expires_in
                ]);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'message' => '帳號密碼錯誤'
                ]);
            }
        } else {
            $error = $validator->messages();

            return response()->json([
                'status' => 'fail',
                'message' => '請輸入帳號密碼',
                'error' => $error
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

        $admin_token = AdminToken::where('token', $token)->take(1)->get();

        if (count($admin_token) == 0) {
            return response()->json([
                'status' => 'fail',
                'message' => 'token 不存在',
            ]);
        } else if ($admin_token[0]->expires_in < date('Y-m-d H:i:s')) {
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

    public function logout(Request $request)
    {
        $data = $request->input();

        $validator = Validator::make($data,
        [
            'token' => 'required|string',
        ]);

        if (!$validator->fails()) {
            AdminToken::where('token', $data['token'])->delete();
                
            return response()->json([
                'status' => 'success',
                'message' => '',
            ]);
            
        } else {
            $error = $validator->messages();

            return response()->json([
                'status' => 'fail',
                'message' => '',
                'error' => $error
            ]);
        }
    }

    private function createToken($payload)
    {
        $jwt = JWT::encode($payload, $this->jwt_key, $this->jwt_algo);

        return $jwt;
    }
}