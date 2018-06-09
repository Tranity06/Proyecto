@extends('admin.home')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="{{ asset('css/theme.blue.css') }}" rel="stylesheet">
    <style>
        select {
            margin-bottom: .2em;
        }
        .anadir {
            margin-bottom: .5em;
        }
    </style>
@stop

@section('js')
    <script src={{ asset('js/jquery-3.3.1.js') }}></script>
    <script src={{ asset('js/jquery.tablesorter.js') }}></script>
    <script src={{ asset('js/jquery.tablesorter.widgets-filter-formatter.min.js') }}></script>
    <script>
        $(document).ready(function(){
            function anadirSlider(){
                if ($('tr').length > 3){
                    console.log($('tr').length);
                    $('#anadir').prop( "disabled", true );
                }
            }
            $(function() {
                $(".table").tablesorter({
                    theme: 'blue',
                    widgets: ['zebra']
                });
                anadirSlider();
            });

            $('.table').on('click', '.borrar', function(){
                var $boton = $(this);
                var $id= $boton.next().val();
                var $titulo = $(this).closest('tr').children().first().html();
               // if (confirm("¿Seguro que quieres eliminar esta película?")){
                    $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                    $.ajax({
                        url: '/slider/borrar',
                        type: 'POST',
                        data: 'id='+$id,
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
                                $('#anadir').prop( "disabled", false );
                                $('#anadir').append($('<option value="'+$id+'">'+$titulo+'</option>'));
                            } else {
                                console.log("Error");
                            }
                        },
                        async: true,
                    });
               // }
            });
        });
    </script>
@stop

@section('admin', $admin )

@section('migas')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"></i> Home</a></li>
        <li class="active">Slider</li>
    </ol>
@endsection

@section('content')
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title">Películas activas en el slider</h3>
        </div>
        <div class="box-body">
            <form action="/slider/anadir" method="POST">{{ csrf_field() }}
                <div class="form-group">
                    <label>Añadir película:</label>
                    <select class="form-control" id="anadir" name="anadir">
                        @foreach($peliculas as $pelicula)
                            @if($pelicula->slider == false )
                                <option value="{{$pelicula->id}}">{{$pelicula->titulo}}</option>
                            @endif
                        @endforeach
                    </select>
                    <input type="submit" class="anadir sub btn btn-primary" value="Añadir"/>
                </div>                
            </form>

            <table class="table table-bordered table-hover tablesorter">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peliculas as $pelicula)
                        @if($pelicula->slider == true )
                            <div class="fila">
                                <tr>
                                    <td> {{ $pelicula->titulo}} </td>
                                    <td>
                                        <button class="borrar"><i class="fa fa-fw fa-trash-o"></i></button>
                                        <input type="hidden" name="id" value="{{ $pelicula->id }}"/>
                                    </td>
                                </tr>
                            </div>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop