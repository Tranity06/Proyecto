
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
import '../../../node_modules/nprogress/nprogress.css';
import NProgress from 'nprogress';



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

moment.locale('es');

window.axios = axios;
axios.defaults.baseURL = 'http://localhost:8000';

// Add a request interceptor
axios.interceptors.request.use(function (config) {
    // Do something before request is sent
    NProgress.start();
    return config;
}, function (error) {
    // Do something with request error
    NProgress.done();
    console.error(error)
    return Promise.reject(error);
});

// Add a response interceptor
axios.interceptors.response.use(function (response) {
    // Do something with response data
    NProgress.done();
    return response;
}, function (error) {
    // Do something with response error
    NProgress.done();
    console.error(error)
    return Promise.reject(error);
});


const dict = {
    custom: {
        email: {
            required: 'El email no puede estar vacío',
            email: 'El email no es correcto'
        },
        nombre: {
            required: 'El nombre no puede estar vacío',
            alpha: 'El nombre sólo puede contener caracteres alfabéticos y sin espacios',
            alpha_spaces: 'El nombre sólo puede contener caracteres alfabéticos y espacios',
            min: 'El nombre debe tener mínimo 3 caracteres',
            max: 'El nombre debe tener máximo 30 caracteres'
        },
        telefono: {
           required: 'El teléfono no puede estar vacío',
           digits: 'El teléfono debe empezar por 6 y contener exactamente 9 dígitos'
        },
        password: {
            required: 'La contraseña no puede estar vacía',
            min: 'La contraseña debe tener mínimo 6 caracteres',
            max: 'La contraseña debe tener máximo 30 caracteres'
        },
        password_confirmation: {
            required: 'La contraseña no puede estar vacía',
            min: 'La contraseña debe tener mínimo 6 caracteres',
            max: 'La contraseña debe tener máximo 30 caracteres',
            confirmed: 'Las contraseñas no coinciden'
        },
        numero: {
            required: 'El número no puede estar vacío',
            credit_card: 'El número no es valido'
        },
        codigo: {
            required: 'El código no puede estar vacío',
            digits: 'El código debe ser numérico y contener exactamente 3 dígitos'
        },
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
