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
                    <textarea class="textarea" placeholder="Escribe un comentario..."></textarea>
                </p>
            </div>
            <nav class="level">
                <div class="level-left">
                    <div class="level-item">
                        <a class="button is-info">Publicar</a>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <span>130/240</span>
                    </div>
                </div>
            </nav>
        </div>
    </article>
    <div v-else class="critica"><span>Identifícate para escribir una crítica.</span></div>
</template>

<script>
    import store from '../../store';

    export default {
        name: "escribir-resenia",
        computed: {
            isLogged() {
                return store.state.isLoggedIn;
            },
            getAvatar(){
                return store.getters.avatar;
            }
        },
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
</style>