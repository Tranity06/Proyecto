<template>
    <div>
        <slider-component></slider-component>
        <menupelicula-component></menupelicula-component>
        <peliculas-component></peliculas-component>
    </div>
</template>
<script>
    import SliderComponent from "../components/SliderComponent";
    import MenupeliculaComponent from '../components/menupeliculaComponent';
    import PeliculasComponent from "../components/peliculasComponent";

    export default {
        components: {
            PeliculasComponent,
            SliderComponent,
            MenupeliculaComponent}
    }
</script>