<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSubCategoryAndProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 所有品項
        $all_products = [];

        $products = DB::table('products')->get();
        
        foreach ($products as $product) {
            $all_products[] = [
                'product_subcategory_id' => '5',
                'product_id' => $product->id,
                'product_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        DB::table('product_subcategory_and_product')->insert($all_products);
        
        DB::table('product_subcategory_and_product')->insert([
            [
                'product_subcategory_id' => '1',
                'product_id' => '1',
                'product_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => '1',
                'product_id' => '5',
                'product_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => '1',
                'product_id' => '2',
                'product_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => '2',
                'product_id' => '4',
                'product_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => '2',
                'product_id' => '3',
                'product_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => '3',
                'product_id' => '8',
                'product_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => '3',
                'product_id' => '7',
                'product_sequence' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => '3',
                'product_id' => '6',
                'product_sequence' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // 熱銷
            [
                'product_subcategory_id' => '6',
                'product_id' => '8',
                'product_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => '6',
                'product_id' => '9',
                'product_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => '6',
                'product_id' => '14',
                'product_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => '6',
                'product_id' => '15',
                'product_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // 經典
            [
                'product_subcategory_id' => '4',
                'product_id' => '9',
                'product_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => '4',
                'product_id' => '10',
                'product_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => '4',
                'product_id' => '14',
                'product_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_subcategory_id' => '4',
                'product_id' => '16',
                'product_sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
