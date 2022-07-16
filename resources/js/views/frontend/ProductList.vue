<template>
    <div>
        <div class="page_banner" :style="{'backgroundImage': 'url(' + head_img + ')'}">
            <div class="page_banner_title">購物商城</div>
        </div>

        <div class="container mb-80px">
            <div class="row">
                <div class="col-lg-3">
                    <nav class="product_nav d-none d-lg-block">
                        <div class="product_nav_dropdown"
                            v-for="product_category in product_categories"
                            :key="product_category.product_category_id">
                            <div class="product_navi_dropdown_title">
                                {{ product_category.category_name }}<i class="fas fa-angle-down"></i>
                            </div>
                            <div class="product_navi_dropdown_content">
                                <router-link class="product_navi_dropdown_link"
                                    v-for="product_subcategory in product_category.enabled_product_subcategories"
                                    :key="product_subcategory.product_subcategory_id"
                                    :to="{ name: 'productList', params: {subcategory_id: product_subcategory.product_subcategory_id} }">
                                    {{ product_subcategory.subcategory_name }}
                                </router-link>
                            </div>
                        </div>
                    </nav>
                </div>

                <div class="col-lg-9">
                    <div class="product_list_head">
                        <div class="product_list_title">子分類1</div>
                    </div>

                    <div class="row mb-5">
                    
                        <div class="col-6 col-md-4 mb-3">
                            <a href="#" class="product_card">
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

                    </div>

                    <div class="d-flex justify-content-center">
                        <ul class="pagination custom_pagination flex-wrap mb-4">
                            <li class="page-item m-1">
                                <a class="page-link rounded" href="#" aria-label="Previous">
                                    <i class="fas fa-angle-left"></i>
                                </a>
                            </li>
            
                            <li class="page-item m-1 active"><a class="page-link rounded" href="#">1</a></li>
                            <li class="page-item m-1"><a class="page-link rounded" href="#">2</a></li>
                            <li class="page-item m-1"><a class="page-link rounded" href="#">3</a></li>

                            <li class="page-item m-1">
                                <a class="page-link rounded" href="#" aria-label="Next">
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        head_img() {
            return this.$store.state.app.head_img.shopping_mall;
        },
        product_categories() {
            return this.$store.state.app.product_categories;
        }
    },
    destroyed() {
        this.$store.commit('app/setCurrentPage', '');
    },
    updated() {
        // $('.product_navi_dropdown_link.active').parent('.product_navi_dropdown_content').show();
        // $('.product_navi_dropdown_link.active').parents('.product_nav_dropdown')
        // .children('.product_navi_dropdown_title').addClass('active');
    },
    mounted() {
        this.$store.commit('app/setCurrentPage', 'shopping_mall');

        $('.product_navi_dropdown_link.active').parent('.product_navi_dropdown_content').show();
        $('.product_navi_dropdown_link.active').parents('.product_nav_dropdown')
        .children('.product_navi_dropdown_title').addClass('active');

        $('.product_navi_dropdown_title').click(function() {
            $(this).toggleClass('active');
            $(this).next('.product_navi_dropdown_content').stop().slideToggle();
        });
    }
}
</script>