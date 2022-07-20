export default {
    namespaced: true,
    state: {
        current_product: null
    },
    actions: {
        async getProduct(context, product_id) {
            context.state.product = null;

            await axios.get('/products/' + product_id)
            .then(function (response) {
                // console.log(response);
                context.state.current_product = response.data.product;
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        },
        initProduct(context) {
            context.state.current_product = null;
        }
    },
    mutations: {
        
    }
}