export default {
    namespaced: true,
    state: {
        current_product: null,
        cart: [],
        cart_qty: 0,
        member: null
    },
    actions: {
        async addProduct(context, { product, qty, is_checkout } ) {
            const vm = this;
            const token = vm.state.member.member_token;

            let add_product = {
                product_id: product.id,
                product_name: product.product_name,
                img: product.product_cover_img,
                price: parseInt(product.price),
                qty: parseInt(qty)
            };

            let cart_update_success = true;

            if (token != '') { // 會員
                await axios.post('/cart/add', {
                    product_id: product.id,
                    qty: qty
                }, {
                    headers: { 'Authorization': 'Bearer ' + token }
                })
                .then(function (response) {
                    // console.log(response);
                    if (response.data.status == 'success') {
                        cart_update_success = true;
                    } else if (response.data.status == 'fail') {
                        cart_update_success = false;
                        vm.dispatch('app/alertMessage', {icon: 'warning', title: response.data.message});
                    } else if (response.data.status == 'token_invalid') {
                        cart_update_success = false;
                        context.dispatch('clearCart');
                        vm.dispatch('member/clearMemberData');
                        vm.dispatch('app/alertMessage', {title: '登入逾時，請重新登入會員', path: {name: 'memberLogin'}});
                    }
                })
                .catch(function(error) {
                    cart_update_success = false;
                    console.error("Error: ", error);
                });
            }

            if (cart_update_success) {
                // 更新 cookie 購物車資料
                let cart_cookie = getCookie('cart');
                let cart = (cart_cookie == '') ? [] : JSON.parse(cart_cookie);
                let product_existed = false; // 檢查購物車是否已存在該商品
    
                cart.forEach((element, index, arr) => {
                    if (element.product_id == add_product.product_id) {
                        product_existed = true;
                        
                        let new_qty = parseInt(arr[index].qty) + add_product.qty;
                        arr[index] = add_product;
                        arr[index].qty = new_qty;
                    }
                });
    
                if (!product_existed) cart.push(add_product);
    
                setCookie('cart', JSON.stringify(cart), 365);
                if (is_checkout) vm.dispatch('app/alertMessage', {icon: 'success', title: '已加入購物車', path: {name: 'cart'}});
                else vm.dispatch('app/alertMessage', {icon: 'success', title: '已加入購物車'});
                context.dispatch('updateCartQty');
            }
        },
        async getCart(context) {
            const vm = this;
            const token = vm.state.member.member_token;

            if (token == '') { // 非會員
                let cart_cookie = getCookie('cart');
                let cart = (cart_cookie == '') ? [] : JSON.parse(cart_cookie);

                if (Array.isArray(cart)) {
                    // 過濾資料不正確的元素
                    cart = cart.filter((element) => {
                        if (typeof element !== 'object' || Array.isArray(element)) return false; // 非物件或為陣列
                        if (!element.hasOwnProperty('product_id')) return false;
                        if (!element.hasOwnProperty('product_name')) return false;
                        if (!element.hasOwnProperty('img')) return false;
                        if (!element.hasOwnProperty('price')) return false;
                        if (!element.hasOwnProperty('qty')) return false;

                        return true;
                    });

                    setCookie('cart', JSON.stringify(cart), 365); // 更新 cart
                } else {
                    cart = [];
                    setCookie('cart', '', 0); // 刪除 cart
                }

                context.state.cart = cart;
            } else {
                // 會員
                await axios.get('/cart', {
                    headers: { 'Authorization': 'Bearer ' + token }
                })
                .then(function (response) {
                    // console.log(response);
                    let data = response.data;

                    if (data.status == 'success') {
                        context.state.cart = data.cart;
                        setCookie('cart', JSON.stringify(data.cart), 365);
                    } else if (data.status == 'token_invalid') {
                        context.dispatch('clearCart');
                        vm.dispatch('member/clearMemberData');
                        vm.dispatch('app/alertMessage', {title: '登入逾時，請重新登入會員', path: {name: 'memberLogin'}});
                    }
                })
                .catch(function(error) {
                    console.error("Error: ", error);
                });
            }

            context.dispatch('updateCartQty');
        },
        updateCartQty(context) {
            const cart_cookie = getCookie('cart');

            if (cart_cookie == '') {
                context.state.cart_qty = 0;
            }  else {
                let cart = JSON.parse(cart_cookie);
                let cart_qty = 0;

                cart.forEach(item => { cart_qty += isNaN(item.qty) ? 0 : parseInt(item.qty) });
                context.state.cart_qty = cart_qty;
            }
        },
        async deleteCart(context, delete_index) {
            const vm = this;
            const token = vm.state.member.member_token;
            const cart_id = context.state.cart[delete_index].id;

            if (cart_id !== undefined) { // 會員購物車 id
                await axios.delete('/cart/' + cart_id, {
                    headers: { 'Authorization': 'Bearer ' + token }
                })
                .then(function (response) {
                    // console.log(response);
                    if (response.data.status == 'success') {
                        vm.dispatch('app/alertMessage', {icon: 'success', title: '刪除成功'});
                    }
                    else if (response.data.status == 'token_invalid') {
                        context.dispatch('clearCart');
                        vm.dispatch('member/clearMemberData');
                        vm.dispatch('app/alertMessage', {title: '登入逾時，請重新登入會員', path: {name: 'memberLogin'}});
                    }
                })
                .catch(function(error) {
                    console.error("Error: ", error);
                });
            }

            context.state.cart.splice(delete_index, 1);
            setCookie('cart', JSON.stringify(context.state.cart), 365);
            vm.dispatch('app/alertMessage', {icon: 'success', title: '刪除成功'});
            context.dispatch('updateCartQty');         
        },
        async updateQty(context, {index, qty}) {
            const vm = this;
            const token = vm.state.member.member_token;
            const cart_id = context.state.cart[index].id;

            if (cart_id !== undefined) { // 會員購物車 id
                await axios.put('/cart/' + cart_id, {
                    qty
                }, {
                    headers: { 'Authorization': 'Bearer ' + token }
                })
                .then(function (response) {
                    console.log(response);

                    if (response.data.status == 'token_invalid') {
                        context.dispatch('clearCart');
                        vm.dispatch('member/clearMemberData');
                        vm.dispatch('app/alertMessage', {title: '登入逾時，請重新登入', path: {name: 'memberLogin'}});
                    }
                })
                .catch(function(error) {
                    console.error("Error: ", error);
                });
            }

            let cart = context.state.cart;
            setCookie('cart', JSON.stringify(cart), 365);
            context.dispatch('updateCartQty');
        },
        async createOrder(context, {payment_info, is_member}) {
            const vm = this;
            const token = vm.state.member.member_token;
            let cart = [];
            
            if (is_member && token == '') {
                vm.dispatch('app/alertMessage', {title: '登入逾時，請重新登入', path: {name: 'memberLogin'}});
                return;
            }

            if (!is_member) {
                let cart_cookie = getCookie('cart');
                cart = (cart_cookie == '') ? [] : JSON.parse(cart_cookie);
            }

            await axios.post('/orders', {
                ...payment_info,
                is_member,
                cart
            }, {
                headers: { 'Authorization': 'Bearer ' + token }
            })
            .then(function (response) {
                // console.log(response);
                if (response.data.status == 'success') {
                    context.dispatch('clearCart');
                    context.dispatch('updateCartQty');
                    vm.dispatch('app/alertMessage', {icon: 'success', title: '訂單建立成功!'});
                }
                else if (response.data.status == 'product_update') {
                    setCookie('cart', JSON.stringify(response.data.update_cart), 365);
                    context.dispatch('updateCartQty');
                    vm.dispatch('app/alertMessage', {title: response.data.message});
                }
                else if (response.data.status == 'fail') {
                    vm.dispatch('app/alertMessage', {title: response.data.message});
                }
                else if (response.data.status == 'token_invalid') {
                    context.dispatch('clearCart');
                    vm.dispatch('member/clearMemberData');
                    vm.dispatch('app/alertMessage', {title: '登入逾時，請重新登入會員', path: {name: 'memberLogin'}});
                }
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        },
        clearCart(context) {
            context.state.cart = [];
            setCookie('cart', '', 0);
        }
    },
    mutations: {
        
    }
}