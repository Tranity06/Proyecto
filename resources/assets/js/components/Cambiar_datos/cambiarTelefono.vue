<template>
    <form method="post" class="box-form" v-on:submit.prevent="cambiarTelefono">
        <h1 class="subtitle has-text-weight-bold"><span>Cambiar teléfono</span></h1>

        <article class="message is-danger" v-if="telefonoRepetido">
            <div class="message-body">
                El teléfono ya existe
            </div>
        </article>

        <div class="field">
            <label class="label">Nuevo teléfono</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" :class="{'is-danger': errors.has('telefono')}" type="text" placeholder="Escribe el teléfono" name="telefono" v-validate="'required|digits:9'"
                       v-model.trim="telefono">
                <span class="icon is-small is-left">
                                    <i class="fas fa-phone"></i>
                                </span>
                <p v-if="errors.has('telefono')" class="help is-danger">{{ errors.first('telefono') }}</p>
            </div>
        </div>

        <div class="control">
            <button class="button is-danger" type="submit" :disabled='errors.any() || !isComplete'>Cambiar Télefono</button>
        </div>
    </form>
</template>

<script>

    import store from '../../store';

    export default {
        name: "cambiar-telefono",
        data(){
            return {
                telefono: '',
                telefonoRepetido: false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        computed: {
            isComplete () {
                return this.telefono;
            }
        },
        methods: {
            cambiarTelefono() {
                this.telefonoRepetido = false;
                axios.post(`/api/datos/telefono?token=${store.getters.token}`, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    telefono: this.telefono
                })
                    .then(response => {
                        if (response.status === 200){

                            //TODO Actualizar el token.

                            store.commit('changeTelefono',this.telefono);

                            this.$notify({
                                group: 'auth',
                                type: 'success',
                                text: 'El teléfono se ha actualizado',
                                duration: 3000,
                            });

                            this.telefono = '';
                        }else{
                            this.telefonoRepetido = true;
                            this.telefono = '';
                        }
                    })
                    .catch(error => {
                        this.telefonoRepetido = true;
                        this.telefono = '';
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