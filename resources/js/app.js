import { createApp } from 'vue';
import '../css/app.css';

import LandingApp from './landing/main';
import AdminApp from './admin/main';
import LoginApp from './auth/main';

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
