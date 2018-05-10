<template>
    <div>
        <navbar-component></navbar-component>

        <router-view></router-view>
        <notifications group="auth" />
        <footer-component></footer-component>
    </div>
</template>
<script>
    import NavbarComponent from '../components/NavbarComponent';
    import FooterComponent from "../components/FooterComponent";
    export default {
        components: {
            FooterComponent,
            NavbarComponent
        },
    }
</script>
<style scoped>

</style>