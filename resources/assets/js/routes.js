import Vue from 'vue';
import VueRouter from 'vue-router';
import NProgress from 'nprogress';

Vue.use(VueRouter);

import Pelicula from './views/Pelicula';
import Home from './views/Home';
import Login from './views/Login';
import Register from './views/Register';
import Profile from './views/Profile';
import Restaurante from './views/Restaurante';
import Entrada  from './components/EntradaComponent';

const routes = [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/pelicula/:id',
            name: 'pelicula',
            component: Pelicula,
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/restaurante',
            name: 'restaurante',
            component: Restaurante,
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/profile',
            name: 'profile',
            component: Profile,
            meta: { requiresAuth: true }
        },
        {
            path: '/entrada/:id',
            name: 'entrada',
            component: Entrada,
            meta: { requiresAuth: true }
        },

    ];

const router = new VueRouter({
    mode: 'history',
    history: true,
    base: '/',
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 };
    },
    routes,
    linkExactActiveClass: 'is-active',
});

router.beforeResolve((to, from, next) => {
    // If this isn't an initial page load.
    if (to.name) {
        // Start the route progress bar.
        NProgress.start()
    }
    next()
})

router.afterEach((to, from) => {
    // Complete the animation of the route progress bar.
    NProgress.done()
})


/*
router.beforeEach((to, from, next) => {

    // check if the route requires authentication and user is not logged in
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
        // redirect to login page
        next({ name: 'login' })
        return
    }

    // if logged in redirect to dashboard
    if(to.path === '/login' && store.state.isLoggedIn) {
        next({ name: 'profile' })
        return
    }

    next()
});*/

export default router;