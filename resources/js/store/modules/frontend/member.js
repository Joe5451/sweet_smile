export default {
    namespaced: true,
    state: {
        member: null,
    },
    actions: {
        async login(context, {email, password}) {
            await axios.post('/login', {
                email,
                password
            })
            .then(function (response) {
                console.log(response);

                if (response.data.status == 'success') {
                    setCookie('member_token', response.data.access_token, 1);
                } else if (response.data.status == 'fail') {

                }

            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        },
        getMember(context) {
            let token = getCookie('member_token');

            context.commit('setMember', null);
            
            axios.get('/members', {
                params: {
                    token
                }
            })
            .then(function (response) {
                // console.log(response);

                if (response.data.status == 'success') {
                    context.commit('setMember', response.data.member);
                }
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        }
    },
    mutations: {
        setMember(state, data) {
            state.member = data;
        }
    }
}