<template>
    <div>
        <section class="hero is-dark">
            <div class="hero-body">
<!--                 <div class="container">
                    <h1 class="title">
                        Primary title
                    </h1>
                    <h2 class="subtitle">
                        Primary subtitle
                    </h2>
                </div> -->
            </div>
        </section>
        <div class="section">
                <div v-show="step === 1">
                    <div class="columns is-gapless">
                        <div class="column is-8">
                            <div class="showtime-form">
                                <div class="select">
                                    <select @change="mostrarHoras(dia,$event)" :value="dia">
                                        <option v-for="sesion in sesiones" :value="sesion.fecha">{{ moment(sesion.fecha).format('DD dddd') }}</option>
                                    </select>
                                </div>
                                <div class="select">
                                    <select @change="mostrarAsientos(primeraSesion,$event)" :value="primeraSesion">
                                        <option v-for="horaa in horas" :value="horaa.sesion_id" :selected="horaa.sesion_id === primeraSesion">{{ horaa.hora }}</option>
                                    </select>
                                </div>
                            </div>
                            <seat-component ref="butaca"></seat-component>
                            <div class="buttons-component">
                                <button @click.prevent="next()" class="button is-rounded is-warning grande">Pagar</button>
                            </div>
                        </div>
                        <div class="column is-hidden-mobile">
                            <div class="pelicula-card centrar-imagen">
                                <img :src="caratula">
                            </div>
                            <p class="subtitle">{{ titulo }}</p>
                            <a :href="trailer" data-lity class="button is-rounded is-danger">Ver tráiler</a>
                        </div>
                    </div>
                </div>
                <div v-show="step === 2">
                    <div class="columns">
                        <div class="column">
                            <section class="panel-moderno">
                                <div class="encabezado">
                                    <span>Producto</span>
                                    <span>Precio</span>
                                </div>
                                <div class="cuerpo">
                                    <img :src="caratula" alt="" width="55" height="74">
                                    <div class="informacion">
                                        <span class="has-text-weight-bold is-size-6">{{ titulo }}</span>
                                        <span class="has-text-grey-light is-size-7">{{ moment(dia).format('DD dddd') + "," + horaSeleccionada + " Sala " + salanum}}</span>
                                        <span class="has-text-grey-light is-size-7"> {{ butacas.num }} {{butacas.num > 1 ? 'entradas': 'entrada'}}</span>
                                    </div>
                                    <span class="precio has-text-weight-bold">{{ butacas.total.toFixed(2) }}€</span>
                                </div>
                                <div class="cuerpo" v-for="item in allCartItems">
                                    <img :src="item.producto.imagen" alt="" width="55" height="74">
                                    <div class="informacion">
                                        <span class="has-text-weight-bold is-size-6">{{ item.producto.nombre }}</span>
                                        <span class="has-text-grey-light is-size-7">Cantidad: {{ item.cantidad }}</span>
                                    </div>
                                    <span class="precio has-text-weight-bold">{{ (item.producto.precio * item.cantidad).toFixed(2) }}€</span>
                                </div>
                                <div class="abajo has-text-weight-bold">
                                    Total: {{ (butacas.total + precioTotal).toFixed(2) }}€
                                </div>
                            </section>
                        </div>
                        <div class="column">
                            <payment-component ref="pago"></payment-component>
                        </div>
                    </div>
                    <div class="buttons-component">
                        <button @click.prevent="prev()" class="button is-rounded is-warning normal">Volver</button>
                        <button @click.prevent="confirmarPago()" class="button is-rounded is-warning normal"><i
                                class="fas fa-lock" style="margin-right: .5rem"></i> Confirmar y pagar
                        </button>
                    </div>

                </div>
            <modal
                    v-show="modal.visible"
                    @close="closeModal"
            >
                <span slot="header">{{modal.titulo}}</span>
                <span slot="body">{{modal.body}}</span>
            </modal>
        </div>
    </div>
</template>

