<template>
    <div class="bookingseats-form">
        <div class="info">
            <div class="tipo">
                <div class="seat libre"></div>
                <span>Libres</span>
            </div>
            <div class="tipo">
                <div class="seat ocupado"></div>
                <span>Ocupadas</span>
            </div>
            <div class="tipo">
                <div class="seat reservado"></div>
                <span>Tus butacas</span>
            </div>
        </div>
        <div class="screen"></div>
        <div class="seats-component">
            <div class="seat" v-for="butaca in butacas"
                 @click="postEstadoButaca(butaca.id,butaca.estado)"
                 :class="getClass(butaca.estado)">
            </div>
        </div>
        <span class="has-text-centered is-size-3" v-if="total > 0">TOTAL: {{ total }}€</span>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                butacas: [],
                total: 0,
                butacasNum: 0,
                registration: {
                    sala: null,
                    dia: null,
                    hora: null,
                    butacas: null,
                }
            }
        },
        methods: {
            getAllButacas: function (id) {
                axios.get(`http://localhost:8000/api/butaca/${id}`)
                    .then(response => {
                        this.butacas = response.data;
                    })
                    .catch(e => {
                        console.log(e);
                    })
            },
            getTotal: function(){
              return this.total;
            },
            getButacas: function(){
                return this.butacasNum;
            },
            sumTotal: function (estado) {
                if (estado == 0) {
                    this.butacasNum += 1;
                    this.total += 7;
                } else {
                    this.butacasNum -= 1;
                    this.total -= 7;
                }
            },
            postEstadoButaca: function (id, estado) {

                this.sumTotal(estado);

                let targetButaca = this.butacas.find(butaca => butaca.id == id);
                targetButaca.estado = ((estado === 0) ? 2 : 0);

                axios.post(`http://localhost:8000/api/butaca/${id}`, {
                    estado: ((estado === 0) ? 2 : 0)
                })
                    .then(response => {
                    })
                    .catch(e => {
                        console.log(e);
                    })
            },
            getClass(estado) {
                return {
                    'libre': (estado === 0),
                    'ocupado': (estado === 1),
                    'reservado': (estado === 2),
                    'indisponible': (estado === 3)
                }
            },
            confirmarPago() {
                alert("mira el console");
                console.log(this.registration);
            }
        },
        mounted() {
            Echo.channel('butaca')
                .listen('ButacaEvent', (e) => {
                    let targetButaca = this.butacas.find(butaca => butaca.id == e.butacaId);
                    targetButaca.estado = e.estado.estado;
                });
        }
    }
</script>

<style scoped>

    .bookingseats-form {
        display: flex;
        flex-direction: column;
    }

    .bookingseats-form > .info {
        margin-top: .8rem;
        display: flex;
        justify-content: space-around;
    }

    .tipo {
        display: flex;
        align-items: center;
    }

    .seat {
        display: inline-block;
        height: 25px;
        width: 25px;
        border-radius: 20%;
        margin: 0 .3rem;
    }

    .libre {
        background-color: #E8E9EA;
    }

    .ocupado {
        background-color: #4B4B5B;
        pointer-events: none;
    }

    .reservado {
        background-color: #fadf98;
    }

    .indisponible {
        background-color: red;
        pointer-events: none;
    }

    .screen {
        margin: .8rem auto;
        height: 50px;
        width: 90%;
        max-width: 320px;
        border: solid 5px #fadf98;
        border-color: #fadf98 transparent transparent transparent;
        border-radius: 50%/45px 45px 0 0;
    }

    .seats-component {
        width: 280px;
        height: 270px;
        margin: 0 auto;
    }

</style>