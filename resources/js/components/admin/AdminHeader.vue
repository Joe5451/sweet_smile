<template>
    <header class="d-flex bg-white shadow-sm w-100">
        <button @click="toggleSideBar" id="toggle_sidebar_btn" :class="{ reverse: !$store.state.admin_setting.sidebar_show }" class="btn admin_header_btn border-end">
            <i class="fas fa-angle-double-left"></i>
        </button>

        <button class="btn admin_header_btn border-start ms-auto">
            <i class="fas fa-sign-out-alt"></i>
            登出
        </button>
    </header>
</template>

<script>
    export default {
        name: 'AdminHeader',
        methods: {
            toggleSideBar() {
                let current_sidebar_show = this.$store.state.admin_setting.sidebar_show;

                this.$store.commit('admin_setting/toggleSiderbar', !current_sidebar_show);
                
                // 由 vuex 管理 sidebar 展開收縮狀態
                // $('#toggle_sidebar_btn').toggleClass('reverse');
                // $('.admin_container').toggleClass('extend');
                // $('.admin_sidebar').toggleClass('hidden');
                // $('.admin_sidebar_close_mask').toggleClass('show');
            }
        }
    }
</script>