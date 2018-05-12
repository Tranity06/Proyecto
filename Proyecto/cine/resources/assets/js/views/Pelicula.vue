<template>
    <div>
        <section class="hero is-medium fondo" :style="{background: 'url('+info.slider_image+') top no-repeat'}">
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
                                <h1 class="title">
                                    {{ info.titulo }}
                                    <span class="tag is-light">PE-7</span>
                                </h1>
                                <h2 class="subtitle">
                                    {{ info.generos + ' '+info.duracion+'min' }}
                                </h2>
                                <h1 class="is-size-4">
                                    Sinopsis
                                </h1>
                                <p>
                                    {{ info.sinopsis }}
                                </p>

                            </div>
                        </div>

                    </div>
                    <div class="is-hidden-tablet has-text-centered">
                        <i class="fa fa-play-circle fa-3x" style="color: white" aria-hidden="true"></i>
                        <h1 class="title">
                            {{ info.titulo }}
                            <span class="tag is-light">PE-7</span>
                        </h1>
                        <h2 class="subtitle">
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
                <article class="media">
                    <figure class="media-left">
                        <p class="image is-64x64">
                            <img src="https://bulma.io/images/placeholders/128x128.png">
                        </p>
                    </figure>
                    <div class="media-content">
                        <div class="field">
                            <p class="control">
                                <textarea class="textarea" placeholder="Escribe un comentario..."></textarea>
                            </p>
                        </div>
                        <nav class="level">
                            <div class="level-left">
                                <div class="level-item">
                                    <a class="button is-info">Publicar</a>
                                </div>
                            </div>
                            <div class="level-right">
                                <div class="level-item">
                                    <span>130/240</span>
                                </div>
                            </div>
                        </nav>
                    </div>
                </article>
                <!-- Escribir-reseña -->
                <resenia-component></resenia-component>
                <!-- Reseñas de otros -->
            </div>
        </section>
        <!-- Reseñas -->
    </div>
</template>

<script>
    import ReseniaComponent from "../components/ReseniaComponent";

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
            axios.get(`/api/pelicula/${this.id}`)
                 .then(response => {
                    console.log(response.data);
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
    }

/*    .fondo::before{
        content: "";
        width: 100%;
        height: 40vh;
        display: inline-block;
        position: relative;
        background: linear-gradient(137deg, rgba(67,67,67,0.7035189075630253) 42%, rgba(0,0,0,0.7) 100%) !important;
        z-index: 2;
    }*/

</style>