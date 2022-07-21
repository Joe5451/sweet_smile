<template>
    <div>
        <div class="page_banner" :style="{'backgroundImage': 'url(' + head_img + ')'}">
            <div class="page_banner_title">會員中心</div>
        </div>

        <div class="container mb-80px">
            <div class="border rounded-3 py-5 px-3">
                <div class="page_title">註冊會員</div>

                <form @submit.prevent="checkForm" class="mx-auto px-3" style="max-width: 400px;">
                    <div class="d-flex justify-content-center mb-4 fw-bold">
                        已經是會員了? <router-link :to="{ name: 'memberLogin' }" class="ms-2">登入會員</router-link>
                    </div>
                
                    <div class="mb-4">
                        <label class="form-label fw-bold">姓名*</label>
                        <input type="text" name="name" v-model="name" class="form-control" placeholder="請輸入您的姓名">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">帳號 (Email)*</label>
                        <input type="email" name="email" v-model="email" class="form-control" placeholder="請輸入您的 Email">
                        <div class="invalid-feedback"></div>
                    </div>
            
                    <div class="mb-4">
                        <label class="form-label fw-bold">手機</label>
                        <input type="text" name="mobile" v-model="mobile" class="form-control" placeholder="請輸入您的手機">
                        <div class="invalid-feedback"></div>
                    </div>
            
                    <div class="mb-4">
                        <label class="form-label fw-bold">密碼*</label>
                        <input type="password" name="password" v-model="password" class="form-control" placeholder="請輸入您的密碼">
                        <div class="invalid-feedback"></div>
                    </div>
            
                    <div class="mb-4">
                        <label class="form-label fw-bold">確認密碼*</label>
                        <input type="password" name="confirm_password" v-model="confirm_password" class="form-control" placeholder="請再次輸入您的密碼">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="d-flex justify-content-center mt-5">
                        <button class="submit_btn fw-bold">註冊</button>
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
            name: '',
            mobile: '',
            email: '',
            password: '',
            confirm_password: ''
        }
    },
    methods: {
        checkForm() {
            const vm = this;

            $('input').removeClass('is-invalid');
            $('input').next('.invalid-feedback').text('');
            
            if (this.name == '')
                this.alertInvalidMessage($('input[name=name]'), '請輸入姓名');
            else if (this.email == '')
                this.alertInvalidMessage($('input[name=email]'), '請輸入帳號 (Email)');
            else if (this.password == '')
                this.alertInvalidMessage($('input[name=password]'), '請輸入密碼');
            else if (this.confirm_password == '')
                this.alertInvalidMessage($('input[name=confirm_password]'), '請輸入再次確認密碼');
            else if (this.password != this.confirm_password)
                this.alertInvalidMessage($('input[name=confirm_password]'), '確認密碼不一致');
            else {
                this.createMember();
            }
        },
        async createMember() {
            const vm = this;

            vm.$store.commit('app/showLoading');
                
            await axios.post('/members', {
                email: vm.email,
                name: vm.name,
                mobile: vm.mobile,
                password: vm.password,
            })
            .then(function (response) {
                // console.log(response);

                if (response.data.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: '會員新增成功',
                        timer: 1500,
                        showConfirmButton: false,
                        willClose: () => {
                            vm.$router.push({name: 'memberLogin'});
                        },
                    });
                } else if (response.data.status == 'fail') {
                    Swal.fire({
                        icon: 'warning',
                        title: response.data.message,
                        timer: 1500,
                    });
                }
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });

            vm.$store.commit('app/hideLoading');
        },
        alertInvalidMessage(element, invalid_message) {
            element.addClass('is-invalid');
            element.next('.invalid-feedback').text(invalid_message);

            // 移至元素位置
            let contentTop = element.offset().top - 160;

            $([document.documentElement, document.body]).animate({
                scrollTop: contentTop
            }, 800, 'swing', function() {
                element.focus();
            });
        }
    }
}
</script>