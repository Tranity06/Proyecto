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
                        <strong>{{ this.resena.nombre_usuario }}</strong> <small>{{ this.resena.tiempo }}</small>
                        <br>
                        {{ this.resena.comentario }}
                    </p>
                </div>
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