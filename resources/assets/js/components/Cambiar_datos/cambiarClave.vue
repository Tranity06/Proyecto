<template>
    <form method="post" class="box-form" v-on:submit.prevent="cambiarClave">
        <h1 class="subtitle has-text-weight-bold"><span>Cambiar contraseña</span></h1>

        <article class="message is-danger" v-if="servidorError">
            <div class="message-body">
               La contraseña no es correcta.
            </div>
        </article>

        <div class="field">
            <label class="label">Contraseña {{this.paso===1?'actual':'nueva'}}</label>
            <div class="control has-icons-left">
                <input class="input" :class="{'is-danger': errors.has('password')}" type="password" placeholder="Password" name="password" v-validate="'required|min:6'"
                       v-model.trim="password" autofocus>
                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                <p v-if="errors.has('password')" class="help is-danger">{{ errors.first('password') }}</p>
            </div>
        </div>

        <div class="field">
            <label class="label">Repite la contraseña {{this.paso===1?'actual':'nueva'}}</label>
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
            <button class="button is-danger" type="submit" :disabled='errors.any() || !isComplete'>{{this.paso === 1 ? 'Comprobar':'Cambiar'}} contraseña</button>
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
                paso: 1,
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

            cambiarClave(){
              if (this.paso === 1){
                  this.verificarClave();
              }
              else {
                  this.actualizarClave();
              }
            },

            verificarClave(){
                this.servidorError = false;
                axios.post(`/api/datos/clave?token=${store.getters.token}`, {
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    paso: this.paso
                })
                    .then(response => {
                        if (response.status === 200){
                            this.paso = 2;
                            this.vaciarClave();
                        }else{
                            this.servidorError = true;
                            this.vaciarClave();
                        }
                    })
                    .catch(error => {
                        this.servidorError = true;
                        this.vaciarClave();
                    })
            },
            actualizarClave() {
                this.servidorError = false;
                axios.post(`/api/datos/clave?token=${store.getters.token}`, {
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    paso: this.paso
                })
                    .then(response => {
                        if (response.status === 200){

                            //TODO Actualizar el token.

                            store.commit('changeToken',response.data.token);

                            this.$notify({
                                group: 'auth',
                                type: 'success',
                                text: 'La contraseña ha sido cambiada',
                                duration: 3000,
                            });

                            this.paso = 1;
                            this.vaciarClave();

                        }else {
                            this.servidorError = true;
                            this.vaciarClave();
                        }
                    })
                    .catch(error => {
                        this.servidorError = true;
                        this.vaciarClave();
                    })
            },
            vaciarClave(){
              this.password = '';
              this.password_confirmation = '';
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