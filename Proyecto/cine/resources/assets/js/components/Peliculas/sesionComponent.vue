<template>
        <span class="tag is-rounded is-light">{{ this.sesion.hora }}</span>
</template>

<script>
    export default {
        props: ['sesion'],
        name: "sesion-component"
    }
</script>

<style scoped>

</style>