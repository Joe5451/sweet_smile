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
    
                <input type="submit" value="登入" class="btn btn-primary w-100">
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'LoginForm',
        methods: {
            async login() {
                let account = $('input[name=account]').val();
                let password = $('input[name=password]').val();

                await this.$store.dispatch('admin_user/login', {account, password});
            }
        }
    }
</script>