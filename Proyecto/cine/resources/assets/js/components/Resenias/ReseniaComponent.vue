<template>
    <section class="section">
        <div class="container">
            <escribir-resenia @publicar="crearComentario($event)"
                              :comento.sync="comento"
                              :ocultarOpciones.sync="ocultarOpciones"
                              :idResena="idResena">
            </escribir-resenia>
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
                idResena: 0,
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
                this.idResena = mensaje.id;
                this.comento = mensaje.comentario;
            },
            usuarioCommented(array){
                const index = array.findIndex(resena => resena.user_id == this.idUsuario);

                if (index !== -1) {
                    this.comento = array[index].comentario;
                    this.idResena = array[index].id;
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