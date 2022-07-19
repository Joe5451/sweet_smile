export default {
    namespaced: true,
    state: {
        login_state: 0, // 0 or 1
        member_token: '',
        token_expires_in: '',
        member: null,
    },
    actions: {
        async checkMemberLogin(context) {
            console.warn('檢查是否登入會員');
            const vm = this;
            const token = getCookie('member_token');
            const expires_in_cookie = getCookie('token_expires_in');
            const expires_in = new Date(expires_in_cookie);
            const now = new Date();

            if (token == '' || expires_in_cookie == '' || now.getTime() > expires_in.getTime()) {
                console.log(token, expires_in_cookie);
                
                context.dispatch('clearMemberData');
            } else {
                await axios.get('/members', {
                    params: {
                        token
                    }
                })
                .then(function (response) {
                    // console.log(response);
                    if (response.data.status == 'success') {
                        context.commit('setMember', response.data.member);
                        context.commit('setLoginState', 1);
                        context.commit('setMemberToken', token);
                        context.commit('setTokenExpiresIn', expires_in_cookie);
                    } else if (response.data.status == 'fail') {
                        context.dispatch('clearMemberData');
                    }
                })
                .catch(function(error) {
                    console.error("Error: ", error);
                });
            }
        },
        async login(context, {email, password}) {
            const vm = this;

            await axios.post('/login', {
                email,
                password
            })
            .then(function (response) {
                console.log(response);
                let data = response.data;

                if (data.status == 'success') {
                    setCookieWithDateTime('member_token', data.access_token, data.expires_in);
                    setCookieWithDateTime('token_expires_in', data.expires_in, data.expires_in);

                    context.state.member = data.member;
                    context.state.member_token = data.access_token;
                    context.state.token_expires_in = data.expires_in;
                    context.state.login_state = 1;

                    vm.dispatch('app/alertMessage', {
                        icon: 'success',
                        title: '登入成功',
                        path: {name: 'memberData'}
                    });
                } else if (data.status == 'fail') {
                    vm.dispatch('app/alertMessage', {title: data.message});
                }
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        },
        getMember(context) {
            const token = getCookie('member_token');

            axios.get('/members', {
                params: {
                    token
                }
            })
            .then(function (response) {
                if (response.data.status == 'success') {
                    context.commit('setMember', response.data.member);
                }
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        },
        async updateMember(context, {name, mobile, password}) {
            const vm = this;
            const token = context.state.member_token;
            
            await axios.put('/members', {
                name,
                mobile,
                password
            }, {
                headers: { 'Authorization': 'Bearer ' + token }
            })
            .then(function (response) {
                console.log(response);
                let data = response.data;
                
                if (data.status == 'success') {
                    context.state.member = data.member;
                    
                    vm.dispatch('app/alertMessage', {
                        icon: 'success',
                        title: '更新成功'
                    });
                } else if (data.status == 'fail') {
                    vm.dispatch('app/alertMessage', {title: data.message});
                }
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        },
        clearMemberData(context) {
            context.state.login_state = 0;
            context.state.member_token = '';
            context.state.token_expires_in = '';
            context.state.member = null;

            setCookie('member_token', '', 0);
            setCookie('token_expires_in', '', 0);
        }
    },
    mutations: {
        setMember(state, data) {
            state.member = data;
        },
        setLoginState(state, data) {
            state.login_state = data;
        },
        setMemberToken(state, data) {
            state.member_token = data;
        },
        setTokenExpiresIn(state, data) {
            state.token_expires_in = data;
        }
    }
}