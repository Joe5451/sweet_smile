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

    public function getItem($id, Request $request) {
        $order = Order::find($id);

        if (is_null($order)) {
            return response()->json([
                'status' => 'fail',
                'message' => '查無訂單'
            ]);
        }

        $order->datetime = date('Y-m-d H:i:s', strtotime($order->created_at));
        $order->order_items;

        return response()->json([
            'status' => 'success',
            'order' => $order
        ]);
    }

    public function updateItem($id, Request $request) {
        $data = $request->input();

        $validator = Validator::make($data,
        [
            'order_state' => 'required|numeric',
            'order_remark' => 'nullable|string',
        ]);

        if (!$validator->fails()) {
            Order::where('order_id', $id)->update($data);

            return response()->json([
                'status' => 'success',
                'message' => ''
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => '資料缺少或格式錯誤，請重新嘗試',
                'error' => $validator->messages()
            ]);
        }
    }

    public function deleteItem($id, Request $request) {
        Order::where('order_id', $id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => ''
        ]);
    }
}