<template>
    <form method="post" class="box-form" v-on:submit.prevent="cambiarAvatar">
        <h1 class="subtitle has-text-weight-bold"><span>Cambiar avatar</span></h1>

        <article class="message is-danger" v-if="servidorError">
            <div class="message-body">
                El avatar no es valido
            </div>
        </article>

        <div class="field">
            <label class="label">Nuevo avatar</label>
            <input type="file" name="avatar" @change="onFileChange">
        </div>

        <div class="control">
            <button class="button is-danger" type="submit" :disabled='!isComplete'>Cambiar avatar</button>
        </div>

    </form>
</template>

<script>

    import store from '../../store';

    export default {
        name: "cambiar-avatar",
        data(){
            return {
                image: '',
                servidorError: false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        computed: {
            isComplete () {
                return this.image;
            }
        },
        methods: {
            cambiarClave() {
                this.servidorError = false;
                axios.post(`/api/datos?token=${store.getters.token}`, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    password: this.password,
                    password_confirmation: this.password_confirmation
                })
                    .then(response => {
                        if (response.data.success){

                            //TODO Actualizar el token.

                            this.$notify({
                                group: 'success',
                                text: '¡Contraseña cambiada con exito!',
                                duration: 3000,
                            });

                        }else{
                            this.servidorError = true;
                        }
                    })
                    .catch(error => {
                        this.servidorError = true;
                    })
            },
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
            cambiarAvatar() {
                axios.post(`/api/datos/avatar?token=${store.getters.token}`,{
                        image: this.image
                    }
                ).then(response => {

                    if (response.status === 200){

                        //TODO Actualizar el token.
                        store.commit('changeAvatar',response.data.avatar_name);

                        this.$notify({
                            group: 'auth',
                            type: 'success',
                            text: 'El teléfono se ha actualizado',
                            duration: 3000,
                        });

                    }else{
                        this.servidorError = true;
                    }

                })
                .catch(error => {
                    this.servidorError = true;
                });
            }
        }
    }
</script>

<style scoped>

</style>