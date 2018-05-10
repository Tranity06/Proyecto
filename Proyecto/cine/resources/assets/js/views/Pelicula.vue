<template>
    <p>{{ id }}</p>
</template>

<script>
    export default {
        name: 'pelicula',
        data() {
            return {
                id: this.$route.params.id
            }
        }
    }
</script>