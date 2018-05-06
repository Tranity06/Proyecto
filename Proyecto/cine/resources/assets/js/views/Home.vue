<template>
    <slider-component></slider-component>
</template>
<script>
    import SliderComponent from "../components/SliderComponent";

    export default {
        components: {SliderComponent},
        mounted(){
            this.$notify({
                group: 'foo',
                title: 'Important message',
                text: 'Hello user! This is a notification!'
            });
        }
    }
</script>