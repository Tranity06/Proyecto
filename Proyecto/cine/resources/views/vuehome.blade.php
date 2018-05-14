<!DOCTYPE html>
<html lang="es" class="has-navbar-fixed-top">
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

        .js-cookie-consent.cookie-consent {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            padding: 15px;
            background-color: hsl(48, 100%, 67%);
            position: fixed;
            width: 100%;
            bottom: 0;
            z-index: 100;
            overflow-y: scroll;
        }

        button.js-cookie-consent-agree.cookie-consent__agree {
            background-color: #fff;
            border-color: #dbdbdb;
            border-width: 1px;
            color: #363636;
            cursor: pointer;
            justify-content: center;
            padding-bottom: calc(.375em - 1px);
            padding-left: .75em;
            padding-right: .75em;
            padding-top: calc(.375em - 1px);
            text-align: center;
            white-space: nowrap;
            -webkit-appearance: none;
            align-items: center;
            border: 1px solid transparent;
            border-radius: 4px;
            box-shadow: none;
            display: inline-flex;
            font-size: 1rem;
            height: 2.25em;
            justify-content: flex-start;
            line-height: 1.5;
            padding-bottom: calc(.375em - 1px);
            padding-left: calc(.625em - 1px);
            padding-right: calc(.625em - 1px);
            padding-top: calc(.375em - 1px);
            position: relative;
            vertical-align: top;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border-radius: 290486px;
            padding-left: 1em;
            padding-right: 1em;
        }

        button.js-cookie-consent-agree.cookie-consent__agree:hover{
            border-color: #b5b5b5;
            color: #363636;
        }

        button.js-cookie-consent-agree.cookie-consent__agree:focus{
            border-color: #3273dc;
            color: #363636;
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