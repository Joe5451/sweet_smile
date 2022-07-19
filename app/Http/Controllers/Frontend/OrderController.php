<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Member;

// JWT
use App\Http\Controllers\Frontend\JwtConfig as JwtConfig;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class OrderController extends Controller
{
    public function add(Request $request) {
        $data = $request->input();

        $validator = Validator::make($data,
        [
            'is_member' => 'required|boolean',
            'name' => 'required|string',
            'phone' => 'required|string',
            'city' => 'required|string',
            'town' => 'required|string',
            'address' => 'required|string',
            'receiver_name' => 'required|string',
            'receiver_phone' => 'required|string',
            'receiver_city' => 'required|string',
            'receiver_town' => 'required|string',
            'receiver_address' => 'required|string',
            'remark' => 'nullable|string',
            'cart' => 'array', // 允許空陣列
            // 巢狀陣列內容驗證
            'cart.*.product_id' => 'required|numeric',
            'cart.*.product_name' => 'required|string',
            'cart.*.img' => 'required|string',
            'cart.*.price' => 'required|int',
            'cart.*.qty' => 'required|int'
        ]);

        if (!$validator->fails()) {
            $is_member = $data['is_member'];
            $carts = $data['cart'];
            $member_id = null;

            unset($data['is_member']);
            unset($data['cart']);
            
            // 驗證會員
            if ($is_member) {
                $token = $request->bearerToken();
                
                $member = Member::where('token', $token)->where('token_expires_in', '>', date('Y-m-d H:i:s'))->take(1)->get();

                if (count($member) == 0) {
                    return response()->json([
                        'status' => 'token_invalid',
                        'message' => ''
                    ]);
                }

                $member_id = $member[0]->member_id;
                
                $carts = Cart::where('member_id', $member_id)->get();
            } else {
                // 非會員為巢狀陣列，ex: cart[product_name]，以下轉化為 cart->product_name
                $carts = json_decode(json_encode($carts));
            }

            // 檢查商品資訊
            $check_product_pass = true;
            $delete_product_name = [];
            $subtotal = 0; // 商品小計
            $fare = 150; // 運費
            $total = 0; // 總金額
            
            foreach ($carts as $index => $cart) {
                $subtotal += $cart->price;
                
                $product = Product::where('product_name', $cart->product_name)
                ->where('price', $cart->price)
                ->where('display', 1)
                ->find($cart->product_id);

                if (is_null($product)) {
                    if ($is_member) Cart::find($cart->id)->delete();
                    $check_product_pass = false;
                    $delete_product_name[] = $cart->product_name;
                    unset($carts[$index]);
                }
            }

            if (!$check_product_pass) {
                return response()->json([
                    'status' => 'product_update',
                    'message' => '「' . implode('、', $delete_product_name) . '」商品資料更新，請重新確認內容後再訂購',
                    'update_cart' => $carts
                ]);
            }

            $total = $subtotal + $fare;

            $data['subtotal'] = $subtotal;
            $data['fare'] = $fare;
            $data['total'] = $total;
            $data['order_number'] = $this->getOrderNumber();
            if ($is_member) $data['member_id'] = $member_id;

            $order = Order::create($data);
            $order_id = $order->order_id;

            // 建立訂單商品資料
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order_id,
                    'product_id' => $cart->product_id,
                    'product_name' => $cart->product_name,
                    'product_img' => $cart->img,
                    'price' => $cart->price,
                    'qty' => $cart->qty
                ]);
            }

            if ($is_member) Cart::where('member_id', $member_id)->delete();

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

    // 產生訂單編號 = 兩個隨機大寫英文字母 + 五個隨機數字
    private function getOrderNumber() {
    	$order_number = '';

    	$num = '1234567890';
    	$num_len = strlen($num);

    	$word = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$word_len = strlen($word);

		for($i = 0; $i < 2; $i++){ // 取 2 次
        	$order_number .= $word[rand() % $word_len]; // 隨機取得一個字元
    	}

    	for($i = 0; $i < 5; $i++){ // 取 5 次
        	$order_number .= $num[rand() % $num_len];
    	}

        $exist_order_number = Order::where('order_number', $order_number)->get();

        while (count($exist_order_number) > 0 && $j <= 10) { // 檢查訂單編號是否已存在
            $order_number = '';

            for($i = 0; $i < 2; $i++){
                $order_number .= $word[rand() % $word_len];
            }
    
            for($i = 0; $i < 5; $i++){
                $order_number .= $num[rand() % $num_len];
            }

            $exist_order_number = Order::where('order_number', $order_number)->get();
        }
		
    	return $order_number;
	}

}