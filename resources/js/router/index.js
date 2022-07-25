import Vue from 'vue';
import Router from 'vue-router';
import store from '../store';

// frontend views
import App from '../views/frontend/App.vue';
import Home from '../views/frontend/Home.vue';
import About from '../views/frontend/About.vue';
import NewsList from '../views/frontend/NewsList.vue';
import News from '../views/frontend/News.vue';
import ProductList from '../views/frontend/ProductList.vue';
import Product from '../views/frontend/Product.vue';
import Contact from '../views/frontend/Contact.vue';
import MemberLogin from '../views/frontend/MemberLogin.vue';
import MemberSignup from '../views/frontend/MemberSignup.vue';
import Member from '../views/frontend/Member.vue';
import MemberData from '../views/frontend/MemberData.vue';
import MemberOrderList from '../views/frontend/MemberOrderList.vue';
import MemberOrder from '../views/frontend/MemberOrder.vue';
import Cart from '../views/frontend/Cart.vue';

// admin views
import AdminLogin from '../views/admin/Login.vue';
import AdminDashboard from '../views/admin/Dashboard.vue';
import AdminWelcome from '../views/admin/Welcome.vue';
import AdminHomeSliderList from '../views/admin/HomeSliderList.vue';
import AdminHomeSliderAddEdit from '../views/admin/HomeSliderAddEdit.vue';
import AdminHomeSliderUpdateEdit from '../views/admin/HomeSliderUpdateEdit.vue';
import AdminHeadImgList from '../views/admin/HeadImgList.vue';
import AdminHeadImgUpdateEdit from '../views/admin/HeadImgUpdateEdit.vue'
import AdminAboutEdit from '../views/admin/AboutEdit.vue';
import AdminMemberList from '../views/admin/MemberList.vue';
import AdminMemberAddEdit from '../views/admin/MemberAddEdit.vue';
import AdminProductList from '../views/admin/ProductList.vue';
import AdminProductCategoryList from '../views/admin/ProductCategoryList.vue';
import AdminProductCategoryAddEdit from '../views/admin/ProductCategoryAddEdit.vue';
import AdminProductCategoryUpdateEdit from '../views/admin/ProductCategoryUpdateEdit.vue';
import AdminProductAddEdit from '../views/admin/ProductAddEdit.vue';
import AdminProductUpdateEdit from '../views/admin/ProductUpdateEdit.vue';
import AdminNewsList from '../views/admin/NewsList.vue';
import AdminNewsAddEdit from '../views/admin/NewsAddEdit.vue';
import AdminNewsUpdateEdit from '../views/admin/NewsUpdateEdit.vue';
import AdminOrderList from '../views/admin/OrderList.vue';
import AdminOrderUpdateEdit from '../views/admin/OrderUpdateEdit.vue';
import AdminContactList from '../views/admin/ContactList.vue';
import AdminContactUpdateEdit from '../views/admin/ContactUpdateEdit.vue';

Vue.use(Router);

