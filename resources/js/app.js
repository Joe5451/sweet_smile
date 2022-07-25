require('./bootstrap');
require('./component');
require('./plugins/dropify');
require('./cookie_functions');

// 引入 bootstrap 並設為原域變數，使得可以使用 js script 控制諸如 modal 等元件開關
const bootstrap =  require('bootstrap');
window.bootstrap = bootstrap;

// 訊息提示插件 https://github.com/snwjas/Message.js
const qmsg = require('./plugins/message.js');
window.Qmsg = qmsg();

Qmsg.config({
    timeout: 1500
})

import jquery from 'jquery';
import Swal from 'sweetalert2';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import CityAndTown from './taiwan_city_and_town';

// vue
import Vue from 'vue';
import router from './router';
import store from './store';

window.Vue = Vue;
window.$ = jquery;
window.Swal = Swal;
window.Swiper = Swiper;
window.CityAndTown = CityAndTown;

// axios 攔截器 response 設定，在處理 then 或 catch 之前攔截
axios.interceptors.response.use(function (res) {
    // console.log(res);
    if (res.data.status == 'admin_token_invalid') {
        store.commit('admin_setting/showLoading');

        Qmsg.error('請重新登入', {
            onClose() {
                router.push({name: 'adminLogin'});
                // store.commit('admin_setting/hideLoading'); 在 return res 後的 then 或 catch 會執行
            }
        });
    }

    return res;
});

const app = new Vue({
    el: '#app',
    router,
    store
});

router.beforeEach(async (to, from, next) => {
    const frontend_route = to.matched.some(record => (record.name == 'frontend'));
    const require_member_auth = to.matched.some(record => record.meta.requireMemberAuth);
    const require_admin_auth = to.matched.some(record => record.meta.requireAdminAuth);

    if (frontend_route) {
        $('.header_nav_mobile').hide();
        $('.header_menu_btn').removeClass('active');
        
        store.dispatch('app/getProductCategories');
    }

    if (require_member_auth) {
        let login_state = store.state.member.login_state;
        // let token = getCookie('member_token');
        let expires_in_cookie = getCookie('token_expires_in');
        let expires_in = new Date(expires_in_cookie);
        let now = new Date();

        if (login_state != 1 || expires_in_cookie == '' || expires_in.getTime() < now.getTime()) {
            console.warn('會員驗證不通過')
            store.dispatch('member/clearMemberData', 0);
            next({name: 'memberLogin'});
            store.dispatch('app/alertMessage', {title: '請登入會員'});
        } else {
            next();
        }
    } else if (require_admin_auth) {
        let expires_in_cookie = getCookie('admin_token_expires_in');
        let expires_in = new Date(expires_in_cookie);
        let now = new Date();

        if (expires_in_cookie == '' || expires_in.getTime() < now.getTime()) {
            console.warn('管理員 token 過期')
            store.dispatch('admin_user/logout');

            Qmsg.error('請重新登入', {
                onClose() {
                    next({name: 'adminLogin'});
                }
            });
        } else {
            next();
        }
    } else {
        next();
    }
});
