<template>
    <div class="admin_container" :class="{ extend: !$store.state.admin_setting.sidebar_show }">
        <!-- loading-spinner -->
        <div class="admin_loader_container" :class="{'d-none': !loading}">
            <admin-loader :loading="true" :color="'#36D7B7'" :size="15"></admin-loader>
        </div>
        
        <div @click="hideSidebar" class="admin_sidebar_close_mask" :class="{ show: $store.state.admin_setting.sidebar_show }"></div>

        <!-- 側邊欄 -->
        <admin-sidebar></admin-sidebar>

        <!-- 主要區域 -->
        <div class="admin_main">
            <!-- Header -->
            <admin-header></admin-header>

            <!-- 內容區域 -->
            <div class="admin_body py-5 px-3 px-md-5">
                <div class="bg-white rounded shadow px-3 px-sm-4 py-4 mx-auto" style="max-width: 1320px;">
                    <router-view :key="content_component_key"></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Dashboard',
        computed: {
            loading() {
                return this.$store.state.admin_setting.loading;
            },
            content_component_key() {
                return this.$store.state.admin_setting.content_component_key;
            }
        },
        data() {
            return {
                
            }
        },
        methods: {
            hideSidebar() {
                this.$store.commit('admin_setting/toggleSiderbar', false);

                // 由 vuex 管理 sidebar 展開收縮狀態
                // $('.admin_sidebar_close_mask').removeClass('show');
                // $('.admin_container').addClass('extend');
                // $('.admin_sidebar').addClass('hidden');
                // $('#toggle_sidebar_btn').addClass('reverse');
            }
        }
    }
</script>