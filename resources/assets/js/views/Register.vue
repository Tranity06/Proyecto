<template>
    <div>
     <div class="relleno"></div>
    <section class="section" style="margin-top: 30px">
        <div class="container">
            <div class="columns">
                <div class="column is-narrow">
                    <form method="post" class="box-form" v-on:submit.prevent="register">
                        <h1 class="title has-text-weight-bold"><span>Regístrate</span></h1>

                        <article class="message is-danger" v-if="registerError">
                            <div class="message-body">
                               El email introducido o el teléfono ya existen
                            </div>
                        </article>

                        <div class="field">
                            <label class="label">Introduce tu nombre</label>
                            <div class="control has-icons-left has-icons-right">
                                <input class="input" :class="{'is-danger': errors.has('nombre')}" type="text" placeholder="Escribe tu nombre" name="nombre" v-validate="'required|alpha|min:3|max:30'"
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
                                <input class="input" :class="{'is-danger': errors.has('password')}" type="password" placeholder="Password" name="password" v-validate="'required|min:6|max:30'"
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
                                <input class="input" :class="{'is-danger': errors.has('password_confirmation')}" type="password" placeholder="Password" name="password_confirmation" v-validate="'required|min:6|max:30|confirmed:password'"
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
                                    <input type="checkbox" v-model="checked">
                                    He leído y acepto los términos y condiciones de uso
                                </label>
                            </div>
                        </div>

                        <div class="control">
                            <button class="button is-warning" type="submit" :disabled='errors.any() || !isComplete'>Registrarme</button>
                        </div>
                    </form>
                </div>
                <div class="column is-half">
                    <h1 class="is-size-3">No tienes Cuenta?</h1>
                    <p>Crea tu cuenta de PalomitasTime y disfruta de:</p>
                    <p><i class="fas fa-check" style="color: green;"></i> Escribir reseñas sobre tus películas favoritas.</p>
                    <p><i class="fas fa-check" style="color: green;"></i> Compra tus entradas online y no hagas cola.</p>
                    <p><i class="fas fa-check" style="color: green;"></i> Realiza la compra de tu menú de comida favorito.</p>
                    <p><i class="fas fa-check" style="color: green;"></i> Accede a tu historial de pedidos.</p>
                </div>
            </div>
        </div>
    </section>
    </div>
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
                checked: false,
                registerError: false,

                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        computed: {
            isComplete () {
                return this.nombre && this.password && this.email && this.telefono && this.password_confirmation && this.checked;
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
                        if (response.data.success){
                            this.$router.push({ name: 'login' });
                            this.$notify({
                                group: 'auth',
                                title: 'Activa tu cuenta',
                                text: '¡Comprueba tu email para completar el registro!',
                                duration: 5000,
                            });
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

    .relleno{
        position: absolute;
        top: 0;
        background-color: #363636;
        width: 100%;
        height: 53px;

        transition: all .2s ease-in-out;
    }

    .box-form{
        box-shadow: 0 0 25px rgba(0,0,0,0.08);
        background-color: #fff;
    }
</style>