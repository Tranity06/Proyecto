<template>
    <form method="post" class="box-form" v-on:submit.prevent="cambiarClave">
        <h1 class="subtitle has-text-weight-bold"><span>Cambiar contraseña</span></h1>

        <article class="message is-danger" v-if="registerError">
            <div class="message-body">
                El email ya existe
            </div>
        </article>

        <div class="field">
            <label class="label">Contraseña</label>
            <div class="control has-icons-left">
                <input class="input" :class="{'is-danger': errors.has('password')}" type="password" placeholder="Password" name="password" v-validate="'required|min:6'"
                       v-model.trim="password">
                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                <p v-if="errors.has('password')" class="help is-danger">{{ errors.first('password') }}</p>
            </div>
        </div>

        <div class="field">
            <label class="label">Repite la contraseña</label>
            <div class="control has-icons-left">
                <input class="input" :class="{'is-danger': errors.has('password_confirmation')}" type="password" placeholder="Password" name="password_confirmation" v-validate="'required|min:6|confirmed:password'"
                       v-model.trim="password_confirmation">
                <span class="icon is-small is-left">
                                     <i class="fas fa-lock"></i>
                                </span>
                <p v-if="errors.has('password_confirmation')" class="help is-danger">{{ errors.first('password_confirmation') }}</p>
            </div>
        </div>

        <div class="control">
            <button class="button is-danger" type="submit" :disabled='errors.any() || !isComplete'>Cambiar contraseña</button>
        </div>

    </form>
</template>

<script>

    import store from '../../store';

    export default {
        name: "cambiar-clave",
        data(){
            return {
                password: '',
                password_confirmation: '',
                servidorError: false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        computed: {
            isComplete () {
                return this.password && this.password_confirmation;
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