<template>
    <article class="media" v-if="isLogged">
        <figure class="media-left">
            <p class="image is-64x64">
                <img :src="'/uploads/avatars/'+getAvatar">
            </p>
        </figure>
        <div class="media-content">
            <div class="field">
                <p class="control">
                    <textarea class="textarea" :class="{'is-danger': caracteres > 140}" placeholder="Escribe un comentario..." v-model="comentario" @keyup="contarCaracteres"></textarea>
                </p>
            </div>
            <nav class="level">
                <div class="level-left">
                    <div class="level-item">
                        <a class="button is-warning" :disabled="caracteres > 140" @click="publicarComentario" v-if="!ocultarOpciones">Publicar</a>
                        <p class="buttons" v-else>
                            <a class="button is-link">
                                <span>
                                 Actualizar
                                </span>
                            </a>
                            <a class="button">
                                <span>
                                 Eliminar
                                </span>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <span>{{ caracteres }}/<b>140</b></span>
                    </div>
                </div>
            </nav>
        </div>
    </article>
    <div v-else class="critica"><span>Identifícate para escribir un comentario.</span></div>
</template>

<script>
    import store from '../../store';

    export default {
        name: "escribir-resenia",
        data(){
            return {
                comentario: '',
                caracteres: 0,
                idPelicula: this.$route.params.id,
                ocultarOpciones: false,
            }
        },
        computed: {
            isLogged() {
                return store.state.isLoggedIn;
            },
            getAvatar(){
                return store.getters.avatar;
            }
        },
        methods: {
            contarCaracteres(){
                this.caracteres = this.comentario.length;
            },
            publicarComentario(){
                let idUsuario = JSON.parse(localStorage.getItem('user')).id;
                axios.post(`/api/resena/${idUsuario}`, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    valoracion: 0,
                    comentario: this.comentario,
                    pelicula_id: this.idPelicula
                })
                    .then(response => {
                        this.$emit('publicar', response.data)
                        this.ocultarOpciones = true;
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        }
    }
</script>

<style scoped>
    .critica{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 12px 20px;
        background: #fff;
        border: 1px solid #e3e3e3;
        border-radius: 5px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 1rem;
    }

    .image img{
        border-radius: 50%;
    }
</style>