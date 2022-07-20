<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';

            $table->increments('id');
            $table->string('name', 200)->default('')->comment('姓名');
            $table->string('email', 200)->default('')->comment('Email');
            $table->string('phone', 50)->nullable()->comment('電話');
            $table->mediumText('content')->nullable()->comment('內容');
            $table->mediumText('remark')->nullable()->comment('管理員備註');
            $table->tinyInteger('state')->default(0)->comment('處理狀態 (0:未處理, 1:處理中, 2:已處理)');
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
        Schema::dropIfExists('contact');
    }
}
