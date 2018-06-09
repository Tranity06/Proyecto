<template>
    <section class="menu-pelicula">
        <div class="opciones" style="max-width:550px;">
            <div class="tabs is-centered">
                <ul>
                    <li class="is-active is-size-7-mobile"><a @click="changeTab(1)">Cartelera</a></li>
                    <li class="is-size-7-mobile"><a @click="changeTab(2)">Estrenos</a></li>
                    <li class="is-size-7-mobile"><a @click="changeTab(3)">Proximos</a></li>
                    <li class="is-size-7-mobile"><a @click="changeTab(4)">Top</a></li>
                </ul>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "menupelicula-component",
        methods: {
            changeTab: function (num) {
                this.$emit('changeTab', num);
            }
        }
    }
</script>

<style scoped>
    .menu-pelicula {
        position: relative;
        bottom: 40px;
        display: flex;
        justify-content: center;
        z-index: 2;
    }

    .menu-pelicula > .opciones {
        background-color: white;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
        padding: 1.25rem;
    }
</style>