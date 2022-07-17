export default {
    namespaced: true,
    state: {
        home_slider: [],
        news: [],
    },
    actions: {
        getHomeSlider(context) {
            context.state.home_slider = [];

            axios.get('/home_sliders')
            .then(function (response) {
                // console.log(response);
                context.state.home_slider = response.data.home_slider;
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        },
        getHomeNews(context) {
            context.state.news = [];

            axios.get('/news', {
                params: { 
                    page: 1,
                    limit: 4
                }
            })
            .then(function (response) {
                // console.log(response);
                context.state.news = response.data.news;
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        }
    },
    mutations: {
        
    }
}