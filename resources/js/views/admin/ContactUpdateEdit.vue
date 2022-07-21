<template>
    <div>
        <div class="admin_title">聯絡我們管理</div>

        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-sm btn-info text-white" @click="$router.back()">回上一頁</button>
        </div>

        <div class="mb-5 table-responsive custom_horizontal_scrollbar" v-if="contact !== null">
            <table class="table table-bordered table-striped align-middle mb-0" style="min-width: max-content;">
                <tbody>
                    <tr>
                        <td>發送時間</td>
                        <td>{{ contact.datetime }}</td>
                    </tr>
                    <tr>
                        <td>姓名</td>
                        <td>{{ contact.name }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ contact.email }}</td>
                    </tr>
                    <tr>
                        <td>電話</td>
                        <td>{{ contact.phone }}</td>
                    </tr>
                    <tr>
                        <td>狀態</td>
                        <td>
                            <select v-model="state" class="form-select w-auto">
                                <option value="0">未處理</option>
                                <option value="1">處理中</option>
                                <option value="2">已處理</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-top">內容</td>
                        <td>
                            <div style="white-space:pre-wrap;">{{ contact.content }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-top">管理者備註</td>
                        <td>
                            <textarea v-model="remark" rows="5" class="form-control"></textarea>
                        </td>
                    </tr>
                </tbody>  
            </table>

            <div class="d-flex justify-content-between py-3">
                <button class="btn btn-primary ms-auto" @click="updateContact">儲存</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ContactUpdateEdit',
        computed: {
            
        },
        data() {
            return {
                contact_id: this.$route.params.contact_id,
                contact: null,
                state: 0,
                remark: '',
            }
        },
        mounted() {
            this.getContact(this.contact_id);
        },
        methods: {
            async getContact(contact_id) {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/contact/' + contact_id, {
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
                .then(function (response) {
                    // console.log(response);
                    let contact = response.data.contact;
                    
                    vm.contact = contact;
                    vm.state = contact.state;
                    vm.remark = contact.remark;
                })
                .catch(function(error) {
                    console.error("Error: ", error);
                });

                vm.$store.commit('admin_setting/hideLoading');
            },
            async updateContact() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');
                    
                await axios.put('/admin/contact/' + vm.contact_id, {
                    remark: vm.remark,
                    state: vm.state,
                }, {
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
                .then(function (response) {
                    // console.log(response);
                    if (response.data.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '儲存成功',
                            timer: 1500,
                            showConfirmButton: false
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

                vm.$store.commit('admin_setting/hideLoading');
            }
        }
    }
</script>