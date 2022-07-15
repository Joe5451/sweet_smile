require('./bootstrap');
require('./component');
require('./plugins/dropify');


// 引入 bootstrap 並設為原域變數，使得可以使用 js script 控制諸如 modal 等元件開關
const bootstrap =  require('bootstrap');
window.bootstrap = bootstrap;

// 訊息提示插件 https://github.com/snwjas/Message.js
const Qmsg = require('./plugins/message.js');
window.Qmsg = Qmsg();

window.Qmsg.config({
    timeout: 1500
})

import jquery from 'jquery';
import Swal from 'sweetalert2';

// vue
import Vue from 'vue';
import router from './router';
import store from './store';

window.Vue = Vue;
window.$ = jquery;
window.Swal = Swal;

const app = new Vue({
    el: '#app',
    router,
    store
});

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
                store.commit('admin_setting/showLoading');

                window.Qmsg.error('請重新登入', {
                    onClose() {
                        store.commit('admin_setting/hideLoading');
                        next({name: 'adminLogin'});
                    }
                });
            }
        });
    } else {
        next();
    }
})