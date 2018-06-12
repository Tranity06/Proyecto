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
        #productos {
            height: 200px;
            margin-bottom: .3em;
        }
        select option {
            margin-bottom: .2em;
            font-size: 1.5em;
            border-top: 1px solid lightgrey;
        }
    </style>
@stop

@section('js')
    <script src={{ asset('js/jquery-3.3.1.js') }}></script>
    <script>
        $(document).ready(function(){
            $('.borrar').on('click', function(){
                var idMenu = $('#id').val();
                var productos = $('#productos').val();
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
                    url: '/productomenu/'+idMenu,
                    type: 'DELETE',
                    data: 'productos='+productos,
                    statusCode:{
                        204: function (e){
                            console.log(e);
                            $callout.text("Productos borrados.");
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
        <li><a href="{{ route('menus.mostrar') }}"></i> Menus</a></li>
        <li class="active">Borrar productos.</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Borrar productos</h3>
        </div>
        <div class="box-body">
            <div class="callout" hidden>
            </div>
            <p><label for="nombre">Productos:</label></p>
            <select multiple type="text" class="form-control input-sm" id="productos" name="productos[]">
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                @endforeach
            </select>
            <input type="hidden" id="id" name="id" value="{{ $menu->id }}"/>
            <p><input type="button" class="borrar sub btn btn-primary" value="Borrar"/></p>
        </div>
    </div>
@stop