<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';

            $table->increments('id');
            $table->string('product_name', 255)->default('')->comment('商品名稱');
            $table->string('product_cover_img', 500)->nullable()->comment('封面圖');
            $table->mediumInteger('original_price')->nullable()->comment('原價');
            $table->mediumInteger('price')->default(0)->comment('售價');
            $table->mediumText('summary')->nullable()->comment('摘要');
            $table->mediumText('content')->nullable()->comment('介紹');
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
        Schema::dropIfExists('products');
    }
}
