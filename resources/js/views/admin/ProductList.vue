<template>
    <div>
        <div class="admin_title">商品列表</div>

        <div class="mb-5 table-responsive custom_horizontal_scrollbar">
            <table class="table table-bordered table-striped align-middle mb-0" style="min-width: max-content;">
                <tbody>
                    <tr class="text-center border-top">
                        <td width="60">項次</td>
                        <td>商品名稱</td>
                        <td width="120">售價</td>
                        <td width="80">狀態</td>
                        <td width="120">操作</td>
                    </tr>

                    <tr v-for="(product, index) in products" :key="product.id">
                        <td class="text-end">{{ index + start_index }}</td>
                        <td>{{ product.product_name }}</td>
                        <td class="text-end">${{ product.price }}</td>
                        <td class="text-center">
                            <span v-if="product.display == 1" style="color: blue;">上架</span>
                            <span v-else style="color: red;">下架</span>
                        </td>
                        <td class="text-center">
                            <router-link class="btn btn-sm btn-primary" :to="{name: 'adminProductUpdate', params: { product_id: product.id }}">
                                管理
                            </router-link>
                            
                            <button class="btn btn-sm btn-danger" @click="confirmDelete(product.id)">
                                刪除
                            </button>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>

        <ul class="pagination flex-wrap justify-content-center mb-4" v-if="total > 0">
            <li class="page-item mx-1 my-1" v-if="page != 1">
                <router-link class="page-link rounded" :to="{name: 'adminProductList', params: { page: page - 1 }}" aria-label="Previous">
                    上一頁
                </router-link>
            </li>

            <li class="page-item mx-1 my-1" :class="{ active: (cur_page_num == page) }" v-for="cur_page_num in page_num" :key="cur_page_num">
                <router-link class="page-link rounded" :to="{name: 'adminProductList', params: { page: cur_page_num }}">
                    {{ cur_page_num }}
                </router-link>
            </li>

            <li class="page-item mx-1 my-1" v-if="page != page_num">
                <router-link class="page-link rounded" :to="{name: 'adminProductList', params: { page: page + 1 }}" aria-label="Next">
                    下一頁
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'ProductList',
        computed: {
            page() {
                let new_page = this.$route.params.page;
                return (new_page === undefined) ? 1 : new_page;
            }
        },
        watch: {
            page(new_page, old_page) {
                this.getProducts();
            }
        },
        data() {
            return {
                products: [],
                total: 0,
                limit: 15,
                page_num: 0,
                start_index: 1,
                cur_product_id: ''
            }
        },
        mounted() {
            this.getProducts();
        },
        methods: {
            async getProducts() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/products', {
                    params: { 
                        page: vm.page,
                        limit: vm.limit
                    }
                })
                .then(function (response) {
                    vm.products = response.data.products;
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
            confirmDelete(product_id) {
                const vm = this;

                Swal.fire({
                    icon: 'question',
                    title: '確定刪除?',
                    showCancelButton: true,
                    cancelButtonText: '取消',
                    confirmButtonText: '確定',
                }).then((result) => {
                    if (result.isConfirmed) {
                        vm.deleteProduct(product_id);
                    } 
                })
            },
            async deleteProduct(product_id) {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.delete('/admin/products/' + product_id)
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