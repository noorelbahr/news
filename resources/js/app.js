/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('profile', require('./components/ProfileComponent.vue').default);
Vue.component('news-create-button', require('./components/NewsCreateButtonComponent.vue').default);

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Register from './components/Register';
import Login from './components/Login';
import Logout from './components/Logout';
import News from './components/News';
import NewsCreate from './components/NewsCreate';
import { store } from './store/store';

const router = new VueRouter({
    linkActiveClass: 'active',
    mode: 'history',
    routes: [
        {
            path: '/register',
            name: 'Register',
            component: Register
        }, {
            path: '/login',
            name: 'Login',
            component: Login
        }, {
            path: '/logout',
            name: 'Logout',
            component: Logout
        }, {
            path: '/news',
            name: 'News',
            component: News
        }, {
            path: '/news/create',
            name: 'NewsCreate',
            component: NewsCreate
        },
    ]
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store,
    router
});
