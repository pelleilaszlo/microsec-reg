/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.axios = require('axios');

window.axios.defaults.baseURL = '/api';

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    token = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

const api_token = document.head.querySelector('meta[name="api-token"]');

if (api_token) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + api_token.content;
}

window.Vue = require('vue').default;

import VueLodash from 'vue-lodash'
import lodash from 'lodash'
Vue.use(VueLodash, { name: 'custom' , lodash: lodash });
Vue.prototype.__ = (str, props) => {
    let text = _.get(window.i18n, str)
    _.forEach(props, function(value, key) {
        text = _.replace(text, ':'+key, value);
    });
    return text;
}

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('error-message', require('./components/ErrorMessage').default);
Vue.component('user-profile', require('./components/UserProfile.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
