import { createApp } from 'vue';
import '../css/app.css';

import LandingApp from './landing/main';
import AdminApp from './admin/main';
import CategoriesApp from './admin/categories/main';
import ProductApp from './admin/product/main';
import LoginApp from './auth/main';
import CustomersApp from './admin/customers/main';
import OrdersApp from './admin/orders/main';

console.log('app.js loaded');

if (document.getElementById('landing-app')) {
    createApp(LandingApp).mount('#landing-app');
}
if (document.getElementById('admin-app')) {
    createApp(AdminApp).mount('#admin-app');
}
if (document.getElementById('login-app')) {
    createApp(LoginApp).mount('#login-app');
}
if (document.getElementById('categories-app')) {
    createApp(CategoriesApp).mount('#categories-app');
}
if (document.getElementById('product-app')) {
    createApp(ProductApp).mount('#product-app');
}
if (document.getElementById('customers-app')) {
    createApp(CustomersApp).mount('#customers-app');
}
if (document.getElementById('orders-app')){
    createApp(OrdersApp).mount('#orders-app');
}

