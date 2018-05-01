<template>
    <div>
        <div class="showtime-form">
            <div class="select">
                <select @change="mostrarAsientos">
                    <option v-for="sala in salas" :value="sala.id" >Sala {{ sala.id }}</option>
                </select>
            </div>
            <div class="select">
                <select>
                    <option>25 Lunes</option>
                    <option>26 Martes</option>
                </select>
            </div>
            <div class="select">
                <select>
                    <option>13:21</option>
                    <option>15:22</option>
                </select>
            </div>
        </div>
        <seat-component ref="butaca"></seat-component>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                salas: 0
            }
        },
        created() {
            axios.get('http://localhost:8000/api/sala')
                .then(response => {
                    this.salas = response.data;
                })
                .catch(e => {
                    console.log(e);
                })
        },
        methods: {
            mostrarAsientos: function (event) {
                this.$refs.butaca.getAllButacas(event.target.value);
            }
        }
    }
</script>

<style scoped>
    .showtime-form{
        display: flex;
        justify-content: space-around;
        margin-top: 1rem;
    }
</style>