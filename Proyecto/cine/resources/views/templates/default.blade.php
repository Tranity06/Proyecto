<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Palomitas time</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.0/js/all.js"></script>

    <style type="text/css">
        .navbar-end {
            margin-left: 20% !important;
        }

        span.navbar-item.navbar-item-end {
            left: 50%;
        }
    </style>

</head>
<body>
    @include('templates.partials.navbar')
    @yield('content');
</body>
</html>