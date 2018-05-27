@extends('admin.home')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="{{ asset('css/theme.blue.css') }}" rel="stylesheet">
    <style>
        /* p, .sub, .cambiar-pw {
            display: block;
            clear: left;
        }
        input {
            margin-bottom: .2em;
        }

        .errores{
            border-color: red;
        }

        .ok {
            border-color: green;
        } */
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

            $('.table').on('click', '.detalles', function(){
                var idSala = $(this).next().val();
                var getUrl = window.location;
                var destino = getUrl .protocol + "//" + getUrl.host + "/sala/" + idSala;
                $( location ).attr("href", destino);
            });

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
            $('.table').on('click', '.borrar', function(){
                var $boton = $(this);
                var $idSala= $boton.next().val();
                var $numeroSala = $boton.closest('tr').children('td').eq(0).text();

                var $callout = $('.callout').first();
                $boton.attr('disabled', 'disabled');
                $callout.slideUp();
                $callout.text('');
                $callout.removeClass('callout-danger');

                if (confirm("¿Seguro que quieres eliminar la sala "+$numeroSala+"?")){
                    $.ajax({
                        url: '/sala/borrar',
                        type: 'POST',
                        data: 'idSala='+$idSala,
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
        <li class="active">Lista de salas</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de salas registradas.</h3>
        </div>
        <div class="box-body">
            <div class="callout" hidden>
            </div>
            <table class="table table-bordered table-hover tablesorter">
                <thead>
                    <tr>
                        <th>Nº de sala</th>
                        <th>Aforo</th>
                        <th>Sesiones</th>
                        <th>Detalles</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salas as $sala)
                        <div class="fila">
                            <tr>
                                <td> {{ $sala->numero}} </td>
                                <td> TODO </td>
                                <td> {{ sizeof($sala->sesiones) }} </td>
                                <td>
                                    <button class="detalles"><i class="glyphicon glyphicon-pencil"></i></button>
                                    <input type="hidden" name="id" value="{{ $sala->id }}"/>
                                </td>
                                <td>
                                    <button class="borrar"><i class="fa fa-fw fa-trash-o"></i></button>
                                    <input type="hidden" name="id" value="{{ $sala->id }}"/>
                                </td>
                            </tr>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop