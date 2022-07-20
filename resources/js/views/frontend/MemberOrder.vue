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
                    <div v-if="loading" class="d-flex justify-content-center align-items-center flex-column" style="height:200px;">
                        <i class="fas fa-spinner rotate-center text-black" style="font-size:40px"></i>
                    </div>

                    <div v-else-if="!loading && order === null" class="col-lg-9 ps-lg-5">
                        <div class="fw-bold text-center p-5">查無訂單資料</div>
                    </div>

                    <div v-else>
                        <div class="order_detail_title">訂單編號：{{ order.order_number }}</div>
                        <div class="row bg-light py-3 mx-0 mb-5">
                            <div class="col-md-4">
                                <div class="order_detail_item">
                                    <span class="order_detail_item_title">訂單日期</span>
                                    <span>{{ order.datetime.match(/(\d{4})-(\d{2})-(\d{2})/)[0].replace(/-/g, '/') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="order_detail_item">
                                    <span class="order_detail_item_title">訂單狀態</span>
                                    <span>{{ order.order_state }}</span>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>

                        <div class="order_detail_title">商品明細</div>

                        <div class="order_product_head d-none d-md-flex">
                            <div class="order_product_head_item img"></div>
                            <div class="order_product_head_item name">商品名稱</div>
                            <div class="order_product_head_item unit_price">單價</div>
                            <div class="order_product_head_item qty">數量</div>
                            <div class="order_product_head_item price">小計</div>
                        </div>

                        <div class="order_product_head_mobile d-md-none">商品明細</div>

                        <div class="order_product_body">
                            <div class="order_product_row" v-for="(product, index) in order.order_items" :key="index">
                                <div class="order_product_row_item img">
                                    <img :src="product.product_img" class="order_product_product_img">
                                </div>
                                <div class="order_product_row_item name">{{ product.product_name }}</div>
                                <div class="order_product_row_item unit_price">
                                    <span class="order_product_row_item_title">單價：</span>
                                    ${{ product.price }}
                                </div>
                                <div class="order_product_row_item qty">
                                    <span class="order_product_row_item_title">數量：</span>
                                    {{ product.qty }}
                                </div>
                                <div class="order_product_row_item price">
                                    <span class="order_product_row_item_title">小計：</span>
                                    ${{ product.price * product.qty }}
                                </div>
                            </div>
                        </div>

                        <div class="row mx-0 order_product_price_info_block">
                            <div class="col-md-4">
                                <div class="order_product_price_info">
                                    <span class="order_product_price_info_title">商品金額小計</span>
                                    <span class="order_product_price_info_content">${{ order.subtotal }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="order_product_price_info">
                                    <span class="order_product_price_info_title">運費</span>
                                    <span class="order_product_price_info_content">${{ order.fare }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="order_product_price_info">
                                    <span class="order_product_price_info_title">總金額</span>
                                    <span class="order_product_price_info_content active">${{ order.total }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="order_detail_title">付款資訊</div>

                        <div class="payment_info_block px-3 py-4 px-md-5 py-md-5 mb-4 border">
                            <div class="payment_info_title">購買人資訊</div>
                            
                            <div class="p-4 mb-4 payment_info_data">
                                <p>姓名：{{ order.name }}</p>
                                <p>聯絡電話：{{ order.phone }}</p>
                                <p>收件人地址：{{buyer_address}}</p>
                            </div>

                            <div class="payment_info_title">收件人資訊</div>

                            <div class="p-4 mb-4 payment_info_data">
                                <p>姓名：{{ order.receiver_name }}</p>
                                <p>聯絡電話：{{ order.receiver_phone }}</p>
                                <p>收件人地址：{{ receiver_address }}</p>
                            </div>

                            <div class="payment_info_title">備註</div>
                            <div class="p-4 mb-4 payment_info_remark">{{ order.remark }}</div>
                        </div>
                    </div>
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
        order_id() {
            return this.$route.params.order_id;
        },
        loading() {
            return this.$store.state.order.loading;
        },
        order() {
            return this.$store.state.order.order;
        },
        buyer_address() {
            let postcode = this.order.town.split('#$#')[0];
            let town = this.order.town.split('#$#')[1];

            if (postcode === undefined) postcode = '';
            if (town === undefined) town = '';
            
            return postcode + this.order.city + town + this.order.address;
        },
        receiver_address() {
            let postcode = this.order.receiver_town.split('#$#')[0];
            let town = this.order.receiver_town.split('#$#')[1];

            if (postcode === undefined) postcode = '';
            if (town === undefined) town = '';
            
            return postcode + this.order.receiver_city + town + this.order.receiver_address;
        }
    },
    mounted() {
        this.$store.commit('order/setIsOrderPage', true);
        this.$store.dispatch('order/getOrder', this.order_id);
    },
    destroyed() {
        this.$store.commit('order/setIsOrderPage', false);
        this.$store.dispatch('order/initOrder');
    }
}
</script>