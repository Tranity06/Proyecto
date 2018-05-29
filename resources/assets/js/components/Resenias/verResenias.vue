<template>
    <div class="ver-resenia">
        <div class="info">
            <span>INFINI WAR</span>
            <span>Martes 07 2018</span>
            <span>
                <i class="fas fa-star"></i>
                Recompensa
            </span>
        </div>
        <p  style="margin-top: 1rem; margin-bottom: 1rem;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam blanditiis dolore eius explicabo in ipsum iste magnam mollitia necessitatibus non porro reprehenderit soluta totam vel velit, vitae voluptatem, voluptatibus voluptatum!</p>
        <button class="button is-danger is-rounded" style="align-self: center;">Eliminar reseña</button>
    </div>
</template>

<script>
    export default {
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


</style>