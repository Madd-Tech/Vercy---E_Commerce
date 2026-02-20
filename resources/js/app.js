import { createApp } from 'vue';
import '../css/app.css';

// Import Main Components (not the mount files)
import LandingApp from './landing/App.vue';
import AdminApp from './admin/App.vue';
import CategoriesApp from './admin/categories/App.vue';
import ProductApp from './admin/product/App.vue';
import CustomersApp from './admin/customers/App.vue';
import AdminOrdersApp from './admin/orders/App.vue';
import AdminOrderItemsApp from './admin/order_items/App.vue';

import LoginApp from './auth/App.vue';

import UsersProductApp from './users/product/App.vue';
import UsersSignupApp from './users/signup/App.vue';
import UsersOrderApp from './users/order/App.vue';
import UsersInvoiceApp from './users/invoice/App.vue';
import UsersOverviewApp from './users/overview/App.vue';

console.log('app.js loaded');

// Mounting Logic
const mountApp = (id, Component, props = {}) => {
    const el = document.getElementById(id);
    if (el) {
        const app = createApp(Component, props);
        // Pass data attributes as props if needed, or handle in component
        app.mount(`#${id}`);
    }
};

mountApp('landing-app', LandingApp);
mountApp('admin-app', AdminApp);
mountApp('login-app', LoginApp);
mountApp('categories-app', CategoriesApp);
mountApp('product-app', ProductApp);
mountApp('customers-app', CustomersApp);
mountApp('admin-orders-app', AdminOrdersApp);
mountApp('admin-order_items-app', AdminOrderItemsApp);

mountApp('users-product-app', UsersProductApp);
mountApp('users-signup-app', UsersSignupApp);
mountApp('users-order-app', UsersOrderApp);
mountApp('users-invoice-app', UsersInvoiceApp);
mountApp('users-overview-app', UsersOverviewApp);