export default new Router({
    mode: 'history',
    linkActiveClass: 'active',
    scrollBehavior (to, from, savedPosition) { // 換頁時置頂
        return { x: 0, y: 0 }
    },
    routes: [
        {
            path: '/',
            component: App,
            name: 'frontend',
            beforeEnter: async (to, from, next) => {
                await store.dispatch('member/initMember');
                next();
            },
            children: [
                {
                    path: '/',
                    name: 'home',
                    component: Home,
                },
                {
                    path: '/about',
                    name: 'about',
                    component: About,
                },
                {
                    path: '/news/list/:page?',
                    name: 'newsList',
                    component: NewsList,
                },
                {
                    path: 'news/:news_id',
                    name: 'news',
                    component: News,
                },
                {
                    path: 'product/list/:subcategory_id/:page?',
                    name: 'productList',
                    component: ProductList,
                },
                {
                    path: 'product/:product_id',
                    name: 'product',
                    component: Product,
                },
                {
                    path: '/contact',
                    name: 'contact',
                    component: Contact,
                },
                {
                    path: 'member/signup',
                    name: 'memberSignup',
                    component: MemberSignup,
                },
                {
                    path: 'member/login',
                    name: 'memberLogin',
                    component: MemberLogin,
                    beforeEnter: (to, from, next) => {
                        let login_state = store.state.member.login_state;
                        // let token = getCookie('member_token');
                        let expires_in_cookie = getCookie('token_expires_in');
                        let expires_in = new Date(expires_in_cookie);
                        let now = new Date();

                        if (login_state != 1 || expires_in.getTime() < now.getTime()) {
                            next();
                        } else {
                            next({name: 'memberData'});
                        }
                    }
                },
                {
                    path: 'member',
                    component: Member,
                    meta: { requireMemberAuth: true},
                    beforeEnter: (to, from, next) => {
                        let login_state = store.state.member.login_state;
                        // let token = getCookie('member_token');
                        let expires_in_cookie = getCookie('token_expires_in');
                        let expires_in = new Date(expires_in_cookie);
                        let now = new Date();

                        if (login_state != 1 || expires_in_cookie == '' || expires_in.getTime() < now.getTime()) {
                            console.warn('會員驗證不通過')
                            store.dispatch('member/clearMemberData', 0);
                            next({name: 'memberLogin'});
                            store.dispatch('app/alertMessage', {title: '請登入會員'});
                        } else {
                            next();
                        }
                    },
                    children: [
                        {
                            path: 'data',
                            name: 'memberData',
                            component: MemberData
                        },
                        {
                            path: 'order/list/:page?',
                            name: 'memberOrderList',
                            component: MemberOrderList
                        },
                        {
                            path: 'order/:order_id',
                            name: 'memberOrder',
                            component: MemberOrder
                        }
                    ]
                },
                {
                    path: '/cart',
                    name: 'cart',
                    component: Cart,
                },
            ]
        },
        {
            path: '/admin/login',
            name: 'adminLogin',
            component: AdminLogin,
            // component: () => import('../views/admin/LoginForm.vue'), // 使用 import() 會在 npm run dev 打包後，js 執行錯誤
        },
        {
            path: '/admin',
            name: 'admin',
            component: AdminDashboard,
            meta: { requireAdminAuth: true},
            beforeEnter: (to, from, next) => {
                let expires_in_cookie = getCookie('admin_token_expires_in');
                let expires_in = new Date(expires_in_cookie);
                let now = new Date();

                if (expires_in_cookie == '' || expires_in.getTime() < now.getTime()) {
                    console.warn('管理員 token 過期')
                    store.dispatch('admin_user/logout');

                    Qmsg.error('請重新登入', {
                        onClose() {
                            next({name: 'adminLogin'});
                        }
                    });
                } else {
                    next();
                }
            },
            children: [
                {
                    path: 'welcome',
                    name: 'adminWelcome',
                    component: AdminWelcome,
                },
                {
                    path: 'about',
                    name: 'adminAbout',
                    component: AdminAboutEdit,
                },
                {
                    path: 'home_slider/list/:page?',
                    name: 'adminHomeSliderList',
                    component: AdminHomeSliderList,
                },
                {
                    path: 'home_slider/add',
                    name: 'adminHomeSliderAdd',
                    component: AdminHomeSliderAddEdit,
                },
                {
                    path: 'home_slider/update/:slider_id',
                    name: 'adminHomeSliderUpdate',
                    component: AdminHomeSliderUpdateEdit,
                },
                {
                    path: 'head_img/list',
                    name: 'adminHeadImgList',
                    component: AdminHeadImgList,
                },
                {
                    path: 'head_img/update/:head_img_id',
                    name: 'adminHeadImgUpdate',
                    component: AdminHeadImgUpdateEdit,
                },
                {
                    path: 'member/list/:page?',
                    name: 'adminMemberList',
                    component: AdminMemberList,
                },
                {
                    path: 'member/add',
                    name: 'adminMemberAdd',
                    component: AdminMemberAddEdit,
                },
                {
                    path: 'news/list/:page?',
                    name: 'adminNewsList',
                    component: AdminNewsList,
                },
                {
                    path: 'news/add',
                    name: 'adminNewsAdd',
                    component: AdminNewsAddEdit,
                },
                {
                    path: 'news/update/:news_id',
                    name: 'adminNewsUpdate',
                    component: AdminNewsUpdateEdit,
                },
                {
                    path: 'product/list/:page?',
                    name: 'adminProductList',
                    component: AdminProductList,
                },
                {
                    path: 'product/add',
                    name: 'adminProductAdd',
                    component: AdminProductAddEdit,
                },
                {
                    path: 'product/update/:product_id',
                    name: 'adminProductUpdate',
                    component: AdminProductUpdateEdit,
                },
                {
                    path: 'product/category_list',
                    name: 'adminProductCategoryList',
                    component: AdminProductCategoryList,
                },
                {
                    path: 'product/category_add',
                    name: 'adminProductCategoryAdd',
                    component: AdminProductCategoryAddEdit,
                },
                {
                    path: 'product/category_update/:product_category_id',
                    name: 'adminProductCategoryUpdate',
                    component: AdminProductCategoryUpdateEdit,
                },
                {
                    path: 'order/list/:page?',
                    name: 'adminOrderList',
                    component: AdminOrderList,
                },
                {
                    path: 'order/update/:order_id',
                    name: 'adminOrderUpdate',
                    component: AdminOrderUpdateEdit,
                },
                {
                    path: 'contact/list/:page?',
                    name: 'adminContactList',
                    component: AdminContactList,
                },
                {
                    path: 'contact/update/:contact_id',
                    name: 'adminContactUpdate',
                    component: AdminContactUpdateEdit,
                }
            ]
        },
    ],
});
