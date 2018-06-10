@extends('admin.home')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
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
            $idPlantilla = $('#idPlantilla').data('id');
            $nombre = $('#nombre').val().trim();
            $descripcion = $('#descripcion').val().trim();
            
            $('.plant').on('blur', function(){ console.log('des:'+$descripcion);
                var $nom = $('#nombre').val().trim();
                var $des = $('#descripcion').val().trim();
                if ( $nom != $nombre || $des != $descripcion){
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
    </script>
@stop

@section('admin', $admin )

@section('migas')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"></i> Home</a></li>
        <li><a href="{{ route('plantillas.mostrar') }}"></i> Lista de plantillas</a></li>
        <li class="active">Detalle plantilla {{$plantilla->nombre}}</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" id="idPlantilla" data-id="{{$plantilla->id}}">Detalle plantilla {{$plantilla->nombre}}</h3>
        </div>
        <div class="box-body">
                <label>Nombre:
                    <input type="text" name="nombre" class="plant" id="nombre" value="{{$plantilla->nombre}}"/>
                </label>
                <label>Descripción:
                    <input type="text" name="descripcion" class="plant" id="descripcion" value="{{$plantilla->descripcion}}"/>
                </label>
                <span class="plant-btn">
                    <input type="button" id="modificar" value="Modificar" disabled="disabled"/>
                </span>
                <div id=error></div>
            <div id="tabla-sesiones">
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
                                    @for($pase=1; $pase<5; $pase++)
                                        @if(isset($sesiones[$sala->id][$pase][0]['hora']))
                                            <td><input type="time" class="hora" value="{{$sesiones[$sala->id][$pase][0]['hora']}}"/></td>
                                        @else
                                            <td><input type="time" class="hora"/></td>
                                        @endif
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <input type="button" id="guardar" value="Guardar cambios"/>
                </div>
        </div>
    </div>
@stop