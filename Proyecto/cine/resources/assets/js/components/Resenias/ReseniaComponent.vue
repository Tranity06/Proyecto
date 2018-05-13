<template>
    <section class="section">
        <div class="container">
            <escribir-resenia @publicar="crearComentario($event)" :comento.sync="comento" :ocultarOpciones="ocultarOpciones"></escribir-resenia>
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
                idPelicula: this.$route.params.id,
                comento: '',
                ocultarOpciones: false
            }
        },
        created(){
            axios.get(`/api/pelicula/${this.idPelicula}/resenas`)
                .then(response => {
                    console.log(this.idUsuario);
                    console.log(response.data);
                    this.resenas = this.usuarioCommented(response.data);
                    console.log(this.resenas)
                })
                .catch(error => {
                    console.log(error);
                })
        },
        methods: {
            crearComentario(mensaje){
                this.ocultarOpciones = true;
                this.resenas.push(mensaje);
            },
            usuarioCommented(array){
                const index = array.findIndex(resena => resena.user_id == this.idUsuario);

                if (index !== -1) {
                    this.comento = array[index].comentario;
                    console.log(this.comento);
                    this.ocultarOpciones = true;
                    array.splice(index, 1);
                }

                return array;
            }
        },
        components: {
            ListarResenia,
            EscribirResenia},
    }
</script>

<style scoped>

</style>