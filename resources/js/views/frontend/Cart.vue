<template>
    <div class="container mt-5">
        <div class="page_title">購物車內容</div>

        <div class="cart_head d-none d-md-flex">
            <div class="cart_head_item img"></div>
            <div class="cart_head_item name">商品名稱</div>
            <div class="cart_head_item unit_price">單價</div>
            <div class="cart_head_item qty">數量</div>
            <div class="cart_head_item price">小計</div>
            <div class="cart_head_item operate"></div>
        </div>

        <div class="cart_head_mobile d-md-none">商品明細</div>

        <div class="cart_body">
            <div v-if="cart_loading" class="d-flex justify-content-center align-items-center flex-column" style="height:200px;">
                <i class="fas fa-spinner rotate-center text-black" style="font-size:40px"></i>
            </div>
            
            <div v-else class="cart_row" v-for="(product, index) in cart" :key="index">
                <div class="cart_row_item img">
                    <img :src="product.img" class="cart_product_img">
                </div>
                <div class="cart_row_item name">{{ product.product_name }}</div>
                <div class="cart_row_item unit_price">${{ product.price }}</div>
                <div class="cart_row_item qty">
                    <div class="cart_qty_control">
                        <button class="cart_qty_btn minus" @click="reduceQty(index)">-</button>
                        <input type="number" class="cart_qty_input" :value="product.qty" @change="checkQty($event, index)">
                        <button class="cart_qty_btn plus" @click="addQty(index)">+</button>
                    </div>
                </div>
                <div class="cart_row_item price">${{ parseInt(product.qty)*parseInt(product.price) }}</div>
                <div class="cart_row_item operate">
                    <button class="cart_delete_btn" @click="deleteCart(index)">&times;</button>
                </div>
            </div>
        </div>

        <div class="row mx-0 cart_price_info_block">
            <div class="col-md-4">
                <div class="cart_price_info">
                    <span class="cart_price_info_title">商品金額小計</span>
                    <span class="cart_price_info_content">${{ subtotal }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cart_price_info">
                    <span class="cart_price_info_title">運費</span>
                    <span class="cart_price_info_content">$150</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cart_price_info">
                    <span class="cart_price_info_title">總金額</span>
                    <span class="cart_price_info_content active">${{ total }}</span>
                </div>
            </div>
        </div>

        <div class="page_title">付款資訊</div>

        <div class="payment_info_block px-3 py-4 px-md-5 py-md-5 mb-4 border">
            <div class="payment_info_title">會員資訊</div>

            <div class="mb-3">
                <label class="payment_info_label">會員 Email</label>
                <input type="email" class="form-control">
            </div>

            <div class="mb-4">
                <label class="payment_info_label">非會員購買聯絡 Email</label>
                <input type="email" class="form-control">
            </div>
            
            <div class="payment_info_title">購買人資訊</div>
            
            <div class="mb-3">
                <label class="payment_info_label">姓名</label>
                <input type="text" class="form-control" v-model="payment_info.name">
            </div>

            <div class="mb-3">
                <label class="payment_info_label">聯絡電話</label>
                <input type="text" class="form-control" v-model="payment_info.phone">
            </div>

            <div class="mb-3">
                <label class="payment_info_label">購買人地址</label>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <select class="form-select" @change="changeCity" v-model="payment_info.city">
                            <option value="" disabled>縣市</option>
                            <option value="基隆市">基隆市</option>
                            <option value="台北市">台北市</option>
                            <option value="新北市">新北市</option>
                            <option value="桃園市">桃園市</option>
                            <option value="新竹市">新竹市</option>
                            <option value="新竹縣">新竹縣</option>
                            <option value="宜蘭縣">宜蘭縣</option>
                            <option value="苗栗縣">苗栗縣</option>
                            <option value="台中市">台中市</option>	
                            <option value="彰化縣">彰化縣</option>
                            <option value="南投縣">南投縣</option>
                            <option value="雲林縣">雲林縣</option>
                            <option value="嘉義市">嘉義市</option>
                            <option value="嘉義縣">嘉義縣</option>		
                            <option value="台南市">台南市</option>
                            <option value="高雄市">高雄市</option>	
                            <option value="屏東縣">屏東縣</option>
                            <option value="澎湖縣">澎湖縣</option>
                            <option value="花蓮縣">花蓮縣</option>
                            <option value="台東縣">台東縣</option>
                            <option value="連江縣">連江縣</option>
                            <option value="金門縣">金門縣</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <select class="form-select" v-model="payment_info.town">
                            <option value="" disabled>鄉鎮市區</option>
                            <option :value="town_option" v-for="town_option in town_options" :key="town_option">{{ town_option.split('#$#')[1] }}</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="text" class="form-control" placeholder="郵遞區號" :value="payment_info.town.split('#$#')[0]" readonly>
                    </div>

                    <div class="col-12 mb-3">
                        <input type="text" v-model="payment_info.address" class="form-control" placeholder="購買人詳細地址：路/巷/弄/樓">
                    </div>
                </div>
            </div>

            <div class="payment_info_title">收件人資訊</div>

            <div class="d-flex align-items-center mb-4">
                <label class="payment_info_radio_label me-3">
                    <input type="radio" v-model="receiver_data_type" :value="'buyer'" class="payment_info_radio">
                    <span>同購買人</span>
                </label>
                <label class="payment_info_radio_label">
                    <input type="radio" v-model="receiver_data_type" :value="'new_receiver'" class="payment_info_radio">
                    <span>新增收件人</span>
                </label>
            </div>

            <div class="p-4 mb-4 payment_info_data" id="receiver_data">
                <p>姓名：{{ payment_info.name }}</p>
                <p>聯絡電話：{{ payment_info.phone }}</p>
                <p>收件人地址：{{ receiver_same_buyer_address }}</p>
            </div>

            <div id="new_receiver_data" style="display:none;">
                <div class="mb-3">
                    <label class="payment_info_label">姓名</label>
                    <input type="text" v-model="payment_info.receiver_name" class="form-control">
                </div>
        
                <div class="mb-3">
                    <label class="payment_info_label">聯絡電話</label>
                    <input type="text" v-model="payment_info.receiver_phone" class="form-control">
                </div>
        
                <div class="mb-3">
                    <label class="payment_info_label">收件人地址</label>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <select class="form-select" @change="changeReceiverCity" v-model="payment_info.receiver_city">
                                <option value="" disabled>縣市</option>
                                <option value="基隆市">基隆市</option>
                                <option value="台北市">台北市</option>
                                <option value="新北市">新北市</option>
                                <option value="桃園市">桃園市</option>
                                <option value="新竹市">新竹市</option>
                                <option value="新竹縣">新竹縣</option>
                                <option value="宜蘭縣">宜蘭縣</option>
                                <option value="苗栗縣">苗栗縣</option>
                                <option value="台中市">台中市</option>	
                                <option value="彰化縣">彰化縣</option>
                                <option value="南投縣">南投縣</option>
                                <option value="雲林縣">雲林縣</option>
                                <option value="嘉義市">嘉義市</option>
                                <option value="嘉義縣">嘉義縣</option>		
                                <option value="台南市">台南市</option>
                                <option value="高雄市">高雄市</option>	
                                <option value="屏東縣">屏東縣</option>
                                <option value="澎湖縣">澎湖縣</option>
                                <option value="花蓮縣">花蓮縣</option>
                                <option value="台東縣">台東縣</option>
                                <option value="連江縣">連江縣</option>
                                <option value="金門縣">金門縣</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <select class="form-select" v-model="payment_info.receiver_town">
                                <option value="" disabled>鄉鎮市區</option>
                            <option :value="receiver_town_option" v-for="receiver_town_option in receiver_town_options" :key="receiver_town_option">{{ receiver_town_option.split('#$#')[1] }}</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" placeholder="郵遞區號" :value="payment_info.receiver_town.split('#$#')[0]" readonly>
                        </div>
        
                        <div class="col-12 mb-3">
                            <input type="text"  v-model="payment_info.receiver_address" class="form-control" placeholder="收件人詳細地址：路/巷/弄/樓">
                        </div>
                    </div>
                </div>
            </div>

            <div class="payment_info_title">備註</div>

            <textarea rows="3" v-model="payment_info.remark" class="form-control custom_scrollbar"></textarea>
        </div>

        <div class="mb-80px d-flex justify-content-center">
            <button class="checkout_btn">送出訂單</button>
        </div>

    </div>
</template>

<script>
export default {
    computed: {
        cart() {
            return this.$store.state.cart.cart;
        },
        subtotal() {
            let subtotal = 0;

            this.cart.forEach(product => {
                subtotal += parseInt(product.price) * parseInt(product.qty);
            });

            return subtotal;
        },
        total() {
            return this.subtotal + 150;
        },
        member() {
            return this.$store.state.cart.member;
        },
        receiver_same_buyer_address() {
            let postcode = this.payment_info.town.split('#$#')[0];
            let town = this.payment_info.town.split('#$#')[1];

            if (postcode === undefined) postcode = '';
            if (town === undefined) town = '';
            
            return postcode + this.payment_info.city + town + this.payment_info.address;
        }
    },
    watch: {
        receiver_data_type(new_value, old_value) {
            if (new_value == 'buyer') {
                $('#receiver_data').show();
                $('#new_receiver_data').hide();
            } else {
                $('#receiver_data').hide();
                $('#new_receiver_data').show();
            }
        }
    },
    data() {
        return {
            cart_loading: true,
            updateQtyTimeout: [],
            payment_info: {
                name: '',
                phone: '',
                city: '',
                town: '',
                address: '',
                receiver_name: '',
                receiver_phone: '',
                receiver_city: '',
                receiver_town: '',
                receiver_address: '',
                remark: ''
            },
            town_options: [],
            receiver_town_options: [],
            receiver_data_type: 'buyer'
        }
    },
    mounted() {
        this.getCart();
        this.$store.dispatch('cart/getMember');

        $('input[name=receiver_data_type]').change(function() {
            if ($(this).val() == 'buyer') {
                $('#receiver_data').show();
                $('#new_receiver_data').hide();
            } else {
                $('#receiver_data').hide();
                $('#new_receiver_data').show();
            }
        });
    },
    methods: {
        async getCart() {
            const vm = this;

            vm.cart_loading = true;
            await this.$store.dispatch('cart/getCart');
            vm.cart_loading = false;
        },
        async deleteCart(delete_index) {
            const vm = this;

            vm.cart_loading = true;

            await vm.$store.dispatch('cart/deleteCart', delete_index);

            vm.cart_loading = false;
        },
        checkQty(e, index) {
            const vm = this;

            let old_qty = vm.cart[index].qty;
            let new_qty = e.target.value;

            console.log('old_qty: ' + old_qty, 'new_qty: ' + new_qty);

            if (new_qty < 1) {
                e.target.value = old_qty;
                this.alertInfo('info', '數量不得低於 1');
            } else if (new_qty > 1000) {
                e.target.value = old_qty;
                this.alertInfo('info', '數量不得高於 1000');
            } else {
                vm.cart[index].qty = new_qty;
                vm.updateQty(index, new_qty);
            }
        },
        reduceQty(index) {
            const vm = this;
            let current_qty = parseInt(vm.cart[index].qty);
            
            if (current_qty > 1) {
                current_qty--;
                vm.cart[index].qty = current_qty;
                vm.updateQty(index, current_qty);
            } else {
                vm.alertInfo('info', '數量不得低於 1');
            }
        },
        addQty(index) {
            const vm = this;
            let current_qty = parseInt(vm.cart[index].qty);

            if (current_qty < 1000) {
                current_qty++;
                vm.cart[index].qty = current_qty;
                vm.updateQty(index, current_qty);
            } else {
                vm.alertInfo('info', '數量不得高於 1000');
            }
        },
        updateQty(index, qty) {
            const vm = this;

            if (vm.updateQtyTimeout[index] !== undefined) {
                clearTimeout(vm.updateQtyTimeout[index]);
            }
            
            vm.updateQtyTimeout[index] = setTimeout(function() {
                console.log('hi~' + index);
                vm.$store.dispatch('cart/updateQty', {index, qty});
            }, 800)
        },
        changeCity() {
            let city = this.payment_info.city;
            let current_town = CityAndTown[city];

            if (current_town === undefined) this.town_options = [];
            else this.town_options = current_town;

            this.payment_info.town = '';
        },
        changeReceiverCity() {
            let city = this.payment_info.receiver_city;
            let current_town = CityAndTown[city];

            if (current_town === undefined) this.receiver_town_options = [];
            else this.receiver_town_options = current_town;

            this.payment_info.receiver_town = '';
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
