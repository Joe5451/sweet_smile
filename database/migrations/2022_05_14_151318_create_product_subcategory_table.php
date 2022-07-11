<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSubcategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_subcategory', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';

            $table->increments('product_subcategory_id');
            $table->string('product_category_id', 10)->nullable()->comment('主分類 id');
            $table->string('subcategory_name', 100)->nullable()->comment('子分類名稱');
            $table->tinyInteger('subcategory_display')->default(1)->comment('顯示狀態 (0:disabled, 1:enabled)');
            $table->smallInteger('subcategory_sequence')->default(0)->comment('排序');
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
        Schema::dropIfExists('product_subcategory');
    }
}
