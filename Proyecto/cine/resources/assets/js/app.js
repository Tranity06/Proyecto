
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import router from './routes.js';
import VeeValidate from 'vee-validate';
import { Validator } from 'vee-validate';

window.Vue = require('vue');

Vue.use(VeeValidate);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.axios = axios
axios.defaults.baseURL = 'http://localhost:8000';

const dict = {
    custom: {
        email: {
            required: 'Introduce un email valido.',
            email: 'que es esto?'
        },
        name: {
            required: () => 'Your name is empty'
        }
    }
};

Validator.localize('es', dict);

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('entrada-component', require('./components/EntradaComponent.vue'));
Vue.component('seat-component', require('./components/SeatComponent.vue'));

import App from './views/App';

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
