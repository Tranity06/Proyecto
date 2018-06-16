@extends('admin.home')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="{{ asset('css/theme.blue.css') }}" rel="stylesheet">
    <style>
        p, .sub, .cambiar-pw {
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
        }
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

            $('.table').on('click', '.editar', function(){
                var $boton = $(this);
                var $idCategoria= $boton.next().val();

                var getUrl = window.location;
                var destino = getUrl .protocol + "//" + getUrl.host + "/categorias/" + $idCategoria;
                $( location ).attr("href", destino);
            });

            $('.table').on('click', '.borrar', function(){
                var $boton = $(this);
                var idCategoria= $('#id').val();

                var $callout = $('.callout').first();
                $boton.attr('disabled', 'disabled');
                $callout.slideUp();
                $callout.text('');
                $callout.removeClass('callout-danger');

                if (confirm("¿Seguro que quieres eliminar esta categoría?")){
                    $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                    $.ajax({
                        url: '/categorias/borrar',
                        type: 'POST',
                        data: 'idCategoria='+idCategoria,
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
        <li class="active">Lista de categorías</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Categorías existentes</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover tablesorter">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categorias as $categoria)
                        <div class="fila">
                            <tr>
                                <td> {{ $categoria->nombre }} </td>
                                <td>
                                    <button class="editar"><i class="glyphicon glyphicon-pencil"></i></button>
                                    <input type="hidden" name="id" value="{{ $categoria->id }}"/>
                                </td>
                                <td>
                                    <button class="borrar"><i class="fa fa-fw fa-trash-o"></i></button>
                                    <input type="hidden" id="id" name="id" value="{{ $categoria->id }}"/>
                                </td>
                            </tr>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop