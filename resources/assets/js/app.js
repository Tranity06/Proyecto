
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import router from './routes.js';
import Notifications from 'vue-notification';
import VeeValidate from 'vee-validate';
import { Validator } from 'vee-validate';
import moment from 'moment';
import GSignInButton from 'vue-google-signin-button';
import AlgoliaComponents from 'vue-instantsearch';



window.Vue = require('vue');
Vue.prototype.moment = moment;

Vue.use(VeeValidate);
Vue.use(Notifications);
Vue.use(GSignInButton);
Vue.use(AlgoliaComponents);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

moment.locale('es-Es');

window.axios = axios
axios.defaults.baseURL = 'http://localhost:8000';

const dict = {
    custom: {
        email: {
            required: 'El email no puede estar vacío',
            email: 'El email no es correcto'
        },
        nombre: {
            required: 'El nombre no puede estar vacío',
            alpha: 'Solo tu primer nombre'
        },
        telefono: {
           required: 'El teléfono no puede estar vacío',
           digits: 'El teléfono debe empezar por 6 y tener 9 números'
        },
        password: {
            required: 'La contraseña no puede estar vacía',
            min: 'La contraseña debe tener mínimo 6 caracteres'
        },
        password_confirmation: {
            required: 'La contraseña no puede estar vacía',
            min: 'La contraseña debe tener mínimo 6 caracteres',
            confirmed: 'Las contraseñas no coinciden'
        }
    }
};

Validator.localize('es', dict);

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('seat-component', require('./components/SeatComponent.vue'));

import App from './views/App';

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
