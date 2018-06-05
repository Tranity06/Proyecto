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
            $(function() {
                $(".table").tablesorter({
                    theme: 'blue',
                    widgets: ['zebra']
                });
            });

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
            $('.table').on('click', '.borrar', function(){
                var $boton = $(this);
                var $idPlantilla= $boton.next().val();
                var $nombrePlantilla = $boton.closest('tr').children('td').eq(0).text();

                var $callout = $('.callout').first();
                $boton.attr('disabled', 'disabled');
                $callout.slideUp();
                $callout.text('');
                $callout.removeClass('callout-danger');

                if (confirm("¿Seguro que quieres eliminar la plantilla "+$nombrePlantilla+"?")){
                    $.ajax({
                        url: '/plantilla/borrar',
                        type: 'POST',
                        data: 'idPlantilla='+$idPlantilla,
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
                            403: function (){
                                $callout.text(e.responseJSON);
                                $callout.addClass('callout-danger').slideDown();
                            }
                        },
                        async: true,
                    });
                }
            });           
        });
    </script>
@stop

@section('admin', $admin )

@section('migas')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"></i> Home</a></li>
        <li class="active">Plantillas</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Plantillas de sesiones.</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover tablesorter">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Sesiones</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plantillas as $plantilla)
                        <div class="fila">
                            <tr>
                                <td> {{ $plantilla->nombre}} </td>
                                <td> {{ $plantilla->descripcion}} </td>
                                <td>
                                    <button class="detalles"><i class="glyphicon glyphicon-pencil"></i></button>
                                    <input type="hidden" name="id" value="{{ $plantilla->id }}"/>
                                </td>
                                <td>
                                    <button class="borrar"><i class="fa fa-fw fa-trash-o"></i></button>
                                    <input type="hidden" name="id" value="{{ $plantilla->id }}"/>
                                </td>
                            </tr>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop