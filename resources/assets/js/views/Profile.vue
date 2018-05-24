<template>
    <div>
        <section class="hero is-dark">
            <div class="hero-body">
                <div class="container">
                    <div class="perfil-header">
                        <img :src="'uploads/avatars/'+getAvatar">
                        <div class="perfil-info">
                            <p class="title">
                                {{ userName }}
                            </p>
                            <p class="subtitle">
                                1250 puntos
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-foot">
                <nav class="tabs is-boxed is-fullwidth">
                    <div class="container">
                        <ul>
                            <li class="is-active">
                                <a>
                                    <span class="icon is-small"><i class="fas fa-cog" aria-hidden="true"></i></span>
                                    <span class="is-hidden-mobile">Datos</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span class="icon is-small"><i class="fas fa-ticket-alt" aria-hidden="true"></i></span>
                                    <span class="is-hidden-mobile">Entradas</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span class="icon is-small"><i class="far fa-comment" aria-hidden="true"></i></span>
                                    <span class="is-hidden-mobile">Reseñas</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span class="icon is-small"><i class="far fa-star" aria-hidden="true"></i></span>
                                    <span class="is-hidden-mobile">Ofertas</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <div class="columns">
                    <div class="column is-10-tablet is-offset-2-tablet">
                        <form v-on:submit.prevent="upload">
                            <label>Cambiar avatar</label>
                            <input type="file" name="avatar" @change="onFileChange">
                            <input type="submit" class="button" value="Guardar">
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
    import store from '../store';

    export default {
        data() {
            return {
                image: '',
                userName: '',
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        computed: {
            getAvatar(){
                return store.getters.avatar;
            }
        },
        mounted(){
            this.userName = JSON.parse(localStorage.getItem('user')).name;
        },
        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            upload(){
                axios.post('/api/avatar',{
                        userId: JSON.parse(localStorage.getItem('user')).id,
                        image: this.image
                    }
                ).then(response => {
                    console.log(response.data);
                    store.commit('changeAvatar',response.data.avatar_name);
                });
            }
        }
    }
</script>
<style scoped>

    .container{
        display: flex;
        justify-content: center;
    }

    .perfil-header{
        display: flex;
        align-items: center;
    }

    .perfil-header > img {
        width:150px;
        height:150px;
        float:left;
        border-radius:50%;
        margin-right:25px;
    }

    @media (max-width: 768px){

        .perfil-header > img {
            width:100px;
            height:100px;
        }
    }

    .perfil-info{
        display: flex;
        flex-direction: column;
    }
</style>