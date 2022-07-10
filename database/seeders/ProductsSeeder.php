<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $test_img = 'https://sweet-smile.s3.ap-northeast-1.amazonaws.com/img/m9SPfptgzFHfcPjtlLX5SQ9xwCAgDWQ49oDSMtix.jpg';
        
        DB::table('products')->insert([
            [
                'product_name' => '特級巧克力蛋糕',
                'product_cover_img' => 'https://sweet-smile.s3.ap-northeast-1.amazonaws.com/img/2DuOFEIu296urh372n6w5rGwCn7CTBYLWkFeNuLR.jpg',
                'original_price' => null,
                'price' => 450,
                'summary' => '要想清楚，特級巧克力蛋糕，到底是一種怎麽樣的存在。',
                'content' => '要想清楚，特級巧克力蛋糕，到底是一種怎麽樣的存在。一般來講，我們都必須務必慎重的考慮考慮。諸葛亮告訴我們，靜以修身，儉以養德，非淡泊無以明志，非寧靜無以致遠。這句話語雖然很短，但令我浮想聯翩。特級巧克力蛋糕的發生，到底需要如何做到，不特級巧克力蛋糕的發生，又會如何產生。特級巧克力蛋糕，到底應該如何實現。',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_name' => '聖多諾黑',
                'product_cover_img' => 'https://sweet-smile.s3.ap-northeast-1.amazonaws.com/img/m9SPfptgzFHfcPjtlLX5SQ9xwCAgDWQ49oDSMtix.jpg',
                'original_price' => 200,
                'price' => 150,
                'summary' => '',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque facere aperiam corrupti excepturi consequatur ipsa possimus deserunt rem optio placeat.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_name' => '草莓蛋糕',
                'product_cover_img' => 'https://sweet-smile.s3.ap-northeast-1.amazonaws.com/img/xrmDpzjEWWlhBt3MFIfuR6z6vjgci7XLhsj2E4Z1.jpg',
                'original_price' => null,
                'price' => 185,
                'summary' => '以精選可可、杏仁增加口感的碰撞出令人驚艷的火花。',
                'content' => '以精選可可、杏仁增加口感的碰撞出令人驚艷的火花。 用真材實料、滿懷愛意烘焙而出的甜點，少了華麗包裝及氣派裝潢，只為專心做好甜點，將滿腔熱情揉進每一個小點心裡。 費工費時，堅持手作最有良心，以製作最安心、健康、美味的甜品為宗旨！',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            
            [
                'product_name' => '草莓優格',
                'product_cover_img' => 'https://sweet-smile.s3.ap-northeast-1.amazonaws.com/img/Y41sGSmvIBW1AioemvRtgehFQ1sxWbEDSCRcl7OI.jpg',
                'original_price' => null,
                'price' => 450,
                'summary' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque facere aperiam corrupti excepturi consequatur ipsa possimus deserunt rem optio placeat.',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque facere aperiam corrupti excepturi consequatur ipsa possimus deserunt rem optio placeat.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_name' => '牛奶巧克力',
                'product_cover_img' => 'https://sweet-smile.s3.ap-northeast-1.amazonaws.com/img/ENImrPwo6LPqtqLG4jKYKLuI5qTPC8vQT2c9x8DH.jpg',
                'original_price' => null,
                'price' => 300,
                'summary' => '',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque facere aperiam corrupti excepturi consequatur ipsa possimus deserunt rem optio placeat.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_name' => '花生可可派',
                'product_cover_img' => 'https://sweet-smile.s3.ap-northeast-1.amazonaws.com/img/arrSDkOPqm2TbzC3OoZaHyDShPvaOQP8D9RvuNjy.jpg',
                'original_price' => null,
                'price' => 500,
                'summary' => '不同口味的慕斯層層疊疊，這一秒好像吃出了什麼滋味，下一秒又消失無蹤',
                'content' => '不同口味的慕斯層層疊疊，這一秒好像吃出了什麼滋味，下一秒又消失無蹤',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_name' => '密橙可可',
                'product_cover_img' => 'https://sweet-smile.s3.ap-northeast-1.amazonaws.com/img/uLi7KoGd3eGriaarcFDHr0bLo162L9jnrPpOulEj.jpg',
                'original_price' => null,
                'price' => 180,
                'summary' => '這濃郁芬香， 就像打開法國凡爾賽宮的大門， 皇家園林的宏偉對稱， 瑪麗皇后的瑰麗奢華',
                'content' => '這濃郁芬香， 就像打開法國凡爾賽宮的大門， 皇家園林的宏偉對稱， 瑪麗皇后的瑰麗奢華，夜夜笙歌的樂韻……。一切，隱沒於過去。遺下繁星，香氣，味道，流傳至今',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_name' => '蒙布朗',
                'product_cover_img' => 'https://sweet-smile.s3.ap-northeast-1.amazonaws.com/img/Nu7B6PfWiFxrJq3z4QYJeYWsGGLEEOuyLWJm50y1.jpg',
                'original_price' => null,
                'price' => 750,
                'summary' => '不同口味的慕斯層層疊疊，這一秒好像吃出了什麼滋味，下一秒又消失無蹤',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque facere aperiam corrupti excepturi consequatur ipsa possimus deserunt rem optio placeat.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
