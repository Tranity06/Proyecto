import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        isLoggedIn: !!localStorage.getItem('token'),
        avatar: JSON.parse(localStorage.getItem('user'))==null ? 'default.jpg' : JSON.parse(localStorage.getItem('user')).avatar
    },
    getters: {
        avatar: state => state.avatar,
        isLoggedIn: state => state.isLoggedIn
    },
    mutations: {
        loginUser (state) {
            state.isLoggedIn = true
        },
        logoutUser (state) {
            state.isLoggedIn = false
        },
        changeAvatar(state, avatar){
            state.avatar = avatar;
        }
    }
})