<template>
    <div>
        <div class="admin_title">最新消息列表</div>

        <div class="mb-5 table-responsive custom_horizontal_scrollbar">
            <table class="table table-bordered table-striped align-middle mb-0" style="min-width: 500px;">
                <thead>
                    <tr>
                        <td width="60">項次</td>
                        <td width="120">日期</td>
                        <td>標題</td>
                        <td width="80">狀態</td>
                        <td width="120">操作</td>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <tr v-for="(new_data, index) in news" :key="new_data.id">
                        <td class="text-end">{{ index + start_index }}</td>
                        <td>{{ new_data.date }}</td>
                        <td>{{ new_data.title }}</td>
                        <td class="text-center">
                            <span v-if="new_data.display == 1" style="color: blue;">上架</span>
                            <span v-else style="color: red;">下架</span>
                        </td>
                        <td class="text-center">
                            <router-link class="btn btn-sm btn-primary" :to="{name: 'adminNewsUpdate', params: { news_id: new_data.id }}">
                                管理
                            </router-link>

                            <button class="btn btn-sm btn-danger" @click="confirmDelete(new_data.id)">
                                刪除
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ul class="pagination flex-wrap justify-content-center mb-4" v-if="total > 0">
            <li class="page-item mx-1 my-1" v-if="page != 1">
                <router-link class="page-link rounded" :to="{name: 'adminNewsList', params: { page: page - 1 }}" aria-label="Previous">
                    上一頁
                </router-link>
            </li>

            <li class="page-item mx-1 my-1" :class="{ active: (cur_page_num == page) }" v-for="cur_page_num in page_num" :key="cur_page_num">
                <router-link class="page-link rounded" :to="{name: 'adminNewsList', params: { page: cur_page_num }}">
                    {{ cur_page_num }}
                </router-link>
            </li>

            <li class="page-item mx-1 my-1" v-if="page != page_num">
                <router-link class="page-link rounded" :to="{name: 'adminNewsList', params: { page: page + 1 }}" aria-label="Next">
                    下一頁
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'NewsList',
        computed: {
            page() {
                let new_page = this.$route.params.page;
                return (new_page === undefined) ? 1 : new_page;
            }
        },
        watch: {
            page(new_page, old_page) {
                this.getNews();
            }
        },
        data() {
            return {
                news: [],
                total: 0,
                limit: 15,
                page_num: 0,
                start_index: 1
            }
        },
        mounted() {
            this.getNews();
        },
        methods: {
            async getNews() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/news', {
                    params: { 
                        page: vm.page,
                        limit: vm.limit
                    },
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
                .then(function (response) {
                    vm.news = response.data.news;
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
            confirmDelete(new_id) {
                const vm = this;

                Swal.fire({
                    icon: 'question',
                    title: '確定刪除?',
                    showCancelButton: true,
                    cancelButtonText: '取消',
                    confirmButtonText: '確定',
                }).then((result) => {
                    if (result.isConfirmed) {
                        vm.deleteNews(new_id);
                    } 
                })
            },
            async deleteNews(new_id) {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.delete('/admin/news/' + new_id, {
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