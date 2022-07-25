<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_subcategory')->insert([
            [
                'product_subcategory_id' => 1,
                'product_category_id' => 2,
                'subcategory_name' => '巧克力 🍫',
                'subcategory_display' => 1,
                'subcategory_sequence' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => 2,
                'product_category_id' => 2,
                'subcategory_name' => '粉紅泡泡 🧁',
                'subcategory_display' => 1,
                'subcategory_sequence' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => 3,
                'product_category_id' => 2,
                'subcategory_name' => '甜點禮盒 🍪',
                'subcategory_display' => 1,
                'subcategory_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => 4,
                'product_category_id' => 3,
                'subcategory_name' => '經典美味',
                'subcategory_display' => 1,
                'subcategory_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => 5,
                'product_category_id' => 1,
                'subcategory_name' => '全品項 🍰',
                'subcategory_display' => 1,
                'subcategory_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => 6,
                'product_category_id' => 1,
                'subcategory_name' => '熱銷🔥',
                'subcategory_display' => 1,
                'subcategory_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
