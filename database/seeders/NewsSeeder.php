<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $test_img = 'https://sweet-smile.s3.ap-northeast-1.amazonaws.com/img/m9SPfptgzFHfcPjtlLX5SQ9xwCAgDWQ49oDSMtix.jpg';
        $test_content = <<<Content
        <h2>Bilingual Personality Disorder</h2><figure class="image image-style-side"><img src="https://c.cksource.com/a/1/img/docs/sample-image-bilingual-personality-disorder.jpg"><figcaption>One language, one person.</figcaption></figure><p>This may be the first time you hear about this made-up disorder but it actually isn’t so far from the truth. Even the studies that were conducted almost half a century show that <strong>the language you speak has more effects on you than you realise</strong>.</p><p>One of the very first experiments conducted on this topic dates back to 1964. <a href="https://www.researchgate.net/publication/9440038_Language_and_TAT_content_in_bilinguals">In the experiment</a> designed by linguist Ervin-Tripp who is an authority expert in psycholinguistic and sociolinguistic studies, adults who are bilingual in English in French were showed series of pictures and were asked to create 3-minute stories. In the end participants emphasized drastically different dynamics for stories in English and French.</p><p>Another ground-breaking experiment which included bilingual Japanese women married to American men in San Francisco were asked to complete sentences. The goal of the experiment was to investigate whether or not human feelings and thoughts are expressed differently in <strong>different language mindsets</strong>. Here is a sample from the the experiment:</p><figure class="table"><table><thead><tr><th>&nbsp;</th><th>English</th><th>Japanese</th></tr></thead><tbody><tr><td>Real friends should</td><td>Be very frank</td><td>Help each other</td></tr><tr><td>I will probably become</td><td>A teacher</td><td>A housewife</td></tr><tr><td>When there is a conflict with family</td><td>I do what I want</td><td>It's a time of great unhappiness</td></tr></tbody></table></figure><p>More recent <a href="https://books.google.pl/books?id=1LMhWGHGkRUC">studies</a> show, the language a person speaks affects their cognition, behaviour, emotions and hence <strong>their personality</strong>. This shouldn’t come as a surprise <a href="https://en.wikipedia.org/wiki/Lateralization_of_brain_function">since we already know</a> that different regions of the brain become more active depending on the person’s activity at hand. Since structure, information and especially <strong>the culture</strong> of languages varies substantially and the language a person speaks is an essential element of daily life.</p>
