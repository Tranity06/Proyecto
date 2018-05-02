<template>
    <div>
        <div v-show="step === 1">
            <div class="showtime-form">
                <div class="select">
                    <select @change="mostrarAsientos(salaTarget)" v-model="salaTarget">
                        <option v-for="sala in salas" :value="sala.id">Sala {{ sala.id }}</option>
                    </select>
                </div>
                <div class="select">
                    <select v-model="dia">
                        <option value="25 Lunes">25 Lunes</option>
                        <option value="26 Martes">26 Martes</option>
                    </select>
                </div>
                <div class="select">
                    <select v-model="hora">
                        <option value="13:21">13:21</option>
                        <option value="15:22">15:22</option>
                    </select>
                </div>
            </div>
            <seat-component ref="butaca"></seat-component>
            <div class="buttons-component">
                <button @click.prevent="next()" class="button is-rounded is-warning grande">Pagar</button>
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
                            <img src="avengers.jpg" alt="" width="55" height="74">
                            <div class="informacion">
                                <span class="has-text-weight-bold is-size-6">Vengadores: Infinity War</span>
                                <span class="has-text-grey-light is-size-7">{{ dia + "," + hora + " Sala " + salaTarget}}</span>
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
</template>

<script>

    import PaymentComponent from './PaymentComponent';
    export default {
        data() {
            return {
                salas: 0,
                salaTarget: 1,
                dia: "25 Lunes",
                hora: "15:22",
                step: 1,
                butacas: {
                    total: 0,
                    num: 0
                }
            }
        },
        components: {
            PaymentComponent
        },
        created() {
            axios.get('http://localhost:8000/api/sala')
                .then(response => {
                    this.salas = response.data;

                    // Al obtener las salas tambien muestra por defecto las butacas de la primera sala
                    this.mostrarAsientos(this.salas[0].id);
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

                let Validacion = this.$refs.butaca.getTotal() > 0;

                if (Validacion) {
                    this.butacas.total = this.$refs.butaca.getTotal();
                    this.butacas.num = this.$refs.butaca.getButacas();
                    this.step++;
                }else{
                    alert("JAJAJA NO :D");
                }


            },
            mostrarAsientos(id) {
                this.$refs.butaca.getAllButacas(id);
            }
        }
    }
</script>

<style scoped>
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
        margin: 1rem 0;

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