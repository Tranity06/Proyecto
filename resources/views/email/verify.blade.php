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
            <p>Haz click en <code>Confirmar mi dirección de correo electrónico</code> para confirmar tu dirección de correo electrónico:</p>
            <br>

            <a class="button is-warning is-rounded" href="{{ url('/').'?verification='.$verification_code }}">Confirmar mi dirección de correo electrónico</a>
        </div>
    </div>

</body>
</html>
