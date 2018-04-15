<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Palomitas time</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.0/js/all.js"></script>

    @yield('estilos')

    <style type="text/css">
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
            border-radius: 35%;
            display: block;
            height: 48px;
            width: 48px;
            margin-right: 9px;
            margin-left: 5px;
        }

    </style>

</head>
<body>
    @include('templates.partials.navbar')
    @yield('content')
    @yield('javascript')
</body>
</html>