<script>

    import store from '../store';
    import PaymentComponent from './PaymentComponent';
    import modal from './modal.vue';

    const getEntrada = (id,callback) => {

        axios
            .get('/api/pelicula/'+id+'/entrada')
            .then(response => {
                callback(null, response.data);
            }).catch(error => {
            callback(error, error.response.data);
        });
    };

    export default {
        data() {
            return {
                salas: 0,
                salaTarget: 1,
                dia: '',
                primeraSesion: null,
                sesionId: null,
                salanum: 0,
                horaSeleccionada: '1',
                horas: [],
                step: 1,
                pelicula: [],
                sesiones: [],
                caratula: '',
                titulo: '',
                trailer: '',
                butacas: {
                    total: 0,
                    num: 0
                },
                modal: {
                    visible: false,
                    titulo: '',
                    body: ''
                }
            }
        },
        computed: {
            allCartItems(){
                return store.getters.cartItems;
            },
            precioTotal(){
                return store.getters.cartItems.reduce((prev,next) => prev + parseFloat(next.producto.precio)*next.cantidad,0);
            },
        },
        components: {
            PaymentComponent,
            modal
        },

        beforeRouteEnter (to, from, next) {
            getEntrada(to.params.id,(err, data) => {
                next(vm => vm.setData(err, data));
            });
        },

        methods: {
            showModal(titulo,body) {
                this.modal = {
                    visible: true,
                    titulo: titulo,
                    body: body
                };
            },
            closeModal() {
                this.modal.visible = false;
            },
            prev() {
                this.step--;
            },
            getNumButacas(){
                return this.$refs.butaca.getButacas();
            },
            next() {
                let validacion = this.$refs.butaca.getTotal() > 0;

                if (validacion) {
                    this.butacas.total = this.$refs.butaca.getTotal();
                    this.butacas.num = this.$refs.butaca.getButacas();
                    this.horaSeleccionada = this.horas.filter(hora => hora.sesion_id === this.primeraSesion)[0].hora;
                    this.step++;
                } else {
                    this.showModal('Elige al menos una butaca','No está permitido ver la pelicula de pie :(');

                }


            },
            mostrarHoras(day,event) {
                console.log('mostrarHoras');

                if (this.$refs.butaca.getButacas() > 0) {
                    this.showModal('Tienes butacas reservadas','No puedes cambiar de sesión teniendo butacas seleccionadas.');
                } else {

                    this.dia = event === undefined ? day : event.target.value;
                    let diaSeleccionado = this.sesiones.filter((sesion) => sesion.fecha === this.dia);
                    this.horas = diaSeleccionado[0].horas;
                   // this.sesionId = this.horas[0].sesion_id;
                    this.primeraSesion  = this.horas[0].sesion_id;
                    this.mostrarAsientosAutomaticamente(this.horas[0].sesion_id);
                }

            },
            mostrarAsientosAutomaticamente(sesion){
                let sala = this.horas.filter(hora => hora.sesion_id === sesion)[0].sala;
                this.$refs.butaca.setSala(sala);
                this.salanum = sala;
                this.$refs.butaca.getAllButacas(sesion);
            },
            mostrarAsientos(sesionId,event) {
                console.log('mostrarAsientos');
                if (this.$refs.butaca.getButacas() > 0){
                    this.showModal('Tienes butacas reservadas','No puedes cambiar de sesión teniendo butacas seleccionadas.');
                } else {
                    this.primeraSesion = event === undefined ? sesionId : parseInt(event.target.value);
                    let sala = this.horas.filter(hora => hora.sesion_id === this.primeraSesion)[0].sala;
                    this.$refs.butaca.setSala(sala);
                    this.salanum = sala;
                    this.$refs.butaca.getAllButacas(this.primeraSesion);
                }
            },

            setData(err, data) {
                if (err) {
                    this.error = err.toString();
                } else {
                    this.caratula = data.cartel;
                    this.titulo = data.titulo;
                    this.trailer = data.trailer;
                   // this.sesionTarget = data.

                    this.sesiones = data.sesiones;
                    this.dia = this.sesiones[0].fecha;
                    this.sesionId = this.sesiones[0].sesion_id;
                    let primeraFecha = this.sesiones[0].fecha;
                    this.mostrarHoras(primeraFecha);
                }

                console.log(data);
            },
            confirmarPago(){
                // fecha -> dia
                // hora -> horaSeleccionada
                // sala -> sesionId
                // butacas -> butacas

                const datosVisa = this.$refs.pago.getDatosVisa();

                axios.post(`/api/pago?token=${store.getters.token}`, {
                    nombre_pelicula: this.titulo,
                    dia: this.dia,
                    nombre_tarjeta: datosVisa.nombre,
                })
                    .then(response => {

                        if (response.status === 200){
                            console.log('reservado');
                            this.$notify({
                                group: 'auth',
                                type: 'success',
                                title: 'Pago confirmado',
                                text: 'Tu entrada ha sido comprada con exito',
                                duration: 3000,
                            });
                        }

                    })
                    .catch(error => {
                        console.log(error);
                    });




                console.log(this.$refs.pago.getDatosVisa());
            }
        }
    }
</script>

<style scoped>

    .pelicula-card {
        width: 250px;
        height: auto;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 3px 3px 20px rgba(0, 0, 0, .5);
        text-align: center;
        position: relative;
        margin-bottom: .7rem;
        line-height: 0;
        /* margin-left: auto;
        margin-right: auto; */
    }

    .showtime-form {
        display: flex;
        justify-content: space-around;
        margin-top: 1rem;
    }

    /* Panel Moderno */
    .precio {
        justify-self: end;
        margin-left: auto;
    }

    .panel-moderno {
        display: flex;
        flex-direction: column;
        max-width: 350px;
        margin: 1rem auto;

        border-radius: 2%;
        background-color: white;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        overflow: hidden;
    }

    .panel-moderno > .encabezado {
        display: flex;
        justify-content: space-between;
        background-color: #F6F5F3;
        padding: .5rem;
    }

    .panel-moderno > .cuerpo {
        display: flex;
        align-items: center;
        margin: .5rem .5rem;
    }

    .cuerpo > .informacion {
        margin-left: .5rem;
        display: flex;
        flex-direction: column;
    }

    .panel-moderno > .abajo {
        margin: 0 .5rem;
        padding: .5rem;
        display: flex;
        justify-content: flex-end;
        border-top: 2px solid #F6F5F3;
    }

    /* Buttons component */

    .buttons-component {
        display: flex;
        justify-content: center;
        margin-bottom: .5rem;
    }

    .grande {
        padding-left: 3em;
        padding-right: 3em;
        color: white;
        font-weight: bold;
        font-size: 1.5rem;
    }

    .normal {
        padding-left: 1.5em;
        padding-right: 1.5em;
        color: white;
        font-weight: bold;
        font-size: 1em;
        margin-left: .5rem;
    }



</style>