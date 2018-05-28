<template>
    <div>

    <div class="relleno">
    </div>

    <section class="section" style="margin-top: 30px">
        <div class="container">
            <div class="columns">
                <div class="column is-narrow">
                    <form class="box-form" v-on:submit.prevent="submitLogin">
                        <h1 class="title has-text-weight-bold"><span>INICIAR SESIÓN</span></h1>

                        <article class="message is-danger" v-if="loginError">
                            <div class="message-body">
                                La contraseña o el email introducido no es valido.
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
                                    <input type="checkbox" name="remember" v-model="checked">
                                    Recordar usuario
                                </label>
                            </div>
                        </div>


                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button is-link" type="submit" :disabled='errors.any()>0 || !isComplete'>Login</button>
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
    </div>
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
                checked: false,

                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        computed: {
            isComplete () {
                return this.email && this.password;
            }
        },
        methods: {
            submitLogin() {
                this.loginError = false;
                axios.post(`/api/login`, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    email: this.email,
                    password: this.password
                })
                    .then(response => {
                        console.log(response.data);
                        console.log(this.checked);
                        if (response.data.success){
                            store.commit('loginUser');

                            if (this.checked === false){
                                // Session -> porque solo quiero que lo recuerde esta sesion
                                console.log('session');
                                sessionStorage.setItem('token',response.data.token);
                                sessionStorage.setItem('user',JSON.stringify(response.data.user));
                            }else {
                                console.log('local');
                                localStorage.setItem('token', response.data.token);
                                localStorage.setItem('user',JSON.stringify(response.data.user));
                            }

                            store.commit('changeId',response.data.user.id);
                            store.commit('changeName',response.data.user.name);
                            store.commit('changeToken',response.data.token);

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

    .relleno{
        position: absolute;
        top: 0;
        background-color: black;
        width: 100%;
        height: 56px;

        transition: background-color .2s ease-in-out;
    }

    .box-form{
        box-shadow: 0 0 25px rgba(0,0,0,0.08);
        background-color: #fff;
    }
</style>