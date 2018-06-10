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
            background-color: #f5f5f5;
        }

        body {
            display: flex;
            flex-direction: column;
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
        $(document).ready(function () {
            // etc

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
</body>
</html>