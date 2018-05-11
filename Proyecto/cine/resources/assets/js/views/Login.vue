<template>
    <section class="section" style="height: 100vh">
        <div class="container">
            <div class="columns">
                <div class="column is-narrow">
                    <form class="box-form" v-on:submit.prevent="submitLogin">
                        <h1 class="title has-text-weight-bold"><span>INICIAR SESIÓN</span></h1>

                        <article class="message is-danger" v-if="loginError">
                            <div class="message-body">
                                La contraseña o el email introducido no son validos.
                            </div>
                        </article>

                        <div class="field">
                            <label class="label">Introduce tu email</label>
                            <div class="control has-icons-left has-icons-right">
                                <input class="input" :class="{'is-danger': errors.has('email')}" type="email" placeholder="Escribe tu email" name="email"  v-validate="'required|email'"
                                       v-model.trim="email">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <p v-if="errors.has('email')" class="help is-danger">{{ errors.first('email') }}</p>
                            </div>
                        </div>
                        <!-- Username -->

                        <div class="field">
                            <label class="label">Contraseña</label>
                            <div class="control has-icons-left has-icons-right">
                                <input class="input" :class="{'is-danger': errors.has('password')}" type="password" placeholder="Escribe tu contraseña" name="password" v-validate="'required|min:6'"
                                       v-model.trim="password">
                                <span class="icon is-small is-left">
                              <i class="fas fa-lock"></i>
                            </span>
                            </div>
                            <p v-if="errors.has('password')" class="help is-danger">{{ errors.first('password') }}</p>
                        </div>
                        <!-- Password -->

                        <div class="field">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" name="remember">
                                    Recordar usuario
                                </label>
                            </div>
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button is-link" type="submit">Login</button>
                            </div>
                        </div>
                        <a href="recuperar">¿Has olvidado tu contraseña?</a>

                        <input type="hidden" name="_token" :value="csrf">
                    </form>
                </div>
                <div class="column is-half">
                    <h1 class="title has-text-weight-bold">CREAR UNA CUENTA</h1>
                    <p>Crea tu cuenta de Palomitas time:</p>
                    <p><i class="fas fa-check" style="color: green;"></i> Acumula puntos y consigue promociones, Si veis
                        esto modificarlo ;D no estoy inspirado ahora</p>
                    <p><i class="fas fa-check" style="color: green;"></i> Escribir reseñas y puntuar peliculas, Si veis
                        esto modificarlo ;D no estoy inspirado ahora</p>
                    <p><i class="fas fa-check" style="color: green;"></i> Recibir ofertas, Si veis esto modificarlo ;D
                        no estoy inspirado ahora </p>
                    <p><i class="fas fa-check" style="color: green;"></i> Realiza tu pedido más rápido guardando tus
                        datos de envío y tu forma de pago, Si veis esto modificarlo ;D no estoy inspirado ahora </p>
                    <p><i class="fas fa-check" style="color: green;"></i> Accede a tu historial de pedidos, Si veis esto
                        modificarlo ;D no estoy inspirado ahora </p>
                    <p><i class="fas fa-check" style="color: green;"></i> Crea y guarda tus menus preferidos, menus
                        lleva tilde verdad?. Si veis esto modificarlo ;D no estoy inspirado ahora ;D no estoy inspirado
                        ahora </p>
                    <router-link class="button is-info is-medium" :to="{ name: 'register' }">
                            Registrarse
                    </router-link>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import store from '../store';
    export default {
        name: 'login',
        data() {
            return {
                email: '',
                password: '',
                loginError: false,

                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        methods: {
            submitLogin() {
                this.loginError = false;
                console.log("Entro al metodo");
                axios.post(`/api/login`, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    email: this.email,
                    password: this.password
                })
                    .then(response => {
                        console.log(response.data);
                        if (response.data.success){
                            store.commit('loginUser');
                            localStorage.setItem('token', response.data.token);
                            localStorage.setItem('user',JSON.stringify(response.data.user));
                            this.$router.push({ name: 'home' })

                            this.$notify({
                                group: 'auth',
                                text: '¡Bienvenido '+response.data.user.name+'!',
                                duration: 5000,
                            });

                        }else{
                            this.loginError = true;
                            this.password = '';
                        }
                    })
                    .catch(error => {
                        this.loginError = true;
                        this.password = '';
                    })
            }
        }
    }
</script>

<style scoped>

</style>