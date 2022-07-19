<template>
    <div>
        <div class="page_banner" :style="{'backgroundImage': 'url(' + head_img + ')'}">
            <div class="page_banner_title">會員中心</div>
        </div>

        <div class="container mb-80px">
            <div class="border rounded-3 py-5 px-3">
                <div class="page_title">登入會員</div>

                <form @submit.prevent="checkForm" class="mx-auto px-3" style="max-width: 400px;">
                    <div class="mb-4">
                        <label class="form-label fw-bold">帳號 (Email)</label>
                        <input type="email" name="email" v-model="email" class="form-control" placeholder="請輸入您的 Email">
                        <div class="invalid-feedback"></div>
                    </div>
            
                    <div class="mb-4">
                        <label class="form-label fw-bold">密碼</label>
                        <input type="password" name="password" v-model="password" class="form-control" placeholder="請輸入您的密碼">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="d-flex justify-content-end mt-3 fw-bold">
                        <router-link :to="{ name: 'memberSignup' }">註冊新會員</router-link>
                    </div>

                    <div class="d-flex justify-content-center mt-5">
                        <button class="submit_btn fw-bold" :disabled="is_loading">
                            <span v-if="is_loading"><i class="fas fa-spinner rotate-center"></i></span>
                            <span v-else>登入</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        head_img() {
            return this.$store.state.app.head_img.member;
        }
    },
    data() {
        return {
            email: '',
            password: '',
            is_loading: false
        }
    },
    methods: {
        checkForm() {
            const vm = this;

            $('input').removeClass('is-invalid');
            $('input').next('.invalid-feedback').text('');
            
            if (this.email == '')
                this.alertMessage($('input[name=email]'), '請輸入帳號 (Email)');
            else if (this.password == '')
                this.alertMessage($('input[name=password]'), '請輸入密碼');
            else {
                this.login();
            }
        },
        async login() {
            const vm = this;

            vm.is_loading = true;
            await vm.$store.dispatch('member/login', {email: this.email, password: this.password});
            vm.is_loading = false;

            // await axios.post('/login', {
            //     email: vm.email,
            //     password: vm.password
            // })
            // .then(function (response) {
            //     console.log(response);

            //     if (response.data.status == 'success') {
            //         setCookie('member_token', response.data.access_token, 1);

            //         Swal.fire({
            //             icon: 'success',
            //             title: '登入成功',
            //             width: 300,
            //             timer: 1500,
            //             showConfirmButton: false,
            //             willClose: () => {
            //                 vm.$router.push({name: 'memberData'});
            //             },
            //         });
            //     } else if (response.data.status == 'fail') {
            //         Swal.fire({
            //             icon: 'warning',
            //             title: response.data.message,
            //             timer: 1500,
            //         });
            //     }
            // })
            // .catch(function(error) {
            //     console.error("Error: ", error);
            // });

            // vm.is_loading = false;
        },
        alertMessage(element, invalid_message) {
            element.addClass('is-invalid');
            element.next('.invalid-feedback').text(invalid_message);
        }
    }
}
</script>