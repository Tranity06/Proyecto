<template>
    <div class="bookingseats-form">
        <div class="info">
            <div class="tipo">
                <div class="seat libre"></div>
                <span class="is-size-7-mobile">Libres</span>
            </div>
            <div class="tipo">
                <div class="seat ocupado"></div>
                <span class="is-size-7-mobile">Ocupadas</span>
            </div>
            <div class="tipo">
                <div class="seat reservado"></div>
                <span class="is-size-7-mobile">Reservadas</span>
            </div>
            <div class="tipo">
                <div class="seat seleccionado"></div>
                <span class="is-size-7-mobile">Tus butacas</span>
            </div>
        </div>
        <div class="screen"></div>

        <div class="seat-columns has-text-centered">
            <div class="seat-column"><i>A</i></div>
            <div class="seat-column"><i>B</i></div>
            <div class="seat-column"><i>C</i></div>
            <div class="seat-column"><i>D</i></div>
            <div class="seat-column"><i>E</i></div>
            <div class="seat-column"><i>F</i></div>
            <div class="seat-column"><i>G</i></div>
            <div class="seat-column"><i>H</i></div>
        </div>
        <div class="seats-component">
            <div class="seat-filas">
                <div><i>1</i></div>
                <div><i>2</i></div>
                <div><i>3</i></div>
                <div><i>4</i></div>
                <div><i>5</i></div>
                <div><i>6</i></div>
                <div><i>7</i></div>
                <div><i>8</i></div>
            </div>
            <div class="seat" v-for="butaca in butacas"
                 @click="postEstadoButaca(butaca.id,butaca.estado)"
                 :class="getClass(butaca.estado,butaca.id)">
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
                },
                selected:[]
            }
        },
        methods: {
            getAllButacas: function (id) {
                axios.get(`/api/butaca/${id}`)
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

                axios.post(`/api/butaca/${id}`, {
                    estado: ((estado === 0) ? 2 : 0)
                })
                    .then(response => {
                    })
                    .catch(e => {
                        console.log(e);
                    })

                this.selected.includes(id) ? this.selected.splice(this.selected.indexOf(id), 1) : this.selected.push(id);

            },
            getClass(estado,id) {
                return {
                    'libre': (estado === 0),
                    'ocupado': (estado === 1),
                    'reservado': (estado === 2) && !this.selected.includes(id),
                    'indisponible': (estado === 3),
                    'seleccionado': this.selected.includes(id)
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


    .seat-filas{
        width: 0;
        height: 0;
        line-height: 25px;
        position: relative;
        left: -10px;
    }

    .seat-filas > div:not(:first-child){
        margin: .38rem 0;
    }

    .seat-columns{
        width: 280px;
        margin: 0 auto;
    }

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

    .seat-column{
        display: inline-block;
        height: 25px;
        width: 25px;
        border-radius: 20%;
        margin: 0 .17rem;
        text-align: center;
    }

    .libre {
        background-color: #E8E9EA;
    }

    .ocupado {
        background-color: #4B4B5B;
        transition: background-color .25s ease-out;
        pointer-events: none;
    }

    .reservado {
        background-color: #fadf98;
        transition: background-color .25s ease-out;
        pointer-events: none;
    }

    .seleccionado {
        background-color: hsl(204, 86%, 53%) !important;
        transition: background-color .25s ease-out;
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