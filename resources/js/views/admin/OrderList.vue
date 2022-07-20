<template>
    <div>
        <div class="admin_title">訂單列表</div>

        <div class="mb-5 table-responsive custom_horizontal_scrollbar">
            <table class="table table-bordered table-striped align-middle mb-0" style="min-width: max-content;">
                <tbody>
                    <tr class="border-top">
                        <td width="60">項次</td>
                        <td>建立時間</td>
                        <td width="100">訂單編號</td>
                        <td class="text-center">類型</td>
                        <td>聯絡 Email</td>
                        <td width="120">收件人</td>
                        <td class="text-center">訂單金額</td>
                        <td width="100" class="text-center">訂單狀態</td>
                        <td width="120">操作</td>
                    </tr>

                    <tr v-for="(order, index) in orders" :key="order.order_id">
                        <td class="text-end">{{ index + start_index }}</td>
                        <td>{{ order.datetime }}</td>
                        <td>{{ order.order_number }}</td>
                        <td class="text-center">
                            <span v-if="order.member_id === null" class="text-black-50">非會員</span>
                            <span v-else class="text-success">會員</span>
                        </td>
                        <td>{{ order.email }}</td>
                        <td>{{ order.receiver_name }}</td>
                        <td class="text-end">${{ order.total }}</td>
                        <td class="text-center" :class="get_order_state_color(order.order_state)">{{ order.order_state }}</td>
                        <td class="text-center">
                            <router-link :to="{ name: 'adminOrderUpdate', params: {order_id: order.order_id} }"
                            class="btn btn-sm btn-primary">
                                管理
                            </router-link>
                            
                            <button class="btn btn-sm btn-danger" @click="confirmDeleteOrder(order.order_id)">
                                刪除
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ul class="pagination flex-wrap justify-content-center mb-4" v-if="total > 0">
            <li class="page-item m-1" v-if="page != 1">
                <router-link class="page-link rounded" :to="{ name: 'adminOrderList', params: { page: page - 1 } }" aria-label="Previous">
                    上一頁
                </router-link>
            </li>

            <li class="page-item m-1" :class="{ active: (cur_page_num == page) }" v-for="cur_page_num in page_num" :key="cur_page_num">
                <router-link class="page-link rounded" :to="{ name: 'adminOrderList', params: { page: cur_page_num } }">
                    {{ cur_page_num }}
                </router-link>
            </li>

            <li class="page-item m-1" v-if="page != page_num">
                <router-link class="page-link rounded" :to="{ name: 'adminOrderList', params: { page: page + 1 } }" aria-label="Next">
                    下一頁
                </router-link>
            </li>
        </ul>

    </div>
</template>

<script>
    export default {
        name: 'OrderList',
        computed: {
            page() {
                return (this.$route.params.page === undefined) ? 1 : this.$route.params.page;
            },
            start_index() {
                return 1 + (this.page - 1) * this.limit;
            },
            page_num() {
                return Math.ceil(this.total / this.limit);
            }
        },
        watch: {
            page(new_page, old_page) {
                this.getOrders();
            }
        },
        data() {
            return {
                orders: [],
                total: 0,
                limit: 15,
                cur_order_id: ''
            }
        },
        mounted() {
            this.getOrders();
        },
        methods: {
            async getOrders() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/orders', {
                    params: { 
                        page: vm.page,
                        limit: vm.limit
                    },
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
                .then(function (response) {
                    // console.log(response);
                    vm.orders = response.data.orders;
                    vm.total = response.data.total;
                })
                .catch(function(error) {
                    console.error("Error: ", error);
                });

                vm.$store.commit('admin_setting/hideLoading');
            },
            get_order_state_color(order_state) {
                if (order_state == '未處理') return { 'text-danger': true };
                else if (order_state == '處理中') return { 'text-primary': true };
                else if (order_state == '已寄出') return { 'text-success': true };
                else if (order_state == '退貨') return { 'text-warning': true };
                else if (order_state == '取消訂單') return { 'text-black-50': true };
                else return { 'text-black': true };
            },
            confirmDeleteOrder(order_id) {
                const vm = this;

                Swal.fire({
                    icon: 'question',
                    title: '確定刪除?',
                    showCancelButton: true,
                    cancelButtonText: '取消',
                    confirmButtonText: '確定',
                }).then((result) => {
                    if (result.isConfirmed) {
                        vm.deleteOrder(order_id);
                    } 
                })
            },
            async deleteOrder(order_id) {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.delete('/admin/orders/' + order_id, {
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