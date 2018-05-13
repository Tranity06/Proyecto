<template>
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-10-tablet is-offset-2-tablet">
                    <img :src="'uploads/avatars/'+getAvatar"
                         style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
                    <h2> <b>{{ userName }}</b> Perfil</h2>
                    <form v-on:submit.prevent="upload">
                        <label>Cambiar avatar</label>
                        <input type="file" name="avatar" @change="onFileChange">
                        <input type="submit" class="button" value="Guardar">
                    </form>
                </div>
            </div>
        </div>
    </section>
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
                    alert('mira la consola');
                    console.log(response.data);
                    store.commit('changeAvatar',response.data.avatar_name);
                });
            }
        }
    }
</script>