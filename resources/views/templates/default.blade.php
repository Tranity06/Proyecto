<!DOCTYPE html>
<html lang="en" class="has-navbar-fixed-top">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Palomitas time</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.0/js/all.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Jua|Lato:400,700" rel="stylesheet">
    <link href="{{ asset('css/utilidades.css') }}" media="all" rel="stylesheet" type="text/css" />

    <style type="text/css">

        body{
            background-color: #f9f9f9;
        }

        html * {
            font-family: 'Lato', sans-serif !important;
        }

        .navbar-end {
            margin-left: 20% !important;
        }

        span.navbar-item.navbar-item-end {
            left: 56%;
        }

        .user-login {
            height: 52px;
            width: 150px;
            display: flex;
            align-items: center;
        }

        .avatar {
            border-radius: 50%;
            display: block;
            width: 32px;
            height: 32px;
            margin-right: 9px;
            margin-left: 5px;
        }

        .centeredIcon {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            width: 40px;
            height: 40px;
            color: dodgerblue;
            background-color: ghostwhite;
            border-radius: 100%;
            margin-left: .5rem;
            -webkit-transition: all .5s;
            -moz-transition: all .5s;
            transition: all .5s;
        }

        .centeredIcon:hover {
            color: white;
            background-color: dodgerblue;
        }

        .prueba {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }



    </style>
    @yield('header')


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Get all "navbar-burger" elements
            var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

            // Check if there are any navbar burgers
            if ($navbarBurgers.length > 0) {

                // Add a click event on each of them
                $navbarBurgers.forEach(function ($el) {
                    $el.addEventListener('click', function () {

                        // Get the target from the "data-target" attribute
                        var target = $el.dataset.target;
                        var $target = document.getElementById(target);

                        // Toggle the class on both the "navbar-burger" and the "navbar-menu"
                        $el.classList.toggle('is-active');
                        $target.classList.toggle('is-active');

                    });
                });
            }

        });
    </script>
</head>
<body>
    @include('templates.partials.navbar')
    <div class="prueba">
        @yield('content')
    </div>
    @yield('javascript')
    @include('templates.partials.footer')
</body>
</html>