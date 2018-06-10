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
        option {
            font-size: 1.5em;
        }
    </style>
@stop

@section('js')
    <script src={{ asset('js/jquery-3.3.1.js') }}></script>
    <script>
        $(document).ready(function(){
            $('.crear').on('click', function(){
                var nombre = $('#nombre').val();
                var precio = $('#precio').val();
                var categoria_id = $('#categoria_id').val();
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
                    url: '/productos/crear',
                    type: 'POST',
                    data: 'nombre='+nombre+'&precio='+precio+'&categoria_id='+categoria_id,
                    statusCode:{
                        201: function (e){
                            $callout.text("Producto creada.");
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
        <li class="active">Crear producto nuevo.</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Crear un nuevo producto</h3>
        </div>
        <div class="box-body">
            <div class="callout" hidden>
            </div>
            
            <p><label for="nombre">Nombre del producto</label></p>
            <input type="text" class="form-control input-sm" id="nombre" name="nombre"/>
            <p><label for="precio">Precio del producto:</label></p>
            <input type="number" class="form-control input-sm" id="precio" name="precio"/>
            <p><label for="categoria_id">Categoría a la que pertenece:</lable></p>
            <select type="text" class="form-control input-sm" id="categoria_id" name="categoria_id">
                @foreach ($categorias as $categoria)
                    <option value="$categoria->id">{{$categoria->nombre}}</option>
                @endforeach
            </select>
            <p><input type="button" class="crear sub btn btn-primary" value="Crear"/></p>
        </div>
    </div>
@stop