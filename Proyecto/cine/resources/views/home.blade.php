@extends('templates.default')

@section('estilos')
    <link href="{{ asset('css/home.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/slick/slick.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/slick/slick-theme.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/efectos/texto.css') }}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <section class="slider-container">
        <div class="slider">
            <div>
                <img src="https://img2.goodfon.ru/original/1600x900/c/e7/justice-league-liga.jpg" alt="Liga de la justicia" class="img-responsive">
                <div class="slider-informacion">
                    <div class="info-pelicula">
                        <h1 class="reveal-text titulo is-size-1-desktop is-size-3-tablet is-size-4-mobile has-text-white has-text-weight-bold">LIGA DE LA JUSTICIA</h1>
                        <h2 class="fade fade-subtitulo is-size-5-tablet is-size-6-mobile is-size-4-desktop has-text-white">CIENCIA FICCIÓN ACCIÓN </h2>
                        <a class="fade fade-boton trailer button is-link is-rounded is-large is-size-6-mobile">Ver Trailer</a>
                    </div>
                    <div class="fecha">
                        <span class="fade fade-estreno is-size-4-tablet is-size-6-mobile is-size-3-desktop has-text-white has-text-weight-normal">Fecha de estreno</span>
                        <span class="fade fade-estreno-fecha is-size-5-tablet is-size-6-mobile is-size-4-desktop has-text-info has-text-weight-light">15 Oct, 2015</span>
                    </div>
                </div>
            </div>
            <div>
                <img src="https://img4.goodfon.ru/original/1600x900/9/63/jumanji-welcome-to-the-jungle-jumanji-welcome-to-the-jumanji.jpg" alt="Jumanji" class="img-responsive">
            </div>
            <div>
                <img src="https://hdqwalls.com/download/4k-thor-ragnarok-cl-1600x900.jpg" alt="Thor Ragnarok" class="img-responsive">
            </div>
        </div>
        <div class="controllers is-hidden-mobile">
            <div class="next control">
                <label>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path d="M298.3 256L131.1 81.9c-4.2-4.3-4.1-11.4.2-15.8l29.9-30.6c4.3-4.4 11.3-4.5 15.5-.2L380.9 248c2.2 2.2 3.2 5.2 3 8.1.1 3-.9 5.9-3 8.1L176.7 476.8c-4.2 4.3-11.2 4.2-15.5-.2L131.3 446c-4.3-4.4-4.4-11.5-.2-15.8L298.3 256z"/>
                    </svg>
                </label>
            </div>
            <div class="prev control">
                <label>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path d="M213.7 256L380.9 81.9c4.2-4.3 4.1-11.4-.2-15.8l-29.9-30.6c-4.3-4.4-11.3-4.5-15.5-.2L131.1 247.9c-2.2 2.2-3.2 5.2-3 8.1-.1 3 .9 5.9 3 8.1l204.2 212.7c4.2 4.3 11.2 4.2 15.5-.2l29.9-30.6c4.3-4.4 4.4-11.5.2-15.8L213.7 256z"/>
                    </svg>
                </label>
            </div>
        </div>
    </section>

    <section class="menu-pelicula">
        <div class="opciones" style="max-width:550px;">
            <div class="tabs is-centered">
                <ul>
                    <li class="is-active is-size-7-mobile"><a>Cartelera</a></li>
                    <li class="is-size-7-mobile"><a>Estrenos</a></li>
                    <li class="is-size-7-mobile"><a>Proximos</a></li>
                    <li class="is-size-7-mobile"><a>Top</a></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="columns is-multiline is-centered">
                <div class="column is-3-desktop-only is-narrow">
                    <div class="pelicula-card centrar-imagen">
                        <div class="pelicula-trailer">
                            <i class="fa fa-play-circle fa-3x" style="color: white" aria-hidden="true"></i>
                        </div>
                        <div class="pelicula-body">
                            <div class="pelicula-horario">
                                <div class="tags">
                                    <span class="tag is-rounded is-light">17:30</span>
                                    <span class="tag is-rounded is-light">21:30</span>
                                    <span class="tag is-rounded is-light">23:00</span>
                                </div>
                            </div>
                            <div class="pelicula-opciones">
                                <div class="buttons">
                                    <a class="button is-link">Más</a>
                                    <a class="button is-link">Comprar entrada</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3-desktop-only is-narrow">
                    <div class="pelicula-card centrar-imagen">
                        <div class="pelicula-trailer">
                            <i class="fa fa-play-circle fa-3x" style="color: white" aria-hidden="true"></i>
                        </div>
                        <div class="pelicula-body">
                            <div class="pelicula-horario">
                                <div class="tags">
                                    <span class="tag is-rounded is-light">17:30</span>
                                    <span class="tag is-rounded is-light">21:30</span>
                                    <span class="tag is-rounded is-light">23:00</span>
                                </div>
                            </div>
                            <div class="pelicula-opciones">
                                <div class="buttons">
                                    <a class="button is-link">Más</a>
                                    <a class="button is-link">Comprar entrada</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3-desktop-only is-narrow">
                    <div class="pelicula-card centrar-imagen">
                        <div class="pelicula-trailer">
                            <i class="fa fa-play-circle fa-3x" style="color: white" aria-hidden="true"></i>
                        </div>
                        <div class="pelicula-body">
                            <div class="pelicula-horario">
                                <div class="tags">
                                    <span class="tag is-rounded is-light">17:30</span>
                                    <span class="tag is-rounded is-light">21:30</span>
                                    <span class="tag is-rounded is-light">23:00</span>
                                </div>
                            </div>
                            <div class="pelicula-opciones">
                                <div class="buttons">
                                    <a class="button is-link">Más</a>
                                    <a class="button is-link">Comprar entrada</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3-desktop-only is-narrow">
                    <div class="pelicula-card centrar-imagen">
                        <div class="pelicula-trailer">
                            <i class="fa fa-play-circle fa-3x" style="color: white" aria-hidden="true"></i>
                        </div>
                        <div class="pelicula-body">
                            <div class="pelicula-horario">
                                <div class="tags">
                                    <span class="tag is-rounded is-light">17:30</span>
                                    <span class="tag is-rounded is-light">21:30</span>
                                    <span class="tag is-rounded is-light">23:00</span>
                                </div>
                            </div>
                            <div class="pelicula-opciones">
                                <div class="buttons">
                                    <a class="button is-link">Más</a>
                                    <a class="button is-link">Comprar entrada</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            Hola
        </div>
    </section>
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/slick/slick.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.slider').slick({
                autoplay: true,
                autoplaySpeed: 10000,
                prevArrow: '.slider-container .prev',
                nextArrow: '.slider-container .next',
            });
            $('.slider').on('swipe', function(event, slick, direction){

                    $('.titulo').removeClass('reveal-text');
                    $('.fade-subtitulo').removeClass('fade');
                    $('.fade-boton').removeClass('fade');
                    $('.fade-estreno').removeClass('fade');
                    $('.fade-estreno-fecha').removeClass('fade');

                    setTimeout(function(){
                        $('.titulo').addClass('reveal-text');
                        $('.fade-subtitulo').addClass('fade');
                        $('.fade-boton').addClass('fade');
                        $('.fade-estreno').addClass('fade');
                        $('.fade-estreno-fecha').addClass('fade');
                    }, 50);
                });
        });
    </script>
@stop