<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fill_data = [];

        for ($i = 1; $i <= 30; $i++) {
            $current_number = str_pad($i, 2, '0', STR_PAD_LEFT);
            
            $fill_data[] = [
                'email' => 'test' . $current_number . '@email.com',
                'name' => '測試員' . $current_number,
                'mobile' => '09123456' . $current_number,
                'password' => md5('aaa'),
                'created_at' => date('Y-m-d H:i:s', strtotime('-' . (30 - $i) . 'day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-' . (30 - $i) . 'day'))
            ];
        }
        
        DB::table('member')->insert($fill_data);
    }
}
