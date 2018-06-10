@extends('admin.home')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/theme.blue.css') }}" rel="stylesheet">
    <style>
        
    </style>
@stop

@section('js')
    <script src={{ asset('js/jquery-3.3.1.js') }}></script>
    <script src={{ asset('js/jquery.tablesorter.js') }}></script>
    <script src={{ asset('js/jquery.tablesorter.widgets-filter-formatter.min.js') }}></script>
    <script>
        $(document).ready(function(){
            $idPlantilla = '';
            $nombre = '';
            $descripcion = '';

            //Registrar nueva plantilla - Bloquear botón de crear
            $('.plant-btn').on('click','#crear', function (){
                $('#error').slideUp();
                $nombre = $('#nombre').val().trim();
                if ( $nombre.length < 1 ){
                    error('Debes especificar un nombre.');
                } else {
                    var $datos = 'nombre='+$nombre;
                    $descripcion = $('#descripcion').val().trim();
                    if ( $descripcion.length > 0 ){
                        $datos+= '&descripcion='+$descripcion;
                    }
                    $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                    $.ajax({
                        url: '/plantilla',
                        type: 'POST',
                        data: $datos,
                        statusCode:{
                            201: function(e){
                                $idPlantilla = e.id;
                                $('#crear').attr('disabled', 'disabled');
                                $('#tabla-sesiones').slideDown();
                            }
                        }
                    });
                }
            });

            $('.plant').on('blur', function(){ console.log('des:'+$descripcion);
                var $nom = $('#nombre').val().trim();
                var $des = $('#descripcion').val().trim();
                if ( $idPlantilla != '' && ( $nom != $nombre || $des != $descripcion)){
                    $('#crear').removeAttr('disabled').attr('id','modificar').val('Modificar');
                    $('#modificar').removeAttr('disabled');
                }
            });

            $('.plant-btn').on('click', '#modificar', function (){
                var $boton = $(this);
                var $nom = $('#nombre').val().trim();
                var $des = $('#descripcion').val().trim();
                var $datos = 'idPlantilla='+$idPlantilla;
                if ($nom != $nombre){
                    $nombre = $nom;
                    $datos+= '&nombre='+$nom;
                }
                if ($des != $descripcion){
                    $descripcion = $des;
                    $datos+= '&descripcion='+$des;
                }
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
                $.ajax({
                    url: '/plantilla/modificar',
                    type: 'POST',
                    data: $datos,
                    statusCode:{
                        204: function(){ 
                            $boton.attr('disabled', 'disabled');
                        },
                        403: function(e){
                            error('La plantilla no existe.');
                        }
                    }
                });

            });

            $('#guardar').on('click', function (){
                var $filas = $('tbody').find('tr');
                var sesiones = [];
                for ( var i=0; i<$filas.length ; i++ ){
                    $fila = $filas.eq(i).find('td');
                    var $sala = $fila.eq(0).text();
                    for (var j=1; j<$fila.length ; j++ ){
                        $hora = $fila.eq(j).children().first().val();
                        if ( $hora != ''){
                            $sesion = {
                                'sala_id' : parseInt($sala),
                                'pase' : j,
                                'hora' : $hora
                            };
                            sesiones.push($sesion);
                        }
                    }
                }
                var datos = {
                    'plantilla_id' : $idPlantilla,
                    'sesiones' : sesiones
                }; console.log(datos);
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
                $.ajax({
                    url: '/sesionvacia/crear',
                    type: 'POST',
                    data: datos,
                    dataType: "json",
                    statusCode:{
                        200: function(e){
                            console.log(e);
                        },
                        204: function(){ 
                            $boton.attr('disabled', 'disabled');
                        },
                        403: function(e){
                            error('La plantilla no existe.');
                        }
                    }
                });
            });
        });

        function error(mensaje){
            $('#error').text(mensaje);
            $('#error').slideDown();
        }
    </script>
@stop

@section('admin', $admin )

@section('migas')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"></i> Home</a></li>
        <li class="active">Crear plantilla</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Crear nueva plantilla.</h3>
        </div>
        <div class="box-body">
            <label>Nombre:
                <input type="text" name="nombre" class="plant" id="nombre"/>
            </label>
            <label>Descripción:
                <input type="text" name="descripcion" class="plant" id="descripcion"/>
            </label>
            <span class="plant-btn">
                <input type="button" id="crear" value="Crear"/>
            </span>
            <div id=error></div>
            <div id="tabla-sesiones" hidden>
                <table id="sesiones">
                    <thead>
                        <tr>
                            <th>Sala</th>
                            <th>Pase 1</th>
                            <th>Pase 2</th>
                            <th>Pase 3</th>
                            <th>Pase 4</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $salas as $sala )
                            <tr>
                                <td>{{$sala->numero}}</td>
                                <td><input type="time" class="hora"/></td>
                                <td><input type="time" class="hora"/></td>
                                <td><input type="time" class="hora"/></td>
                                <td><input type="time" class="hora"/></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <input type="button" id="guardar" value="Guardar cambios"/>
            </div>
        </div>
    </div>
@stop