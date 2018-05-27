import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        isLoggedIn: !!localStorage.getItem('token') || !!sessionStorage.getItem('token'),
        avatar: JSON.parse(localStorage.getItem('user'))==null ? 'default.jpg' : JSON.parse(localStorage.getItem('user')).avatar
                || JSON.parse(sessionStorage.getItem('user'))==null ? 'default.jpg' : JSON.parse(sessionStorage.getItem('user')).avatar,
        token: localStorage.getItem('token')==null ? sessionStorage.getItem('token') : localStorage.getItem('token'),
        userId: JSON.parse(localStorage.getItem('user')) !=null ? JSON.parse(localStorage.getItem('user')).id : JSON.parse(sessionStorage.getItem('user')) !=null ? JSON.parse(sessionStorage.getItem('user')).id : null
    },
    getters: {
        avatar: (state) => state.avatar,
        isLoggedIn: (state) => state.isLoggedIn,
        token: (state) => state.token,
        userId: (state) => state.userId,
    },
    mutations: {
        loginUser (state) {
            state.isLoggedIn = true;
        },
        logoutUser (state) {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            sessionStorage.removeItem('token');
            sessionStorage.removeItem('user');
            state.isLoggedIn = false;
        },
        changeAvatar(state, avatar){
            state.avatar = avatar;
        },
        changeToken(state, token){
            state.token = token;
        },
        changeId(state, userId){
            state.userId = userId;
        }
    }
});