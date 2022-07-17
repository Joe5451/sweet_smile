<template>
    <div>
        <div class="page_banner" :style="{'backgroundImage': 'url(' + head_img + ')'}">
            <div class="page_banner_title">會員中心</div>
        </div>

        <div class="container mb-80px">
            <div class="row">
                <div class="col-lg-3">
                    <member-sidebar></member-sidebar>
                </div>

                <div class="col-lg-9">
                    <div class="border rounded-3 py-5 px-sm-3 mx-auto" style="max-width: 800px;">
                        <div class="page_title">會員資料</div>

                        <div class="d-flex justify-content-center align-items-center p-3" style="height:200px;" v-if="member === null">
                            <i class="fas fa-spinner rotate-center" style="font-size:40px;color:#565656;"></i>
                        </div>
                
                        <form @submit.prevent="checkForm" class="mx-auto px-3" style="max-width: 400px;" v-else>
                            <div class="mb-4">
                                <label class="form-label fw-bold">姓名*</label>
                                <input type="text" name="name" v-model="name" class="form-control" placeholder="請輸入您的姓名">
                                <div class="invalid-feedback"></div>
                            </div>
                
                            <div class="mb-4">
                                <label class="form-label fw-bold">帳號 (Email)</label>
                                <input type="email" v-model="email" class="form-control" placeholder="請輸入您的 Email" disabled>
                                <div class="invalid-feedback"></div>
                            </div>
                    
                            <div class="mb-4">
                                <label class="form-label fw-bold">手機</label>
                                <input type="text" name="mobile" v-model="mobile" class="form-control" placeholder="請輸入您的手機">
                                <div class="invalid-feedback"></div>
                            </div>
                    
                            <div class="mb-4">
                                <label class="form-label fw-bold">密碼</label>
                                <input type="password" name="password" v-model="password" class="form-control" placeholder="若不更改請空白">
                                <div class="invalid-feedback"></div>
                            </div>
                
                            <div class="d-flex justify-content-center mt-5">
                                <button class="submit_btn fw-bold" :disabled="is_loading">
                                    <span v-if="is_loading"><i class="fas fa-spinner rotate-center"></i></span>
                                    <span v-else>更新</span>
                                </button>
                            </div>
                        </form>
                    </div>         
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    computed: {
        head_img() {
            return this.$store.state.app.head_img.member;
        },
        member() {
            return this.$store.state.member.member;
        }
    },
    watch: {
        member(new_value, old_value) {
            if (new_value !== null) {
                this.name = new_value.name;
                this.email = new_value.email;
                this.mobile = new_value.mobile;
                this.password = '';
            }
        }
    },
    data() {
        return {
            name: '',
            mobile: '',
            email: '',
            password: '',
            is_loading: false
        }
    },
    mounted() {
        this.$store.dispatch('member/getMember');
    },
    destroyed() {
        this.$store.commit('member/setMember', null);
    },
    methods: {
        checkForm() {
            const vm = this;

            $('input').removeClass('is-invalid');
            $('input').next('.invalid-feedback').text('');
            
            if (this.name == '')
                this.alertInvalidMessage($('input[name=name]'), '請輸入姓名');
            else {
                this.updateMember();
            }
        },
        async updateMember() {
            const vm = this;
            const token = getCookie('member_token');

            vm.is_loading = true;

            await axios.put('/members', {
                name: this.name,
                mobile: this.mobile,
                password: this.password,
            }, {
                headers: { 'Authorization': 'Bearer ' + token }
            })
            .then(function (response) {
                console.log(response);

                if (response.data.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: '更新成功',
                        width: 300,
                        timer: 1500,
                        showConfirmButton: false,
                        willClose: () => {
                            vm.$store.dispatch('member/getMember');
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
                vm.$store.dispatch('member/getMember');
            });

            vm.is_loading = false;
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