<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $demo_img = [
            'https://sweet-smile.s3.ap-northeast-1.amazonaws.com/img/1JKKgg0H2C7qZEyUX1CbcB4TsNmhgGCD7ZbaVkYn.jpg',
            'https://sweet-smile.s3.ap-northeast-1.amazonaws.com/img/0TCQJPBmWMxCtYTJrkIhLEUoiqN7pLte3OdKivhE.jpg',
            'img/banner3.jpg',
            'img/banner4.jpg',
            'img/banner5.jpg'
        ];
        
        
        DB::table('home_slider')->insert([
            [
                'slider_img' => $demo_img[0],
                'link' => 'https://www.google.com.tw/',
                'display' => 1,
                'sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'slider_img' => $demo_img[1],
                'link' => null,
                'display' => 1,
                'sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'slider_img' => $demo_img[2],
                'link' => null,
                'display' => 1,
                'sequence' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
