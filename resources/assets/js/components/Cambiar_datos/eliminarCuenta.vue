<template>
    <form method="post" class="box-form" v-on:submit.prevent="eliminarCuenta">
        <div class="control">
            <button class="button is-danger centrar-este-botton" type="submit">Eliminar cuenta</button>
        </div>
    </form>
</template>

<script>
    export default {
        name: "eliminarCuenta",
        methods: {
            eliminarCuenta() {

            }
        }
    }
</script>

<style scoped>
    .centrar-este-botton {
        transform: translateX(40%);
    }
</style>