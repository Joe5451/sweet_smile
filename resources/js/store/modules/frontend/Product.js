export default {
    namespaced: true,
    state: {
        current_product: null
    },
    actions: {
        getProduct(context, product_id) {
            context.state.product = null;

            axios.get('/products/' + product_id)
            .then(function (response) {
                console.log(response);
                context.state.current_product = response.data.product;
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        },
        
    },
    mutations: {
        
    }
}