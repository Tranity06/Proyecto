<template>
    <section class="section">
        <div class="container">
            <escribir-resenia @publicar="crearComentario($event)"></escribir-resenia>
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
                idUsuario: JSON.parse(localStorage.getItem('user')).id,
                idPelicula: this.$route.params.id
            }
        },
        created(){
            axios.get(`/api/pelicula/${this.idPelicula}/resenas`)
                .then(response => {
                    console.log(this.idUsuario);
                    console.log(response.data);
                    this.resenas = response.data.filter(e => e.user_id != this.idUsuario);
                    console.log(this.resenas)
                })
                .catch(error => {
                    console.log(error);
                })
        },
        methods: {
            crearComentario(mensaje){
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