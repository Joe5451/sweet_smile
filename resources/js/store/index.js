import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate' // 使 vuex 持久化，將資料存在 localStorage

// 後台 modules
import admin_user from './modules/admin/user'
import admin_setting from './modules/admin/setting'

// 前台 modules
import app from './modules/frontend/app'
import home from './modules/frontend/home'
import news from './modules/frontend/news'
import product from './modules/frontend/product'

Vue.use(Vuex);

export default new Vuex.Store({
    plugins: [
        createPersistedState({
            paths: [ // 保存項目
                'admin_user.access_token',
                'admin_user.expires_in',
                'admin_setting.sidebar_show'
            ],
        }),
    ],
    modules: {
        admin_user,
        admin_setting,
        app,
        home,
        news,
        product
    },
    state: {
        
    },
    mutations: {

    },
});