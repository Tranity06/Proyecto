<template>
    <div>
        <section class="hero is-dark">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">
                        Primary title
                    </h1>
                    <h2 class="subtitle">
                        Primary subtitle
                    </h2>
                </div>
            </div>
        </section>
        <div class="section">
                <div v-show="step === 1">
                    <div class="columns is-gapless">
                        <div class="column is-8">
                            <div class="showtime-form">
                                <div class="select">
                                    <select @change="mostrarHoras(dia)" v-model="dia">
                                        <option v-for="sesion in sesiones" :value="sesion.fecha">{{ moment(sesion.fecha).format('DD dddd') }}</option>
                                    </select>
                                </div>
                                <div class="select">
                                    <select @change="mostrarAsientos(horaTarget)" v-model="horaTarget">
                                        <option v-for="horaa in horas" :value="horaa.sala_id">{{ horaa.hora }}</option>
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
                            <span class="subtitle">{{ titulo }}</span>
                            <a :href="trailer" data-lity class="button is-rounded is-danger">Ver trailer</a>
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
                                        <span class="has-text-grey-light is-size-7">{{ moment(dia).format('DD dddd') + "," + horaTarget + " Sala " + salaTarget}}</span>
                                        <span class="has-text-grey-light is-size-7"> {{ butacas.num }} entradas</span>
                                    </div>
                                    <span class="precio has-text-weight-bold">{{ butacas.total }}€</span>
                                </div>
                                <div class="abajo has-text-weight-bold">
                                    Total: {{ butacas.total }}€
                                </div>
                            </section>
                        </div>
                        <div class="column">
                            <payment-component></payment-component>
                        </div>
                    </div>
                    <div class="buttons-component">
                        <button @click.prevent="prev()" class="button is-rounded is-warning normal">Volver</button>
                        <button @click.prevent="confirmarPago()" class="button is-rounded is-warning normal"><i
                                class="fas fa-lock" style="margin-right: .5rem"></i> Confirmar y pagar
                        </button>
                    </div>

                </div>
        </div>
    </div>
</template>

<script>

    import PaymentComponent from './PaymentComponent';

    export default {
        data() {
            return {
                salas: 0,
                salaTarget: 1,
                dia: '',
                horaTarget: '',
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
                }
            }
        },
        components: {
            PaymentComponent
        },
        mounted() {
            axios.get(`/api/pelicula/${this.$route.params.id}`)
                .then(response => {
                    this.caratula = response.data.cartel;
                    this.titulo = response.data.titulo;
                    this.trailer = response.data.trailer;

                    this.sesiones = response.data.sesiones;
                    console.log(this.sesiones);

/*                    let sesionesSinDiasDuplicados = response.data.sesiones.filter((sesion, index, self) =>
                        index === self.findIndex((t) => (
                            t.fecha === sesion.fecha
                        ))
                    );

                    // los inserta ordenados por fecha.
                     this.sesiones =sesionesSinDiasDuplicados.sort((a, b) => {
                            return new Date(a.fecha) - new Date(b.fecha);
                     });

                    this.dia = this.sesiones[0].fecha;
                    this.horaTarget = this.sesiones[0].sala_id;
                    console.log('1:: '+this.sesiones[5].fecha);
                    this.sesiones.forEach(sesion => console.log(sesion.fecha));

                    console.log('2:: '+this.sesiones[5].fecha);*/
                    this.dia = this.sesiones[0].fecha;
                    this.horaTarget = this.sesiones[0].sala_id;
                    let primeraFecha = this.sesiones[0].fecha;
                    this.mostrarHoras(primeraFecha);
/*                    this.salas = response.data;

                    // Al obtener las salas tambien muestra por defecto las butacas de la primera sala
                    this.mostrarAsientos(this.salas[0].id);*/
                })
                .catch(e => {
                    console.log(e);
                })
        },
        methods: {
            prev() {
                this.step--;
            },
            next() {
                let validacion = this.$refs.butaca.getTotal() > 0;

                if (validacion) {
                    this.butacas.total = this.$refs.butaca.getTotal();
                    this.butacas.num = this.$refs.butaca.getButacas();
                    this.step++;
                } else {
                    alert("Debes seleccionar al menos una butaca.");
                }


            },
            mostrarHoras(day) {

                let diaSeleccionado = this.sesiones.filter((sesion) => sesion.fecha === day);

                console.log(diaSeleccionado[0].horas);
                this.horas = diaSeleccionado[0].horas;
                console.log(this.horas);
                console.log('HORAS:: '+this.horas[0][0])
                this.horaTarget = this.horas[0].sala_id;
                this.mostrarAsientos(this.horaTarget);
            },

            mostrarAsientos(id) {
                this.$refs.butaca.getAllButacas(id);
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