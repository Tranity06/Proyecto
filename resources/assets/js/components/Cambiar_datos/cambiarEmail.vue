<template>
    <form method="post" class="box-form" v-on:submit.prevent="cambiarEmail">
        <h1 class="subtitle has-text-weight-bold"><span>Cambiar email</span></h1>

        <article class="message is-danger" v-if="registerError">
            <div class="message-body">
                El email ya existe
            </div>
        </article>

        <div class="field">
            <label class="label">Email nuevo</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" :class="{'is-danger': errors.has('email')}" type="email" placeholder="Escribe el email" name="email" v-validate="'required|email'"
                       v-model.trim="email">
                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                <p v-if="errors.has('email')" class="help is-danger">{{ errors.first('email') }}</p>
            </div>
        </div>

        <div class="control">
            <button class="button is-danger" type="submit" :disabled='errors.any() || !isComplete'>Cambiar email</button>
        </div>
    </form>
</template>

<script>

    import store from '../../store';

    export default {
        name: "cambiar-email",
        data(){
            return {
                email: '',
                emailRepetido: false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        computed: {
            isComplete () {
                return this.email;
            }
        },
        methods: {
            cambiarEmail() {
                this.emailRepetido = false;
                axios.post(`/api/datos?token=${store.getters.token}`, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    email: this.email
                })
                    .then(response => {
                        if (response.data.success){

                            //TODO Actualizar el token.

                            this.$notify({
                                group: 'success',
                                text: '¡Email cambiado con exito!',
                                duration: 3000,
                            });

                        }else{
                            this.emailRepetido = true;
                        }
                    })
                    .catch(error => {
                        this.emailRepetido = true;
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