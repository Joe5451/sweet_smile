<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $test_content = <<<Content
        <h2 class="l-section-title" style="-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border:0px;box-sizing:border-box;color:rgb(33, 37, 41);font-family:&quot;Microsoft JhengHei&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;font-size:1.75rem;font-stretch:inherit;font-style:normal;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-weight:500;letter-spacing:normal;line-height:1.2;margin:0px 0px 30px;orphans:2;padding:0px 0px 1rem;position:relative;text-align:center;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;" data-v-e045c05c=""><strong>關於我們</strong></h2><figure class="image image-style-side"><img src="img/banner6.png"></figure><p style="-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border:0px;box-sizing:border-box;color:rgb(33, 37, 41);font-family:&quot;Microsoft JhengHei&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;font-size:20px;font-stretch:inherit;font-style:normal;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-weight:400;letter-spacing:normal;line-height:inherit;margin:0px 0px 1rem;orphans:2;padding:0px;text-align:left;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;" data-v-e045c05c="">在這裡有美國大分量的紙杯蛋糕、德國濃郁鄉村氣息的櫻桃黑森林蛋糕或是義大利無人不知的提拉米蘇，以及精緻又複雜的法式甜點</p><p style="-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border:0px;box-sizing:border-box;color:rgb(33, 37, 41);font-family:&quot;Microsoft JhengHei&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;font-size:20px;font-stretch:inherit;font-style:normal;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-weight:400;letter-spacing:normal;line-height:inherit;margin:0px 0px 1rem;orphans:2;padding:0px;text-align:left;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;" data-v-e045c05c="">我們將甜點與文化藝術品划上等號，讓你在每一個角落都能感受到五彩斑斕的甜點世界</p><p style="-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border:0px;box-sizing:border-box;color:rgb(33, 37, 41);font-family:&quot;Microsoft JhengHei&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;font-size:20px;font-stretch:inherit;font-style:normal;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-weight:400;letter-spacing:normal;line-height:inherit;margin:0px 0px 1rem;orphans:2;padding:0px;text-align:left;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;" data-v-e045c05c="">堅持手工製作，並採用健康、無添加的上等材料，新鮮製作甜點</p><p style="-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border:0px;box-sizing:border-box;color:rgb(33, 37, 41);font-family:&quot;Microsoft JhengHei&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;font-size:20px;font-stretch:inherit;font-style:normal;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-weight:400;letter-spacing:normal;line-height:inherit;margin:0px 0px 1rem;orphans:2;padding:0px;text-align:left;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;" data-v-e045c05c="">醉心於研究各種甜品，並在其中加入浪漫動人的元素，琳琅滿目的甜品閃耀著精緻誘人的光彩，讓你不禁陶醉其中</p><p style="-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border:0px;box-sizing:border-box;color:rgb(33, 37, 41);font-family:&quot;Microsoft JhengHei&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;font-size:20px;font-stretch:inherit;font-style:normal;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-weight:400;letter-spacing:normal;line-height:inherit;margin:0px 0px 1rem;orphans:2;padding:0px;text-align:left;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;" data-v-e045c05c="">找一個溫暖的下午，細細體會其中的美味，一起品嘗出這些甜點背後的文化與藝術，我們將帶給你視覺、味覺、嗅覺的極致體驗。</p><figure class="table"><table style="margin-top:40px;"><thead><tr><th style="text-align:center;">🌿 新鮮自然</th><th style="text-align:center;">🥛 最佳配方</th><th style="text-align:center;">✨ 全新創造</th></tr></thead><tbody><tr><td>我們本著用心、真心、良心的態度來製作出健康美味的甜點，替顧客挑選新鮮自然的原料，為你的健康做把關</td><td>經過多次嘗試，搭配出最好的配方，材料間完美平衡，並且兼顧品質、細緻、藝術為一體，將每個細節做到最好</td><td>研究各種甜品，並在其中加入浪漫動人的元素，創造風格鮮明、讓人耳目一新，專屬於我們的精品甜點</td></tr></tbody></table></figure><h4 style="-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border:0px;box-sizing:border-box;color:rgb(33, 37, 41);font-family:&quot;Microsoft JhengHei&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;font-size:1.5rem;font-stretch:inherit;font-style:normal;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-weight:500;letter-spacing:normal;line-height:1.2;margin:0px 0px 0.5rem;orphans:2;padding:0px;text-align:center;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;" data-v-e045c05c="">&nbsp;</h4><p style="-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border:0px;box-sizing:border-box;color:rgb(33, 37, 41);font-family:&quot;Microsoft JhengHei&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;font-size:1.5rem;font-stretch:inherit;font-style:normal;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-weight:500;letter-spacing:normal;line-height:1.2;margin:0px 0px 0.5rem;orphans:2;padding:0px;text-align:center;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;" data-v-e045c05c="">&nbsp;</p><figure class="image image_resized" style="width:49.59%;"><img class="image" src="img/banner8.jpg"></figure><h4 style="-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border:0px;box-sizing:border-box;color:rgb(33, 37, 41);font-family:&quot;Microsoft JhengHei&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;font-size:1.5rem;font-stretch:inherit;font-style:normal;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-weight:500;letter-spacing:normal;line-height:1.2;margin:0px 0px 0.5rem;orphans:2;padding:0px;text-align:center;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;" data-v-e045c05c="">享受美好下午茶時光</h4><p class="mt-3 text-secondary" style="-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border:0px;box-sizing:border-box;color:rgb(108, 117, 125) !important;font-family:&quot;Microsoft JhengHei&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;font-size:16px;font-stretch:inherit;font-style:normal;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-weight:400;letter-spacing:normal;line-height:inherit;margin-bottom:1rem;margin-left:0px;margin-right:0px;margin-top:1rem !important;orphans:2;padding:0px;text-align:center;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;" data-v-e045c05c=""><span style="-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);color:rgb(108, 117, 125);display:inline !important;float:none;font-family:&quot;Microsoft JhengHei&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;font-size:16px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;orphans:2;text-align:center;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;">繁忙的生活中，給自己紓壓的時間，在寧靜輕鬆的空間享受咖啡、甜點！</span></p><p>&nbsp;</p><p class="mt-3 text-secondary" style="-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border:0px;box-sizing:border-box;color:rgb(108, 117, 125) !important;font-family:&quot;Microsoft JhengHei&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;font-size:16px;font-stretch:inherit;font-style:normal;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-weight:400;letter-spacing:normal;line-height:inherit;margin-bottom:1rem;margin-left:0px;margin-right:0px;margin-top:1rem !important;orphans:2;padding:0px;text-align:center;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;" data-v-e045c05c="">&nbsp;</p><figure class="image image_resized" style="width:50.25%;"><img class="image image_resized" src="img/banner3.jpg"></figure><h4 style="-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border:0px;box-sizing:border-box;color:rgb(33, 37, 41);font-family:&quot;Microsoft JhengHei&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;font-size:1.5rem;font-stretch:inherit;font-style:normal;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-weight:500;letter-spacing:normal;line-height:1.2;margin:0px 0px 0.5rem;orphans:2;padding:0px;text-align:center;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;" data-v-e045c05c="">探索甜點世界</h4><p class="mt-3 text-secondary" style="-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border:0px;box-sizing:border-box;color:rgb(108, 117, 125) !important;font-family:&quot;Microsoft JhengHei&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;font-size:16px;font-stretch:inherit;font-style:normal;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-weight:400;letter-spacing:normal;line-height:inherit;margin-bottom:1rem;margin-left:0px;margin-right:0px;margin-top:1rem !important;orphans:2;padding:0px;text-align:center;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;" data-v-e045c05c="">一起享受令人著迷的滋味，讓人愛不釋口的美味點心，愈吃愈上癮！</p><p class="mt-3 text-secondary" style="-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border:0px;box-sizing:border-box;color:rgb(108, 117, 125) !important;font-family:&quot;Microsoft JhengHei&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;font-size:16px;font-stretch:inherit;font-style:normal;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-weight:400;letter-spacing:normal;line-height:inherit;margin-bottom:1rem;margin-left:0px;margin-right:0px;margin-top:1rem !important;orphans:2;padding:0px;text-align:center;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;" data-v-e045c05c="">&nbsp;</p>
Content;

        DB::table('pages')->insert([
            [
                'id' => 1,
                'page_name' => '關於我們',
                'content' => $test_content,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // [
            //     'id' => 2,
            //     'page_name' => '聯絡我們',
            //     'content' => null,
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s')
            // ],
        ]);
    }
}
