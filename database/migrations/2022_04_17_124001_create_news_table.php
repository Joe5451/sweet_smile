<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';

            $table->increments('id');
            $table->string('title', 255)->default('')->comment('標題');
            $table->string('cover_img', 500)->nullable()->comment('封面圖');
            $table->date('date')->comment('日期');
            $table->mediumText('summary')->nullable()->comment('摘要');
            $table->mediumText('content')->nullable()->comment('內容');
            $table->tinyInteger('display')->default(1)->comment('顯示狀態 (0:disabled, 1:enabled)');
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
        Schema::dropIfExists('news');
    }
}
