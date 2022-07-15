<template>
    <div>
        <div class="admin_title">會員新增</div>

        <form @submit.prevent="checkForm">
            <div class="mb-4">
                <label class="form-label">姓名*</label>
                <input type="text" name="name" v-model="name" class="form-control">
                <!-- <input type="text" name="name" v-model="name" @focusout="checkData($event, name)" class="form-control" required> -->
                <div class="invalid-feedback"></div>
            </div>
            
            <div class="mb-4">
                <label class="form-label">帳號*</label>
                <input type="text" name="account" v-model="account" class="form-control">
                <!-- <input type="text" name="account" v-model="account" @focusout="checkData($event, account)" class="form-control" required> -->
                <div class="invalid-feedback"></div>
            </div>

            <div class="mb-4">
                <label class="form-label">手機</label>
                <input type="text" name="mobile" v-model="mobile" class="form-control">
                <!-- <input type="text" name="mobile" v-model="mobile" @focusout="checkData($event, mobile)" class="form-control"> -->
                <div class="invalid-feedback"></div>
            </div>

            <div class="mb-4">
                <label class="form-label">密碼*</label>
                <input type="password" name="password" v-model="password" class="form-control">
                <!-- <input type="password" name="password" v-model="password" @focusout="checkData($event, password)" class="form-control" required> -->
                <div class="invalid-feedback"></div>
            </div>

            <div class="mb-4">
                <label class="form-label">確認密碼*</label>
                <input type="password" name="confirm_password" v-model="confirm_password" class="form-control">
                <!-- <input type="text" name="confirm_password" v-model="confirm_password" @focusout="checkData($event, confirm_password)" class="form-control" required> -->
                <div class="invalid-feedback"></div>
            </div>

            <div class="d-flex justify-content-between py-3">
                <button class="btn btn-primary">新增</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'MemberAddEdit',
        data() {
            return {
                name: '',
                mobile: '',
                account: '',
                password: '',
                confirm_password: '',
                // field_ch: {
                //     name: '姓名',
                //     mobile: '手機',
                //     account: '帳號',
                //     password: '密碼',
                //     confirm_password: '確認密碼',
                // }
            }
        },
        methods: {
            // checkData(e, value) {
            //     let element = $(e.target);
            //     let required = element.prop('required');
            //     let field_ch = this.field_ch[element.attr('name')];

            //     // 檢查必填
            //     if (required && value == '') {
            //         element.addClass('is-invalid');
            //         element.next('.invalid-feedback').text('請輸入' + field_ch);
            //     } else {
            //         element.removeClass('is-invalid');
            //     }
            // },
            async checkForm() {
                const vm = this;

                $('input').removeClass('is-invalid');
                $('input').next('.invalid-feedback').text('');
                
                if (this.name == '')
                    this.alertInvalidMessage($('input[name=name]'), '請輸入姓名');
                else if (this.account == '')
                    this.alertInvalidMessage($('input[name=account]'), '請輸入帳號');
                else if (this.password == '')
                    this.alertInvalidMessage($('input[name=password]'), '請輸入密碼');
                else if (this.confirm_password == '')
                    this.alertInvalidMessage($('input[name=confirm_password]'), '請輸入再次確認密碼');
                else if (this.password != this.confirm_password)
                    this.alertInvalidMessage($('input[name=confirm_password]'), '確認密碼不一致');
                else {
                    vm.$store.commit('admin_setting/showLoading');
                    
                    await axios.post('/admin/members', {
                        account: vm.account,
                        name: vm.name,
                        mobile: vm.mobile,
                        password: vm.password,
                    }, {
                        headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                    })
                    .then(function (response) {
                        vm.$store.commit('admin_setting/hideLoading');

                        if (response.data.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: '會員新增成功',
                                timer: 1500,
                                showConfirmButton: false,
                                willClose: () => {
                                    vm.$router.push({name: 'adminMemberList'});
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
                        vm.$store.commit('admin_setting/hideLoading');
                        console.error("Error: ", error);
                    });
                    
                }
            },
            alertInvalidMessage(element, invalid_message) {
                element.addClass('is-invalid');
                element.next('.invalid-feedback').text(invalid_message);

                // 移至元素位置
                let contentTop = element.offset().top - 120;

                $([document.documentElement, document.body]).animate({
                    scrollTop: contentTop
                }, 800, 'swing', function() {
                    element.focus();
                });
            }
        }
    }
</script>