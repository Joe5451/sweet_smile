<template>
    <div>
        <div class="page_banner" :style="{'backgroundImage': 'url(' + head_img + ')'}">
            <div class="page_banner_title">購物商城</div>
        </div>

        <div class="container mb-80px">
            <div class="row">
                <div class="col-lg-3">
                    <nav class="product_nav">
                        <div class="d-flex justify-content-center align-items-center p-3" v-if="product_categories.length == 0">
                            <data-loader :loading="true" :color="'#BDBDBD'" :height="10"></data-loader>
                        </div>
                        
                        <div class="product_nav_dropdown" v-else
                            v-for="product_category in product_categories"
                            :key="product_category.product_category_id">
                            <div class="product_navi_dropdown_title" @click="showDropdownContent">
                                {{ product_category.category_name }}<i class="fas fa-angle-down"></i>
                            </div>
                            <div class="product_navi_dropdown_content">
                                <router-link class="product_navi_dropdown_link"
                                    v-for="product_subcategory in product_category.enabled_product_subcategories"
                                    :key="product_subcategory.product_subcategory_id"
                                    :to="{ name: 'productList', params: {subcategory_id: product_subcategory.product_subcategory_id} }">
                                    {{ product_subcategory.subcategory_name }}
                                </router-link>
                            </div>
                        </div>
                    </nav>
                </div>

                <div class="col-lg-9" v-if="isLoading">
                    <div class="d-flex justify-content-center align-items-center flex-column" style="height:200px;">
                        <i class="fas fa-spinner rotate-center text-black" style="font-size:40px"></i>
                        <span class="mt-3">Loading</span>
                    </div>
                </div>

                <div class="col-lg-9" v-else>
                    <div class="product_list_head">
                        <div class="product_list_title">{{ subcategory_name }}</div>
                    </div>

                    <div class="row mb-5">            
                        <div class="col-6 col-md-4 mb-3" v-for="product in products" :key="product.product_id">
                            <router-link class="product_card" :to="{name: 'product', params: { product_id: product.product_id } }">
                                <div class="product_card_img_wrap">
                                    <img :src="product.product_cover_img" class="product_card_img">
                                </div>
                                <div class="product_card_body">
                                    <div class="product_card_title">{{ product.product_name }}</div>
                                    <div class="product_card_price_wrap">
                                        <div class="product_card_price del" v-if="product.original_price">${{ product.original_price }}</div>
                                        <div class="product_card_price">${{ product.price }}</div>
                                    </div>
                                    <button class="product_card_btn">加入購物車</button>
                                </div>
                            </router-link>
                        </div>
                    </div>

                    <ul class="pagination custom_pagination justify-content-center flex-wrap mb-4" v-if="total > 0">
                        <li class="page-item m-1" v-if="page != 1">
                            <router-link class="page-link rounded" :to="{name: 'productList', params: { page: page - 1 } }" aria-label="Previous">
                                <i class="fas fa-angle-left"></i>
                            </router-link>
                        </li>

                        <li class="page-item m-1" :class="{ active: (cur_page_num == page) }" v-for="cur_page_num in page_num" :key="cur_page_num">
                            <router-link class="page-link rounded" :to="{name: 'productList', params: { page: cur_page_num } }">
                                {{ cur_page_num }}
                            </router-link>
                        </li>

                        <li class="page-item m-1" v-if="page != page_num">
                            <router-link class="page-link rounded" :to="{name: 'productList', params: { page: page + 1 } }" aria-label="Next">
                                <i class="fas fa-angle-right"></i>
                            </router-link>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        head_img() {
            return this.$store.state.app.head_img.shopping_mall;
        },
        product_categories() {
            return this.$store.state.app.product_categories;
        },
        subcategory_id() {
            return this.$route.params.subcategory_id;
        },
        page() {
            return (this.$route.params.page === undefined) ? 1 : this.$route.params.page;
        }
    },
    watch: {
        subcategory_id(new_id, old_id) {
            this.getSubCategoryProducts(new_id);
        },
        page(new_page, old_page) {
            this.getSubCategoryProducts(this.subcategory_id);
        }
    },
    data() {
        return {
            isLoading: true,
            subcategory_name: '',
            products: [],
            total: 0,
            limit: 15,
            page_num: 0
        }
    },
    destroyed() {
        this.$store.commit('app/setCurrentPage', '');
    },
    updated() {
        $('.product_navi_dropdown_link.active').parent('.product_navi_dropdown_content').show();
        $('.product_navi_dropdown_link.active').parents('.product_nav_dropdown')
        .children('.product_navi_dropdown_title').addClass('active');
    },
    mounted() {
        this.$store.commit('app/setCurrentPage', 'shopping_mall');

        $('.product_navi_dropdown_link.active').parent('.product_navi_dropdown_content').show();
        $('.product_navi_dropdown_link.active').parents('.product_nav_dropdown')
        .children('.product_navi_dropdown_title').addClass('active');

        this.getSubCategoryProducts(this.subcategory_id);
    },
    methods: {
        showDropdownContent(e) {
            const dispatch_element = $(e.currentTarget);

            dispatch_element.toggleClass('active');
            dispatch_element.next('.product_navi_dropdown_content').stop().slideToggle();
        },
        async getSubCategoryProducts(subcategory_id) {
            const vm = this;

            vm.isLoading = true;
            vm.products = [];

            await axios.get('/subcategory_products/' + subcategory_id, {
                params: { 
                    page: vm.page,
                    limit: vm.limit
                },
            })
            .then(function (response) {
                // console.log(response);
                let data = response.data;

                vm.subcategory_name = data.subcategory_name;
                vm.products = data.products;
                vm.total = data.total;
                vm.page_num = parseInt(vm.total / vm.limit);
                vm.page_num += (vm.total%vm.limit != 0) ? 1 : 0;
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });

            vm.isLoading = false;
        }
    }
}
</script>