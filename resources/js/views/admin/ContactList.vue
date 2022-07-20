<template>
    <div>
        <div class="admin_title">聯絡我們列表</div>

        <div class="mb-5 table-responsive custom_horizontal_scrollbar">
            <table class="table table-bordered table-striped align-middle mb-0" style="min-width: 800px;">
                <tbody>
                    <tr class="border-top">
                        <td width="60">項次</td>
                        <td width="200">發送時間</td>
                        <td width="100">姓名</td>
                        <td>Email</td>
                        <td width="80">狀態</td>
                        <td width="120">操作</td>
                    </tr>

                    <tr v-for="(contact, index) in contacts" :key="contact.id">
                        <td class="text-end">{{ index + start_index }}</td>
                        <td>{{ contact.created_at }}</td>
                        <td>{{ contact.name }}</td>
                        <td style="word-break: break-all;">{{ contact.email }}</td>
                        <td>{{ contact.state }}</td>
                        <td class="text-center">
                            <router-link to="{ name: 'adminContact', params: {contact_id: contact.id} }" class="btn btn-sm btn-primary">
                                管理
                            </router-link>
                            <button class="btn btn-sm btn-danger" @click="confirmDeleteContact(contact.contact_id)">
                                刪除
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ul class="pagination flex-wrap justify-content-center mb-4" v-if="total > 0">
            <li class="page-item mx-1 my-1" v-if="page != 1">
                <router-link class="page-link rounded" :to="{ name: 'adminContactList', params: { page: page - 1 } }" aria-label="Previous">
                    上一頁
                </router-link>
            </li>

            <li class="page-item mx-1 my-1" :class="{ active: (cur_page_num == page) }" v-for="cur_page_num in page_num" :key="cur_page_num">
                <router-link class="page-link rounded" :to="{ name: 'adminContactList', params: { page: cur_page_num } }">
                    {{ cur_page_num }}
                </router-link>
            </li>

            <li class="page-item mx-1 my-1" v-if="page != page_num">
                <router-link class="page-link rounded" :to="{ name: 'adminContactList', params: { page: page + 1 } }" aria-label="Next">
                    下一頁
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'ContactList',
        computed: {
            page() {
                let new_page = this.$route.params.page;
                return (new_page === undefined) ? 1 : new_page;
            },
            start_index() {
                return 1 + (this.page - 1) * this.limit;
            },
            page_num() {
                return Math.ceil(this.total / this.limit);
            }
        },
        watch: {
            page(new_page, old_page) {
                this.getContacts();
            }
        },
        data() {
            return {
                contacts: [],
                total: 0,
                limit: 15
            }
        },
        mounted() {
            this.getContacts();
        },
        methods: {
            async getContacts() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/contact', {
                    params: { 
                        page: vm.page,
                        limit: vm.limit
                    },
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
                .then(function (response) {
                    // console.log(response);
                    vm.contacts = response.data.contacts;
                    vm.total = response.data.total;
                })
                .catch(function(error) {
                    console.error("Error: ", error);
                });

                vm.$store.commit('admin_setting/hideLoading');
            },
            confirmDeleteContact(contact_id) {
                const vm = this;

                Swal.fire({
                    icon: 'question',
                    title: '確定刪除?',
                    showCancelButton: true,
                    cancelButtonText: '取消',
                    confirmButtonText: '確定',
                }).then((result) => {
                    if (result.isConfirmed) {
                        vm.deleteContact(contact_id);
                    } 
                })
            },
            async deleteContact(contact_id) {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.delete('/admin/contact/' + contact_id, {
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
                .then(function (response) {
                    // console.log(response);
                    if (response.data.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '刪除成功',
                            width: 300,
                            timer: 1500,
                            showConfirmButton: false,
                            willClose: () => {
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
                    console.error("Error: ", error);
                });

                vm.$store.commit('admin_setting/hideLoading');
            }
        }
    }
</script>