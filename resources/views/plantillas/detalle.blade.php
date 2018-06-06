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
            <h3 class="box-title">Detalle plantilla {{$plantilla->nombre}}</h3>
        </div>
        <div class="box-body">
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