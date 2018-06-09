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

        #resultado>.buscar, #resultado>.guardar{
            margin-left: 1em;
            margin-top: 1em;
        }
        p {
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
                $('#err').slideUp();
                $('.callout').slideUp();
                var $titulo = $('#buscar_titulo').val().trim();
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
                $('#err').slideUp();
                $idtmdb = $(this).next().val();
                $('#resultado').children().remove();

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "https://api.themoviedb.org/3/movie/"+$idtmdb+"?language=es&api_key=0e46a63ca778de097560700378c1c185&append_to_response=credits,videos",
                    "method": "GET",
                    "headers": {},
                    "data": "{}"
                }

                $.ajax(settings).done(function (response) { console.log(response);
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
                        actores.push(response['credits']['cast'][i]['character']+' - '+response['credits']['cast'][i]['name']);
                    } console.log(actores);
                    actores = actores.join(', ');
                    url = 'https://www.youtube.com/embed/'+response.videos.results[0]['key'];

                    $('#idtmdb').val($idtmdb);
                    $('#titulo').val(response.title);
                    $('#titulo_original').val(response.original_title);
                    $('#estreno').val(response.release_date);
                    $('#generos').val(generos);
                    $('#director').val(director);
                    $('#actores').val(actores);
                    $('#sinopsis').val(response.overview);
                    $('#duracion').val(response.runtime);
                    $('#trailer').val(url);
                    $('#poster').val('https://image.tmdb.org/t/p/w500'+response.poster_path);
                    $('#slider_image').val('https://image.tmdb.org/t/p/w500'+response.backdrop_path);
                    $('#popularidad').val(response.popularity);
                    $('#imagen_poster').attr('src', 'https://image.tmdb.org/t/p/w500'+response.poster_path);
                    $('#imagen_slider').attr('src', 'https://image.tmdb.org/t/p/w500'+response.backdrop_path);
                    $('#video_trailer').attr('src', url);
                    $('#detalle').slideDown();
                });
            });

            $('#poster').on('change', function(){
                $('#imagen_poster').slideUp();
                $('#imagen_poster').attr('src', $('#poster').val());
                $('#imagen_poster').slideDown();
            });

            $('#slider_image').on('change', function(){
                $('#imagen_slider').slideUp();
                $('#imagen_slider').attr('src', $('#slider_image').val());
                $('#imagen_slider').slideDown();
            });

            $('#trailer').on('change', function(){
                $('#video_trailer').slideUp();
                $('#video_trailer').attr('src', $('#trailer').val());
                $('#video_trailer').slideDown();
            });
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
            @if ( isset($noslider) )
                <div class="callout callout-warning">
                    <p>La película se ha registrado con éxito pero no se pueden añadir más de tres películas al slider. Puedes modificar el contenido del slider en el menú Slider.</p>
                </div>
            @endif
            @if ( isset($pelicula) )
                <div class="callout callout-success">
                    <p>Pelicula nueva registrada.</p>
                </div>
            @endif
            @if ( isset($repetida) )
                <div class="callout callout-danger">
                    <p>La película ya estaba registrada en la base de datos.</p>
                </div>
            @endif
            <p>Título de la película:</p>
            <div class="col-xs-4" id="buscar">
                <input type="text" class="form-control input-sm" id="buscar_titulo"/>
                <input type="button" class="buscar sub btn btn-primary" value="Buscar"/>
            </div>
            <div id="resultado">
            </div>
            <div id="detalle" hidden>
                <form action=""{{ route('pelicula.crear') }}"" id="formulario" method="POST">{{ csrf_field() }}
                    <input type="hidden" class="form-control input-sm" id="idtmdb" name="idtmdb"/>
                    
                    <p>Título:</p>
                    <input type="text" class="form-control input-sm" id="titulo" name="titulo"/>
            
                    <p>Título original:</p>
                    <input type="text" class="form-control input-sm" id="titulo_original" name="titulo_original"/>
            
                    <p>Fecha de estreno:</p>
                    <input type="text" class="form-control input-sm" id="estreno" name="estreno"/>
            
                    <p>Géneros:</p>
                    <input type="text" class="form-control input-sm" id="generos" name="generos"/>
            
                    <p>Director:</p>
                    <input type="text" class="form-control input-sm" id="director" name="director"/>
            
                    <p>Actores:</p>
                    <input type="text" class="form-control input-sm" id="actores" name="actores"/>
            
                    <p>Sinopsis:</p>
                    <textarea class="form-control input-sm" id="sinopsis" name="sinopsis" rows="4"></textarea>
            
                    <p>Duración:</p>
                    <input type="text" class="form-control input-sm" id="duracion" name="duracion"/>
            
                    <p>Cartel:</p>
                    <input type="text" class="form-control input-sm" id="poster" name="poster"/>
                    <img id="imagen_poster" src="#" alt="Póster de la película película" width="200"/>

                    <p>Tráiler:</p>
                    <input type="text" class="form-control input-sm" id="trailer" name="trailer"/>
                    <iframe id="video_trailer" width="560" height="315" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    <!-- <div id="video_trailer"></div> -->
                    
            
                    <p>Añadir al slider:</p>
                    <input type="checkbox" id="slider" name="slider"/>
                    
                    <p>Imagen del slider:</p>
                    <input type="text" class="form-control input-sm" id="slider_image" name="slider_image"/>
                    <img id="imagen_slider" src="#" alt="Imagen del slider de la película película"/>

                    <input type="hidden" class="form-control input-sm" id="popularidad" name="popularidad"/>
                    
                    <p>
                    <input type="button" class="buscar sub btn btn-primary" value="Volver a la lista"/>
                    <input type="submit" class="guardar sub btn btn-primary" id="guardar" value="Guardar"/>
                    </p>
                </form>
            </div>
        </div>
    </div>
@stop