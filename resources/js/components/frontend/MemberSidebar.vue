<template>
    <div>
        <div class="member_nav_title">會員中心</div>

        <nav class="member_nav mb-5">
            <div class="member_nav_item">
                <router-link :to="{ name: 'memberData' }" class="member_nav_link">會員資料</router-link>
            </div>
            <div class="member_nav_item">
                <!-- <router-link :to="{ name: 'memberOrder' }" class="member_nav_link">訂單紀錄</router-link> -->
                <a href="member_order.php" class="member_nav_link">訂單紀錄</a>
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
        logout() {
            const vm = this;

            setCookie('member_token', '', 0);

            Swal.fire({
                icon: 'success',
                title: '登出成功',
                width: 300,
                timer: 1500,
                showConfirmButton: false,
                willClose: () => {
                    vm.$router.push({name: 'memberLogin'});
                },
            });
        }
    }
}
</script>