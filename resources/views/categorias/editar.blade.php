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
            $('.editar').on('click', function(){
                var idCategoria = $('#id').val();
                var nombre = $('#nombre').val();
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
                    url: '/categorias/'+idCategoria,
                    type: 'POST',
                    data: 'nombre='+nombre,
                    statusCode:{
                        200: function (e){
                            $callout.text("Categoría editada correctamente.");
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
        <li class="active">Editar categoría.</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Editando categoría {{$categoria->nombre}}</h3>
        </div>
        <div class="box-body">
            <div class="callout" hidden>
            </div>
            <p><label for="nombre">Nombre de la categoría:</label></p>
            <input type="text" class="form-control input-sm" id="nombre" name="nombre" value="{{$categoria->nombre}}"/>
            <input type="hidden" id="id" name="id" value="{{$categoria->id}}"/>
            <p><input type="button" class="editar sub btn btn-primary" value="Editar"/></p>
        </div>
    </div>
@stop