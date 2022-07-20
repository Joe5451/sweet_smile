<template>
    <div class="admin_sidebar" :class="{ hidden: !$store.state.admin_setting.sidebar_show }">
        <header class="admin_sidebar_header">後台管理系統</header>
        
        <nav class="admin_nav">
            <div class="admin_nav_item">
                <div class="admin_navi_dropdown_title">首頁 <i class="fas fa-angle-down"></i></div>
                <div class="admin_navi_dropdown_content">
                    <router-link class="admin_nav_sub_link" :to="{name: 'adminHomeSliderList'}">上方輪播列表</router-link>
                    <router-link class="admin_nav_sub_link" :to="{name: 'adminHomeSliderAdd'}">上方輪播新增</router-link>
                </div>
            </div>
            <div class="admin_nav_item">
                <router-link class="admin_nav_link" :to="{name: 'adminHeadImgList'}">上方大圖</router-link>
            </div>
            <div class="admin_nav_item">
                <router-link class="admin_nav_link" :to="{name: 'adminAbout'}">關於我們</router-link>
            </div>
            <div class="admin_nav_item">
                <div class="admin_navi_dropdown_title">最新消息 <i class="fas fa-angle-down"></i></div>
                <div class="admin_navi_dropdown_content">
                    <router-link class="admin_nav_sub_link" :to="{name: 'adminNewsList'}">最新消息列表</router-link>
                    <router-link class="admin_nav_sub_link" :to="{name: 'adminNewsAdd'}">最新消息新增</router-link>
                </div>
            </div>
            <div class="admin_nav_item">
                <div class="admin_navi_dropdown_title">會員管理 <i class="fas fa-angle-down"></i></div>
                <div class="admin_navi_dropdown_content">
                    <router-link class="admin_nav_sub_link" :to="{name: 'adminMemberList'}">會員列表</router-link>
                    <router-link class="admin_nav_sub_link" :to="{name: 'adminMemberAdd'}">會員新增</router-link>
                </div>
            </div>
            <div class="admin_nav_item">
                <div class="admin_navi_dropdown_title">商品管理 <i class="fas fa-angle-down"></i></div>
                <div class="admin_navi_dropdown_content">
                    <router-link class="admin_nav_sub_link" :to="{name: 'adminProductList'}">商品列表</router-link>
                    <router-link class="admin_nav_sub_link" :to="{name: 'adminProductAdd'}">商品新增</router-link>
                    <router-link class="admin_nav_sub_link" :to="{name: 'adminProductCategoryList'}">商品分類</router-link>
                    <router-link class="admin_nav_sub_link" :to="{name: 'adminProductCategoryAdd'}">商品分類新增</router-link>
                </div>
            </div>
            <div class="admin_nav_item">
                <router-link class="admin_nav_link" :to="{name: 'adminOrderList'}">訂單管理</router-link>
            </div>
            <div class="admin_nav_item">
                <router-link class="admin_nav_link" :to="{name: 'adminContactList'}">聯絡我們管理</router-link>
            </div>
        </nav>
    </div>
</template>

<script>
    export default {
        name: 'Sidebar',
        mounted() {
            const vm = this;

            vm.updateNavActive();

            $('.admin_nav_link, .admin_nav_sub_link').click(function() {
                vm.updateNavActive();
            });

            $('.admin_navi_dropdown_title').click(function() {
                $(this).toggleClass('active');
                $(this).next('.admin_navi_dropdown_content').stop().slideToggle();
            });
        },
        methods: {
            toggleDropdown() {
                
            },
            updateNavActive() {
                // $('.admin_navi_dropdown_content').hide();
                $('.admin_navi_dropdown_title').removeClass('admin_navi_dropdown_title_active');

                $('.admin_nav_sub_link.active').parents('.admin_nav_item').children('.admin_navi_dropdown_title')
                .addClass('admin_navi_dropdown_title_active active');

                $('.admin_navi_dropdown_title_active + .admin_navi_dropdown_content').show();
            }
        }
    }
</script>