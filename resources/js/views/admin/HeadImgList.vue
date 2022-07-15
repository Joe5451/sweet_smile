<template>
    <div>
        <div class="admin_title">上方大圖</div>

        <div class="mb-5 table-responsive custom_horizontal_scrollbar">
            <table class="table table-bordered table-striped align-middle mb-0" style="min-width: max-content;">
                <thead>
                    <tr>
                        <td width="100">頁面</td>
                        <td>圖片</td>
                        <td width="80">操作</td>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <tr v-for="head_img in head_imgs" :key="head_img.id">
                        <td>{{ head_img.page_name }}</td>
                        <td>
                            <img :src="head_img.img" style="width:480px; height:100px; object-fit:cover">
                        </td>
                        
                        <td class="text-center">
                            <router-link class="btn btn-sm btn-primary" :to="{name: 'adminHeadImgUpdate', params: { head_img_id: head_img.id }}">
                                管理
                            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

       
    </div>
</template>

<script>
    export default {
        name: 'HeadImgList',
        data() {
            return {
                head_imgs: []
            }
        },
        mounted() {
            this.getHeadImgs();
        },
        methods: {
            async getHeadImgs() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/head_img', {
                    params: { 
                        page: vm.page,
                        limit: vm.limit
                    },
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
                .then(function (response) {
                    console.log(response);
                    vm.head_imgs = response.data.head_imgs;
                    vm.$store.commit('admin_setting/hideLoading');
                })
                .catch(function(error) {
                    vm.$store.commit('admin_setting/hideLoading');
                    console.error("Error: ", error);
                });
            }
        }
    }
</script>