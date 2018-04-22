@extends('admin.home')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/theme.blue.css') }}" rel="stylesheet">
    <style>
        input {
            margin-bottom: .2em;
        }
        #resultado {
            padding-top: 1em;
            display: block;
            clear: left;
        }

        #poster{
            float: left;
            display: block;
        }

        #datos-peli{
            float: left;
            width: 80%
        }

        #resultado>.buscar, #resultado>.guardar{
            margin-left: 1em;
            margin-top: 1em;
        }
    </style>
@stop

@section('js')
    <script src={{ asset('js/jquery-3.3.1.js') }}></script>
    <script src={{ asset('js/jquery.tablesorter.js') }}></script>
    <script src={{ asset('js/jquery.tablesorter.widgets-filter-formatter.min.js') }}></script>
    <script>
        $(document).ready(function(){

            $('.box-body').on('click','.buscar', function(){
                var $titulo = $('#titulo').val().trim();
                $('#resultado').children().remove();

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "https://api.themoviedb.org/3/search/movie?language=es&api_key=0e46a63ca778de097560700378c1c185&query="+$titulo,
                    "method": "GET",
                    "headers": {},
                    "data": "{}"
                }

                $.ajax(settings).done(function (response) {
                    resultados = response['results'];
                    var $tabla = $('<table class="table table-bordered table-hover tablesorter"></table>');
                    var $cabecera = $('<thead><tr><th>Título</th><th>Fecha de estreno</th><th>Mostrar</th></tr></thead>')
                    $tabla.append($cabecera);

                    $cuerpo = $('<tbody></tbody>');
                    for ( var i=0 ; i<resultados.length ; i++ ){
                        var idtmdb = resultados[i]['id'];
                        var titulo = resultados[i]['title'];
                        var estreno = resultados[i]['release_date'];
                        
                        var $titulo = $('<td></td>');
                        $titulo.append(titulo);
                        var $estreno = $('<td></td>');
                        $estreno.append(estreno);
                        var $icono = $('<button class="editar"><i class="glyphicon glyphicon-pencil"></i></button>');
                        var $hiddenId = $('<input type="hidden" name="id" value="'+idtmdb+'"/>');
                        var $mostrar = $('<td></td>');
                        $mostrar.append($icono);
                        $mostrar.append($hiddenId);

                        $fila = $('<tr></tr>');
                        $fila.append($titulo);
                        $fila.append($estreno);
                        $fila.append($mostrar);

                        $cuerpo.append($fila);
                    }
                    $tabla.append($cuerpo);

                    $(function() {
                        $(".table").tablesorter({
                            theme: 'blue',
                            widgets: ['zebra']
                        });
                    });
                    
                    $('#resultado').append($tabla);
                });
            });

            $('#resultado').on('click', '.editar', function(){
                $idtmdb = $(this).next().val();
                $('#resultado').children().remove();

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "https://api.themoviedb.org/3/movie/"+$idtmdb+"?language=es&api_key=0e46a63ca778de097560700378c1c185&append_to_response=credits",
                    "method": "GET",
                    "headers": {},
                    "data": "{}"
                }

                $.ajax(settings).done(function (response) {
                    var titulo = response.title;
                    var titulo_original = response.original_title;
                    var estreno = response.release_date;
                    var generos = [];
                    response.genres.forEach(function(entry){
                        generos.push(entry.name);
                    });
                    generos = generos.join(', ');
                    var director = [];
                    response.credits.crew.forEach(function(entry){
                        if (entry.job === 'Director') {
                            director.push(entry.name);
                        }
                    });
                    director = director.join(', ');
                    var actores = [];
                    for ( var i=0 ; i<5 ; i++ ){
                        actores.push(response['credits']['cast'][i]['name']);
                    }
                    actores = actores.join(', ');

                    var sinopsis = response['overview'];

                    var $contenedor_datos = $('<dl id="datos-peli" class="dl-horizontal"></dl>');
                    var $titulo = $('<dt>Título</dt><dd id="titulo">'+titulo+'</dd>');
                    var $titulo_original = $('<dt>Título original</dt><dd id="titulo_original">'+titulo_original+'</dd>');
                    var $estreno = $('<dt>Fecha de estreno</dt><dd id="estreno">'+estreno+'</dd>');
                    var $director = $('<dt>Director</dt><dd id="director">'+director+'</dd>');
                    var $actores = $('<dt>Actores</dt><dd id="actores">'+actores+'</dd>');
                    var $sinopsis = $('<dt>Sinopsis</dt><dd id="sinopsis">'+sinopsis+'</dd>');
                    var $generos = $('<dt>Géneros</dt><dd id="generos">'+generos+'</dd>');
                    var $idtmdb_hidden = $('<input type="hidden" name="idtmdb" id="idtmdb" value="'+$idtmdb+'"/>');
                    
                    $contenedor_datos.append($titulo);
                    $contenedor_datos.append($titulo_original);
                    $contenedor_datos.append($estreno);
                    $contenedor_datos.append($generos);
                    $contenedor_datos.append($director);
                    $contenedor_datos.append($actores);
                    $contenedor_datos.append($sinopsis);
                    $contenedor_datos.append($idtmdb_hidden);

                    var poster = response.poster_path;
                    var $poster = $('<img id="poster" src="https://image.tmdb.org/t/p/w500'+poster+'" alt="Póster de la película película" width="200">');

                    var $atras = $('<input type="button" class="buscar sub btn btn-primary" value="Volver a la lista"/>');
                    var $guardar = $('<input type="button" class="guardar sub btn btn-primary" id="guardar" value="Guardar"/>');

                    $('#resultado').append($poster);
                    $('#resultado').append($contenedor_datos);
                    $('#resultado').append($atras);
                    $('#resultado').append($guardar);
                });
            });

            $('#resultado').on('click', '.guardar', function(){
                var $formulario = $('#formulario');
                $formulario.append('<input type="text" name="idtmdb" value="'+$('#idtmdb').val()+'"/>');
                $formulario.append('<input type="text" name="titulo" value="'+$('#titulo').val()+'"/>');
                $formulario.append('<input type="text" name="titulo_original" value="'+$('#titulo_original').val()+'"/>');
                $formulario.append('<input type="text" name="estreno" value="'+$('#estreno').val()+'"/>');
                $formulario.append('<input type="text" name="generos" value="'+$('#generos').val()+'"/>');
                $formulario.append('<input type="text" name="director" value="'+$('#director').val()+'"/>');
                $formulario.append('<input type="text" name="actores" value="'+$('#actores').val()+'"/>');
                $formulario.append('<input type="text" name="sinopsis" value="'+$('#sinopsis').val()+'"/>');
                $formulario.submit();
            })
        });
    </script>
@stop

@section('admin', $admin )

@section('migas')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"></i> Home</a></li>
        <li class="active">Registrar nueva película</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Registrar nueva película</h3>
        </div>
        <div class="box-body">
            <p>Título de la película:</p>
            <div class="col-xs-4" id="buscar">
                <input type="text" class="form-control input-sm" id="titulo"/>
                <input type="button" class="buscar sub btn btn-primary" value="Buscar"/>
            </div>
            <div id="resultado">
            </div>
        </div>
    </div>
    <form action="#" id="formulario" method="POST" hidden>{{ csrf_field() }}</form>
@stop