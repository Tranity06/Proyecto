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
    {{-- <script>
        $(document).ready(function(){
            $(function() {
                $(".table").tablesorter({
                    theme: 'blue',
                    widgets: ['zebra']
                });
            });

            $('.table').on('click', '.borrar', function(){
                var $boton = $(this);
                var $id= $boton.next().val();
                if (confirm("¿Seguro que quieres eliminar esta película?")){
                    $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                    $.ajax({
                        url: '/peliculas/borrar',
                        type: 'POST',
                        data: 'id='+$id,
                        statusCode:{
                            204: function (){
                                $boton.closest('tr')
                                .children('td')
                                .animate({ 
                                    padding: 0
                                })
                                .wrapInner('<div/>')
                                .children().slideUp(function () {
                                    $(this).closest('tr').remove();
                                });
                            },
                            400: function() {
                                console.log("Error");
                            }
                        },
                        async: true,
                    });
                }
            });
        }); --}}
    </script>
@stop

@section('admin', $admin )

@section('migas')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"></i> Home</a></li>
        <li><a href="#"></i> Lista de salas</a></li>
        <li class="active">Detalle sala {{$sala->id}}</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Detalle sala {{$sala->id}}.</h3>
        </div>
        <div class="box-body">
            <p>Nº Sala: {{$sala->numero}}</p>
            <p>Aforo: {{$sala->aforo}}</p>
            <p>Butacas bloqueadas:{{ sizeof($butacas_bloqueadas) }}</p>
            <table class="table table-bordered table-hover tablesorter">
                <thead>
                    <tr>
                        <th>Fila</th>
                        <th>Butaca</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($butacas_bloqueadas as $butaca)
                        <div class="fila">
                            <tr>
                                <td> {{ $butaca->fila}} </td>
                                <td> {{ $butaca->numero}} </td>
                            </tr>
                        </div>
                    @endforeach
                </tbody>
            </table>
            <p>Sesiones:{{ sizeof($sesiones) }}</p>
            <table class="table table-bordered table-hover tablesorter">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sesiones as $sesion)
                        <div class="fila">
                            <tr>
                                <td> {{ $sesion->fecha}} </td>
                                <td> {{ $sesion->hora}} </td>
                            </tr>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop