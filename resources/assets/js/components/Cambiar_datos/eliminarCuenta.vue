<template>
    <form method="post" class="box-form" v-on:submit.prevent="eliminarCuenta">
        <h1 class="subtitle has-text-weight-bold"><span>Eliminar cuenta</span></h1>

        <article class="message is-danger" v-if="servidorError">
            <div class="message-body">
                La contraseña no es correcta.
            </div>
        </article>

        <div class="field">
            <label class="label">Introduce tu contraseña</label>
            <div class="control has-icons-left">
                <input class="input" :class="{'is-danger': errors.has('password')}" type="password" placeholder="Password" name="password" v-validate="'required|min:6|max:20'"
                       v-model.trim="password" autofocus>
                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                <p v-if="errors.has('password')" class="help is-danger">{{ errors.first('password') }}</p>
            </div>
        </div>

        <div class="control">
            <button class="button is-danger" type="submit" :disabled='errors.any() || !isComplete'><span style="margin-right: 5px;">Eliminar cuenta </span><span><i class="fas fa-trash-alt"></i></span> </button>
        </div>
    </form>
</template>

<script>
    export default {
        name: "eliminarCuenta",
        data(){
            return {
                password: '',

                servidorError: false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        computed: {
            isComplete () {
                return this.password;
            }
        },
        methods: {
            eliminarCuenta() {
                axios.post(`/api/datos/eliminar?token=${store.getters.token}`, {
                    password: this.password,
                })
                    .then(response => {
                        if (response.status === 200){
                            this.$notify({
                                group: 'auth',
                                type: 'error',
                                title: 'La cuenta ha sido eliminada',
                                text: 'Tu cuenta ha sido eliminada',
                                duration: 5000,
                            });
                        }else{
                            this.servidorError = true;
                            this.password = '';
                        }
                    })
                    .catch(error => {
                        this.servidorError = true;
                        this.password = '';
                    })
            }
        }
    }
</script>

<style scoped>
    .box-form{
        box-shadow: 0 0 25px rgba(0,0,0,0.08);
        background-color: #fff;
    }

    .box-form:hover{
        box-shadow: 0 0 25px rgba(0,0,0,0.20);
        background-color: #fff;
    }
</style>