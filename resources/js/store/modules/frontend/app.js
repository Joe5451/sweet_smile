export default {
    namespaced: true,
    state: {
        head_img: { // 上方大圖
            about: '',
            news: '',
            contact: '',
            shopping_mall: '',
            member: ''
        },
        home_slider: [],
        about_content: '',
        product_categories: [],
        current_page: ''
    },
    actions: {
        async getData(context) {
            await axios.get('/web_data')
            .then(async function (response) {
                console.log(response);
                context.commit('setData', response.data);
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        }
    },
    mutations: {
        setData(state, {head_img, about_content, home_slider, product_categories}) {
            head_img.forEach(item => {
                switch (item.page_name)
                {
                    case '關於我們':
                        state.head_img.about = item.img;
                        break;
                    case '最新消息':
                        state.head_img.news = item.img;
                        break;
                    case '購物商城':
                        state.head_img.shopping_mall = item.img;
                        break;
                    case '聯絡我們':
                        state.head_img.contact = item.img;
                        break;
                    case '會員中心':
                        state.head_img.member = item.img;
                        break;
                    default:
                }
            });

            state.home_slider = home_slider;
            state.about_content = about_content;
            state.product_categories = product_categories;
        },
        setCurrentPage(state, page_name) {
            state.current_page = page_name;
        }
    }
}