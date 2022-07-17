<template>
    <div class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">會員管理</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-4">
                            <label class="form-label">姓名*</label>
                            <input type="text" name="name" v-model="name" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">帳號 (Email)*</label>
                            <input type="text" name="email" v-model="email" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">手機</label>
                            <input type="text" name="mobile" v-model="mobile" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">密碼*</label>
                            <input type="password" name="password" v-model="password" class="form-control" placeholder="不更改請留空">
                            <div class="invalid-feedback"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" @click="checkForm">更新</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['memberId', 'modalId'],
        watch: {
            memberId(new_member_id, old_member_id) {
                this.name = this.mobile = this.email = this.password = '';
                // this.getMember(new_member_id);
            }
        },
        data() {
            return {
                name: '',
                mobile: '',
                email: '',
                password: '',
                origin_member: {
                    name: '',
                    mobile: '',
                    email: '',
                    password: '',
                },
                modal: null,
            }
        },
        mounted() {
            const vm = this;
            let modal_element = document.getElementById(this.modalId)

            this.modal = new bootstrap.Modal(modal_element);

            modal_element.addEventListener('hide.bs.modal', function (event) {
                vm.name = vm.origin_member.name;
                vm.email = vm.origin_member.email;
                vm.mobile = vm.origin_member.mobile;
                vm.password = vm.origin_member.password;
            });

            modal_element.addEventListener('show.bs.modal', function (event) {
                vm.$store.commit('admin_setting/showLoading'); // 在 shown.bs.modal 執行 getMember() 關閉 loading
                // vm.getMember(vm.memberId); // show.bs.modal 還無法使用 hide() 隱藏 modal，shown.bs.modal 才可以
            })

            modal_element.addEventListener('shown.bs.modal', function (event) {
                vm.getMember(vm.memberId);
            })
        },
        methods: {
            async getMember(member_id) {
                const vm = this;

                await axios.get('/admin/members/' + member_id, {
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
                .then(function (response) {
                    if (response.data.status == 'token_invalid') { // token 驗證失敗
                        vm.modal.hide(); // 關閉 modal
                    } else {
                        let member = response.data.member;
    
                        vm.name = member.name;
                        vm.email = member.email;
                        vm.mobile = member.mobile;
                        vm.origin_member.name = member.name;
                        vm.origin_member.email = member.email;
                        vm.origin_member.mobile = member.mobile;
                    }
                    
                    vm.$store.commit('admin_setting/hideLoading');
                    // console.log(response);
                })
                .catch(function(error) {
                    vm.$store.commit('admin_setting/hideLoading');
                    console.error("Error: ", error);
                });
            },
            checkForm() {
                $('input').removeClass('is-invalid');
                $('input').next('.invalid-feedback').text('');
                
                if (this.name == '')
                    this.alertInvalidMessage($('input[name=name]'), '請輸入姓名');
                else if (this.email == '')
                    this.alertInvalidMessage($('input[name=email]'), '請輸入帳號 (Email)');
                else
                    this.updateMember();
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
            },
            async updateMember() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');
                    
                await axios.put('/admin/members/' + this.memberId, {
                    email: this.email,
                    name: this.name,
                    mobile: this.mobile,
                    password: this.password,
                }, {
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
                .then(function (response) {
                    // console.log(response);
                    vm.$store.commit('admin_setting/hideLoading');

                    if (response.data.status == 'token_invalid') {
                        vm.modal.hide(); // 關閉 modal
                    }

                    if (response.data.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '更新成功',
                            width: 300,
                            timer: 1500,
                            showConfirmButton: false,
                            willClose: () => {
                                vm.modal.hide(); // 關閉 modal
                                vm.$store.commit('admin_setting/updateContentComponentKey'); // 更新畫面
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
            
        }
    }
</script>