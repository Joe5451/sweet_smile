<template>
    <div>
        <div class="member_nav_title">會員中心</div>

        <nav class="member_nav mb-5">
            <div class="member_nav_item">
                <router-link :to="{ name: 'memberData' }" class="member_nav_link">會員資料</router-link>
            </div>
            <div class="member_nav_item">
                <router-link :to="{ name: 'memberOrderList' }" class="member_nav_link" :class="{ active: $store.state.order.is_order_page }">訂單紀錄</router-link>
            </div>
            <div class="member_nav_item">
                <a @click="logout" class="member_nav_link" style="cursor:pointer;">會員登出</a>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    methods: {
        async logout() {
            const vm = this;

            await vm.$store.dispatch('member/logout');
        }
    }
}
</script>