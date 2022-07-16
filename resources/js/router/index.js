import Vue from 'vue';
import Router from 'vue-router';

// frontend views
import App from '../views/frontend/App.vue';
import Home from '../views/frontend/Home.vue';
import About from '../views/frontend/About.vue';
import NewsList from '../views/frontend/NewsList.vue';
import News from '../views/frontend/News.vue';
import Contact from '../views/frontend/Contact.vue';
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

Vue.use(Router);

export default new Router({
    // mode: 'history',
    linkActiveClass: 'active',
    scrollBehavior (to, from, savedPosition) { // 換頁時置頂
        return { x: 0, y: 0 }
    },
    routes: [
        {
            path: '/',
            component: App,
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
                    path: '/contact',
                    name: 'contact',
                    component: Contact,
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
                }
            ]
        },
    ],
});
