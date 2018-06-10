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
                 :class="getClass(butaca.estado,butaca.id)">
            </div>
        </div>
        <span class="has-text-centered is-size-3" v-if="total > 0">TOTAL: {{ total }}€</span>
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
    import modal from './modal.vue';

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
            }
        },
        components: {
            modal
        },
        methods: {
            showModal() {
                this.isModalVisible = true;
            },
            closeModal() {
                this.isModalVisible = false;
            },
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
            esContiguo(id){
                const seatSeleccionado = this.butacas.find((butaca) => butaca.id === id);
                console.log(seatSeleccionado);
                if (this.firstSeat === undefined){
                    this.firstSeat = seatSeleccionado;
                    this.esNumeroContiguo(seatSeleccionado.id);
                    return true;
                }else if(this.firstSeat !== undefined && this.selected.length === 0){
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

                if (this.selected.length === 1){
                    if (num === this.selected[0]){
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

                    for (let i = 0; i<this.selected.length; i++){
                        if (this.selected[i] === num - 1){
                            numeroAnteriorExiste = true;
                            break;
                        }
                    }

                    for (let i = 0; i<this.selected.length; i++){
                        if (this.selected[i] === num + 1){
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