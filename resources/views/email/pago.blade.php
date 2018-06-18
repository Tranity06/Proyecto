<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <style>

        .flex-container {
            display: flex;
            align-items: center;
            justify-content: center;
            /* You can set flex-wrap and
               flex-direction individually */
            flex-direction: row;
            flex-wrap: wrap;
            /* Or do it all in one line
              with flex flow */
            flex-flow: row wrap;
            /* tweak where items line
               up on the row
               valid values are: flex-start,
               flex-end, space-between,
               space-around, stretch */
            align-content: flex-end;
        }

        .box-form{
            box-shadow: 0 0 25px rgba(0,0,0,0.08);
            background-color: #fff;
        }

        .box-form:hover{
            box-shadow: 0 0 25px rgba(0,0,0,0.20);
            background-color: #fff;
        }

        .ticket-block {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .ticket-block > .codigo{
            width: 100px;
            height: 100px;
            background-color: gray;
            margin-right: 15px;
        }

        .restaurante-block {
            display: flex;
            justify-content: space-between;
            flex-direction: column;
            align-items: center;
            margin-bottom: 15px;
        }

        .restaurante-block > .item{
            display: flex;
            width: 100%;
            justify-content: space-between;
        }

        .precio-total{
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>

    <div class="section">
        <div class="container">
            <p class="title">Hola {{ $user->name }},</p>
            <p class="subtitle">Aquí tienes tu ticket.</p>
            <div class="flex-container">
                <div class="box-form" style="display: flex; flex-direction: column; padding: 1rem;">
                    <div class="ticket-block">
                        <div class="codigo"></div>
                        <div class="entrada">
                            <p class="has-text-weight-bold is-size-4">{{$datos_pago['nombre_pelicula']}}</p>
                            <span><i class="far fa-clock"></i> {{ $datos_pago['hora'] }} </span>
                            <span>Sala: {{$datos_pago['sala_id']}}</span>
                            <div class="tags">
                                @foreach ($datos_pago['butacas'] as $butaca)
                                    <span class="tag is-rounded">{{$butaca}}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="restaurante-block">
                    @foreach ($datos_pago['items_restaurante'] as $item)
                            <div class="item">
                                <span class="has-text-weight-bold">{{$item['producto']['nombre']}}</span>
                                <span>cantidad: {{$item['cantidad']}}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="precio-total">
                        <span class="has-text-weight-bold">TOTAL:</span>
                        <span>{{ $datos_pago['precio_total'] }} €</span>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>

</body>
</html>
