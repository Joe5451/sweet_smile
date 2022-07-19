<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    const order_states = [
        0 => '未處理',
        1 => '處理中',
        2 => '已寄出',
        3 => '退貨',
        4 => '取消訂單'
    ];

    protected $fillable = [
        'order_id',
        'member_id',
        'order_number',
        'subtotal',
        'fare',
        'total',
        'email',
        'name',
        'phone',
        'city',
        'town',
        'address',
        'receiver_name',
        'receiver_phone',
        'receiver_city',
        'receiver_town',
        'receiver_address',
        'remark',
        'order_remark',
        'order_state',
    ];

    public function order_items() {
        return $this->hasMany('App\Models\OrderItem', 'order_id', 'order_id');
    }
}
