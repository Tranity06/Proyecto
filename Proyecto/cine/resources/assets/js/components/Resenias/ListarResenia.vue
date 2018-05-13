<template>
        <article class="media">
            <figure class="media-left">
                <p class="image is-64x64">
                    <img :src="'/uploads/avatars/'+this.resena.imagen_usuario">
                </p>
            </figure>
            <div class="media-content">
                <div class="content">
                    <p>
                        <strong>{{ this.resena.nombre_usuario }}</strong> <small>31m</small>
                        <br>
                        {{ this.resena.comentario }}
                    </p>
                </div>
                <nav class="level is-mobile">
                    <div class="level-left">
                        <a class="level-item">
                            <span class="icon is-small"><i class="fas fa-reply"></i></span>
                        </a>
                        <a class="level-item">
                            <span class="icon is-small"><i class="fas fa-retweet"></i></span>
                        </a>
                    </div>
                </nav>
            </div>
        </article>
</template>

<script>
    export default {
        props: ['resena'],
        name: "listar-resenia",
    }
</script>

<style scoped>
    .image img{
        border-radius: 50%;
    }
</style>