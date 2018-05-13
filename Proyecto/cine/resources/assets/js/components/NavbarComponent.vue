<template>
    <nav class="navbar is-fixed-top">
        <div class="container">
            <div class="navbar-brand">
                <router-link class="navbar-item" :to="{ name: 'home' }">
                    <div class="logo-container">
                        <img src="48px.png" alt="Logo">
                        <span>Palomitas time</span>
                    </div>
                </router-link>
                <span class="navbar-burger burger" data-target="navbarMenuHeroA">
                <span></span>
                <span></span>
                <span></span>
              </span>
            </div>
            <div id="navbarMenuHeroA" class="navbar-menu">
                <div class="navbar-end">
                    <a class="navbar-item is-active">
                        Películas
                    </a>
                    <a class="navbar-item">
                        Restaurante
                    </a>
                    <a class="navbar-item">
                        Acerca de
                    </a>
                    <span class="navbar-item navbar-item-end">
                        <div class="user-login" v-show="StoreStateEnabled">
                          <i class="fas fa-shopping-cart fa-sm carta"></i>
                          <div class="dropdown is-hoverable">
                              <div class="dropdown-trigger">
                                  <img class="avatar"
                                       :src="'uploads/avatars/'+getAvatar"
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
                        <div v-show="!StoreStateEnabled" style="display: flex;">
                            <router-link class="button is-primary" :to="{ name: 'login' }">
                                <div class="logo-container">
                                    <span>Entrar</span>
                                </div>
                            </router-link>
                            <a href="http://www.facebook.com" class="centeredIcon">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </div>
                </span>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
    import store from '../store';

    export default {
        name: "navbar-component",
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
                localStorage.removeItem('token');
                store.commit('logoutUser');
                this.$notify({
                    group: 'auth',
                    text: '¡Has cerrado la sesión con exito!',
                    duration: 5000,
                });
                this.$router.push({ name: 'home' });
            }
        }
    }
</script>

<style scoped>
    .centeredIcon {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        width: 40px;
        height: 40px;
        color: dodgerblue;
        background-color: ghostwhite;
        border-radius: 100%;
        margin-left: .5rem;
        -webkit-transition: all .5s;
        -moz-transition: all .5s;
        transition: all .5s;
    }

    .centeredIcon:hover {
        color: white;
        background-color: dodgerblue;
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