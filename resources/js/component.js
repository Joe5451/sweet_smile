import Vue from 'vue';

// npm components
import { GridLoader, SyncLoader, FadeLoader } from '@saeris/vue-spinners' // loading-spinner，https://vue-spinners.saeris.io/

// frontend components
import MainHeader from './components/frontend/MainHeader.vue';
import MainFooter from './components/frontend/MainFooter.vue';
import TopBtn from './components/frontend/TopBtn.vue';

// admin components
import AdminLoginForm from './components/admin/LoginForm.vue';
import AdminSidebar from './components/admin/Sidebar.vue';
import AdminHeader from './components/admin/AdminHeader.vue';
import AdminFooter from './components/admin/AdminFooter.vue';
import AdminProductCategoryAddModal from './components/admin/ProductCategoryAddModal.vue';
import AdminMemberUpdateModal from './components/admin/MemberUpdateModal.vue';

// regist global frontend components
Vue.component('main-header', MainHeader);
Vue.component('main-footer', MainFooter);
Vue.component('top-button', TopBtn);

// regist global admin components
Vue.component('admin-login-form', AdminLoginForm);
Vue.component('admin-sidebar', AdminSidebar);
Vue.component('admin-header', AdminHeader);
Vue.component('admin-footer', AdminFooter);
Vue.component('admin-product-category-add-modal', AdminProductCategoryAddModal);
Vue.component('admin-member-update-modal', AdminMemberUpdateModal);

// regist global npm components
Vue.component('admin-loader', GridLoader);
Vue.component('frontend-loader', SyncLoader);
Vue.component('data-loader', FadeLoader);
