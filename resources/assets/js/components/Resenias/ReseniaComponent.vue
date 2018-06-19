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
    import store from '../../store';

    export default {
        name: "resenia-component",
        data(){
            return {
                resenas: [],
                idUsuario: store.getters.userId,
                idPelicula: this.$route.params.id,
                comento: '',
                idResena: 0,
                ocultarOpciones: false
            }
        },
        created(){
            axios.get(`/api/pelicula/${this.idPelicula}/resenas`)
                .then(response => {
                    this.resenas = this.usuarioCommented(response.data);
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

        mounted(){
            Echo.channel('resena')
                .listen('ResenaEvent', (e) => {

                    if (e.datos.tipo === 'write'){
                        this.resenas.push(e.datos);
                    } else if (e.datos.tipo === 'update') {
                        let targetResena = this.resenas.find(resena => resena.id == e.datos.id);
                        targetResena.comentario = e.datos.comentario;
                    } else if (e.datos.tipo === 'delete') {
                        this.resenas.splice(this.resenas.indexOf(e.datos.id),1);
                    }

                });
        }

    }
</script>

<style scoped>

</style>