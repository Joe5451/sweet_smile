<template>
    <div>
        <div class="page_banner" :style="{'backgroundImage': 'url(' + head_img + ')'}">
            <div class="page_banner_title">購物商城</div>
        </div>

        <div class="container mb-80px" v-if="product !== null">
            <div class="row">
                <div class="col-lg-6">
                    <img :src="product.product_cover_img" class="product_img mx-auto d-block">
                </div>
                <div class="col-lg-6 ps-lg-5 d-flex flex-column">
                    <div class="product_title">{{ product.product_name }}</div>            
                    
                    <div class="product_summary custom_scrollbar">{{ product.summary }}</div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="fw-bold me-3">售價</div>
                        <div class="product_price">${{ product.price }}</div>
                        <div class="product_price del" v-if="product.original_price">${{ product.original_price }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="product_qty_control">
                            <button class="product_qty_btn minus" @click="reduceQty">-</button>
                            <input type="number" class="product_qty_input" :value="qty" @change="checkQty">
                            <button class="product_qty_btn plus" @click="addQty">+</button>
                        </div>
                    </div>

                    <div class="d-flex">
                        <button class="me-1 product_btn add_cart" @click="addCart" :disabled="add_cart_loading">
                            <span v-if="add_cart_loading"><i class="fas fa-spinner rotate-center"></i></span>
                            <span v-else>加入購物車</span>
                        </button>
                        <button class="ms-1 product_btn buy_now">立即購買</button>
                    </div>
                </div>
            </div>

            <hr class="my-5">

            <div class="product_intro_title">商品介紹</div>

            <div class="ck-content" v-html="product.content"></div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        head_img() {
            return this.$store.state.app.head_img.shopping_mall;
        },
        product() {
            return this.$store.state.product.current_product;
        },
    },
    data() {
        return {
            qty: 1,
            product_id: this.$route.params.product_id,
            add_cart_loading: false,
        }
    },
    mounted() {
        this.$store.dispatch('product/getProduct', this.product_id);
    },
    methods: {
        checkQty(e) {
            let old_qty = this.qty;
            let new_qty = e.target.value;

            console.log('old_qty: ' + old_qty, 'new_qty: ' + new_qty);

            if (new_qty < 1) {
                e.target.value = old_qty;
                this.alertInfo('info', '數量不得低於 1');
            } else if (new_qty > 1000) {
                e.target.value = old_qty;
                this.alertInfo('info', '數量不得高於 1000');
            } else {
                this.qty = new_qty;
            }
        },
        reduceQty() {
            if (this.qty > 1) {
                this.qty--;
            } else {
                this.alertInfo('info', '數量不得低於 1');
            }
        },
        addQty() {
            if (this.qty < 1000) {
                this.qty++;
            } else {
                this.alertInfo('info', '數量不得高於 1000');
            }
        },
        async addCart() {
            const vm = this;

            vm.add_cart_loading = true;
            await this.$store.dispatch('cart/addProduct', { product: this.product, qty: this.qty });
            vm.add_cart_loading = false;
        },
        alertInfo(icon, title) {
            Swal.fire({
                icon,
                title,
                width: 300,
                timer: 1500,
                showConfirmButton: false
            });
        }
    }
}
</script>