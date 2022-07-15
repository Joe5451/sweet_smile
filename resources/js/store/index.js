import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate' // 使 vuex 持久化，將資料存在 localStorage

// modules
import admin_user from './modules/admin/user'
import admin_setting from './modules/admin/setting'

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
        admin_setting
    },
    state: {
        
    },
    mutations: {

    },
});