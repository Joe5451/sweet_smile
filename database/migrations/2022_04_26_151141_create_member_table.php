<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';

            $table->increments('member_id');
            $table->string('name', 100)->default('')->comment('姓名');
            $table->string('email', 100)->default('')->comment('帳號');
            $table->string('password', 200)->default('')->comment('密碼');
            $table->string('mobile', 20)->nullable()->comment('手機');
            $table->tinyInteger('state')->default(1)->comment('狀態 (0:停權, 1:正常)');
            $table->mediumText('remark')->nullable()->comment('管理員備註');
            $table->string('token', 255)->nullable()->comment('登入 token');
            $table->dateTime('token_expires_in')->nullable()->comment('token 到期時間');
            $table->dateTime('datetime', 0)->useCurrent()->comment('加入時間'); // useCurrent() 使用 CURRENT_TIMESTAMP 作為預設值
            // $table->timestamps(); // 建立 created_at 和 updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member');
    }
}
