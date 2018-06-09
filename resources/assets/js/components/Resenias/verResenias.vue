<template>
    <div class="ver-resenia">
        <div class="info">
            <span>{{ tituloPelicula }}</span>
            <span>{{ moment(fecha).format("D MMMM YYYY") }}</span>
            <span>
                <i class="fas fa-star"></i>
                Recompensa
            </span>
        </div>
        <p  style="margin-top: 1rem; margin-bottom: 1rem;">{{ texto }}</p>
        <button class="button is-danger is-rounded" style="align-self: center;">Eliminar reseña</button>
    </div>
</template>

<script>
    export default {
        props: ['tituloPelicula','fecha','texto'],
        name: "ver-resenias"
    }
</script>

<style scoped>
    .ver-resenia{
        display: flex;
        flex-direction: column;

        background: white;
        box-shadow: 0 2px 4px 0 rgba(0,0,0,0.1);



    padding: 11.5px;
        margin-bottom: 2rem;
    }

    .ver-resenia > .info{
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .info > span{
        margin-right: 1rem;
    }


</style>