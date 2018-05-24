<template>
    <div>
        <navbar-component></navbar-component>

        <router-view></router-view>
        <notifications group="auth" />
    </div>
</template>
<script>
    import NavbarComponent from '../components/NavbarComponent';
    export default {
        components: {
            NavbarComponent
        },
    }
</script>
<style scoped>
</style>