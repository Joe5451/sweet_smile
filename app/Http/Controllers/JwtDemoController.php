<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// JWT
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtDemoController extends Controller
{
    const key = 'demo_jwt_secret';
    const algo = 'HS256';

    public function jwt_demo()
    {
        $payload = [
            'message' => 'This is a demo.'
        ];

        $jwt = JWT::encode($payload, self::key, self::algo);

        try {
            $decoded = JWT::decode($jwt, new Key(self::key, self::algo));
            // $decoded = JWT::decode($jwt, new Key('another_key', self::algo));
            
            echo 'JWT: ' . $jwt . '<br>';
            echo 'decoded: ';
            var_dump($decoded);
        } catch (\Exception $e) {
            if ($e->getMessage() == 'Signature verification failed') {
                echo 'Token 驗證失敗';
            }
        }
    }
}
