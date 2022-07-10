import Vue from 'vue';

// npm components
import { GridLoader } from '@saeris/vue-spinners' // loading-spinner

// frontend components
import MainHeader from './components/MainHeader.vue';

// admin components
import AdminLoginForm from './components/admin/LoginForm.vue';
import AdminSidebar from './components/admin/Sidebar.vue';
import AdminHeader from './components/admin/AdminHeader.vue';
import AdminFooter from './components/admin/AdminFooter.vue';
import AdminProductCategoryAddModal from './components/admin/ProductCategoryAddModal.vue';
import AdminMemberUpdateModal from './components/admin/MemberUpdateModal.vue';

// regist global frontend components
Vue.component('main-header', MainHeader);

// regist global admin components
Vue.component('admin-login-form', AdminLoginForm);
Vue.component('admin-sidebar', AdminSidebar);
Vue.component('admin-header', AdminHeader);
Vue.component('admin-footer', AdminFooter);
Vue.component('admin-product-category-add-modal', AdminProductCategoryAddModal);
Vue.component('admin-member-update-modal', AdminMemberUpdateModal);

// regist global npm components
Vue.component('admin-loader', GridLoader);
