<template>
    <router-view></router-view>
</template>

<script>

export default {
    mounted() {
        this.checkToken();
    },
    methods: {
        checkToken() {
            const vm = this;
            const token = getCookie('member_token');

            if (token == '') {
                vm.$router.push({name: 'memberLogin'});
                
                Swal.fire({
                    icon: 'info',
                    title: '請登入會員',
                    timer: 1500,
                    showConfirmButton: false,
                });

                return;
            }
            
            axios.post('/members/checkToken', {
                token
            }).then(function (response) {
                if (response.data.status != 'success') {
                    vm.$router.push({name: 'memberLogin'});

                    Swal.fire({
                        icon: 'info',
                        title: '請登入會員',
                        timer: 1500,
                        showConfirmButton: false,
                    });
                }
            });
        }
    }
}
</script>