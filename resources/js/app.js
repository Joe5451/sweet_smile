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

// vue
import Vue from 'vue';
import router from './router';
import store from './store';

window.Vue = Vue;
window.$ = jquery;
window.Swal = Swal;
window.Swiper = Swiper;

// axios 攔截器 response 設定，在處理 then 或 catch 之前攔截
axios.interceptors.response.use(function (res) {
    // console.log(res);
    if (res.data.status == 'token_invalid') {
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

    if (frontend_route) {
        $('.header_nav_mobile').hide();
        $('.header_menu_btn').removeClass('active');
        
        store.dispatch('app/getProductCategories');
    }
    
    next();
});



/*
router.beforeEach(async (to, from, next) => {
    const requireAdminAuth = to.matched.some(record => record.meta.requireAdminAuth);

    if (requireAdminAuth) {
        let token = store.state.admin_user.access_token;
        
        await axios.post('/admin/checkToken', {
            token
        }).then(function (response) {
            // console.log(response);
            
            if (response.data.status == 'success') {
                next();
            } else if (response.data.status == 'fail') {
                Qmsg.error('請重新登入', {
                    onClose() {
                        next({name: 'adminLogin'});
                    }
                });
            }
        });
    } else {
        next();
    }
})
*/