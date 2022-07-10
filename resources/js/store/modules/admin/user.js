export default {
    namespaced: true,
    state: {
        user: null,
        admin_token: null,
        login_state: 0,
    },
    actions: {
        login(context, {account, password}) {
            axios.post('/admin/login').then(function (response) {
                console.log(response);
            });

            // axios.get('/admin/login').then(function (response) {
            //     console.log(response);
            // });
            
            if (account == 'admin' && password == 'aaa') {
                context.commit('setLoginState', 1);
            } else {
                context.commit('setLoginState', 0);
            }
        },
    },
    mutations: {
        setLoginState(state, login_state) {
            state.login_state = login_state;
        }
    },
    getters: {
        
    },
}