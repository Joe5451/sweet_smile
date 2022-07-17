<template>
    <header id="main_header">
        <div class="header_above">
            <div class="container-lg header_above_inner_container">
                <div class="header_menu_btn" @click="showHeaderMobileMenu">
                    <svg class="ham hamRotate" viewBox="0 0 100 100" width="50">
                        <path class="line top" d="m 70,33 h -40 c 0,0 -8.5,-0.149796 -8.5,8.5 0,8.649796 8.5,8.5 8.5,8.5 h 20 v -20" />
                        <path class="line middle" d="m 70,50 h -40" />
                        <path class="line bottom" d="m 30,67 h 40 c 0,0 8.5,0.149796 8.5,-8.5 0,-8.649796 -8.5,-8.5 -8.5,-8.5 h -20 v 20" />
                    </svg>
                </div>
                
                <router-link :to="{name: 'home'}">
                    <img src="img/logo_b.svg" class="header_logo">
                </router-link>

                <div class="header_btn_group">
                    <router-link :to="{name: 'memberLogin'}" class="header_btn">
                        <i class="far fa-user"></i>
                    </router-link>
                    <router-link :to="{name: 'cart'}" class="header_btn">
                        <i class="fas fa-shopping-cart"></i>
                        <div class="header_btn_cart_qty">0</div>
                    </router-link>
                </div>
            </div>
        </div>
        <nav class="header_nav">
            <router-link :to="{name: 'home'}" exact class="header_nav_link">
                <span>首頁</span>
            </router-link>
            <router-link :to="{name: 'about'}" class="header_nav_link">
                <span>關於我們</span>
            </router-link>
            <router-link :to="{name: 'newsList'}" class="header_nav_link"
                :class="{active: current_page == 'news'}">
                <span>最新消息</span>
            </router-link>
            <div class="header_nav_link"
                :class="{active: current_page == 'shopping_mall'}">
                <span>購物商城</span>

                <ul class="header_nav_menu">
                    <div class="d-flex justify-content-center align-items-center p-3 ps-4 rounded-3" style="background: rgba(255, 255, 255, 0.8);" v-if="product_categories.length == 0">
                        <data-loader :loading="true" :color="'#BDBDBD'" :height="10"></data-loader>
                    </div>
                    
                    <li v-else v-for="product_category in product_categories"
                        :key="product_category.product_category_id">
                        <span class="header_nav_menu_link">{{ product_category.category_name }}</span>
                        
                        <div class="header_nav_sub_menu_wrap">
                            <ul class="header_nav_sub_menu">
                                <li v-for="product_subcategory in product_category.enabled_product_subcategories"
                                :key="product_subcategory.product_subcategory_id">
                                    <router-link :to="{ name: 'productList', params: {subcategory_id: product_subcategory.product_subcategory_id} }">
                                        {{ product_subcategory.subcategory_name }}
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>

            <router-link :to="{name: 'contact'}" class="header_nav_link">
                <span>聯絡我們</span>
            </router-link>
        </nav>

        <nav class="header_nav_mobile">
            <router-link :to="{name: 'home'}" exact class="header_nav_link_mobile">
                <span>首頁</span>
            </router-link>
            <router-link :to="{name: 'about'}" class="header_nav_link_mobile">
                <span>關於我們</span>
            </router-link>
            <router-link :to="{name: 'newsList'}" class="header_nav_link_mobile"
                :class="{active: current_page == 'news'}">
                <span>最新消息</span>
            </router-link>
            <div class="header_nav_link_mobile">
                <span class="header_nav_dropdown_title" @click="showProductCategoryMenu">購物商城 <i class="fas fa-angle-down"></i></span>

                <div class="header_nav_dropdown_content">
                    <div class="d-flex justify-content-center align-items-center p-3" v-if="product_categories.length == 0">
                        <data-loader :loading="true" :color="'#BDBDBD'" :height="10"></data-loader>
                    </div>
                    
                    <div class="header_nav_sub_dropdown" v-else
                        v-for="product_category in product_categories"
                        :key="product_category.product_category_id">
                        <div class="header_nav_sub_dropdown_title" @click="showProductSubcategoryMenu">
                            {{ product_category.category_name }}
                            <i class="fas fa-angle-down"></i>
                        </div>
                        <div class="header_nav_sub_dropdown_content">
                            <router-link class="header_nav_sub_dropdown_link"
                                :to="{ name: 'productList', params: {subcategory_id: product_subcategory.product_subcategory_id} }"
                                v-for="product_subcategory in product_category.enabled_product_subcategories"
                                :key="product_subcategory.product_subcategory_id">
                                {{ product_subcategory.subcategory_name }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
            <router-link :to="{name: 'contact'}" class="header_nav_link_mobile">
                <span>聯絡我們</span>
            </router-link>
        </nav>
    </header>
</template>

<script>
    export default {
        computed: {
            product_categories() {
                return this.$store.state.app.product_categories;
            },
            current_page() {
                return this.$store.state.app.current_page;
            }
        },
        methods: {
            showProductSubcategoryMenu(e) {
                const dispatch_element = $(e.currentTarget);
                const parent_element = dispatch_element.parent('.header_nav_sub_dropdown');
                
                if (parent_element.hasClass('active')) {
                    parent_element.removeClass('active');
                    dispatch_element.next('.header_nav_sub_dropdown_content').stop().slideUp();
                } else {
                    parent_element.addClass('active');
                    dispatch_element.next('.header_nav_sub_dropdown_content').stop().slideDown();
                }
            },
            showHeaderMobileMenu(e) {
                const dispatch_element = $(e.currentTarget);

                dispatch_element.toggleClass('active');
                $('.header_nav_mobile').stop().slideToggle(function() {$(this).css('height', 'inherit')});
            },
            showProductCategoryMenu(e) {
                const dispatch_element = $(e.currentTarget);
                const parent_element = dispatch_element.parent('.header_nav_link_mobile');

                if (parent_element.hasClass('active')) {
                    parent_element.removeClass('active');
                    dispatch_element.next('.header_nav_dropdown_content').stop().slideUp(function() {$(this).css('height', 'inherit')});
                } else {
                    parent_element.addClass('active');
                    dispatch_element.next('.header_nav_dropdown_content').stop().slideDown(function() {$(this).css('height', 'inherit')});
                }
            }
        },
        mounted() {
            
        }
    }
</script>
