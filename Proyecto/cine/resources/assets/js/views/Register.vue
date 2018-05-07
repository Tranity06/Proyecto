<template>
    <section class="section" style="height: 100vh">
        <div class="container">
            <div class="columns">
                <div class="column is-narrow">
                    <form method="post" class="box-form" v-on:submit.prevent="register">
                        <div class="field">
                            <label class="label">Introduce tu nombre</label>
                            <div class="control has-icons-left has-icons-right">
                                <input class="input" :class="{'is-danger': errors.has('nombre')}" type="text" placeholder="Escribe tu nombre" name="nombre" v-validate="'required|alpha'"
                                       v-model.trim="nombre">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                                <p v-if="errors.has('nombre')" class="help is-danger">{{ errors.first('nombre') }}</p>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control has-icons-left has-icons-right">
                                <input class="input" :class="{'is-danger': errors.has('email')}" type="email" placeholder="Escribe tu email" name="email" v-validate="'required|email'"
                                       v-model.trim="email">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <p v-if="errors.has('email')" class="help is-danger">{{ errors.first('email') }}</p>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Teléfono</label>
                            <div class="control has-icons-left has-icons-right">
                                <input class="input" :class="{'is-danger': errors.has('telefono')}" type="text" placeholder="Escribe tu teléfono" name="telefono" v-validate="'required|digits:9'"
                                       v-model.trim="telefono">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <p v-if="errors.has('telefono')" class="help is-danger">{{ errors.first('telefono') }}</p>
                            </div>
                        </div>

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

                        <div class="field">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox">
                                    I agree to the <a href="#">terms and conditions</a>
                                </label>
                            </div>
                        </div>

                        <div class="control">
                            <button class="button is-primary" type="submit">Registrarme</button>
                        </div>
                    </form>
                </div>
                <div class="column is-half">
                    <h1 class="is-size-3">No tienes Cuenta?</h1>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus officia nostrum dignissimos obcaecati iusto! Ex quasi alias id, error nesciunt accusantium eum ipsum ut reprehenderit, voluptatibus exercitationem dolorem doloremque aperiam.
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import store from '../store';
    export default {
        name: 'register',
        data() {
            return {
                nombre: '',
                email: '',
                telefono: '',
                password: '',
                password_confirmation: '',
                registerError: false,

                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        methods: {
            register() {
                this.registerError = false;
                axios.post(`/api/register`, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    email: this.email,
                    name: this.nombre,
                    telefono: this.telefono,
                    password: this.password,
                    password_confirmation: this.password_confirmation

                })
                    .then(response => {
                        console.log(response.data);
                        if (response.data.success){
                            console.log('yupii :D');
                        }else{
                            this.registerError = true;
                            this.password = '';
                            this.password_confirmation = '' ;
                        }
                    })
                    .catch(error => {
                        this.registerError = true;
                        this.password = '';
                        this.password_confirmation = '' ;
                    })
            }
        }
    }
</script>

<style scoped>

</style>