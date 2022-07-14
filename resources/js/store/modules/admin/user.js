export default {
    namespaced: true,
    state: {
        user: null,
        admin_token: null,
        login_state: 0,
    },
    actions: {
        login(context, {account, password}) {
            axios.post('/admin/login', {
                account,
                password
            }).then(function (response) {
                console.log(response);
                
                if (response.data.status == 'success') {
                    Qmsg.success('登入成功', {
                        onClose() {
                            console.log('我懂了')
                        }
                    });
                } else if (response.data.status == 'fail') {
                    Qmsg.error(response.data.message);
                }
            });
            
            // if (account == 'admin' && password == 'aaa') {
            //     context.commit('setLoginState', 1);
            // } else {
            //     context.commit('setLoginState', 0);
            // }
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