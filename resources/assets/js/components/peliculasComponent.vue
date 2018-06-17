<template>
    <section class="section-peliculas">
        <div class="container">

            <div class="columns is-multiline is-centered nomarginright" v-if="this.tab === 1">
                <div class="column is-3-desktop-only is-narrow" v-for="(index,key,pelicula) in peliculas">
                    <div class="pelicula-card centrar-imagen">
                        <img :src="peliculas[key].cartel">
                        <div class="pelicula-trailer grow">
                            <a :href="peliculas[key].trailer" data-lity><img src="icons/play-button.svg"></a>
                        </div>
                        <div class="pelicula-body">
                            <div class="pelicula-opciones">
                                <div class="buttons">
                                    <router-link class="button is-rounded" :to="'/pelicula/'+peliculas[key].id">
                                        <img src="icons/arrow-pointing-to-right.svg">
                                    </router-link>
                                    <router-link class="button is-rounded" :to="'/entrada/'+peliculas[key].id">
                                        Comprar entrada
                                    </router-link>
                                </div>
                            </div>
                            <div class="pelicula-horario">
<!--                                <div class="tags">
                                    <sesion-component v-for="sesion in peliculas[key].sesiones" :key="sesion.id" :sesion="sesion"></sesion-component>
                                </div>-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="columns is-multiline is-centered nomarginright" v-if="this.tab === 2">
                <div class="column is-3-desktop-only is-narrow" v-for="(index,key,pelicula) in peliculasEstreno">
                    <div class="pelicula-card centrar-imagen">
                        <img :src="peliculasEstreno[key].cartel">
                        <div class="pelicula-trailer grow">
                            <a :href="peliculasEstreno[key].trailer" data-lity><img src="icons/play-button.svg"></a>
                        </div>
                        <div class="pelicula-body">
                            <div class="pelicula-opciones">
                                <div class="buttons">
                                    <router-link class="button is-rounded" :to="'/pelicula/'+peliculasEstreno[key].id">
                                        <img src="icons/arrow-pointing-to-right.svg">
                                    </router-link>
                                    <router-link class="button is-rounded" :to="'/entrada/'+peliculasEstreno[key].id">
                                        Comprar entrada
                                    </router-link>
                                </div>
                            </div>
                            <div class="pelicula-horario">
                                <!--                                <div class="tags">
                                                                    <sesion-component v-for="sesion in peliculas[key].sesiones" :key="sesion.id" :sesion="sesion"></sesion-component>
                                                                </div>-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="columns is-multiline is-centered nomarginright" v-if="this.tab === 3">
                <div class="column is-3-desktop-only is-narrow" v-for="(index,key,pelicula) in peliculasProximo">
                    <div class="pelicula-card centrar-imagen">
                        <img :src="peliculasProximo[key].cartel">
                        <div class="pelicula-trailer grow">
                            <a :href="peliculasProximo[key].trailer" data-lity><img src="icons/play-button.svg"></a>
                        </div>
                        <div class="pelicula-body">
                            <div class="pelicula-opciones">
                                <div class="buttons">
                                    <router-link class="button is-rounded" :to="'/pelicula/'+peliculasProximo[key].id">
                                        <img src="icons/arrow-pointing-to-right.svg">
                                    </router-link>
                                    <router-link class="button is-rounded" :to="'/entrada/'+peliculasProximo[key].id">
                                        Comprar entrada
                                    </router-link>
                                </div>
                            </div>
                            <div class="pelicula-horario">
                                <!--                                <div class="tags">
                                                                    <sesion-component v-for="sesion in peliculas[key].sesiones" :key="sesion.id" :sesion="sesion"></sesion-component>
                                                                </div>-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="columns is-multiline is-centered nomarginright" v-if="this.tab === 4">
                <div class="column is-3-desktop-only is-narrow" v-for="(index,key,pelicula) in peliculasTOP">
                    <div class="pelicula-card centrar-imagen">
                        <img :src="peliculasTOP[key].cartel">
                        <div class="pelicula-trailer grow">
                            <a :href="peliculasTOP[key].trailer" data-lity><img src="icons/play-button.svg"></a>
                        </div>
                        <div class="pelicula-body">
                            <div class="pelicula-opciones">
                                <div class="buttons">
                                    <router-link class="button is-rounded" :to="'/pelicula/'+peliculasTOP[key].id">
                                        <img src="icons/arrow-pointing-to-right.svg">
                                    </router-link>
                                    <router-link class="button is-rounded" :to="'/entrada/'+peliculasTOP[key].id">
                                        Comprar entrada
                                    </router-link>
                                </div>
                            </div>
                            <div class="pelicula-horario">
                                <!--                                <div class="tags">
                                                                    <sesion-component v-for="sesion in peliculas[key].sesiones" :key="sesion.id" :sesion="sesion"></sesion-component>
                                                                </div>-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

    import SesionComponent from "./Peliculas/sesionComponent";

    export default {
        components: {SesionComponent},
        props: {
            tab: {
                type: Number,
                required: true
            }
        },
        name: "peliculas-component",
        data() {
            return {
                peliculas: [],
                peliculasTOP: [],
                peliculasEstreno: [],
                peliculasProximo: [],
            }
        },
        mounted() {
            axios.get('/api/peliculas')
                .then(response => {
                    this.setPeliculas(response.data);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        methods: {
            setPeliculas(peliculas){
                this.peliculas = peliculas;
                this.peliculasEstreno = peliculas.filter(pelicula => pelicula.is_estreno === true);
                this.peliculasProximo = peliculas.filter(pelicula => pelicula.proximamente === true);
                this.peliculasTOP = peliculas.slice(0).sort((min,max) => max.popularidad - min.popularidad)
            }
        }
    }
</script>

<style scoped>
    /* Pelicula Card */

    .nomarginright{
        margin-left: 0 !important;
         margin-right: 0 !important;
    }

    .section-peliculas{
        margin-bottom: 1.5rem;
    }

    .pelicula-card {
        width: 250px;
        height: auto;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 3px 3px 20px rgba(0, 0, 0, .5);
        text-align: center;
        position: relative;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: .7rem;
        line-height: 0;
        /* margin-left: auto;
        margin-right: auto; */
    }


    .pelicula-body {
        width: 100%;
        height: 25%;
        position: absolute;
        bottom: 0;
        left: 0;
    }

    .pelicula-trailer {
        position: absolute;
        top: 30%;
        left: 40%;
    }

    .pelicula-horario {
        display: flex;
        justify-content: center;
        padding-bottom: 10px;
    }

    .pelicula-opciones {
        display: flex;
        justify-content: center;
        opacity: 0;
        margin-bottom: 10px;
    }

    @media only screen and (max-width: 1024px) {
        .pelicula-opciones {
            opacity: 1;
        }
    }

    .pelicula-card:hover .pelicula-opciones{
        opacity: 1;
        transition: opacity .4s;
    }

    .grow { transition: all .2s ease-in-out; }
    .grow:hover { transform: scale(1.2); }

</style>