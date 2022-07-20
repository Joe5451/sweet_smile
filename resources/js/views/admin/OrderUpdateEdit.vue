<template>
    <div>
        <div class="admin_title">訂單管理</div>

        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-sm btn-info text-white" @click="$router.back()">回上一頁</button>
        </div>

        <div class="mb-5 table-responsive custom_horizontal_scrollbar" v-if="order !== null">
            <table class="table table-bordered table-striped align-middle mb-0" style="min-width: max-content;">
                <tbody>
                    <tr class="border-top">
                        <td width="140">訂單編號</td>
                        <td>{{ order.order_number }}</td>
                    </tr>
                    <tr>
                        <td>建立時間</td>
                        <td>{{ order.datetime }}</td>
                    </tr>
                    <tr>
                        <td>類型</td>
                        <td>
                            <span v-if="order.member_id === null" class="text-black-50">非會員</span>
                            <span v-else class="text-success">會員</span>
                        </td>
                    </tr>
                    <tr>
                        <td>聯絡 Email</td>
                        <td>{{ order.email }}</td>
                    </tr>
                    <tr>
                        <td>購買人姓名</td>
                        <td>{{ order.name }}</td>
                    </tr>
                    <tr>
                        <td>購買人連絡電話</td>
                        <td>{{ order.phone }}</td>
                    </tr>
                    <tr>
                        <td>購買人地址</td>
                        <td>{{ buyer_address }}</td>
                    </tr>
                    <tr>
                        <td>收件人姓名</td>
                        <td>{{ order.receiver_name }}</td>
                    </tr>
                    <tr>
                        <td>收件人連絡電話</td>
                        <td>{{ order.receiver_phone }}</td>
                    </tr>
                    <tr>
                        <td>收件人地址</td>
                        <td>{{ receiver_address }}</td>
                    </tr>
                    <tr>
                        <td>商品小計</td>
                        <td>${{ order.subtotal }}</td>
                    </tr>
                    <tr>
                        <td>運費</td>
                        <td>${{ order.fare }}</td>
                    </tr>
                    <tr>
                        <td>總金額</td>
                        <td>${{ order.total }}</td>
                    </tr>
                    <tr>
                        <td>訂單狀態</td>
                        <td>
                            <select v-model="order_state" class="form-select w-auto">
                                <option value="0">未處理</option>
                                <option value="1">處理中</option>
                                <option value="2">已寄出</option>
                                <option value="3">退貨</option>
                                <option value="4">取消訂單</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-top">備註</td>
                        <td>
                            <div style="white-space:pre-wrap;">{{ order.remark }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-top">管理者備註</td>
                        <td>
                            <textarea v-model="order_remark" rows="5" class="form-control"></textarea>
                        </td>
                    </tr>
                </tbody>  
            </table>

            <div class="d-flex justify-content-between py-3">
                <button class="btn btn-primary ms-auto" @click="updateOrder">儲存</button>
            </div>
        </div>

        <h5 class="fw-bold" v-if="order !== null">訂單商品</h5>
    
        <div class="mb-5 table-responsive custom_horizontal_scrollbar" v-if="order !== null">
            <table class="table table-bordered table-striped align-middle mb-0" style="min-width: 530px;">
                <thead>
                    <tr>
                        <td class="text-center">商品圖片</td>
                        <td>商品名稱</td>
                        <td width="100" class="text-center">單價</td>
                        <td width="90" class="text-center">數量</td>
                        <td width="100" class="text-center">小計</td>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <tr v-for="(item, index) in order.order_items" :key="index">
                        <td width="116">
                            <img :src="item.product_img" style="width:100px;height:100px;object-fit:contain;">
                        </td>
                        <td>{{ item.product_name }}</td>
                        <td class="text-center">${{ item.price }}</td>
                        <td class="text-center">{{ item.qty }}</td>
                        <td class="text-center">${{ item.price*item.qty }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
</template>

<script>
    export default {
        name: 'OrderUpdateEdit',
        computed: {
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
        data() {
            return {
                order: null,
                order_state: 0,
                order_remark: '',
                order_id: this.$route.params.order_id,
            }
        },
        mounted() {
            this.getOrder(this.order_id);
        },
        methods: {
            async getOrder(order_id) {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/orders/' + order_id, {
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
                .then(function (response) {
                    // console.log(response);
                    let order = response.data.order;
                    
                    vm.order = order;
                    vm.order_state = order.order_state;
                    vm.order_remark = order.order_remark;
                })
                .catch(function(error) {
                    console.error("Error: ", error);
                });

                vm.$store.commit('admin_setting/hideLoading');
            },
            async updateOrder() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');
                    
                await axios.put('/admin/orders/' + vm.order_id, {
                    order_remark: vm.order_remark,
                    order_state: vm.order_state,
                }, {
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
                .then(function (response) {
                    console.log(response);

                    if (response.data.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '儲存成功',
                            timer: 1500,
                            showConfirmButton: false
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
                    console.error("Error: ", error);
                });

                vm.$store.commit('admin_setting/hideLoading');
            }
        }
    }
</script>