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
                 @click="postEstadoButaca(butaca.id,butaca.estado,$event)"
                 :class="{
                 'ocupado': butaca.estado === 1,
                 'indisponible': butaca.estado === 3,
                 'seleccionado': selectedSeats.includes(butaca.id),
                 'reservado': reservedSeats.includes(butaca.id)
                 }">
            </div>
            <!--<seat-individual v-for="butaca in butacas" :key="butaca.id" ></seat-individual>-->
        </div>
        <div class="bloquetotalbutacas" v-if="total > 0">
            <span class="has-text-centered is-size-5" style="margin-right: 80px"><b>TOTAL:</b> {{ total }}€</span>
            <span class="is-size-5"><b>Sala:</b> {{sala}}</span>
        </div>

        <modal
                v-show="isModalVisible"
                @close="closeModal"
        >
            <span slot="header">Las butacas tienen que ser contiguas</span>
            <span slot="body">¿Os habéis enfadado?</span>
        </modal>
    </div>

</template>

<script>
    import store from '../store';
    import modal from './modal.vue';
    import SeatIndividual from "./seat-individual";

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
                selected:[],
                numerosPosibles: [],
                firstSeat: undefined,
                isModalVisible: false,
                sala: 0,
            }
        },
        components: {
            SeatIndividual,
            modal
        },
        computed: {
          selectedSeats(){
              return store.getters.selectedSeats;
          },
          reservedSeats(){
              return store.getters.reservedSeats;
          }
        },
        methods: {
            setSala(sala){
                this.sala = sala;
            },
            showModal() {
                this.isModalVisible = true;
            },
            closeModal() {
                this.isModalVisible = false;
            },
            getAllButacas: function (sesionId) {
                axios.get(`/api/sesion/${sesionId}`)
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
            getButacas(){
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


                if (!this.esContiguo(id)) {
                    event.preventDefault();
                    this.showModal();
                    return;
                }

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
                    });

                this.updateSelectedSeats(id);

                if (store.getters.selectedSeats.length > 0 && !store.getters.timerStart){
                    store.commit('changeTimerStart',true);
                }else if (store.getters.selectedSeats.length === 0 && store.getters.timerStart){
                    store.commit('changeTimerStart',false);
                }

            },
            updateSelectedSeats(id){
              if (store.getters.selectedSeats.includes(id)){
                  store.commit('removeSelectedSeat',id);
              }else {
                  store.commit('addSelectedSeat',id);
              }
            },
            esContiguo(id){
                const seatSeleccionado = this.butacas.find((butaca) => butaca.id === id);
                console.log(seatSeleccionado);
                if (this.firstSeat === undefined){
                    this.firstSeat = seatSeleccionado;
                    this.esNumeroContiguo(seatSeleccionado.id);
                    return true;
                }else if(this.firstSeat !== undefined && store.getters.selectedSeats.length === 0){
                    this.firstSeat = seatSeleccionado;
                    return true;
                }else{
                    if (this.firstSeat.fila !== seatSeleccionado.fila || !this.esNumeroContiguo(seatSeleccionado.id)){
                        return false;
                    }else {
                        return true;
                    }
                }
            },

            esNumeroContiguo(num){
                let numeroActual = this.firstSeat.id;

                if (store.getters.selectedSeats.length === 1){
                    if (num === store.getters.selectedSeats[0]){
                        this.numerosPosibles = [];
                        this.firstSeat = undefined;
                        return true;
                    }
                }

                if (this.numerosPosibles.length > 0){
                    let esValido;

                    for (let i = 0; i<this.numerosPosibles.length; i++){
                        if (this.numerosPosibles[i] == num){
                            esValido = true;
                            break;
                        }
                    }

                    let numeroAnteriorExiste = false;
                    let numeroPosteriorExiste = false;

                    for (let i = 0; i<store.getters.selectedSeats.length; i++){
                        if (store.getters.selectedSeats[i] === num - 1){
                            numeroAnteriorExiste = true;
                            break;
                        }
                    }

                    for (let i = 0; i<store.getters.selectedSeats.length; i++){
                        if (store.getters.selectedSeats[i] === num + 1){
                            numeroPosteriorExiste = true;
                            break;
                        }
                    }


                    if (numeroAnteriorExiste && numeroPosteriorExiste){
                        return false;
                    }



                    if (esValido){
                           if (num>numeroActual){
                               this.numerosPosibles.push(num+1);
                           }else{
                               this.numerosPosibles.unshift(num-1);
                           }
                           return true;
                    }else{
                        return false;
                    }
                } else {
                    let numeroAnterior = numeroActual - 1;
                    let numeroPosterior = numeroActual + 1;
                    this.numerosPosibles.push(numeroAnterior);
                    this.numerosPosibles.push(numeroActual);
                    this.numerosPosibles.push(numeroPosterior);
                    return true;
                }
            },

            confirmarPago() {
                alert("mira el console");
                console.log(this.registration);
            }
        },
        mounted() {
            // Desde navegador le llega el id de la butaca y el estado de esa butaca (reservado o libre);
            // if esta butaca id no existe no hagas nada y si esta cambialo :D
            Echo.channel('butaca')
                .listen('ButacaEvent', (e) => {
                    console.log(e);
                        let targetButaca = this.butacas.find(butaca => butaca.id == e.butacaId);
                        if (targetButaca !== undefined){
                            targetButaca.estado = e.estado.estado;
                            if (e.estado.estado == 2){
                                store.commit('addReservedSeat',parseInt(e.butacaId));
                            }else if (e.estado.estado == 0){
                                store.commit('removeReservedSeats',parseInt(e.butacaId))
                            }
                        }
                });
        }
    }
</script>

<style scoped>

    .bloquetotalbutacas{
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin: 0 auto 20px auto;
    }

    .seat-filas{
        width: 0;
        height: 0;
        line-height: 25px;
        position: relative;
        left: -10px;
        animation: fadein .5s;
    }

    .seat-filas > div:not(:first-child){
        margin: .38rem 0;
    }

    .seat-columns{
        width: 280px;
        margin: 0 auto;
        animation: fadein .5s;
    }

    @keyframes fadein {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    .bookingseats-form {
        display: flex;
        flex-direction: column;
    }

    .bookingseats-form > .info {
        margin-top: .8rem;
        display: flex;
        justify-content: space-around;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
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
        background-color: #E8E9EA;
    }

    .seat-column{
        display: inline-block;
        height: 25px;
        width: 25px;
        border-radius: 20%;
        margin: 0 .17rem;
        text-align: center;
    }

    .ocupado {
        background-color: #4B4B5B !important;
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