<!DOCTYPE html>
<html lang="es" class="has-navbar-fixed-top">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Palomitas Time</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Jua|Lato:400,700" rel="stylesheet">
    <link href="{{ asset('css/utilidades.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/modal/lity.css') }}" media="all" rel="stylesheet" type="text/css" />

    <style>
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
    </style>
</head>
<body>

    <div id="app">
        <app></app>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/modal/lity.js') }}"></script>
</body>
</html>