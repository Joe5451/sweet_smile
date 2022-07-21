<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fill_data = [];
        $demo_content = <<<Content
(❍ᴥ❍ʋ) 你好
ก็ʕ•͡ᴥ•ʔ ก้
ฅ●ω●ฅ' 哈囉~
Content;

        for ($i = 1; $i <= 30; $i++) {
            $current_number = str_pad($i, 2, '0', STR_PAD_LEFT);
            
            $fill_data[] = [
                'name' => '訪客' . $current_number,
                'email' => 'guest' . $current_number . '@email.com',
                'phone' => '0912345678',
                'content' => $demo_content,
                'state' => rand(0, 2),
                'created_at' => date('Y-m-d H:i:s', strtotime('-'. (30 - $i) .'day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-'. (30 - $i) .'day')),
            ];
        }
        
        DB::table('contact')->insert($fill_data);
    }
}
