<template>
    <div class="slider">
        <!-- Configuring slider components -->
        <slider ref="slider" :pages="pages" :sliderinit="sliderinit" @slide='slide' @tap='onTap' @init='onInit'>
            <!-- Set loading -->
            <div slot="loading">loading...</div>
        </slider>
    </div>
</template>

<script>
    import slider from 'vue-concise-slider';
    export default {
        name: "slider-component",
        data () {
            return {
                //Image list
                pages:[
                    {
                        html: '<div class="slider1">slider1</div>',
                        style: {
                            'background': '#1bbc9b'
                        }
                    },
                    {
                        html: '<div class="slider2">slider2</div>',
                        style: {
                            'background': '#4bbfc3'
                        }
                    },
                    {
                        html: '<div class="slider3">slider3</div>',
                        style: {
                            'background': '#7baabe'
                        }
                    }
                ],
                //Sliding configuration [obj]
                sliderinit: {
                    currentPage: 0,
                    thresholdDistance: 500,
                    thresholdTime: 100,
                    autoplay:5000,
                    loop:true,
                    direction:'horizontal',
                    infinite:1,
                    slidesToScroll:1,
                    timingFunction: 'ease',
                    duration: 300
                }
            }
        },
        components: {
            slider
        },
        methods: {
            // Listener event
            slide (data) {
                console.log(data)
            },
            onTap (data) {
                console.log(data)
            },
            onInit (data) {
                console.log(data)
            }
        }
    }
</script>

<style scoped>
    .slider {
        height: 70vh;
        width: 100%;
        position: relative;
        top: 0;
        left: 0;
    }
</style>