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
    {{-- <script>
        $(document).ready(function(){
            $(function() {
                $(".table").tablesorter({
                    theme: 'blue',
                    widgets: ['zebra']
                });
            });

            $('.table').on('click', '.detalles', function(){
                var idSala = $(this).next().val();
                console.log(idSala);
            });
        });
    </script> --}}
@stop

@section('admin', $admin )

@section('migas')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"></i> Home</a></li>
        <li class="active">Crear sala.</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Crear nueva sala.</h3>
        </div>
        <div class="box-body">
            <p>Nº de sala:</p>
            <input type="text" id="numero" name="numero"/>
            <p>Nº de filas:</p>
            <input type="text" id="filas" name="filas"/>
            <p>Nº de butacas por fila:</p>
            <input type="text" id="butacas" name="butacas"/>
            <input type="button" value="Crear"/>
        </div>
    </div>
@stop