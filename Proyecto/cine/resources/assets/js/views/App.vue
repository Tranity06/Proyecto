<template>
    <div>
        <navbar-component></navbar-component>

        <p>
            <router-link :to="{ name: 'home' }">Home</router-link> |
            <router-link :to="{ name: 'hello' }">Hello World</router-link>
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    import NavbarComponent from '../components/NavbarComponent';
    export default {
        components: {
            NavbarComponent
        }
    }
</script>