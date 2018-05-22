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
            axios.get('/api/slider')
                .then(response => {
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
                    this.pages[i].html = `<div class="has-text-weight-bold is-uppercase is-size-3 is-size-5-mobile">${data[i].titulo}</div>
                                          <div class="is-italic has-text-white is-size-5 is-size-7-mobile">próximamente el ${data[i].estreno}</div>
                                          <a class="button is-rounded is-small is-warning" href="${data[i].trailer}" style="z-index: 9999" data-lity>
                                          <span class="has-text-white">trailer</span>
                                             <span class="icon is-small" style="color:white;">
                                                <i class="fas fa-play"></i>
                                             </span>
                                          </a>`
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