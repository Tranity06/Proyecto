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
            console.log(sesiones_all)

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
                console.log('asd'+Object.keys(sesiones).length);
                console.log(sesiones);
                var $body = $('tbody').first();
                var cuerpo = '';

                for (var sala=1; sala<=5 ; sala++ ){
                    cuerpo+= '<tr><td rowspan="2">'+sala+'</td>';
                    horas='';
                    pelis='<tr>';
                    if ( sesiones[sala]!=null){
                        for (var pase=1 ; pase<5 ; pase++ ) {
                            console.log('sala?'+sesiones[sala][pase]['pelicula']['titulo']);
                            horas+= '<td data-pelicula="">'+sesiones[sala][pase]['hora']+'</td>';
                            pelis+= '<td data-pelicula="">'+sesiones[sala][pase]['pelicula']['titulo']+'</td>';
                        }
                    } else {
                        for (var pase=1 ; pase<5 ; pase++ ) {
                            horas+= '<td data-pelicula="">'+'HORA'+'</td>';
                            pelis+= '<td data-pelicula="">'+'PELI'+'</td>';
                        }
                    }
                    cuerpo+= horas+'</tr>'+pelis+'</tr>'
                    
                }
                $body.append(cuerpo);
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
            <div id="tabla-sesiones">
                <table class="table table-bordered table-hover tablesorter" id="sesiones" data-cosas="{{$sesiones}}">
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