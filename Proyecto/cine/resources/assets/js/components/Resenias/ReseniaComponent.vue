<template>
    <section class="section">
        <div class="container">
            <escribir-resenia></escribir-resenia>
            <listar-resenia></listar-resenia>
        </div>
    </section>
</template>

<script>
    import EscribirResenia from "./EscribirResenia";
    import ListarResenia from "./ListarResenia";

    export default {
        name: "resenia-component",
        data(){
            return {
            }
        },
        components: {
            ListarResenia,
            EscribirResenia},
    }
</script>

<style scoped>

</style>