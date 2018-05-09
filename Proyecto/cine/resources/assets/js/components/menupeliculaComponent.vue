<template>
    <section class="menu-pelicula">
        <div class="opciones" style="max-width:550px;">
            <div class="tabs is-centered">
                <ul>
                    <li class="is-active is-size-7-mobile"><a>Cartelera</a></li>
                    <li class="is-size-7-mobile"><a>Estrenos</a></li>
                    <li class="is-size-7-mobile"><a>Proximos</a></li>
                    <li class="is-size-7-mobile"><a>Top</a></li>
                </ul>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "menupelicula-component"
    }
</script>

<style scoped>
    .menu-pelicula {
        position: relative;
        bottom: 40px;
        display: flex;
        justify-content: center;
        z-index: 900;
    }

    .menu-pelicula > .opciones {
        background-color: #f9f9f9;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
        padding: 1.25rem;
    }
</style>