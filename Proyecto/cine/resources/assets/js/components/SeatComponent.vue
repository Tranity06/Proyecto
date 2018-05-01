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
        <div class="buttons-component">
            <a class="button is-warning is-rounded is-medium">PAGAR</a>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
               butacas: [],
               total: 0
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
            sumTotal: function (estado) {
                if(estado == 0){
                   this.total += 7;
                }else {
                   this.total -= 7;
                }
            },
            postEstadoButaca: function(id,estado){

                this.sumTotal(estado);

                let targetButaca= this.butacas.find(butaca => butaca.id == id);
                targetButaca.estado = ((estado ===  0) ? 2 : 0);

                axios.post(`http://localhost:8000/api/butaca/${id}`, {
                    estado: ((estado ===  0) ? 2 : 0)
                    })
                    .then(response => {})
                    .catch(e => {
                        console.log(e);
                    })
            },
            getClass(estado){
                return {
                    'libre': (estado === 0),
                    'ocupado': (estado === 1),
                    'reservado': (estado === 2),
                    'indisponible': (estado === 3)
                }
            },
        },
        mounted(){
            Echo.channel('butaca')
                .listen('ButacaEvent', (e) => {
                   let targetButaca= this.butacas.find(butaca => butaca.id == e.butacaId);
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

    .bookingseats-form > .info{
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

    .indisponible{
        background-color: red;
        pointer-events: none;
    }

    .screen {
        margin: .8rem auto;
        height:50px;
        width:90%;
        border: solid 5px #fadf98;
        border-color:#fadf98 transparent transparent transparent;
        border-radius: 50%/45px 45px 0 0;
    }

    .seats-component {
        width: 280px;
        height: 270px;
        margin: 0 auto;
    }

    .buttons-component{
        display: flex;
        justify-content: center;
    }

    .button.is-rounded{
        padding-left: 3em;
        padding-right: 3em;
        color: white;
        font-weight: bold;
        font-size: 1.5rem;
    }

    /* The container */
    .container {
        display: inline-block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>