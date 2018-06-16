import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        cartItems: JSON.parse(sessionStorage.getItem('cartItems'))==null ? [] : JSON.parse(sessionStorage.getItem('cartItems')),
        countItems: 0,
        modalActive: false,
        contenidoModal: {
          titulo: '',
          cuerpo: ''
        },
        isLoggedIn: !!localStorage.getItem('token') || !!sessionStorage.getItem('token'),
        avatar: JSON.parse(localStorage.getItem('user'))==null ? 'default.jpg' : JSON.parse(localStorage.getItem('user')).avatar
                || JSON.parse(sessionStorage.getItem('user'))==null ? 'default.jpg' : JSON.parse(sessionStorage.getItem('user')).avatar,
        token: localStorage.getItem('token')==null ? sessionStorage.getItem('token') : localStorage.getItem('token'),
        userId: JSON.parse(localStorage.getItem('user')) !=null ? JSON.parse(localStorage.getItem('user')).id : JSON.parse(sessionStorage.getItem('user')) !=null ? JSON.parse(sessionStorage.getItem('user')).id : null,
        name: JSON.parse(localStorage.getItem('user')) !=null ? JSON.parse(localStorage.getItem('user')).name : JSON.parse(sessionStorage.getItem('user')) !=null ? JSON.parse(sessionStorage.getItem('user')).name : null,
        email: JSON.parse(localStorage.getItem('user')) !=null ? JSON.parse(localStorage.getItem('user')).email : JSON.parse(sessionStorage.getItem('user')) !=null ? JSON.parse(sessionStorage.getItem('user')).email : null,
        telefono: JSON.parse(localStorage.getItem('user')) !=null ? JSON.parse(localStorage.getItem('user')).telefono : JSON.parse(sessionStorage.getItem('user')) !=null ? JSON.parse(sessionStorage.getItem('user')).telefono : null
    },
    getters: {
        avatar: (state) => state.avatar,
        isLoggedIn: (state) => state.isLoggedIn,
        token: (state) => state.token,
        userId: (state) => state.userId,
        name: (state) => state.name,
        email: (state) => state.email,
        telefono: (state) => state.telefono,
        cartItems: (state) => state.cartItems,
        countItems: (state) => state.cartItems.reduce((prev,next) => prev + next.cantidad,0),
        modalActive: (state) => state.modalActive,
        contenidoModal: (state) => state.contenidoModal,
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
        },
        changeName(state, name){
            state.name = name;
        },
        changeEmail(state, email){
            state.email = email;
        },
        changeTelefono(state, telefono){
            state.telefono = telefono;
        },
        closeModal(state){
            state.modalActive = false;
        },
        addCartItem(state,cartItem){
            if (state.cartItems.some(item => item.producto === cartItem.producto)) {
                let targetCartItem = state.cartItems.find(item => item.producto.id === cartItem.producto.id);

                let suma = targetCartItem.cantidad + cartItem.cantidad;

                if (suma > 10){
                    let resto = suma - 10;
                    targetCartItem.cantidad = suma - resto;

                    state.contenidoModal = {
                        titulo: '¿Vas a poder con todo eso?',
                        cuerpo: 'Si vas a asistir con un grupo grande de amigos te recomendamos que te pongas en contacto con nosotros, ¡Podemos ofrecerte grandes descuentos!'
                    };

                    state.modalActive = true;

                    sessionStorage.setItem('cartItems',JSON.stringify(state.cartItems));

                } else{
                    targetCartItem.cantidad = suma;
                    sessionStorage.setItem('cartItems',JSON.stringify(state.cartItems));
                }

            } else {
                state.cartItems.push(cartItem);
                sessionStorage.setItem('cartItems',JSON.stringify(state.cartItems));
            }

        },
        incrementCantidad(state,id){
            let targetCartItem = state.cartItems.find(item => item.producto.id === id);
            if (targetCartItem.cantidad <= 9){
                targetCartItem.cantidad += 1;
            }
            sessionStorage.setItem('cartItems',JSON.stringify(state.cartItems));
        },
        decrementCantidad(state,id){
            let targetCartItem = state.cartItems.find(item => item.producto.id === id);
            if(targetCartItem.cantidad > 1){
                targetCartItem.cantidad -= 1;
            }
            sessionStorage.setItem('cartItems',JSON.stringify(state.cartItems));
        },
        removeCartItem(state,cartItem){
            let items = state.cartItems;
            let index = items.indexOf(cartItem);
            if (index > -1) {
                items.splice(index, 1);
            }
            sessionStorage.setItem('cartItems',JSON.stringify(state.cartItems));
        }
    }
});