<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            
            $table->increments('order_id');
            $table->string('member_id', 10)->nullable()->comment('會員 id');
            $table->string('order_number', 10)->default('')->comment('訂單編號');
            $table->integer('subtotal')->default(0)->comment('商品小計');
            $table->mediumInteger('fare')->default(0)->comment('運費');
            $table->integer('total')->default(0)->comment('總計');
            $table->string('email', 100)->default('')->comment('會員/非會員聯絡 Email');
            $table->string('name', 100)->default('')->comment('購買人姓名');
            $table->string('phone', 20)->default('')->comment('購買人電話');
            $table->string('city', 200)->default('')->comment('購買人縣市');
            $table->string('town', 200)->default('')->comment('購買人鄉鎮市區');
            $table->string('address', 200)->default('')->comment('購買人地址');
            $table->string('receiver_name', 100)->default('')->comment('收件人姓名');
            $table->string('receiver_phone', 20)->default('')->comment('收件人電話');
            $table->string('receiver_city', 200)->default('')->comment('收件人縣市');
            $table->string('receiver_town', 200)->default('')->comment('收件人鄉鎮市區');
            $table->string('receiver_address', 200)->default('')->comment('收件人地址');
            $table->mediumText('remark')->nullable()->comment('訂單備註');
            $table->mediumText('order_remark')->nullable()->comment('管理者備註');
            $table->tinyInteger('order_state')->default(0)->comment('訂單狀態');
            $table->timestamps(); // 建立 created_at 和 updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
