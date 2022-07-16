<template>
    <div class="d-flex flex-column" style="height: 300px;">
        <div class="admin_title">歡迎</div>
        <div class="d-flex justify-content-center align-items-center flex-grow-1">
            <p class="text-black-50 fs-5 fw-bold">歡迎登入後台管理系統</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Welcome',
        mounted() {
            this.checkToken();
        },
        methods: {
            async checkToken() {
                const vm = this;
                let token = this.$store.state.admin_user.access_token;
        
                await axios.post('/admin/checkToken', {
                    token
                }).then(function (response) {
                    // console.log(response);
                    
                    if (response.data.status == 'success') {
                        // 
                    } else {
                        Qmsg.error('請重新登入', {
                            onClose() {
                                vm.$router.push({name: 'adminLogin'});
                            }
                        });
                    }
                });
            }
        }
    }
</script>