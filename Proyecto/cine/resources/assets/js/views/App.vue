<template>
    <div>
        <navbar-component></navbar-component>

        <router-view></router-view>
        <notifications group="foo" />
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
        mounted(){
            this.$notify({
                group: 'foo',
                title: 'Important message',
                text: 'Hello user! This is a notification!',
                duration: 5000,

            });
        }
    }
</script>
<style scoped>

</style>