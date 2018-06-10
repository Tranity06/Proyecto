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
            var sesiones_all = $('.table').first().data('cosas');
            var peliculas = $('.table').first().data('peliculas');
            console.log(sesiones_all)
            
            var selectPeliculas = '<select name="idPelicula" id="idPelicula">';
            selectPeliculas+= '<option value="-1">- Seleccionar película -</option>';
            for ( var i=0; i<peliculas.length ; i++ ){
                selectPeliculas+='<option value="'+peliculas[i]['id']+'">'+peliculas[i]['titulo']+'</option>';
            }
            selectPeliculas+='</select>';

            var plantillas = $('#plantilla').data('plantillas');

            $(function() {
                $(".table").tablesorter({
                    theme: 'blue',
                    widgets: ['zebra']
                });
            });

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $('#fecha').change(function(){
                var fecha = $(this).val();
                var sesiones = sesiones_all[fecha];
                var $body = $('tbody').first();
                var cuerpo = '';

                for (var sala=1; sala<=5 ; sala++ ){
                    cuerpo+= '<tr><td rowspan="2">'+sala+'</td>';
                    horas='';
                    pelis='<tr>';
                    plantilla = $('#plantilla').val();
                    if ( typeof sesiones !== "undefined" && sesiones[sala]!=null){
                        for (var pase=1 ; pase<5 ; pase++ ) {
                            horas+= '<td class="'+sala+pase+'" id="hora"><input type="time"';
                            pelis+= '<td class="'+sala+pase+'" id="peli"><select name="idPelicula" id="idPelicula">';
                            pelis+= '<option value="-1">- Seleccionar película -</option>';
                            for ( var i=0; i<peliculas.length ; i++ ){
                                pelis+='<option value="'+peliculas[i]['id']+'" ';
                                if ( sesiones[sala][pase]['pelicula']['titulo'] != null ){
                                    horas+= 'id="'+sesiones[sala][pase]['id']+'" value="'+sesiones[sala][pase]['hora']+'"/></td>';
                                    pelis+='selected';
                                } else if ( typeof plantillas[plantilla][sala][pase][0] !== "undefined") {
                                    horas+= 'value="'+plantillas[plantilla][sala][pase][0]['hora']+'"';
                                }
                                horas+= '/></td>';
                                pelis+= '>'+peliculas[i]['titulo']+'</option>';
                            }
                            pelis+='</select></td>';
                        }
                    } else {
                        for (var pase=1 ; pase<5 ; pase++ ) {
                            horas+= '<td class="'+sala+pase+'" id="hora"><input type="time"';
                            if ( typeof plantillas[plantilla][sala][pase][0] !== "undefined"){
                                horas+= 'value="'+plantillas[plantilla][sala][pase][0]['hora']+'"';
                            }
                            horas+= '/></td>';
                            pelis+= '<td class="'+sala+pase+'" id="peli">'+selectPeliculas+'</td>';
                        }
                    }
                    cuerpo+= horas+'</tr>'+pelis+'</tr>'
                    
                }
                $body.html(cuerpo);
            });

            $('#plantilla').change(function () {
                if (confirm("Si cambias la plantilla cambiarán las horas de las sesiones, ¿Seguro que quieres hacerlo?")){
                    var plantilla = $(this).val();
                    for ( var sala=1 ; sala<=5 ; sala++ ) {
                        for (var pase=1; pase<=4 ; pase++ ){
                            var clase='.'+sala+pase;
                            $(clase).children().first().val('');
                            if ( typeof plantillas[plantilla][sala][pase][0] !== "undefined" ){
                                $(clase).children().first().val(plantillas[plantilla][sala][pase][0]['hora']);
                            }
                        }
                    }
                }
            });

            $('#guardar').on('click', function(){
                $fecha = $('#fecha').val();
                var sesiones = [];
                if ($fecha != ''){
                    for ( var sala=1 ; sala<=5 ; sala++ ){
                        for (var pase=1; pase<4 ; pase++ ){
                            var clase='.'+sala+pase;
                            var $hora = $(clase).children().first().val();
                            var $idPelicula = $(clase).children().eq(1).val();
                            if ( $hora != '' && $idPelicula>0){
                                var sesion = {
                                    'fecha': $fecha,
                                    'pase': pase,
                                    'hora': $hora,
                                    'estado': 1,
                                    'pelicula_id': $idPelicula,
                                    'sala': sala
                                }
                                sesiones.push(sesion);
                            }
                        }
                    }
                }
                var datos = {
                    'sesiones' : sesiones
                };
                $.ajax({
                    url: '/sesion',
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
        <li class="active">Sesiones</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Sesiones.</h3>
        </div>
        <div class="box-body">
            <label>Fecha:
                <input type="date" id="fecha" name="fecha"/>
            </label>
            <label>Plantillas:
                <select id="plantilla" name="plantilla" data-plantillas="{{$sesionesvacias}}">
                    @foreach($plantillas as $plantilla)
                        <option value="{{$plantilla->id}}">{{$plantilla->nombre}}</option>
                    @endforeach
                </select>
            </label>
            <div id="tabla-sesiones">
                <table class="table table-bordered table-hover tablesorter" id="sesiones" data-cosas="{{$sesiones}}" data-peliculas="{{$peliculas}}">
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

                    </tbody>
                </table>
                <input type="button" id="guardar" value="Guardar cambios"/>
            </div>
        </div>
    </div>
@stop