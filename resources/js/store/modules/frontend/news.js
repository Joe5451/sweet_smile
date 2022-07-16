export default {
    namespaced: true,
    state: {
        head_img: '',
        content: '',
    },
    actions: {
        async getData(context) {
            await axios.get('/news')
            .then(async function (response) {
                context.commit('setData', response.data);
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        },
    },
    mutations: {
        setData(state, {head_img, content}) {
            state.head_img = head_img;
            state.content = content;
        }
    }
}