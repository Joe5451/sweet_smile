<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_token', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            
            $table->increments('id'); // 建立自增 UNSIGNED INTEGER 類型主鍵
            $table->string('admin_token')->comment('admin_token');
            $table->dateTime('expired_at')->nullable()->comment('到期時間');
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
        Schema::dropIfExists('admins');
    }
}
