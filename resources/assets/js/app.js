/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Vue component loader
 */
function load(pathname) {
    return require('./components/' + pathname + '.vue');
}

window.Vue = require('vue');

/**
 * vue-router is the official router for Vue.js.
 * It deeply integrates with Vue.js core to make building
 * Single Page Applications with Vue.js a breeze
 */
import VueRouter from 'vue-router';
Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'home',
        component: load('Home')
    },
    {
        path: '/category',
        name: 'category.index',
        component: load('category/Index')
    },
    {
        path: '/category/:id',
        name: 'category.show',
        component: load('category/Show')
    },
    {
        path: '/quote',
        name: 'quote.index',
        component: load('quote/Index')
    },
    {
        path: '/quote/new',
        name: 'quote.create',
        component: load('quote/Create')
    }
];

const router = new VueRouter({routes});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    router
}).$mount('#app');
