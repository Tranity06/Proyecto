<template>
    <section class="section">
        <div class="container">
            <escribir-resenia @publicar="actualizarLista($event)"></escribir-resenia>
            <listar-resenia v-for="resena in resenas" :key="resena.id" :resena="resena"></listar-resenia>
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
                resenas: [],
                idPelicula: this.$route.params.id
            }
        },
        created(){
            axios.get(`/api/pelicula/${this.idPelicula}/resenas`)
                .then(response => {
                    console.log(response.data);
                    this.resenas = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
        },
        methods: {
          actualizarLista(mensaje){
              this.resenas.push(mensaje);
          }
        },
        components: {
            ListarResenia,
            EscribirResenia},
    }
</script>

<style scoped>

</style>