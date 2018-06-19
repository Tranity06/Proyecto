<template>
    <div>
        <section class="hero is-dark">
            <div class="hero-body">
                <div class="container">
                    <div class="perfil-header">
                        <img :src="'uploads/avatars/'+getAvatar">
                        <div class="perfil-info">
                            <p class="is-size-2 has-text-weight-bold">
                                {{ getName }}
                            </p>
                            <p class="is-size-6 has-text-grey-light">
                                {{ getEmail }}
                            </p>
                            <p class="is-size-6 has-text-grey-light">
                                {{ getTelefono }}
                            </p>
                            <p class="is-size-6 has-text-grey-light">
                                1250 puntos
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-foot">
                <nav class="tabs is-boxed is-fullwidth">
                    <div class="container">
                        <ul>
                            <li :class="{'is-active': this.tab===1}">
                                <a @click="selectTab(1)">
                                    <span class="icon is-small"><i class="fas fa-cog" aria-hidden="true"></i></span>
                                    <span class="is-hidden-mobile">Cambiar Datos</span>
                                </a>
                            </li>
                            <li :class="{'is-active': this.tab===2}">
                                <a @click="selectTab(2)">
                                    <span class="icon is-small"><i class="fas fa-ticket-alt"></i></span>
                                    <span class="is-hidden-mobile">Entradas</span>
                                </a>
                            </li >
                            <li :class="{'is-active': this.tab===3}">
                                <a @click="selectTab(3)">
                                    <span class="icon is-small"><i class="far fa-comment" aria-hidden="true"></i></span>
                                    <span class="is-hidden-mobile">Reseñas</span>
                                </a>
                            </li>
                            <li :class="{'is-active': this.tab===4}">
                                <a @click="selectTab(4)">
                                    <span class="icon is-small"><i class="far fa-star" aria-hidden="true"></i></span>
                                    <span class="is-hidden-mobile">Ofertas</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </section>
        <section class="section">
            <div class="container is-fluid">
<!--                <div class="columns">
                    <div class="column is-10-tablet is-offset-2-tablet">
                        <form v-on:submit.prevent="upload">
                            <label>Cambiar   atar</label>
                            <input type="file" name="avatar" @change="onFileChange">
                            <input type="submit" class="button" value="Guardar">
                        </form>
                    </div>
                </div>-->
                <div class="flexcontainer" v-if="this.tab === 1">
                    <cambiar-avatar class="tarjeta"></cambiar-avatar>
                    <cambiar-email class="tarjeta"></cambiar-email>
                    <cambiar-telefono class="tarjeta"></cambiar-telefono>
                    <cambiar-clave class="tarjeta"></cambiar-clave>
                    <eliminar-cuenta class="tarjeta"></eliminar-cuenta>
                </div>
                <div v-if="this.tab === 2">
                    <pelicula-ticket v-for="ticket in tickets" :key="ticket.id" :ticket="ticket"></pelicula-ticket>
                </div>
                <div v-if="this.tab === 3">
                    <ver-resenias v-for="resenia in resenias" :key="resenia.id" :tituloPelicula="resenia.pelicula_id" :fecha="resenia.created_at" :texto="resenia.comentario"></ver-resenias>
                </div>
                <div v-if="this.tab === 4">
                    Ofertas
                </div>
            </div>
        </section>
    </div>
</template>
<script>
    import store from '../store';
    import CambiarEmail from "../components/Cambiar_datos/cambiarEmail";
    import CambiarTelefono from "../components/Cambiar_datos/cambiarTelefono";
    import CambiarClave from "../components/Cambiar_datos/cambiarClave";
    import CambiarAvatar from "../components/Cambiar_datos/cambiarAvatar";
    import PeliculaTicket from "../components/PeliculaTicket";
    import VerResenias from "../components/Resenias/verResenias";
    import EliminarCuenta from "../components/Cambiar_datos/eliminarCuenta";

    export default {
        components: {
            EliminarCuenta,
            VerResenias,
            PeliculaTicket,
            CambiarAvatar,
            CambiarClave,
            CambiarTelefono,
            CambiarEmail},
        data() {
            return {
                image: '',
                tab: 1,
                resenias: [],
                tickets: [],
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        computed: {
            getAvatar(){
                return store.getters.avatar;
            },
            getName(){
                return store.getters.name;
            },
            getEmail(){
                return store.getters.email;
            },
            getTelefono(){
                return store.getters.telefono;
            }
        },
        mounted() {
            axios.get(`/api/resena?token=${store.getters.token}`)
            .then(response => {
                this.resenias = response.data
            })
            .catch(error => {
                console.log(error);
            });
            axios.get(`/api/tickets?token=${store.getters.token}`)
                .then(response => {
                    this.tickets = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            upload(){
                axios.post('/api/avatar',{
                        userId: store.getters.userId,
                        image: this.image
                    }
                ).then(response => {
                    console.log(response.data);
                    store.commit('changeAvatar',response.data.avatar_name);
                });
            },
            selectTab(selectedTab) {
                switch (selectedTab){
                    case 1:
                        this.tab = 1;
                        console.log(this.tab);
                        break;
                    case 2:
                        this.tab = 2;
                        console.log(this.tab);
                        break;
                    case 3:
                        this.tab = 3;
                        break;
                    case 4:
                        this.tab = 4;
                        break;
                }
            }
        }
    }
</script>
<style scoped>

    .flexcontainer {
        display: flex;
        align-items: center;
        justify-content: center;
        /* You can set flex-wrap and
           flex-direction individually */
        flex-direction: row;
        flex-wrap: wrap;
        /* Or do it all in one line
          with flex flow */
        flex-flow: row wrap;
        /* tweak where items line
           up on the row
           valid values are: flex-start,
           flex-end, space-between,
           space-around, stretch */
        align-content: flex-end;
    }

    .tarjeta {
        width: 325px;
        height: auto;
        margin: .5rem .5rem;
    }

    .container{
        display: flex;
        justify-content: center;
    }

    .perfil-header{
        display: flex;
        align-items: center;
    }

    .perfil-header > img {
        width:150px;
        height:150px;
        float:left;
        border-radius:50%;
        margin-right:25px;
    }

    @media (max-width: 768px){

        .perfil-header > img {
            width:100px;
            height:100px;
        }
    }

    .perfil-info{
        display: flex;
        flex-direction: column;
    }
</style>