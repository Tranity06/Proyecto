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
                        <i class="fa fa-play-circle fa-3x" style="color: white" aria-hidden="true"></i>
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
                        <a class="button is-large is-rounded">
                            Comprar Entrada
                        </a>
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

        <div class="section">
            <div class="container">
                <div class="actores-list">
                    <div class="actor-item">
                        <img class="actor-foto" src="https://image.tmdb.org/t/p/w138_and_h175_face/9nhqKVGA09DLeZqsvWVoNeTRlRQ.jpg" alt="Imagen del actor." width="138px" height="175px">
                        <div class="actor-detalles">
                            <span class="actor-nombre">Viola Davis</span>
                            <span class="papel-nombre">Amanda Waller</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="container">
                <escribir-resenia :idPelicula="id"></escribir-resenia>
                <resenia-component></resenia-component>
                <!-- Reseñas de otros -->
            </div>
        </section>
        <!-- Reseñas -->
    </div>
</template>

<script>
    import ReseniaComponent from "../components/ReseniaComponent";
    import EscribirResenia from "../components/Resenias/EscribirResenia";

    export default {
        components: {
            EscribirResenia,
            ReseniaComponent},
        name: 'pelicula',
        data() {
            return {
                id: this.$route.params.id,
                info: []
            }
        },
        mounted(){
            axios.get(`/api/pelicula/${this.id}`)
                 .then(response => {
                    this.info = response.data;

                 })
                 .catch(error => {
                    console.log(error);
                 })
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