<template>
    <div>
        <div class="home_swiper swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide" v-for="slider in sliders" :key="slider.id">
                    <a :href="slider.link" class="home_swiper_link">
                        <img :src="slider.slider_img" class="home_swiper_img">
                    </a>
                </div>
            </div>

            <div class="home_swiper_pagination swiper-pagination"></div> 

            <div class="home_swiper_btn home_swiper_btn_prev">
                <i class="fas fa-chevron-left"></i>
            </div>
            <div class="home_swiper_btn home_swiper_btn_next">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>

        <section class="home_about_section">
            <div class="overflow-hidden">
                <div class="container">
                    <h2 class="home_about_title">關於我們</h2>
                </div>
            </div>

            <img src="img/snack7.png" class="home_about_snack_img1">
            <img src="img/snack12.png" class="home_about_snack_img2">
            <img src="img/snack6.png" class="home_about_snack_img3">

            <div class="container">
                <div class="home_about_content">在這裡有美國大分量的紙杯蛋糕、德國濃郁鄉村氣息的櫻桃黑森林蛋糕或是義大利無人不知的提拉米蘇，以及精緻又複雜的法式甜點

        我們將甜點與文化藝術品划上等號，讓你在每一個角落都能感受到五彩斑斕的甜點世界

        堅持手工製作，並採用健康、無添加的上等材料，新鮮製作甜點

        醉心於研究各種甜品，並在其中加入浪漫動人的元素，琳琅滿目的甜品閃耀著精緻誘人的光彩，讓你不禁陶醉其中

        找一個溫暖的下午，細細體會其中的美味，一起品嘗出這些甜點背後的文化與藝術，我們將帶給你視覺、味覺、嗅覺的極致體驗</div>

                <div class="d-flex justify-content-end">
                    <router-link :to="{name: 'about'}" class="more_btn">
                        <span>More</span>
                        <i class="fas fa-angle-double-right"></i>
                    </router-link>
                </div>
            </div>
        </section>

        <section class="home_product_section">
            <div class="container">
                <div class="home_section_title">熱賣商品</div>

                <div class="home_product_swiper swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="product.php" class="product_card">
                                <div class="product_card_img_wrap">
                                    <img src="img/banner1.jpg" class="product_card_img">
                                </div>
                                <div class="product_card_body">
                                    <div class="product_card_title">1.精選甜點禮盒(精選馬卡龍7份+斯里蘭卡紅茶500ml)</div>
                                    <div class="product_card_price_wrap">
                                        <div class="product_card_price del">$780</div>
                                        <div class="product_card_price">$690</div>
                                    </div>
                                    <button class="product_card_btn">加入購物車</button>
                                </div>
                            </a>
                        </div>

                        <div class="swiper-slide">
                            <a href="product.php" class="product_card">
                                <div class="product_card_img_wrap">
                                    <img src="img/banner1.jpg" class="product_card_img">
                                </div>
                                <div class="product_card_body">
                                    <div class="product_card_title">2.精選甜點禮盒(精選馬卡龍7份+斯里蘭卡紅茶500ml)</div>
                                    <div class="product_card_price_wrap">
                                        <div class="product_card_price del">$780</div>
                                        <div class="product_card_price">$690</div>
                                    </div>
                                    <button class="product_card_btn">加入購物車</button>
                                </div>
                            </a>
                        </div>

                        <div class="swiper-slide">
                            <a href="product.php" class="product_card">
                                <div class="product_card_img_wrap">
                                    <img src="img/banner1.jpg" class="product_card_img">
                                </div>
                                <div class="product_card_body">
                                    <div class="product_card_title">3.精選甜點禮盒(精選馬卡龍7份+斯里蘭卡紅茶500ml)</div>
                                    <div class="product_card_price_wrap">
                                        <div class="product_card_price del">$780</div>
                                        <div class="product_card_price">$690</div>
                                    </div>
                                    <button class="product_card_btn">加入購物車</button>
                                </div>
                            </a>
                        </div>
                        
                        <div class="swiper-slide">
                            <a href="product.php" class="product_card">
                                <div class="product_card_img_wrap">
                                    <img src="img/banner1.jpg" class="product_card_img">
                                </div>
                                <div class="product_card_body">
                                    <div class="product_card_title">4.精選甜點禮盒(精選馬卡龍7份+斯里蘭卡紅茶500ml)</div>
                                    <div class="product_card_price_wrap">
                                        <div class="product_card_price del">$780</div>
                                        <div class="product_card_price">$690</div>
                                    </div>
                                    <button class="product_card_btn">加入購物車</button>
                                </div>
                            </a>
                        </div>

                        <div class="swiper-slide">
                            <a href="product.php" class="product_card">
                                <div class="product_card_img_wrap">
                                    <img src="img/banner1.jpg" class="product_card_img">
                                </div>
                                <div class="product_card_body">
                                    <div class="product_card_title">5.精選甜點禮盒(精選馬卡龍7份+斯里蘭卡紅茶500ml)</div>
                                    <div class="product_card_price_wrap">
                                        <div class="product_card_price del">$780</div>
                                        <div class="product_card_price">$690</div>
                                    </div>
                                    <button class="product_card_btn">加入購物車</button>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- <div class="home_product_swiper_pagination swiper-pagination"></div> -->

                </div>
            </div>
        </section>

        <section class="home_news_section">
            <div class="container">
                <div class="home_section_title">最新消息</div>

                <div class="row">
                    <div class="col-md-6" v-for="new_data in news" :key="new_data.id">
                        <router-link class="news_list" :to="{name: 'news', params: { news_id: new_data.id }}">
                            <div class="news_list_img_wrap">
                                <img :src="new_data.cover_img" class="news_list_img">
                            </div>
                            <div class="news_list_content">
                                <div class="news_list_title">{{ new_data.title }}</div>
                                <div class="news_list_date">{{ new_data.date.replace(/-/g, '/') }}</div>
                                <div class="news_list_summary">{{ new_data.summary }}</div>
                                <div class="news_list_more">繼續閱讀</div>
                            </div>
                        </router-link>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <router-link :to="{name: 'newsList'}" class="more_btn">
                        <span>More</span>
                        <i class="fas fa-angle-double-right"></i>
                    </router-link>
                </div>
            </div>
        </section>

        <section class="home_intro_section">
            <div class="home_intro_bg"></div>

            <div class="d-flex justify-content-center">
                <h2 class="home_intro_title">不忘初心</h2>
            </div>

            <div class="home_intro_content">
                我們堅持健康、無添加<br>
                選用上等材料、新鮮製作<br>
                給客人最好的體驗
            </div>

            <div class="d-flex justify-content-center mt-4">
                <a href="product_list.php" class="home_intro_btn">
                    <img src="img/cake.png" class="home_intro_btn_img">
                    <span>前往購買</span>
                </a>
            </div>
        </section>
        
    </div>
