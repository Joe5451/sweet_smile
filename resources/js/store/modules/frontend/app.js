import router from '../../../router'

export default {
    namespaced: true,
    state: {
        loading: false, // loading-spinner 狀態
        head_img: { // 上方大圖
            about: '',
            news: '',
            contact: '',
            shopping_mall: '',
            member: ''
        },
        about_content: '',
        product_categories: [],
        current_page: ''
    },
    actions: {
        async getData(context) {
            await axios.get('/web_data')
            .then(function (response) {
                // console.log(response);
                context.commit('setData', response.data);
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        },
        getProductCategories(context) {
            context.state.product_categories = [];

            axios.get('/product_categories')
            .then(function (response) {
                // console.log(response);
                context.state.product_categories = response.data.product_categories;
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        },
        alertMessage(context, data) {
            let icon = data.hasOwnProperty('icon') ? data.icon : 'info';
            let title = data.hasOwnProperty('title') ? data.title : '';
            let path = data.hasOwnProperty('path') ? data.path : undefined;

            if (icon == 'info') {
                Swal.fire({
                    icon,
                    iconHtml: '<img style="width:80px;" src="img/logo_b.svg">',
                    customClass: { icon: 'border-0' },
                    title,
                    width: 300,
                    timer: 1500,
                    showConfirmButton: false,
                    willClose: () => {
                        if (path !== undefined) {
                            router.push(path);
                        }
                    }
                });
            } else {
                Swal.fire({
                    icon,
                    title,
                    width: 300,
                    timer: 1500,
                    showConfirmButton: false,
                    willClose: () => {
                        if (path !== undefined) {
                            router.push(path);
                        }
                    }
                });
            }
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

            state.about_content = about_content;
            // state.home_slider = home_slider;
            // state.product_categories = product_categories;
        },
        setCurrentPage(state, page_name) {
            state.current_page = page_name;
        },
        showLoading(state) {
            state.loading = true;
        },
        hideLoading(state) {
            state.loading = false;
        }
    }
}