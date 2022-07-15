export default {
    namespaced: true,
    state: {
        user: null,
        access_token: null,
        expires_in: null,
    },
    actions: {
        // login(context, {account, password}) {
        //     axios.post('/admin/login', {
        //         account,
        //         password
        //     }).then(function (response) {
        //         console.log(response);
                
        //         if (response.data.status == 'success') {
        //             Qmsg.success('登入成功');
        //         } else if (response.data.status == 'fail') {
        //             Qmsg.error(response.data.message);
        //         }
        //     });
        // },
    },
    mutations: {
        setLoginState(state, login_state) {
            state.login_state = login_state;
        },
        setToken(state, {access_token, expires_in}) {
            state.access_token = access_token;
            state.expires_in = expires_in;
        }
    },
    getters: {
        
    },
}