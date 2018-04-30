<template>
    <div>
        <div class="select">
            <select @change="mostrarAsientos">
                <option v-for="sala in salas" :value="sala.id" >Sala {{ sala.id }}</option>
            </select>
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

</style>