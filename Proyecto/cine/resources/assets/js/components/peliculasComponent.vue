<template>
    <section class="section-peliculas">
        <div class="container">

            <div class="button">Filtro</div>

            <div class="columns is-multiline is-centered">
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
                                    <router-link class="button is-rounded" :to="{ name: 'entrada' }">
                                        Comprar entrada
                                    </router-link>
                                </div>
                            </div>
                            <div class="pelicula-horario">
                                <div class="tags">
                                    <span class="tag is-rounded is-light">17:30</span>
                                    <span class="tag is-rounded is-light">21:30</span>
                                    <span class="tag is-rounded is-light">23:00</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "peliculas-component",
        data() {
            return {
                peliculas: []
            }
        },
        mounted() {
            axios.get('/api/peliculas')
                .then(response => {
                    console.log(response.data);
                    this.peliculas = response.data;
                    console.log('HOLA: '+this.peliculas[0]['cartel']);
                })
                .catch(error => {
                    console.log(error);
                })
        }
    }
</script>

<style scoped>
    /* Pelicula Card */

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

    .pelicula-card:hover .pelicula-opciones{
        opacity: 1;
        transition: opacity .4s;
    }

    .grow { transition: all .2s ease-in-out; }
    .grow:hover { transform: scale(1.2); }

</style>