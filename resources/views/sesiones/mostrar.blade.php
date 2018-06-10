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
            
            var selectPeliculas = '<select name="idPelicula" id="idPelicula">';
            selectPeliculas+= '<option value="-1">- Seleccionar película -</option>';
            for ( var i=0; i<peliculas.length ; i++ ){
                selectPeliculas+='<option value="'+peliculas[i]['id']+'">'+peliculas[i]['titulo']+'</option>';
            }
            selectPeliculas+='</select>';

            var plantillas = $('#plantilla').data('plantillas');
            console.log(plantillas);

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
                            horas+= '<td><input type="time"';
                            pelis+= '<td><select name="idPelicula" id="idPelicula">';
                            pelis+= '<option value="-1">- Seleccionar película -</option>';
                            for ( var i=0; i<peliculas.length ; i++ ){
                                pelis+='<option value="'+peliculas[i]['id']+'" ';
                                if ( sesiones[sala][pase]['pelicula']['titulo'] != null ){
                                    horas+= 'id="'+sesiones[sala][pase]['id']+'" value="'+sesiones[sala][pase]['hora']+'"/></td>';
                                    pelis+='selected';
                                } else {
                                    horas+= 'value="'+plantillas[plantilla][sala][pase][0]['hora']+'"/></td>';
                                }
                                pelis+= '>'+peliculas[i]['titulo']+'</option>';
                            }
                            pelis+='</select></td>';
                        }
                    } else {
                        for (var pase=1 ; pase<5 ; pase++ ) {
                            horas+= '<td><input type="time" value="'+plantillas[plantilla][sala][pase][0]['hora']+'"/></td>';
                            pelis+= '<td>'+selectPeliculas+'</td>';
                        }
                    }
                    cuerpo+= horas+'</tr>'+pelis+'</tr>'
                    
                }
                $body.html(cuerpo);
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