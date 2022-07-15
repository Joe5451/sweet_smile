<template>
    <div>
        <div class="admin_title">會員列表</div>

        <div class="mb-5 table-responsive custom_horizontal_scrollbar">
            <table class="table table-bordered table-striped align-middle mb-0" style="min-width: 800px;">
                <tbody>
                    <tr class="border-top">
                        <td width="60">項次</td>
                        <td width="200">加入時間</td>
                        <td width="160">姓名</td>
                        <td>帳號</td>
                        <td width="120">操作</td>
                    </tr>

                    <tr v-for="(member, index) in members" :key="member.member_id">
                        <td class="text-end">{{ index + start_index }}</td>
                        <td>{{ member.created_at }}</td>
                        <td>{{ member.name }}</td>
                        <td>{{ member.account }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary" @click="cur_member_id = member.member_id" data-bs-toggle="modal" data-bs-target="#memberUpdateModal">
                                管理
                            </button>
                            
                            <button class="btn btn-sm btn-danger" @click="confirmDeleteMember(member.member_id)">
                                刪除
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ul class="pagination flex-wrap justify-content-center mb-4" v-if="total > 0">
            <li class="page-item mx-1 my-1" v-if="page != 1">
                <router-link class="page-link rounded" :to="{name: 'adminMemberList', params: { page: page - 1 }}" aria-label="Previous">
                    上一頁
                </router-link>
            </li>

            <li class="page-item mx-1 my-1" :class="{ active: (cur_page_num == page) }" v-for="cur_page_num in page_num" :key="cur_page_num">
                <router-link class="page-link rounded" :to="{name: 'adminMemberList', params: { page: cur_page_num }}">
                    {{ cur_page_num }}
                </router-link>
            </li>

            <li class="page-item mx-1 my-1" v-if="page != page_num">
                <router-link class="page-link rounded" :to="{name: 'adminMemberList', params: { page: page + 1 }}" aria-label="Next">
                    下一頁
                </router-link>
            </li>
        </ul>

        <admin-member-update-modal id="memberUpdateModal" :modal-id="'memberUpdateModal'" :member-id="cur_member_id"></admin-member-update-modal>
    </div>
</template>

<script>
    export default {
        name: 'MemberList',
        computed: {
            page() {
                let new_page = this.$route.params.page;
                return (new_page === undefined) ? 1 : new_page;
            }
        },
        watch: {
            page(new_page, old_page) {
                this.getMembers();
            }
        },
        data() {
            return {
                members: [],
                total: 0,
                limit: 15,
                page_num: 0,
                start_index: 1,
                cur_member_id: ''
            }
        },
        mounted() {
            this.getMembers();
        },
        methods: {
            async getMembers() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/members', {
                    params: { 
                        page: vm.page,
                        limit: vm.limit
                    },
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
                .then(function (response) {
                    vm.members = response.data.members;
                    vm.total = response.data.total;
                    vm.start_index = 1 + (vm.page - 1) * vm.limit;
                    vm.page_num = parseInt(vm.total / vm.limit);
                    vm.page_num += (vm.total%vm.limit != 0) ? 1 : 0;
                    
                    vm.$store.commit('admin_setting/hideLoading');
                    // console.log(response);
                })
                .catch(function(error) {
                    vm.$store.commit('admin_setting/hideLoading');
                    console.error("Error: ", error);
                });
            },
            confirmDeleteMember(member_id) {
                const vm = this;

                Swal.fire({
                    icon: 'question',
                    title: '確定刪除?',
                    showCancelButton: true,
                    cancelButtonText: '取消',
                    confirmButtonText: '確定',
                }).then((result) => {
                    if (result.isConfirmed) {
                        vm.deleteMember(member_id);
                    } 
                })
            },
            async deleteMember(member_id) {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.delete('/admin/members/' + member_id, {
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
                .then(function (response) {
                    vm.$store.commit('admin_setting/hideLoading');
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
                    vm.$store.commit('admin_setting/hideLoading');
                    console.error("Error: ", error);
                });
            }
        }
    }
</script>