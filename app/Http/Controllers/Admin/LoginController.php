<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                $payload = [
                    'expires_in' => date('Y-m-d H:i:s')
                ];

                $token = $this->createToken($payload);
                
                return response()->json([
                    'status' => 'success',
                    'message' => $data,
                    'access_token' => $token
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

    public function createToken($payload)
    {
        $jwt = JWT::encode($payload, $this->jwt_key, $this->jwt_algo);

        return $jwt;
    }
}