Content;

        $test_imgs = [
            'img/banner1.jpg',
            'img/banner2.jpg',
            'img/banner3.jpg',
            'img/banner4.jpg',
            'img/banner5.jpg',
        ];

        $fill_data = [];

        for ($i = 1; $i <= 30; $i++) {
            $current_number = str_pad($i, 2, '0', STR_PAD_LEFT);
            
            $fill_data[] = [
                'title' => '特級巧克力蛋糕，到底是一種怎麽樣的存在~',
                'cover_img' => $test_imgs[$i%5],
                'date' => date('Y-m-d', strtotime('-' . (35 - $i) . 'day')),
                'summary' => '要想清楚，特級巧克力蛋糕，到底是一種怎麽樣的存在。',
                'content' => '要想清楚，特級巧克力蛋糕，到底是一種怎麽樣的存在。一般來講，我們都必須務必慎重的考慮考慮。諸葛亮告訴我們，靜以修身，儉以養德，非淡泊無以明志，非寧靜無以致遠。這句話語雖然很短，但令我浮想聯翩。特級巧克力蛋糕的發生，到底需要如何做到，不特級巧克力蛋糕的發生，又會如何產生。特級巧克力蛋糕，到底應該如何實現。',
                'display' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        DB::table('news')->insert($fill_data);
        
        DB::table('news')->insert([
            [
                'title' => '新商品上市',
                'cover_img' => $test_img,
                'date' => date('Y-m-d'),
                'summary' => '新商品上市真的是很值得探究，新商品上市的發生，到底需要如何做到',
                'content' => '新商品上市真的是很值得探究，新商品上市的發生，到底需要如何做到，不新商品上市的發生，又會如何產生。塞涅卡有一句座右銘，真正的人生，只有在經過艱難卓絕的鬥爭之後才能實現。這讓我思索了許久，一般來講，我們都必須務必慎重的考慮考慮。新商品上市的意義其實就隱藏在我們的生活中，希臘有說過一句話，最困難的事情就是認識自己。這讓我思索了許久，林則徐講過一句話，豈能盡如人意，但求無愧我心！這啟發了我，為什麼是這樣呢？問題的關鍵究竟為何？了解清楚新商品上市到底是一種怎麽樣的存在，是解決一切問題的關鍵。我們都知道，只要有意義，那麽就必須慎重考慮。帶著這些問題，我們來審視一下新商品上市。所謂新商品上市，關鍵是新商品上市需要如何寫。',
                'display' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => '歡慶開幕日!!!',
                'cover_img' => $test_imgs[0],
                'date' => date('Y-m-d', strtotime('-1day')),
                'summary' => '我們不得不面對一個非常尷尬的事實，那就是，開幕日，發生了會如何，不發生又會如何。帶著這些問題，我們來審視一下開幕日。至於為什麼要思考開幕日呢？其實是有更深層的原因，羅素·貝克有一句名言，一個人即使已登上頂峰，也仍要自強不息。這似乎非常的有道理，對吧？開幕日真的是很值得探究，在這種困難的抉擇下，本人思來想去，寢食難安。為什麼是這樣呢？',
                'content' => '我們不得不面對一個非常尷尬的事實，那就是，開幕日，發生了會如何，不發生又會如何。帶著這些問題，我們來審視一下開幕日。至於為什麼要思考開幕日呢？其實是有更深層的原因，羅素·貝克有一句名言，一個人即使已登上頂峰，也仍要自強不息。這似乎非常的有道理，對吧？開幕日真的是很值得探究，在這種困難的抉擇下，本人思來想去，寢食難安。為什麼是這樣呢？郭沫若曾經告訴世人，形成天才的決定因素應該是勤奮。我希望諸位也能好好地體會這句話。歌德在不經意間這樣說過，意志堅強的人能把世界放在手中像泥塊一樣任意揉捏。這讓我深深地想到，我們一般認為，抓住了問題的關鍵，其他一切則會迎刃而解。你真的了解開幕日嗎？我認為，拉羅什夫科有一句名言，取得成就時堅持不懈，要比遭到失敗時頑強不屈更重要。帶著這句話，我們還要更加慎重的審視這個問題：洛克曾經講過，學到很多東西的訣竅，就是一下子不要學很多。這讓我思索了許久，既然是這樣，本人也是經過了深思熟慮，在每個日日夜夜思考這個問題。開幕日的發生，到底需要如何做到，不開幕日的發生，又會如何產生。拉羅什福科曾經說過一句發人深省的話，我們唯一不會改正的缺點是軟弱。帶著這句話，我們還要更加慎重的審視這個問題：每個人都不得不面對這些問題。 在面對這種問題時，所以說，既然如此，蒙田曾經告訴世人，沉默較之言不由衷的話更有益於社交。這句話語雖然很短，但令我浮想聯翩。總結的來說，生活中，若開幕日出現了，我們就不得不考慮它出現了的事實。開幕日的意義其實就隱藏在我們的生活中，現在，解決開幕日的問題，是非常非常重要的。 所以，要想清楚，開幕日，到底是一種怎麽樣的存在。伏爾泰曾經告訴世人，堅持意志偉大的事業需要始終不渝的精神。這讓我深深地想到，了解清楚開幕日到底是一種怎麽樣的存在，是解決一切問題的關鍵。' . $test_content,
                'display' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => '大放送',
                'cover_img' => $test_imgs[1],
                'date' => date('Y-m-d', strtotime('-2day')),
                'summary' => '奧普拉·溫弗瑞講過一句話，你相信什麽，你就成為什麽樣的人。這不禁令我深思。',
                'content' => '奧普拉·溫弗瑞講過一句話，你相信什麽，你就成為什麽樣的人。這不禁令我深思。我認為，總結的來說，大放送，到底應該如何實現。問題的關鍵究竟為何？塞涅卡曾經說過，真正的人生，只有在經過艱難卓絕的鬥爭之後才能實現。這似乎非常的有道理，對吧？大放送的意義其實就隱藏在我們的生活中，大放送，發生了會如何，不發生又會如何。其實大放送是非常值得我們深思的。一般來講，我們都必須務必慎重的考慮考慮。每個人都不得不面對這些問題。 在面對這種問題時，在這種困難的抉擇下，本人思來想去，寢食難安。更多大放送的意義是這樣的，一般來說，帶著這些問題，我們來審視一下大放送。你真的了解大放送嗎？我這幾天一直在思索這個問題，就我個人來說，大放送對我的意義，不能不說非常重大。這種事實對本人來說意義重大，相信對這個世界也是有一定意義的。',
                'display' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => '悠閒生活',
                'cover_img' => $test_imgs[2],
                'date' => date('Y-m-d', strtotime('-3day')),
                'summary' => '就我個人來說，悠閒生活對我的意義，不能不說非常重大。我們都知道，只要有意義，那麽就必須慎重考慮。你真的了解悠閒生活嗎？',
                'content' => '就我個人來說，悠閒生活對我的意義，不能不說非常重大。我們都知道，只要有意義，那麽就必須慎重考慮。你真的了解悠閒生活嗎？這種事實對本人來說意義重大，相信對這個世界也是有一定意義的。悠閒生活，到底應該如何實現。為什麼是這樣呢？既然如此，在這種困難的抉擇下，本人思來想去，寢食難安。本人也是經過了深思熟慮，在每個日日夜夜思考這個問題。悠閒生活，發生了會如何，不發生又會如何。帶著這些問題，我們來審視一下悠閒生活。',
                'display' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => '生活意義!',
                'cover_img' => $test_imgs[3],
                'date' => date('Y-m-d', strtotime('-3day')),
                'summary' => '我們都知道，只要有意義，那麽就必須慎重考慮。進步的意義其實就隱藏在我們的生活中，',
                'content' => '經過上述討論，我們都知道，只要有意義，那麽就必須慎重考慮。進步的意義其實就隱藏在我們的生活中，每個人都不得不面對這些問題。 在面對這種問題時，你真的了解進步嗎？既然如此，就我個人來說，進步對我的意義，不能不說非常重大。一般來說，總結的來說，更多進步的意義是這樣的，在這種困難的抉擇下，本人思來想去，寢食難安。孟德斯鳩有一句座右銘，是看他在知道沒人看見的時候幹些什麼。這讓我深深地想到，本人也是經過了深思熟慮，在每個日日夜夜思考這個問題。我認為，生活中，若進步出現了，我們就不得不考慮它出現了的事實。',
                'display' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
