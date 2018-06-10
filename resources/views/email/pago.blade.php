<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
</head>
<body>

    <div class="section">
        <div class="container">
            <p class="title">Hola {{ $user->name }},</p>
            <p class="subtitle">Gracias por crear una cuenta con nosotros. No olvides completar tu registro!</p>
            <p>{{ $datos_pago['nombre_pelicula'] }}</p>
            <p>{{ $datos_pago['dia'] }}</p>
            <p>{{ $datos_pago['nombre_tarjeta']  }}</p>
            <br>
        </div>
    </div>

</body>
</html>
