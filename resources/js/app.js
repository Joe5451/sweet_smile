require('./bootstrap');
require('./component');
require('./dropify');

// 引入 bootstrap 並設為原域變數，使得可以使用 js script 控制諸如 modal 等元件開關
const bootstrap =  require('bootstrap');
window.bootstrap = bootstrap;

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