</template>

<script>
    export default {
        name: 'Home',
        computed: {
            sliders() {
                return this.$store.state.home.home_slider;
            },
            news() {
                return this.$store.state.home.news;
            }
        },
        data() {
            return {
                home_swiper: null,
                product_swiper: null,
            }
        },
        updated() {
            const vm = this;

            // sliders 為空陣列時執行 new Swiper()，在有元素後 loop 不會如執行，只有在有元素時 (updated) 設定 loop
            vm.home_swiper.loopCreate();
            vm.product_swiper.loopCreate();
        },
        mounted() {
            const vm = this;

            vm.$store.dispatch('home/getHomeSlider');
            vm.$store.dispatch('home/getHomeNews');

            vm.home_swiper =  new Swiper('.home_swiper', {
                loop: true,
                pagination: {
                    el: '.home_swiper_pagination',
                    clickable: true, // 可點擊換頁
                    bulletClass: 'home_swiper_pagination_bullet', // 分頁按鈕 classname
                    bulletActiveClass: 'home_swiper_pagination_bullet_active', // 分頁按鈕 active classname
                },
                navigation: {
                    prevEl: '.home_swiper_btn_prev',
                    nextEl: '.home_swiper_btn_next',
                },
            });

            vm.product_swiper = new Swiper('.home_product_swiper', {
                loop: true,
                slidesPerView: 4,
                slidesPerGroup: 2,
                spaceBetween: 40,
                breakpoints: {
                    0: { //當螢幕寬度大於等於0
                        slidesPerView: 2,
                        slidesPerGroup: 2,
                        spaceBetween: 20,
                    },
                    768: { //當螢幕寬度大於等於768
                        slidesPerView: 3,
                        slidesPerGroup: 3,
                        spaceBetween: 25
                    },
                    992: { //當螢幕寬度大於等於992
                        slidesPerView: 4,
                        slidesPerGroup: 2,
                        spaceBetween: 40
                    },
                }
            });
        },
        methods: {
            
        }
    }
</script>