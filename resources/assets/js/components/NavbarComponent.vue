<template>
    <nav class="navbar is-fixed-top is-transparent animate-search" v-click-outside="hide" :class="{'fondoblanco': fondoBlanco}">
        <div class="main-search" :class="{'puedo-ver': searchDisparado === true }">
            <div class="container">

                <ais-index :app-id="'0TZV0R68WE'"
                           :api-key="'40ed7ce0a36dde51997fb88645263243'"
                           :index-name="'peliculas'"
                           :query="query"
                          >
                    <input v-model="query" class="ais-input" placeholder="Busca ..." autofocus>
                    <ais-results>
                        <template slot-scope="{ result }">
                            <div class="pelicula-item">
                                <div>
                                    <span class="has-text-weight-bold">{{ result.titulo }}</span>
                                    <span>{{ result.duracion }} min</span>
                                </div>
                                <div>
                                    <span class="button is-light is-small" @click="irEntrada(result.id)">
                                        ver pelicula
                                    </span>
                                    <a :href="result.trailer" class="button is-light is-small" data-lity @click="verTrailer()">
                                        ver trailer
                                    </a>
                                </div>
                            </div>
                        </template>
                    </ais-results>
                </ais-index>

                <span class="situarIzquierda" @click="hide"><i class="fas fa-times"></i></span>

            </div>
        </div>
        <div class="container" v-if="searchDisparado === false">
            <div class="navbar-brand">
                <router-link class="navbar-item" :to="{ name: 'home' }">
                    <div class="logo-container">
                        <img src="/48px.png" alt="Logo" class="is-hidden-mobile">
                        <span :class="{'has-text-black': textblack && textblackLogo}" @click="closeMenu" >Palomitas time</span>
                    </div>
                </router-link>
                <span class="navbar-burger burger" :class="{'is-active': isActive,'has-text-black': textblack && textblackLogo}" data-target="navbarMenuHeroA" @click="menu">
                <span></span>
                <span></span>
                <span></span>
                </span>
            </div>
            <div id="navbarMenuHeroA" class="navbar-menu" :class="{'is-active': isActive,'has-text-black': textblack}">
                <div class="navbar-start">
                    <router-link class="navbar-item has-text-white is-active" :to="{ name: 'home' }" :class="{'has-text-black': textblack}">
                        <span  @click="closeMenu">Películas</span>
                    </router-link>
                    <router-link class="navbar-item has-text-white" :to="{ name: 'restaurante' }" :class="{'has-text-black': textblack}" >
                        <span @click="closeMenu">Restaurante</span>
                    </router-link>
                    <a class="navbar-item has-text-white" :class="{'has-text-black': textblack}" @click="closeMenu">
                        Acerca de
                    </a>
                </div>
                <div class="navbar-end">
                    <span class="navbar-item"  :class="{'has-text-black': textblack,'has-text-white': !textblack}" @click="dispararSearch"><i class="fas fa-search fa-lg"></i></span>
                    <span class="navbar-item navbar-item-end">
                        <div class="user-login" v-show="StoreStateEnabled">
                          <i class="fas fa-shopping-cart fa-sm carta"></i>
                          <div class="dropdown is-hoverable">
                              <div class="dropdown-trigger">
                                  <img class="avatar"
                                       :src="'/uploads/avatars/'+getAvatar"
                                       aria-haspopup="true" aria-controls="dropdown-menu">
                              </div>
                              <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                <div class="dropdown-content">
                                    <router-link class="dropdown-item" :to="{ name: 'profile' }">
                                        Perfil
                                    </router-link>
                                  <hr class="dropdown-divider">
                                  <a class="dropdown-item is-link" @click="Logout">
                                     Salir
                                  </a>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div v-show="!StoreStateEnabled" style="display: flex; justify-content: center">
                            <router-link class="button is-primary entrar" :to="{ name: 'login' }">
                                <div class="logo-container">
                                    <span @click="closeMenu">Entrar</span>
                                </div>
                            </router-link>
<!--                            <a href="http://www.facebook.com" class="centeredIcon">
                                <i class="fab fa-google"></i>
                            </a>-->
                              <g-signin-button
                                      class="centeredIcon"
                                      :params="googleSignInParams"
                                      @success="onSignInSuccess"
                                      @error="onSignInError">
                                <i class="fab fa-google"></i>
                              </g-signin-button>
                        </div>
                </span>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
    import store from '../store';
    import ClickOutside from 'vue-click-outside';

    export default {
        name: "navbar-component",
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
                query: ''
            }
        },
        computed: {
            StoreStateEnabled() {
                return store.state.isLoggedIn;
            },
            getAvatar(){
                return store.getters.avatar;
             }
        },
        methods: {
            Logout() {
                store.commit('logoutUser');
                this.$notify({
                    group: 'auth',
                    text: '¡Has cerrado la sesión con exito!',
                    duration: 5000,
                });
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
                this.$router.replace({ path: `/pelicula/${id}` })
            },
            verTrailer(){
                this.searchDisparado = false;
            },
            hide(event) {
                this.searchDisparado = false;
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
            }
        },
        // do not forget this section
        directives: {
            ClickOutside
        }
    }
</script>

<style scoped>

    .situarIzquierda{
        color: white;
        position: absolute;
        top: 15px;
        left: 70%;
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
            margin: 0 calc(5% + 116px) 0 calc(5% + 170px);
            box-shadow: 0 4px 40px rgba(0,0,0,.39);

            background-color: #fff;
            max-height: calc(100vh - 50px);
            overflow-y: auto;
            border-radius: 3px;
        }
    }


    .ais-results{
        padding: 1em;
        background-color: #fff;
        margin-top: 15px;
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

    <!-->

    .animate-search .main-search.puedo-ver {
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
    }

    .main-search {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2;
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
        margin-right: 9px;
        margin-left: 5px;
    }
</style>