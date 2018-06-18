<template>
    <nav class="navbar is-fixed-top is-transparent" v-click-outside="hide" :class="{'fondoblanco': fondoBlanco}" aria-label="dropdown navigation">
        <div class="timer" v-if="start">
            <vue-countdown v-on:time-expire="handleTimeExpire" :seconds="120" :units="['minutes','seconds']" :start="start"></vue-countdown>
        </div>

        <div class="main-search" :class="{'puedo-ver': searchDisparado === true }" v-if="searchDisparado">
            <div class="container">

                <ais-index :app-id="'Z6VIFIHM1C'"
                           :api-key="'48e3d951455bb00f67cbe7a409376887'"
                           :index-name="'peliculas'"
                           :query="query"
                           :auto-search="false"
                          >
                    <input v-model.trim="query" v-focus class="ais-input" placeholder="Busca ..." autofocus>
                    <ais-results>
                        <template slot-scope="{ result }">
                            <div class="pelicula-item">
                                <div>
                                    <span class="has-text-weight-bold">{{ result.titulo }}</span>
                                    <span>{{ result.duracion }} min</span>
                                </div>
                                <div>
                                    <span class="button is-light is-small" @click="irEntrada(result.id)">
                                        información
                                    </span>
                                    <a :href="result.trailer" class="button is-light is-small" data-lity @click="verTrailer()">
                                        ver tráiler
                                    </a>
                                    <span class="button is-light is-small" @click="irComprarEntrada(result.id)">
                                        comprar entrada
                                    </span>
                                </div>
                            </div>
                        </template>
                    </ais-results>
                </ais-index>

                <span class="situarIzquierda" @click="hide"><i class="fas fa-times"></i></span>

            </div>
        </div>
        <transition name="cartcontainer-fade">
            <div class="cartcontainer" v-if="cartDisparado">
                <div class="cartcontainer__header" v-if="allCartItems.length > 0">
                    <span class="has-text-weight-bold is-size-5">PRECIO TOTAL</span>
                    <span class="is-size-5">{{precioTotal.toFixed(2)}}€</span>
                </div>
                <div style="width: 100%; text-align: center;" v-if="allCartItems.length > 0">
                    <span>Recuerda que debes comprar una entrada</span>
                    <span>para completar tu pedido.</span>
                </div>
                <div v-if="allCartItems.length > 0">
                    <div class="navbar-item-flexible">
                        <cart-item v-for="(item,index) in allCartItems"  :key="index" :item="item"></cart-item>
                    </div>
                </div>
                <div v-else style="display: flex; justify-content: center;">
                    <span class="has-text-weight-bold is-size-6" style="margin-top: 20px;">Tu carrito está vacío.</span>
                </div>
                <div style="display: flex; justify-content: center; margin-top: 20px;" >
                    <a   class="button is-rounded is-danger" @click="cerrarCartMobile">Cerrar</a>
                </div>
            </div>
        </transition>
        <div class="container" v-if="searchDisparado === false">
            <div class="navbar-brand">
                <router-link class="navbar-item no-activar" :to="{ name: 'home' }">
                    <div class="logo-container">
                        <img src="/48px.png" alt="Logo" class="is-hidden-mobile">
                        <span :class="{'has-text-black': textblack && textblackLogo}" @click="closeMenu" >Palomitas time</span>
                    </div>
                </router-link>
                <a class="nav-item is-hidden-desktop nearburguer" @click="mostrarCartMobile">
                    <i class="fas fa-shopping-cart" style="color: white"></i>
                    <ul class="count" :class="{'activo': countItems > 0 && !isActive}">
                        <li>{{countItems}}</li>
                        <li>2</li>
                    </ul>
                </a>
                <a role="button" class="navbar-burger" :class="{'is-active': isActive,'has-text-black': textblack && textblackLogo}" aria-label="menu" aria-expanded="false" @click="menu">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>
            <div id="navbarMenuHeroA" class="navbar-menu" :class="{'is-active': isActive,'has-text-black': textblack}">
                <div class="navbar-start">
                    <router-link class="navbar-item has-text-white" :to="{ name: 'home' }" :class="{'has-text-black': textblack}">
                        <span  @click="closeMenu">Películas</span>
                    </router-link>
                    <router-link class="navbar-item has-text-white" :to="{ name: 'restaurante' }" :class="{'has-text-black': textblack}" >
                        <span @click="closeMenu">Restaurante</span>
                    </router-link>
                </div>
                <div class="navbar-end">

                    <span class="navbar-item"  :class="{'has-text-black': textblack,'has-text-white': !textblack}" @click="dispararSearch"><i class="fas fa-search fa-sm"></i></span>
                    <span class="navbar-item navbar-item-end">
                        <shopping-cart class="is-hidden-touch" :active="isCartActive"></shopping-cart>
                        <div class="navbar-item has-dropdown perfilActivo" :class="{'is-active': isDropdownActive}" v-show="StoreStateEnabled">
                            <a class="navbar-link" @click="dropdown">
                                <img class="avatar"
                                     :src="'/uploads/avatars/'+getAvatar">
                            </a>
                            <div class="navbar-dropdown is-boxed">
                               <a class="navbar-item" @click="irPerfil">
                                   Perfil
                               </a>
                               <hr class="navbar-divider">
                               <a class="navbar-item" @click="Logout">
                                   Salir
                               </a>
                            </div>
                        </div>
                        <div v-show="!StoreStateEnabled" style="display: flex; justify-content: center">
                            <router-link class="button is-danger is-rounded entrar" :to="{ name: 'login' }">
                                <div class="logo-container">
                                    <span @click="closeMenu">Entrar</span>
                                </div>
                            </router-link>
<!--                            <a href="http://www.facebook.com" class="centeredIcon">
                                <i class="fab fa-google"></i>
                            </a>--><!--
                              <g-signin-button
                                      class="centeredIcon"
                                      :params="googleSignInParams"
                                      @success="onSignInSuccess"
                                      @error="onSignInError">
                                <i class="fab fa-google"></i>
                              </g-signin-button>-->
                        </div>
                </span>
                </div>
            </div>
        </div>
        <modal
                v-show="isModalVisible"
                @close="closeModal"
        >
            <span slot="header">Tu sesión ha expirado</span>
            <span slot="body">Qué dificil es decidir</span>
        </modal>
    </nav>
</template>

<script>
    import modal from './modal';
    import store from '../store';
    import ClickOutside from 'vue-click-outside';
    import ShoppingCart from "./shoppingCart";
    import CartItem from "./CartItem";
    import VueCountdown from '@dmaksimovic/vue-countdown';

    const focus = {
        inserted(el) {
            el.focus()
        },
    }

    export default {
        name: "navbar-component",
        components: {
            CartItem,
            ShoppingCart,
            'vue-countdown': VueCountdown,
            modal},
        data () {
            return {
                googleSignInParams: {
                    client_id: '807265199183-m5l3c4mkeftknbq73c2f8stdnimnk1nk.apps.googleusercontent.com'
                },
                searchDisparado: false,
                isActive: false,
                textblack: false,
                textblackLogo: true,
                fondoBlanco: false,
                query: '',
                isDropdownActive: false,
                isCartActive: false,
                cartDisparado: false,
                isModalVisible: false,
            }
        },
        computed: {
            StoreStateEnabled() {
                return store.state.isLoggedIn;
            },
            getAvatar(){
                return store.getters.avatar;
             },

            allCartItems(){
                return store.getters.cartItems;
            },
            precioTotal(){
                return store.getters.cartItems.reduce((prev,next) => prev + parseFloat(next.producto.precio)*next.cantidad,0);
            },
            countItems(){
                return store.getters.countItems;
            },
            start(){
                return store.getters.timerStart;
            }
        },

        methods: {
            showModal(){
                this.isModalVisible = true;
            },
            closeModal(){
                this.isModalVisible = false;
            },
            handleTimeExpire () {
                this.desreservarSeats();
                this.showModal();
                console.log(this.$router.currentRoute);
                if (this.$router.currentRoute.name === 'entrada'){
                    this.$router.push({ name: 'home' });
                }

            },
            desreservarSeats(){
                for (let i = 0; i< store.getters.selectedSeats.length; i++){
                    axios.post(`/api/butaca/${store.getters.selectedSeats[0]}`, {
                        estado: 0
                    })
                        .then(response => {
                        })
                        .catch(e => {
                            console.log(e);
                        });
                }
                store.commit('clearSelectedSeats');
                store.commit('changeTimerStart',false);
            },
            mostrarCartMobile(){
                this.cartDisparado = true;
            },
            Logout() {
                this.isDropdownActive = false;
                this.closeMenu();
                store.commit('logoutUser');
                this.$notify({
                    group: 'auth',
                    text: '¡Has cerrado la sesión con exito!',
                    duration: 5000,
                });
                if (store.getters.timerStart){
                    this.desreservarSeats();
                }
                this.$router.push({ name: 'home' });
            },
            onSignInSuccess (googleUser) {
                // `googleUser` is the GoogleUser object that represents the just-signed-in user.
                // See https://developers.google.com/identity/sign-in/web/reference#users
                const profile = googleUser.getBasicProfile().getEmail();// etc etc
                console.log(profile);
            },
            onSignInError (error) {
                // `error` contains any error occurred.
                console.log('OH NOES', error)
            },
            dispararSearch(){
                this.closeMenu();
                this.searchDisparado = true;
            },
            irEntrada(id){
                this.searchDisparado = false;
                this.query = '';
                this.$router.replace({ path: `/pelicula/${id}` })
            },
            irComprarEntrada(id){
                this.searchDisparado = false;
                this.query = '';
                this.$router.replace({ path: `/entrada/${id}` })
            },
            verTrailer(){
                this.query = '';
                this.searchDisparado = false;
            },
            irPerfil(){
                this.isDropdownActive = false;
                this.closeMenu();
                this.$router.push({ name: 'profile' });
            },
            hide(event) {
                this.searchDisparado = false;
                this.isCartActive = false;
                this.query = '';
            },
            menu() {

                //Hago click en el menu y
                //si esta a menos de 100px del top :: ABRO EL MENU
                // -> toggle fondoblanco DONE
                // -> toggle textblack DONE
                //si hago click en un link del menu ::
                // -> isActive = false DONE
                // -> textblack = false DONE
                // -> fondoblanco = false DONE
                //si esta a mas de 100px del top ::
                // -> toggle isActive
                // -> toggle textblack
                //si hago click en un link del menu ::
                // -> isActive = false
                // -> textblack = false
                // -> fondoblanco = false

                const scrollTop = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop);

                if (scrollTop < 100){
                    this.textblackLogo = true;
                    this.openMenu()
                } else {
                    this.textblack = !this.textblack;
                    this.textblackLogo = false;
                }

                this.isActive = !this.isActive;
            },

            openMenu(){
                this.fondoBlanco = !this.fondoBlanco;
                this.textblack = !this.textblack;
            },
            closeMenu(){
                this.isActive = false;
                this.textblack = false;
                this.fondoBlanco = false;
                this.isDropdownActive = false;
                this.isCartActive = false;
            },
            dropdown(){
                if (this.isDropdownActive === false){
                    this.isDropdownActive = true;
                } else {
                    this.isDropdownActive = false;
                }
            },
            cartDropdown(){
                if (this.isCartActive === false){
                    this.isCartActive = true;
                } else {
                    this.isCartActive = false;
                }
            },
            cerrarCartMobile(){
                this.cartDisparado = false;
            }


        },
        // do not forget this section
        directives: {
            ClickOutside,
            focus
        }
    }
</script>

<style scoped>
    .timer{
        position: absolute;
        width: 100%;
        height: 100%;
        padding: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-weight: bold;
    }
    .cartcontainer{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        z-index: 60;
        background-color: white;
    }

    .cartcontainer-fade-enter,
    .cartcontainer-fade-leave-active {
        opacity: 0;
    }

    .cartcontainer-fade-enter-active,
    .cartcontainer-fade-leave-active {
        transition: opacity .25s ease-out
    }

    .no-activar{
        background-color: transparent !important;
    }

    .situarIzquierda{
        color: white;
        position: absolute;
        top: 15px;
        left: 70%;
    }

    .situarIzquierda:hover{
        color: darkgrey;
        transition: color linear .25s;
    }

    .pelicula-item{
        display: flex;
        flex-direction: column;
    }

    .ais-index{
        position: absolute;
        margin: 10px 20%;
        width: 70%;

    }

    ::-ms-clear {
        display: none;
    }

    ::-webkit-search-decoration,
    ::-webkit-search-cancel-button,
    ::-webkit-search-results-button,
    ::-webkit-search-results-decoration {
        display: none;
    }

    @media only screen and (max-width: 600px){
        .situarIzquierda{
            left: 90%;
        }
    }

    @media only screen and (min-width: 768px){
        .ais-results{
            display: block;
            position: absolute;
            top: 44px;
            left: 0;
            padding: 2em;
            /*display: none;*/
            width: calc(90% - 286px);
            margin: 0 calc(5%) 0 calc(5%);
            box-shadow: 0 4px 40px rgba(0,0,0,.39);

            background-color: #fff;
            max-height: calc(100vh - 50px);
            overflow-y: auto;
            border-radius: 3px;
        }

        .ais-index{
            margin: 10px 26%;
        }
    }

    @media only screen and (max-width: 768px){
        .ais-results{
            margin-top: 15px;
        }
    }


    .ais-results{
        padding: 1em;
        background-color: #fff;
        max-height: calc(100vh - 60px);
        overflow-y: auto;
    }

    .ais-input {
        font-size: 1.4rem;
        color: #fff;
        /* height: 100%; */
        background-color: transparent;
        -webkit-appearance: none;
        -moz-appearance: none;
        -ms-appearance: none;
        -o-appearance: none;
        appearance: none;
        border: none;
        border-radius: 0;
    }

    .ais-input:focus{
        outline:none;
    }


    .main-search.puedo-ver {
        animation: slide-in .3s;
    }

    @keyframes slide-in {
        0% {
            transform: translateY(-100%)
        }

        to {
            transform: translateY(0)
        }
    }


    .main-search.puedo-ver {
        opacity: 1;
        visibility: visible;
        animation: slide-in .3s;
    }

    .main-search {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10;
        background: #191c1e;
        opacity: 0;
        visibility: hidden;
        transition: opacity .3s,visibility .3s;
    }


    .navbar-burger{
        color: #fff;
        z-index: 2;
    }

    .navbar-burger span{
        height: 2px;
    }
    
    .logo-container span{
        color: #fff;
    }

    .centeredIcon {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        width: 40px;
        height: 40px;
        color: #d34836;
        background-color: ghostwhite;
        border-radius: 100%;
        margin-left: .5rem;
        -webkit-transition: all .5s;
        -moz-transition: all .5s;
        transition: all .5s;
    }

    .centeredIcon:hover {
        color: white;
        background-color: #d34836;
    }

    .avatar {
        border-radius: 50%;
        display: block;
        width: 32px;
        height: 32px;
        margin-left: 5px;
    }

    .count {
        background: transparent;
        color: transparent;
        font-size: .6rem;
        font-weight: 700;
        border-radius: 50%;
        text-indent: 0;
        transition: transform .2s .5s,-webkit-transform .2s .5s;
        position: relative;
        top: -25px;
        right: -12px;
        height: 15px;
        width: 15px;
    }

    .count li {
        position: absolute;
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        left: 45%;
        top: 50%;
        bottom: auto;
        right: auto;
        -webkit-transform: translateX(-50%) translateY(-50%);
        -ms-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
    }

    .count li:last-of-type {
        visibility: hidden;
    }

    .count.activo {
        background: #e94b35;
        color: #fff;
        transition: background .25s ease-in, color .25s ease-in;
    }

    .navbar-item-flexible .navbar-item{
        display: flex;
        align-items: center;
        justify-content: space-around;
    }

    .cartcontainer__header{
        display: flex;
        justify-content: space-around;
        padding: 1rem;
    }

</style>