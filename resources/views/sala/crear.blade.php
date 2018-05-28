@extends('admin.home')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="{{ asset('css/theme.blue.css') }}" rel="stylesheet">
    <style>
        label {
            margin-top: 1em;
        }
        input {
            margin-bottom: .2em;
        }
        p {
            margin-bottom: 0em;
        }
    </style>
@stop

@section('js')
    <script src={{ asset('js/jquery-3.3.1.js') }}></script>
    <script>
        $(document).ready(function(){
            $('.crear').on('click', function(){
                var numero = $('#numero').val();
                var filas = $('#filas').val();
                var butacas = $('#butacas').val();
                var $callout = $('.callout').first();
                var $boton = $(this)
                $boton.attr('disabled', 'disabled');
                $callout.slideUp();
                $callout.text('');
                $callout.removeClass('callout-success');
                $callout.removeClass('callout-danger');

                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
                $.ajax({
                    url: '/sala',
                    type: 'POST',
                    data: 'numero='+numero+'&filas='+filas+'&butacas='+butacas,
                    statusCode:{
                        201: function (e){
                            $callout.text("Sala creada.");
                            $callout.addClass('callout-success').slideDown();
                            $boton.removeAttr('disabled');
                        },
                        403: function(e) {
                            $callout.text(e.responseJSON);
                            $callout.addClass('callout-danger').slideDown();
                            $boton.removeAttr('disabled');
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
        <li class="active">Crear sala.</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Crear nueva sala.</h3>
        </div>
        <div class="box-body">
            <div class="callout" hidden>
            </div>
            
            <p><label for="numero">Nº de sala:</label></p>
            <input type="number" class="form-control input-sm" id="numero" name="numero"/>
            <p><label for="filas">Nº de filas:</label></p>
            <input type="number" class="form-control input-sm" id="filas" name="filas" value="8" disabled/>
            <p><label for="butacas">Nº de butacas por fila:</lable></p>
            <input type="number" class="form-control input-sm" id="butacas" name="butacas" value="8" disabled/>
            <p><input type="button" class="crear sub btn btn-primary" value="Crear"/></p>
        </div>
    </div>
@stop