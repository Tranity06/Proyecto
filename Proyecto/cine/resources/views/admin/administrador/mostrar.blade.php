@extends('admin.home')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                var $id= $(this).next().val();
                var $boton = $(this);
                $.ajax({
                    url: '/admin/borrar',
                    type: 'POST',
                    data: 'id='+$id+'&token=0',
                    success: function(e){
                        if ( e === 'Borrado'){
                            $boton.closest('tr')
                            .children('td')
                            .animate({ 
                                padding: 0
                            })
                            .wrapInner('<div/>')
                            .children().slideUp(function () {
                                $(this).closest('tr').remove();
                            });
                        } else {
                            console.log("Error");
                        }
                    },
                    async: true,
                });
            });
        });
    </script>
@stop

@section('admin', $admin )

@section('migas')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"></i> Home</a></li>
        <li class="active">Lista de usuarios</li>
    </ol>
@endsection

@section('content')
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title">Administradores registrados</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover tablesorter">
                <thead>
                    <tr>
                        @if( isset($sumerAdmin) )
                            <th>ID</th>
                        @endif
                        <th>Nombre</th>
                        <th>Email</th>
                        @if( isset($sumerAdmin) )
                            <td><b>Modificar</b></td>
                            <td><b>Borrar</b></td>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($administradores as $administrador)
                        <div class="fila">
                            <tr>
                                @if( isset($sumerAdmin) )
                                    <td> {{ $administrador->id}} </td>
                                @endif
                                <td> {{ $administrador->name}} </td>
                                <td> {{ $administrador->email}} </td>
                                @if( isset($sumerAdmin) )
                                    @unless( $administrador->id == 1)
                                        <td>
                                            <button name="mostrarForm"><i class="glyphicon glyphicon-pencil"></i></button>
                                        </td>
                                        <td>
                                            <button class="borrar"><i class="fa fa-fw fa-trash-o"></i></button>
                                            <input type="text" name="id" value="{{ $administrador->id }}" hidden/>
                                        </td>
                                    @else
                                        <td></td>
                                        <td></td>
                                    @endunless
                                @endif
                            </tr>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop