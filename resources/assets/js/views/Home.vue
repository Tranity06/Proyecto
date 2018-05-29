<template>
    <div>
        <slider-component></slider-component>
        <menupelicula-component></menupelicula-component>
        <ais-index :app-id="'0TZV0R68WE'"
                   :api-key="'40ed7ce0a36dde51997fb88645263243'"
                   :index-name="'peliculas'">

            <ais-input :placeholder="'Buscar peliculas'"></ais-input>

            <ais-results></ais-results>

        </ais-index>
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
            MenupeliculaComponent},
        data() {
            return {
                idDeAlgolia: "{{ config('scout.algolia.id') }}",
                keyDeAlgolia: "{{ env('ALGOLIA_SEARCH') }}"
            }
        },
    }
</script>