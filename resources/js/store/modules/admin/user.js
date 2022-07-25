export default {
    namespaced: true,
    state: {
        // user: null,
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
        async logout(context) {
            await axios.post('/admin/logout', {
                token: context.state.access_token
            })
            // .then(async function (response) {
            //     console.log(response);
            // });

            context.commit('setToken', {access_token: null, expires_in: null});
            setCookie('admin_token', '', 0);
            setCookie('admin_token_expires_in', '', 0);
        },
    },
    mutations: {
        setLoginState(state, login_state) {
            state.login_state = login_state;
        },
        setToken(state, {access_token, expires_in}) {
            state.access_token = access_token;
            state.expires_in = expires_in;

            this.commit('admin_setting/updateCkeditorConfigAuthorizationToken', access_token);
        }
    },
    getters: {
        
    },
}