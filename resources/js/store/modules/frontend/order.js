export default {
    namespaced: true,
    state: {
        loading: false,
        orders: [],
        order: null,
        total: 0,
        limit: 15,
        is_order_page: false,
    },
    actions: {
        async getOrders(context, current_page) {
            const vm = this;
            const token = vm.state.member.member_token;
            context.state.loading = true;

            await axios.get('/orders', {
                params: { 
                    page: current_page,
                    limit: context.state.limit
                },
                headers: { 'Authorization': 'Bearer ' + token }
            })
            .then(function (response) {
                // console.log(response);
                if (response.data.status == 'success') {
                    context.state.total = response.data.total;
                    context.state.orders = response.data.orders;
                } else if (response.data.status == 'token_invalid') {
                    vm.dispatch('cart/clearCart');
                    vm.dispatch('member/clearMemberData');
                    vm.dispatch('app/alertMessage', {title: '登入逾時，請重新登入會員', path: {name: 'memberLogin'}});
                }
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });

            context.state.loading = false;
        },
        async getOrder(context, order_id) {
            const vm = this;
            const token = vm.state.member.member_token;
            context.state.loading = true;

            await axios.get('/orders/' + order_id, {
                headers: { 'Authorization': 'Bearer ' + token }
            })
            .then(function (response) {
                console.log(response);
                if (response.data.status == 'success') {
                    context.state.order = response.data.order;
                } else if (response.data.status == 'fail') {
                    vm.dispatch('app/alertMessage', {title: response.data.message});
                } else if (response.data.status == 'token_invalid') {
                    vm.dispatch('cart/clearCart');
                    vm.dispatch('member/clearMemberData');
                    vm.dispatch('app/alertMessage', {title: '登入逾時，請重新登入會員', path: {name: 'memberLogin'}});
                }
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });

            context.state.loading = false;
        },
        initOrders(context) {
            context.state.loading = false;
            context.state.orders = [];
            context.state.total = 0;
        },
        initOrder(context) {
            context.state.order = null;
        }
    },
    mutations: {
        setIsOrderPage(state, data) {
            state.is_order_page = data;
        }
    }
}