<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;

class OrderController extends Controller
{
    public function getItems(Request $request) {
        $page = (int) $request->query('page', 1);
        $limit = (int) $request->query('limit', 15);
        $offset = ($page - 1) * $limit;

        $orders = Order::orderBy('created_at', 'desc')
        ->orderBy('order_id', 'desc')
        ->select(['order_id', 'receiver_name', 'order_number', 'email', 'member_id', 'total', 'order_state', 'created_at'])
        ->offset($offset)
        ->limit($limit)
        ->get();

        $orders->each(function ($order) {
            $order->datetime = date('Y-m-d H:i:s', strtotime($order->created_at));
            $order->order_state = Order::order_states[$order->order_state];
        });

        $total = Order::count();
        
        return response()->json([
            'orders' => $orders,
            'total' => $total,
        ]);
    }

    public function getOrder($id, Request $request) {
        $order = Order::select(['order_id', 'name', 'email', 'mobile', 'created_at'])
        ->find($id);

        return response()->json([
            'order' => $order
        ]);
    }

    public function updateOrder($id, Request $request) {
        $data = $request->input();

        $existOrder = Order::where('email', $data['email'])
        ->where('order_id', '!=', $id)
        ->take(1)->get();

        if (count($existOrder) > 0) {
            return response()->json([
                'status' => 'fail',
                'message' => '帳號已存在，請重新設置'
            ]);
        }

        $validator = Validator::make($data,
        [
            'name' => 'required|string',
            'mobile' => 'nullable|string',
            'email' => 'required|email',
            'password' => 'nullable|string',
        ]);

        if (!$validator->fails()) {
            // 密碼非空白更改
            if (!is_null($data['password']))
                $data['password'] = md5($data['password']);
            else
                unset($data['password']);
                
            Order::where('order_id', $id)->update($data);

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

    public function deleteOrder($id, Request $request) {
        Order::where('order_id', $id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => ''
        ]);
    }
}