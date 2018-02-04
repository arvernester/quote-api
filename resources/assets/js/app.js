
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Create localization function.
 */
Vue.prototype.__ = string => {
    const line = _.get(window.i18n, string)
    if (line) {
        return line
    }

    return string
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('contact-form', require('./components/contact/Form.vue'))
 

const app = new Vue({
    el: '#wrapper'
});
