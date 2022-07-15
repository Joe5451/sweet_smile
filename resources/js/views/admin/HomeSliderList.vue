<template>
    <div>
        <div class="admin_title">上方輪播列表</div>

        <div class="mb-5 table-responsive custom_horizontal_scrollbar">
            <table class="table table-bordered table-striped align-middle mb-0" style="min-width: 800px;">
                <thead>
                    <tr>
                        <td width="60">項次</td>
                        <td width="200">圖片</td>
                        <td>連結</td>
                        <td width="90">排序</td>
                        <td width="80">狀態</td>
                        <td width="120">操作</td>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <tr v-for="(slider, index) in sliders" :key="slider.id">
                        <td class="text-end">{{ index + start_index }}</td>
                        <td>
                            <img :src="slider.slider_img" style="width:184px; height:calc(184px / 1100 * 380); object-fit:cover;">
                        </td>
                        <td style="word-break:break-all;">
                            <a :href="slider.link" target="_blank">{{ slider.link }}</a>
                        </td>
                        <td class="text-center">
                            <input type="number" class="form-control text-center" style="width: 70px;" :value="slider.sequence">
                        </td>
                        <td class="text-center">
                            <span v-if="slider.display == 1" style="color: blue;">上架</span>
                            <span v-else style="color: red;">下架</span>
                        </td>
                        <td class="text-center">
                            <router-link class="btn btn-sm btn-primary" :to="{name: 'adminHomeSliderUpdate', params: { slider_id: slider.id }}">
                                管理
                            </router-link>

                            <button class="btn btn-sm btn-danger" @click="confirmDelete(slider.id)">
                                刪除
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ul class="pagination flex-wrap justify-content-center mb-4" v-if="total > 0">
            <li class="page-item mx-1 my-1" v-if="page != 1">
                <router-link class="page-link rounded" :to="{name: 'adminHomeSliderList', params: { page: page - 1 }}" aria-label="Previous">
                    上一頁
                </router-link>
            </li>

            <li class="page-item mx-1 my-1" :class="{ active: (cur_page_num == page) }" v-for="cur_page_num in page_num" :key="cur_page_num">
                <router-link class="page-link rounded" :to="{name: 'adminHomeSliderList', params: { page: cur_page_num }}">
                    {{ cur_page_num }}
                </router-link>
            </li>

            <li class="page-item mx-1 my-1" v-if="page != page_num">
                <router-link class="page-link rounded" :to="{name: 'adminHomeSliderList', params: { page: page + 1 }}" aria-label="Next">
                    下一頁
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'HomeSliderList',
        computed: {
            page() {
                let new_page = this.$route.params.page;
                return (new_page === undefined) ? 1 : new_page;
            }
        },
        watch: {
            page(new_page, old_page) {
                this.getSliders();
            }
        },
        data() {
            return {
                sliders: [],
                total: 0,
                limit: 15,
                page_num: 0,
                start_index: 1
            }
        },
        mounted() {
            this.getSliders();
        },
        methods: {
            async getSliders() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/home_slider', {
                    params: { 
                        page: vm.page,
                        limit: vm.limit
                    },
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
                .then(function (response) {
                    // console.log(response);

                    vm.sliders = response.data.sliders;
                    vm.total = response.data.total;
                    vm.start_index = 1 + (vm.page - 1) * vm.limit;
                    vm.page_num = parseInt(vm.total / vm.limit);
                    vm.page_num += (vm.total%vm.limit != 0) ? 1 : 0;
                    
                    vm.$store.commit('admin_setting/hideLoading');
                })
                .catch(function(error) {
                    vm.$store.commit('admin_setting/hideLoading');
                    console.error("Error: ", error);
                });
            },
            confirmDelete(slider_id) {
                const vm = this;

                Swal.fire({
                    icon: 'question',
                    title: '確定刪除?',
                    showCancelButton: true,
                    cancelButtonText: '取消',
                    confirmButtonText: '確定',
                }).then((result) => {
                    if (result.isConfirmed) {
                        vm.deleteHomeSlider(slider_id);
                    } 
                })
            },
            async deleteHomeSlider(slider_id) {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.delete('/admin/home_slider/' + slider_id, {
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