import router from '../../../router';

export default {
    namespaced: true,
    state: {
        current_product: null,
        cart: [],
        member: null
    },
    actions: {
        async getMember(context) {
            const token = getCookie('member_token');

            if (token == '') {
                context.state.member = null;
                return;
            }

            context.state.member = null;
            
            await axios.get('/members', {
                params: {
                    token
                }
            })
            .then(function (response) {
                // console.log(response);

                if (response.data.status == 'success') {
                    context.state.member = response.data.member;
                } else {
                    context.state.member = null;
                }
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        },
        async addProduct(context, { product, qty} ) {
            const vm = this;
            const token = getCookie('member_token');
            
            if (token == '') { // 非會員
                let cart_cookie = getCookie('cart');

                let add_product = {
                    product_id: product.id,
                    product_name: product.product_name,
                    img: product.product_cover_img,
                    price: parseInt(product.price),
                    qty: parseInt(qty)
                };

                if (cart_cookie == '') {
                    let cart = [add_product];
                    
                    setCookie('cart', JSON.stringify(cart), 365);
                } else {
                    let cart = JSON.parse(cart_cookie);

                    if (Array.isArray(cart)) {
                        // 過濾資料不正確的元素
                        cart = cart.filter((element) => {
                            if (typeof element !== 'object' || Array.isArray(element)) { // 非物件或為陣列
                                return false;
                            }

                            if (!element.hasOwnProperty('product_id')) return false;
                            if (!element.hasOwnProperty('product_name')) return false;
                            if (!element.hasOwnProperty('img')) return false;
                            if (!element.hasOwnProperty('price')) return false;
                            if (!element.hasOwnProperty('qty')) return false;

                            return true;
                        });
                        
                        // 檢查購物車是否已存在該商品
                        let product_existed = false;

                        cart.forEach((element, index, arr) => {
                            if (element.product_id == add_product.product_id) {
                                product_existed = true;
                                
                                let new_qty = parseInt(arr[index].qty) + add_product.qty;
                                arr[index] = add_product;
                                arr[index].qty = new_qty;
                            }
                        });

                        if (!product_existed) {
                            cart.push(add_product);
                        }
                    } else {
                        cart = [add_product];
                    }

                    setCookie('cart', JSON.stringify(cart), 365);
                }

                this.dispatch('app/alertMessage', {icon: 'success', title: '已加入購物車'});
            } else {
                // 會員
                await axios.post('/cart/add', {
                    product_id: product.id,
                    qty: qty
                }, {
                    headers: { 'Authorization': 'Bearer ' + token }
                })
                .then(function (response) {
                    // console.log(response);

                    if (response.data.status == 'success') {
                        vm.dispatch('app/alertMessage', {icon: 'success', title: '已加入購物車'});
                    } else if (response.data.status == 'fail') {
                        vm.dispatch('app/alertMessage', {icon: 'warning', title: response.data.message});
                    } else if (response.data.status == 'token_invalid') {
                        setCookie('member_token', '', 0); // 刪除 token

                        Swal.fire({
                            icon: 'info',
                            title: '請重新登入會員',
                            timer: 1500,
                            width: 300,
                            showConfirmButton: false,
                            willClose: () => {
                                router.push({name: 'memberLogin'});
                            }
                        });
                    }
                })
                .catch(function(error) {
                    console.error("Error: ", error);
                });
            }
        },
        async getCart(context) {
            const vm = this;
            const token = getCookie('member_token');

            context.state.cart = [];

            if (token == '') { // 非會員
                let cart_cookie = getCookie('cart');
                let cart = (cart_cookie == '') ? [] : JSON.parse(cart_cookie);

                if (Array.isArray(cart)) {
                    // 過濾資料不正確的元素
                    cart = cart.filter((element) => {
                        if (typeof element !== 'object' || Array.isArray(element)) { // 非物件或為陣列
                            return false;
                        }

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

                if (context.state.cart.length == 0) {
                    vm.dispatch('app/alertMessage', {icon: 'info', title: '購物車無商品'});
                }
            } else {
                // 會員
                await axios.get('/cart', {
                    headers: { 'Authorization': 'Bearer ' + token }
                })
                .then(function (response) {
                    console.log(response);

                    if (response.data.status == 'success') {
                        context.state.cart = response.data.cart;

                        if (context.state.cart.length == 0) {
                            vm.dispatch('app/alertMessage', {icon: 'info', title: '購物車無商品'});
                        }
                    } else if (response.data.status == 'token_invalid') {
                        setCookie('member_token', '', 0); // 刪除 token

                        vm.dispatch('app/alertMessage', {icon: 'info', title: '登入逾時，請重新登入', path: {name: 'memberLogin'}});
                    }
                })
                .catch(function(error) {
                    console.error("Error: ", error);
                });
            }
        },
        async deleteCart(context, delete_index) {
            const vm = this;

            let cart_id = context.state.cart[delete_index].id;

            if (cart_id !== undefined) { // 會員購物車 id
                const token = getCookie('member_token');

                if (token == '') {
                    vm.dispatch('app/alertMessage', {icon: 'warning', title: '操作錯誤，請重新整理頁面'});
                } else {

                    await axios.delete('/cart/' + cart_id, {
                        headers: { 'Authorization': 'Bearer ' + token }
                    })
                    .then(function (response) {
                        console.log(response);
    
                        if (response.data.status == 'success') {
                            context.state.cart.splice(delete_index, 1);
    
                            vm.dispatch('app/alertMessage', {icon: 'success', title: '刪除成功'});
                        }
                        else if (response.data.status == 'token_invalid') {
                            setCookie('member_token', '', 0); // 刪除 token
    
                            vm.dispatch('app/alertMessage', {icon: 'info', title: '登入逾時，請重新登入', path: {name: 'memberLogin'}});
                        }
                    })
                    .catch(function(error) {
                        console.error("Error: ", error);
                    });
                }
                
            } else {
                context.state.cart.splice(delete_index, 1);
                let cart = context.state.cart;

                setCookie('cart', JSON.stringify(cart), 365);
                vm.dispatch('app/alertMessage', {icon: 'success', title: '刪除成功'});
            }
        },
        async updateQty(context, {index, qty}) {
            const vm = this;

            let cart_id = context.state.cart[index].id;

            if (cart_id !== undefined) { // 會員購物車 id
                const token = getCookie('member_token');

                if (token == '') {
                    vm.dispatch('app/alertMessage', {icon: 'warning', title: '操作錯誤，請重新整理頁面'});
                } else {

                    await axios.put('/cart/' + cart_id, {
                        qty
                    }, {
                        headers: { 'Authorization': 'Bearer ' + token }
                    })
                    .then(function (response) {
                        console.log(response);
    
                        if (response.data.status == 'token_invalid') {
                            setCookie('member_token', '', 0); // 刪除 token
    
                            vm.dispatch('app/alertMessage', {icon: 'info', title: '登入逾時，請重新登入', path: {name: 'memberLogin'}});
                        }
                    })
                    .catch(function(error) {
                        console.error("Error: ", error);
                    });
                }
                
            } else {
                let cart = context.state.cart;
                setCookie('cart', JSON.stringify(cart), 365);
            }
        },
        async createOrder(context, {payment_info, is_member}) {
            const vm = this;
            const token = getCookie('member_token');
            let cart = [];
            
            if (is_member && token == '') {
                vm.dispatch('app/alertMessage', {icon: 'info', title: '登入逾時，請重新登入', path: {name: 'memberLogin'}});
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
                console.log(response);

                if (response.data.status == 'success') {
                    alert('訂單建立成功!');
                }
                else if (response.data.status == 'product_update') {
                    setCookie('cart', JSON.stringify(response.data.update_cart), 365);
                    vm.dispatch('app/alertMessage', {icon: 'info', title: response.data.message});
                }
                else if (response.data.status == 'fail') {
                    vm.dispatch('app/alertMessage', {icon: 'info', title: response.data.message});
                }
                else if (response.data.status == 'token_invalid') {
                    setCookie('member_token', '', 0); // 刪除 token

                    vm.dispatch('app/alertMessage', {icon: 'info', title: '登入逾時，請重新登入', path: {name: 'memberLogin'}});
                }
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        }
    },
    mutations: {
        
    }
}