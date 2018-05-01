<template>
    <div>
        <label class="container" v-for="butaca in butacas">
            <input type="checkbox" @click="postEstadoButaca(butaca.id,butaca.estado)" :disabled="isDisabled(butaca.estado)">
            <span class="checkmark" :class="getClass(butaca.estado)"></span>
        </label>
    </div>
</template>

<script>
    export default {
        data() {
            return {
               butacas: []
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
            postEstadoButaca: function(id,estado){
                //this.checkedButacas.message.push(estado);
                axios.post(`http://localhost:8000/api/butaca/${id}`, {
                    estado: ((estado ===  0) ? 2 : 0)
                    })
                    .then(response => {})
                    .catch(e => {
                        console.log(e);
                    })
            },
            isDisabled(estado) {
                return estado === 1 || estado === 3;
            },
            getClass(estado){
                return {
                    'libre': (estado === 0),
                    'ocupado': (estado === 1),
                    'reservado': (estado === 2),
                    'indisponible': (estado === 3)
                }
            }
        },
        created(){
            Echo.channel('butaca')
                .listen('ButacaEvent', (e) => {
                   let targetButaca = this.butacas.findIndex(butaca => butaca.id === 3 );
                   console.log("Target:"+targetButaca + " || "+ this.butacas[targetButaca].estado);
                   this.butacas[targetButaca].estado = e.estado.estado;
                    console.log("After:"+ this.butacas[targetButaca].estado);
                });
        }
    }
</script>

<style scoped>
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

    .libre {
        background-color: #eee;
    }

    .ocupado {
        background-color: black;
    }

    .reservado {
        background-color: aqua;
    }

    .indisponible {
        background-color: red;
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