<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Cart;
use App\Models\Product;

// JWT
use App\Http\Controllers\Frontend\JwtConfig as JwtConfig;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class CartController extends Controller
{
    public function add(Request $request) {
        $token = $request->bearerToken();

        $decoded = JWT::decode($token, new Key(JwtConfig::JWT_KEY, JwtConfig::JWT_ALGO));

        $member_id = $decoded->member_id;
        
        $data = $request->input();

        $validator = Validator::make($data,
        [
            'product_id' => 'required|numeric',
            'qty' => 'required|int',
        ]);

        if (!$validator->fails()) {
            $product = Product::where('display', 1)->find($data['product_id']);

            if (is_null($product)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => '查無商品'
                ]);
            }

            $existed_cart = Cart::where('member_id', $member_id)
            ->where('product_id', $product->id)
            ->get();

            if (count($existed_cart) > 0) {
                Cart::find($existed_cart[0]->id)
                ->update([
                    'qty' => $data['qty'] + $existed_cart[0]->qty,
                    'product_name' => $product->product_name,
                    'price' => $product->price,
                    'img' => $product->product_cover_img,
                ]);
            } else {
                Cart::create([
                    'product_id' => $data['product_id'],
                    'qty' => $data['qty'],
                    'product_name' => $product->product_name,
                    'price' => $product->price,
                    'img' => $product->product_cover_img,
                    'member_id' => $member_id
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => ''
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => '發生錯誤，請重新嘗試',
                'error' => $validator->messages()
            ]);
        }
    }

    public function getItems(Request $request) {
        $token = $request->bearerToken();

        $decoded = JWT::decode($token, new Key(JwtConfig::JWT_KEY, JwtConfig::JWT_ALGO));

        $member_id = $decoded->member_id;

        $cart = Cart::where('member_id', $member_id)
        ->select('id', 'product_id', 'product_name', 'price', 'img', 'qty')
        ->get();

        return response()->json([
            'status' => 'success',
            'cart' => $cart
        ]);
    }

    public function deleteItem($id, Request $request) {
        $token = $request->bearerToken();

        $decoded = JWT::decode($token, new Key(JwtConfig::JWT_KEY, JwtConfig::JWT_ALGO));

        $member_id = $decoded->member_id;

        Cart::where('member_id', $member_id)->where('id', $id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => ''
        ]);
    }

    public function updateItem($id, Request $request) {
        $token = $request->bearerToken();

        $decoded = JWT::decode($token, new Key(JwtConfig::JWT_KEY, JwtConfig::JWT_ALGO));

        $member_id = $decoded->member_id;

        $qty = $request->input('qty');

        if (is_null($qty) || (int) $qty == 0) {
            return response()->json([
                'status' => 'fail',
                'message' => ''
            ]);
        }

        Cart::where('member_id', $member_id)->where('id', $id)->update([
            'qty' => $qty
        ]);

        return response()->json([
            'status' => 'success',
            'message' => ''
        ]);
    }
}