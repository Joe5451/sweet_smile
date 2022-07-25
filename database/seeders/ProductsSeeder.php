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
            [
                'product_name' => '經典奶油草莓蛋糕',
                'product_cover_img' => 'img/snack2.png',
                'original_price' => 200,
                'price' => 170,
                'summary' => '草莓蛋糕夾入爆量新鮮草莓，草莓的酸甜與奶油的甜香經典組合',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque facere aperiam corrupti excepturi consequatur ipsa possimus deserunt rem optio placeat.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_name' => '經典下午茶套餐',
                'product_cover_img' => 'img/snack7.png',
                'original_price' => 600,
                'price' => 550,
                'summary' => '可頌 + 拿鐵 + 當季水果，讓您享受愉快的下午茶',
                'content' => '我們都很清楚，這是個嚴謹的議題。不難發現，問題在於該用什麼標準來做決定呢？魯訊說過，忍看朋輩成新鬼，怒向刀叢覓小詩。這讓我的思緒清晰了。毛澤東深信，諒解、支援和友誼，比什麼都重要。這不禁令我重新仔細的思考。孟郊曾經提到過，慷慨丈夫志，可以耀鋒？ 這段話可說是震撼了我。了解清楚經典下午茶套餐到底是一種怎麼樣的存在，是解決一切問題的關鍵。經典下午茶套餐對我來說有著舉足輕重的地位，必須要嚴肅認真的看待。我們普遍認為，若能理解透徹核心原理，對其就有了一定的了解程度。',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_name' => '櫻桃冰淇淋',
                'product_cover_img' => 'img/snack3.png',
                'original_price' => 120,
                'price' => 100,
                'summary' => '為什麼櫻桃冰淇淋對我們來說這麼重要？拉羅什福科曾經說過，我們唯一不會改正的缺點是軟弱。這果然是一句至理名言。我們不得不面對一個非常尷尬的事實，那就是，笛卡兒有一句座右銘，閱讀一切好書如同和過去最傑出的人談話。這似乎非常的有道理，對吧？',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque facere aperiam corrupti excepturi consequatur ipsa possimus deserunt rem optio placeat.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_name' => '檸檬紅茶奶蓋',
                'product_cover_img' => 'img/snack6.png',
                'original_price' => 120,
                'price' => 100,
                'summary' => '艾迪生說過一句富有哲理的話，每生塊土壤都會長出虛偽和欺詐，它們可是四季植物啊。請諸位將這段話在心中默念三遍。我想，把奶蓋檸檬紅茶的意義想清楚，對各位來說並不是一件壞事。本人也是經過了深思熟慮，在每個日日夜夜思考這個問題。奶蓋檸檬紅茶絕對是史無前例的。我們不得不相信，我們都有個共識，若問題很困難，那就勢必不好解決。若無法徹底理解奶蓋檸檬紅茶，恐怕會是人類的一大遺憾。',
                'content' => '我們可以很篤定的說，這需要花很多時間來嚴謹地論證。這必定是個前衛大膽的想法。巴爾扎克曾經提到過，愛情抵抗不住繁瑣的家務，必須至少有一方品質極堅強。這句話決定了一切。淮南子深信，巧治不能鑄木，巧工不能斫金。希望大家能發現話中之話。在這種不可避免的衝突下，我們必須解決這個問題。我們不得不相信，劉向深信，君子居人間則治，小人居人間則亂。君子慾和人，譬猶水火不相能然也，而鼎在其間，水火不亂，乃和百味，是以君子不可不慎擇人在其間。這激勵了我。利德益特講過一段耐人尋思的話，壞習慣像餅子，碎了比保存起來好。希望各位能用心體會這段話。我們不妨可以這樣來想: 話雖如此，我們卻也不能夠這麼篤定。回過神才發現，思考奶蓋檸檬紅茶的存在意義，已讓我廢寢忘食。我們都知道，只要有意義，那麼就必須慎重考慮。',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_name' => '水果茶',
                'product_cover_img' => 'img/snack8.png',
                'original_price' => 200,
                'price' => 170,
                'summary' => '我們需要淘汰舊有的觀念，切斯特頓告訴我們，理智本身是一種信仰。它是一種確定自己思想和現實之間關係的信仰。這段話令我陷入了沈思。甘地曾講過，對真理之神的忠誠，勝過其他所有的忠誠。我希望諸位也能好好地體會這句話。在人生的歷程中，水果茶的出現是必然的。',
                'content' => '水果茶因何而發生？深入的探討水果茶，是釐清一切的關鍵。世界需要改革，需要對水果茶有新的認知。領悟其中的道理也不是那麼的困難。對水果茶進行深入研究，在現今時代已經無法避免了。我們不得不相信，從這個角度來看，所謂水果茶，關鍵是水果茶需要如何解讀。水果茶似乎是一種巧合，但如果我們從一個更大的角度看待問題，這似乎是一種不可避免的事實。',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_name' => '提拉米蘇',
                'product_cover_img' => 'img/snack10.png',
                'original_price' => 230,
                'price' => 200,
                'summary' => '若能夠洞悉提拉米蘇各種層面的含義，勢必能讓思維再提高一個層級。每個人都不得不面對這些問題。在面對這種問題時，務必詳細考慮提拉米蘇的各種可能。話雖如此，我們卻也不能夠這麼篤定。',
                'content' => '世界需要改革，需要對提拉米蘇有新的認知。就我個人來說，提拉米蘇對我的意義，不能不說非常重大。蘇軾曾說過，慎重則必成，輕發則多敗。這句話讓我們得到了一個全新的觀點去思考這個問題。我們需要淘汰舊有的觀念，柯爾律治說過一句著名的話，講述生活折聲音沒有不和諧的。希望各位能用心體會這段話。所謂提拉米蘇，關鍵是提拉米蘇需要如何解讀。',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_name' => '芒果布丁',
                'product_cover_img' => 'img/snack11.png',
                'original_price' => 145,
                'price' => 125,
                'summary' => '採用當季新鮮芒果製作',
                'content' => '芒果布丁，到底應該如何實現。費孝通曾說過一句意義深遠的話，在父母的眼中，孩子常是自我的一部分，子女是他理想自我再來一次的機會。這句話反映了問題的急切性。每個人都不得不面對這些問題。在面對這種問題時，務必詳細考慮芒果布丁的各種可能。',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'product_name' => '巧克力+草莓貝果',
                'product_cover_img' => 'img/snack12.png',
                'original_price' => 280,
                'price' => 260,
                'summary' => '對於一般人來說，巧克力+草莓貝果究竟象徵著什麼呢？在人類的歷史中，我們總是盡了一切努力想搞懂巧克力+草莓貝果。恩格斯曾經提過，有所作為是“生活中的最高境界”這段話看似複雜，其中的邏輯思路卻清晰可見。',
                'content' => '總結來說，需要考慮周詳巧克力+草莓貝果的影響及因應對策。不難發現，問題在於該用什麼標準來做決定呢？當前最急迫的事，想必就是釐清疑惑了。荀況曾經提過，君子贈人以言，庶人贈人以財。但願各位能從這段話中獲得心靈上的滋長。譚嗣同曾經提過，我自橫刀向天笑，去留肝膽兩崑崙。這段話雖短，卻足以改變人類的歷史。儘管如此，別人往往卻不這麼想。',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
