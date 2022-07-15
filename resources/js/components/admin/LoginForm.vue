<template>
    <div class="d-flex justify-content-center align-items-center vw-100 vh-100">
        <form @submit.prevent="login"  method="post" class="admin_login_form border rounded">
            <header class="fs-5 text-black-50 fw-bold text-center py-2 border-bottom">管理後台</header>

            <div class="p-4">
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="account" placeholder="帳號">
                </div>
    
                <div class="form-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="密碼">
                </div>
    
                <button class="btn btn-primary w-100" :disabled="isLoading">
                    <span v-if="!isLoading">登入</span>
                    <span v-else><i class="fas fa-spinner rotate-center"></i></span>
                </button>
                <!-- <input type="submit" value="登入" class="btn btn-primary w-100"> -->
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'LoginForm',
        data() {
            return {
                isLoading: false,
            }
        },
        methods: {
            async login() {
                const vm = this;
                let account = $('input[name=account]').val();
                let password = $('input[name=password]').val();

                vm.isLoading = true;

                await axios.post('/admin/login', {
                    account,
                    password
                }).then(async function (response) {
                    // console.log(response);
                    
                    if (response.data.status == 'success') {

                        await vm.$store.commit('admin_user/setToken', {
                            access_token: response.data.access_token,
                            expires_in: response.data.expires_in
                        });

                        Qmsg.success('登入成功', {
                            onClose() {
                                vm.$router.push({name: 'adminWelcome'});
                            }
                        });
                    } else if (response.data.status == 'fail') {
                        vm.isLoading = false;
                        Qmsg.error(response.data.message);
                    }
                });
            }
        }
    }
</script>