<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="login-status" content="{{ Auth::check() }}">
    <title>Palomitas Time</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Jua|Lato:400,700" rel="stylesheet">
    <link href="{{ asset('css/utilidades.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/modal/lity.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/footer.css') }}" media="all" rel="stylesheet" type="text/css" />
    <script src="https://apis.google.com/js/api:client.js"></script>

    <style>

        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            width: auto !important;
            overflow-x: hidden !important;
        }

        .vue-notification{
            margin-top: .5rem !important;
            font-size: .8rem !important;
        }

        .img-responsive {
            width: 100%;
            height: 70vh;
            object-fit: cover;
            object-position: top;
        }

        @media only screen and (max-width: 1024px) {
            .img-responsive {
                height: 70vh;
            }
        }

        .navbar{
            top: 0;
            background-color: transparent !important;
            transition: all .2s ease-in-out;
        }

        .navbar.nav-up{
            top: -70px;
        }

        .navbar.nav-down{
            background-color: #0b0b0b !important;
        }

        .contentprueba {
            flex: 1 0 auto;
        }

        @media screen and (max-width: 1023px) {
            .navbar-menu {
                margin-left: auto;
                min-width: 50%;
            }
        }

        .fondoblanco{
            background-color: white !important;
        }

    </style>
</head>
<body>

    <div id="app" class="contentprueba">
        <app></app>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="content has-text-centered">
                <span class="marca">Palomitas Time</span>
                <div class="redes">
                    <a href="http://www.twitter.com" class="centeredIcon twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="http://www.facebook.com" class="centeredIcon facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="http://www.facebook.com" class="centeredIcon instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
                <span><b>2018 PALOMITASTIME.COM</b></span>
            </div>
        </div>
    </footer>

    <script src="{{ mix('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/modal/lity.js') }}"></script>
    <script>
        $(function(){

            var didScroll;
            var lastScrollTop = 0;
            var delta = 5;
            var navbarHeight = $('.navbar').outerHeight();

            $(window).scroll(function(event){
                didScroll = true;
            });

            setInterval(function() {
                if (didScroll) {
                    hasScrolled();
                    didScroll = false;
                }
            }, 250);

            function hasScrolled() {
                var st = $(this).scrollTop();

                // Make sure they scroll more than delta
                if(Math.abs(lastScrollTop - st) <= delta)
                    return;

                // If they scrolled down and are past the navbar, add class .nav-up.
                // This is necessary so you never see what is "behind" the navbar.
                if (st > lastScrollTop && st > navbarHeight){
                    // Scroll Down
                    $('.navbar').removeClass('nav-down').addClass('nav-up');
                } else {
                    if (st < 100){
                        $('.navbar').removeClass('nav-up').removeClass('nav-down');
                    }else{
                        if(st + $(window).height() < $(document).height()) {
                            $('.navbar').removeClass('nav-up').addClass('nav-down');
                        }
                    }
                }

                lastScrollTop = st;
            }
        });
    </script>
    <script>
/*        $(function(){

            //Hago click en el menu y
            //si esta a menos de 100px del top :: ABRO EL MENU
                // -> toggle fondoblanco
                // -> toggle textblack
                //si hago click en un link del menu ::
                // -> isActive = false
                // -> fondoblanco = false
                // -> textblack = false
            //si esta a mas de 100px del top ::
                // -> toggle isActive
                // -> toggle textblack
                //si hago click en un link del menu ::
                // -> isActive = false
                // -> textblack = false
                // -> fondoblanco = false
            $('.navbar-burger').click(function() {

                //si cerca del top que ponga el fondo blanco, texto negro y muestre el menu.
                if ($(document).scrollTop() < 100){
                    console.log('hola desde el home');
                    openMenu()
                } else { //si esta mas lejos, el texto blanco, fondo igual, y el logo igual.
                    console.log('hola desde el home mas de 100');
                    $('a.navbar-item').toggleClass('has-text-black');
                    $('a.button').click(function(e){
                        $('#navbarMenuHeroA, .navbar-burger').removeClass('is-active has-text-black');
                        $('.navbar').removeClass('fondoblanco');
                        $('a.navbar-item').removeClass('has-text-black');
                        $('.logo-container > span').removeClass('has-text-black');
                    });

                    $('a.navbar-item').click(function(e){
                        $('#navbarMenuHeroA, .navbar-burger').removeClass('is-active');
                    });
                }

//                $('#navbarMenuHeroA, .navbar-burger').toggleClass('is-active');

            });

            function openMenu(){
                // Activar Desactivar Fondo blanco del navbar
                $('.navbar').toggleClass('fondoblanco');
                // Activar desactivar el texto negro de los enlaces
                $('.navbar-item').toggleClass('has-text-black');
                // Poner el texto negro del navbar
                $('.logo-container > span').toggleClass('has-text-black');
                $('#navbarMenuHeroA, .navbar-burger').toggleClass('has-text-black');
                //Cuando haga click en algun elemento del menu:
                //Quitar 'is-active y has-text-black', el fondo blanco y el texto negro.
                $('.navbar-item').click(function(e){
                    $('#navbarMenuHeroA, .navbar-burger').removeClass('is-active has-text-black');
                    $('.navbar').removeClass('fondoblanco');
                    $('.navbar-item').removeClass('has-text-black');
                    $('.logo-container > span').removeClass('has-text-black');
                });
            }

        });*/
    </script>
</body>
</html>