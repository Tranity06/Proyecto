<template>
    <form method="post" class="box-form" v-on:submit.prevent="cambiarEmail">
        <h1 class="subtitle has-text-weight-bold"><span>Cambiar email</span></h1>

        <article class="message is-danger" v-if="emailRepetido">
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
                axios.post(`/api/datos/email?token=${store.getters.token}`, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    email: this.email
                })
                    .then(response => {
                        if (response.status === 200){

                            //TODO Actualizar el token.
                            console.log('email');

                            this.$notify({
                                group: 'auth',
                                type: 'success',
                                text: 'El email se ha actualizado',
                                duration: 3000,
                            });

                            this.email = '';

                        }else{
                            this.emailRepetido = true;
                            this.email = '';
                        }
                    })
                    .catch(error => {
                        this.emailRepetido = true;
                        this.email = '';
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