<template>
    <div>
        <div class="admin_title">商品分類</div>

        <div class="mb-5 table-responsive custom_horizontal_scrollbar">
            <table class="table table-bordered table-striped align-middle mb-0" style="min-width: 800px;">
                <tbody>
                    <tr class="text-center border-top">
                        <td width="60">項次</td>
                        <td width="160">商品主分類</td>
                        <td>商品子分類</td>
                        <td width="90">排序</td>
                        <td width="80">狀態</td>
                        <td width="120">操作</td>
                    </tr>
                    <tr v-for="(product_category, index) in product_categories" :key="product_category.product_category_id">
                        <td class="text-end">{{ index + start_index }}</td>
                        <td>{{ product_category.category_name }}</td>
                        <td>
                            <span v-for="(product_subcategory, sub_index) in product_category.product_subcategories"
                            :class="{
                                'text-primary': product_subcategory.subcategory_display,
                                'text-black-50 text-decoration-line-through': !product_subcategory.subcategory_display,
                            }"
                            :key="product_category.product_category_id + '-' + sub_index">
                                {{ product_subcategory.subcategory_name }}<br>
                            </span>
                        </td>
                        <td class="text-center">
                            <input type="number" class="form-control text-center" style="width: 70px;" value="0">
                        </td>
                        <td class="text-center">
                            <span v-if="product_category.category_display == 1" style="color: blue;">上架</span>
                            <span v-else style="color: red;">下架</span>
                        </td>
                        <td class="text-center">
                            <router-link class="btn btn-sm btn-primary" :to="{name: 'adminProductCategoryUpdate', params: { product_category_id: product_category.product_category_id }}">
                                管理
                            </router-link>

                            <a href="#" class="btn btn-sm btn-danger">刪除</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <ul class="pagination flex-wrap justify-content-center mb-4" v-if="total > 0">
            <li class="page-item mx-1 my-1" v-if="page != 1">
                <router-link class="page-link rounded" :to="{name: 'adminProductCategoryList', params: { page: page - 1 }}" aria-label="Previous">
                    上一頁
                </router-link>
            </li>

            <li class="page-item mx-1 my-1" :class="{ active: (cur_page_num == page) }" v-for="cur_page_num in page_num" :key="cur_page_num">
                <router-link class="page-link rounded" :to="{name: 'adminProductCategoryList', params: { page: cur_page_num }}">
                    {{ cur_page_num }}
                </router-link>
            </li>

            <li class="page-item mx-1 my-1" v-if="page != page_num">
                <router-link class="page-link rounded" :to="{name: 'adminProductCategoryList', params: { page: page + 1 }}" aria-label="Next">
                    下一頁
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'ProducCategoryList',
        computed: {
            page() {
                let new_page = this.$route.params.page;
                return (new_page === undefined) ? 1 : new_page;
            }
        },
        watch: {
            page(new_page, old_page) {
                this.getProductCategories();
            }
        },
        data() {
            return {
                product_categories: [],
                total: 0,
                limit: 15,
                page_num: 0,
                start_index: 1,
                cur_product_id: ''
            }
        },
        mounted() {
            this.getProductCategories();
        },
        methods: {
            async getProductCategories() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/product_category', {
                    params: { 
                        page: vm.page,
                        limit: vm.limit
                    }
                })
                .then(function (response) {
                    console.log(response);

                    vm.product_categories = response.data.product_categories;
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
            }
        }
    }
</script>