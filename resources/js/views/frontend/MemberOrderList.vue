<template>
    <div>
        <div class="page_banner" :style="{'backgroundImage': 'url(' + head_img + ')'}">
            <div class="page_banner_title">會員中心</div>
        </div>

        <div class="container mb-80px">
            <div class="row">
                <div class="col-lg-3">
                    <member-sidebar></member-sidebar>
                </div>

                <div class="col-lg-9 ps-lg-5">
                    <div class="order_list_head">
                        <div class="order_list_head_item item_number"></div>
                        <div class="order_list_head_item number">訂單編號</div>
                        <div class="order_list_head_item date">訂單日期</div>
                        <div class="order_list_head_item price">訂單金額</div>
                        <div class="order_list_head_item state">訂單狀態</div>
                        <div class="order_list_head_item mobile">訂單內容</div>
                    </div>

                    <div v-if="loading" class="d-flex justify-content-center align-items-center flex-column" style="height:200px;">
                        <i class="fas fa-spinner rotate-center text-black" style="font-size:40px"></i>
                    </div>

                    <div v-else-if="!loading && orders.length == 0" class="text-center p-3 fw-bold border">無資料</div>

                    <router-link :to="{ name: 'memberOrder', params: {order_id: order.order_id} }"
                    v-else v-for="(order, index) in orders" :key="order.order_number" class="order_list_row">
                        <div class="order_list_row_item item_number">{{ start_index + index }}</div>
                        <div class="order_list_row_item number">
                            <span class="order_list_row_item_title">訂單編號：</span>
                            {{ order.order_number }}
                        </div>
                        <div class="order_list_row_item date">
                            <span class="order_list_row_item_title">訂單日期：</span>
                            {{ order.datetime.match(/(\d{4})-(\d{2})-(\d{2})/)[0].replace(/-/g, '/') }}
                        </div>
                        <div class="order_list_row_item price">
                            <span class="order_list_row_item_title">訂單金額：</span>
                            ${{ order.total }}
                        </div>
                        <div class="order_list_row_item state">
                            <span class="order_list_row_item_title">訂單狀態：</span>
                            {{ order.order_state }}
                        </div>
                    </router-link>

                    <ul class="pagination custom_pagination justify-content-center flex-wrap mt-5 mb-4" v-if="total > 0">
                        <li class="page-item m-1" v-if="page != 1">
                            <router-link class="page-link rounded" :to="{name: 'memberOrderList', params: { page: parseInt(page) - 1 } }" aria-label="Previous">
                                <i class="fas fa-angle-left"></i>
                            </router-link>
                        </li>

                        <li class="page-item m-1" :class="{ active: (cur_page_num == page) }" v-for="cur_page_num in page_num" :key="cur_page_num">
                            <router-link class="page-link rounded" :to="{name: 'memberOrderList', params: { page: cur_page_num } }">
                                {{ cur_page_num }}
                            </router-link>
                        </li>

                        <li class="page-item m-1" v-if="page != page_num">
                            <router-link class="page-link rounded" :to="{name: 'memberOrderList', params: { page: parseInt(page) + 1 } }" aria-label="Next">
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
            return this.$store.state.app.head_img.member;
        },
        page() {
            return (this.$route.params.page === undefined) ? 1 : this.$route.params.page;
        },
        total() {
            return this.$store.state.order.total;
        },
        page_num() {
            return Math.ceil(this.total / this.limit);
        },
        loading() {
            return this.$store.state.order.loading;
        },
        orders() {
            return this.$store.state.order.orders;
        },
        limit() {
            return this.$store.state.order.limit;
        },
        start_index() {
            return 1 + (this.page - 1) * this.limit;
        }
    },
    watch: {
        page(new_page, old_page) {
            this.$store.dispatch('order/getOrders', new_page);
        }
    },
    mounted() {
        this.$store.dispatch('order/getOrders', this.page);
    },
    destroyed() {
        this.$store.dispatch('order/initOrders');
    }
}
</script>