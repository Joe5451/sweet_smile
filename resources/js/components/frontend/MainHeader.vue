<template>
    <header id="main_header">
        <div class="header_above">
            <div class="container-lg header_above_inner_container">
                <div class="header_menu_btn">
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
                    <a href="member_data.php" class="header_btn">
                        <i class="far fa-user"></i>
                    </a>
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
            <router-link :to="{name: 'newsList'}" class="header_nav_link">
                <span>最新消息</span>
            </router-link>
            <div class="header_nav_link">
                <span>購物商城</span>

                <ul class="header_nav_menu">
                    <li>
                        <span class="header_nav_menu_link">分類一</span>
                        
                        <div class="header_nav_sub_menu_wrap">
                            <ul class="header_nav_sub_menu">
                                <li>
                                    <a href="product_list.php">子分類1</a>
                                </li>
                                <li>
                                    <a href="product_list.php">子分類2</a>
                                </li>
                                <li>
                                    <a href="product_list.php">子分類3</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <span class="header_nav_menu_link">分類二</span>

                        <div class="header_nav_sub_menu_wrap">
                            <ul class="header_nav_sub_menu">
                                <li>
                                    <a href="product_list.php">子分類4</a>
                                </li>
                                <li>
                                    <a href="product_list.php">子分類5</a>
                                </li>
                                <li>
                                    <a href="product_list.php">子分類6</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <span class="header_nav_menu_link">分類三</span>

                        <div class="header_nav_sub_menu_wrap">
                            <ul class="header_nav_sub_menu">
                                <li>
                                    <a href="product_list.php">子分類7</a>
                                </li>
                                <li>
                                    <a href="product_list.php">子分類8</a>
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
            <router-link :to="{name: 'newsList'}" class="header_nav_link_mobile">
                <span>最新消息</span>
            </router-link>
            <div class="header_nav_link_mobile">
                <span class="header_nav_dropdown_title">購物商城 <i class="fas fa-angle-down"></i></span>

                <div class="header_nav_dropdown_content">
                    <div class="header_nav_sub_dropdown">
                        <div class="header_nav_sub_dropdown_title">分類一 <i class="fas fa-angle-down"></i></div>
                        <div class="header_nav_sub_dropdown_content">
                            <a href="product_list.php" class="header_nav_sub_dropdown_link">子分類1</a>
                            <a href="product_list.php" class="header_nav_sub_dropdown_link">子分類2</a>
                            <a href="product_list.php" class="header_nav_sub_dropdown_link">子分類3</a>
                        </div>
                    </div>

                    <div class="header_nav_sub_dropdown">
                        <div class="header_nav_sub_dropdown_title">分類二 <i class="fas fa-angle-down"></i></div>
                        <div class="header_nav_sub_dropdown_content">
                            <a href="product_list.php" class="header_nav_sub_dropdown_link">子分類4</a>
                            <a href="product_list.php" class="header_nav_sub_dropdown_link">子分類5</a>
                            <a href="product_list.php" class="header_nav_sub_dropdown_link">子分類6</a>
                        </div>
                    </div>

                    <div class="header_nav_sub_dropdown">
                        <div class="header_nav_sub_dropdown_title">分類三 <i class="fas fa-angle-down"></i></div>
                        <div class="header_nav_sub_dropdown_content">
                            <a href="product_list.php" class="header_nav_sub_dropdown_link">子分類7</a>
                            <a href="product_list.php" class="header_nav_sub_dropdown_link">子分類8</a>
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
        mounted() {
            $('.header_menu_btn').click(function() {
                $(this).toggleClass('active');
                $('.header_nav_mobile').stop().slideToggle(function() {$(this).css('height', 'inherit')});
            });
            
            $('.header_nav_dropdown_title').click(function() {
                let parent_element = $(this).parent('.header_nav_link_mobile');
                
                if (parent_element.hasClass('active')) {
                    parent_element.removeClass('active');
                    $(this).next('.header_nav_dropdown_content').stop().slideUp(function() {$(this).css('height', 'inherit')});
                    // $(this).next('.header_nav_dropdown_content').stop().slideUp();
                } else {
                    parent_element.addClass('active');
                    $(this).next('.header_nav_dropdown_content').stop().slideDown(function() {$(this).css('height', 'inherit')});
                    // $(this).next('.header_nav_dropdown_content').stop().slideDown();
                }
            });

            $('.header_nav_sub_dropdown_title').click(function() {
                let parent_element = $(this).parent('.header_nav_sub_dropdown');
                
                if (parent_element.hasClass('active')) {
                    parent_element.removeClass('active');
                    $(this).next('.header_nav_sub_dropdown_content').stop().slideUp();
                } else {
                    parent_element.addClass('active');
                    $(this).next('.header_nav_sub_dropdown_content').stop().slideDown();
                }
            });
        }
    }
</script>
