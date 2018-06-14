<template>
    <div>
        <section class="hero is-medium fondo" :style="{background: 'linear-gradient( rgba(67, 67, 67, 0.8), rgba(0, 0, 0, 0.8) ), url('+info.slider_image+')'}">
            <!-- Hero content: will be in the middle -->
            <div class="hero-body">
                <div class="container">
                    <div class="columns is-hidden-mobile">
                        <div class="column is-one-fifth-desktop is-hidden-touch">
                            <img :src="info.cartel" alt="Poster-pelicula"
                                 width="196px"
                                 height="266px"
                                 class="pelicula-poster"
                            >
                        </div>
                        <div class="column">
                            <div class="pelicula-header">
                                <h1 class="title has-text-white">
                                    {{ info.titulo }}
                                    <span class="tag is-danger">PE-7</span>
                                </h1>
                                <h2 class="subtitle has-text-white">
                                    {{ info.generos + ' '+info.duracion+'min' }}
                                </h2>

                                <a class="button is-warning is-rounded" :href="info.trailer" data-lity>Ver Trailer</a>

                                <h1 class="is-size-4 has-text-white">
                                    Sinopsis
                                </h1>
                                <p class="has-text-white">
                                    {{ info.sinopsis }}
                                </p>

                            </div>
                        </div>

                    </div>
                    <div class="is-hidden-tablet has-text-centered">
                        <a :href="info.trailer" data-lity><img src="/icons/play-button.svg"></a>
                        <h1 class="title has-text-white">
                            {{ info.titulo }}
                            <span class="tag is-danger">PE-7</span>
                        </h1>
                        <h2 class="subtitle has-text-white">
                            {{ info.generos + ' '+info.duracion+'min' }}
                        </h2>
                    </div>
                </div>
            </div>

            <!-- Hero footer: will stick at the bottom -->
            <div class="hero-foot sombra">
                <div class="es-posicionado">
                    <router-link class="button is-rounded" :to="'/entrada/'+id">
                        Comprar entrada
                    </router-link>
                </div>
            </div>
        </section>
        <!-- Hero -->
        <section class="section is-hidden-tablet">
            <div class="container has-text-justified">
                <h1 class="title">Sinopsis</h1>
                <p>
                    {{ info.sinopsis }}
                </p>
            </div>
        </section>
        <!-- Sinopsis -->

        <resenia-component></resenia-component>

    </div>
</template>

<script>
    import ReseniaComponent from "../components/Resenias/ReseniaComponent";

    const getPelicula = (id,callback) => {

        console.log(id);

        axios
            .get('/api/pelicula/'+id)
            .then(response => {
                console.log(response);
                callback(null, response.data);
            }).catch(error => {
            callback(error, error.response.data);
        });
    };

    export default {
        components: {ReseniaComponent},
        name: 'pelicula',
        data() {
            return {
                id: this.$route.params.id,
                info: []
            }
        },
        mounted(){
/*            axios.get(`/api/pelicula/${this.id}`)
                 .then(response => {
                    this.info = response.data;

                 })
                 .catch(error => {
                    console.log(error);
                 })*/
        },
        beforeRouteEnter (to, from, next) {
            getPelicula(to.params.id,(err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        methods: {
            setData(err, info) {
                if (err) {
                    this.error = err.toString();
                    console.log(this.error);
                } else {
                    this.info = info;
                }

                console.log(this.info);
            },
        }
    }
</script>
<style scoped>
    .pelicula-poster {
        border-radius: 10px;
    }
    .es-posicionado {
        display: flex;
        justify-content: center !important;
        position: relative;
        bottom: -20px;
    }
    .sombra {
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16);
    }

    .fondo{
        background-size: cover !important;
        background-position: center top !important;
    }

</style>