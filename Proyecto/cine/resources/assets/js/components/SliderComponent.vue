<template>
    <div class="slider">
        <!-- Configuring slider components -->
        <slider ref="slider" :pages="pages" :sliderinit="sliderinit">
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
                        html: '',
                        style: {
                            'background': '',
                            'background-position': 'top !important',
                            'background-repeat': 'no-repeat'
                        }
                    },
                    {
                        html: '',
                        style: {
                            'background': '',
                            'background-position': 'top !important',
                            'background-repeat': 'no-repeat'
                        }
                    },
                    {
                        html: '',
                        style: {
                            'background': '',
                            'background-position': 'top !important',
                            'background-repeat': 'no-repeat'
                        }
                    }
                ],
                //Sliding configuration [obj]
                sliderinit: {
                    currentPage: 0,
                    thresholdDistance: 100,
                    thresholdTime: 300,
                    loop:true,
                    infinite:1,
                    slidesToScroll:1,
                    autoplay: 10000
                },
            }
        },
        created(){
            console.log('PAGES '+this.pages[0].style.background);
            axios.get('/api/slider')
                .then(response => {
                    console.log('MIO '+response.data[0].slider_image);
                    this.mountSlider(response.data);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        components: {
            slider
        },
        methods: {

            mountSlider(data){
                for (let i=0; i<=3;i++){
                    this.pages[i].style.background = 'url('+data[i].slider_image+')';
                    this.pages[i].html = `<div>${data[i].titulo}</div><a href="${data[i].trailer}" style="z-index: 9999" data-lity><img src="icons/play-button.svg"> Trailer</a>`
                }
            },
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