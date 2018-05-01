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
        });
    </script>
@stop

@section('admin', $admin )

@section('migas')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"></i> Home</a></li>
        <li class="active">Lista de películas</li>
    </ol>
@endsection

@section('content')
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title">Películas registrados</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover tablesorter">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Estreno</th>
                        <th>Duración</th>
                        <th>Sesiones activas</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peliculas as $pelicula)
                        <div class="fila">
                            <tr>
                                <td> {{ $pelicula->titulo}} </td>
                                <td> {{ $pelicula->estreno}} </td>
                                <td> {{ $pelicula->duracion}} </td>
                                <td> TODO </td>
                            <!--    <td>
                                    <button class="mostrarForm"><i class="glyphicon glyphicon-pencil"></i></button>
                                </td> -->
                                <td>
                                    <button class="borrar"><i class="fa fa-fw fa-trash-o"></i></button>
                                    <input type="hidden" name="id" value="{{ $pelicula->id }}"/>
                                </td>
                            </tr>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="formDiv" hidden>
        <form class="form" action="{{ route('admin.modificarPerfil') }}" method="post">
            <input type="hidden" name="token" value="1"/>
            <input type="hidden" name="id" id="id"/>
                <div>
                    <p>Nombre:</p>
                    <div class="formularios">
                        <div>
                            <div class="col-xs-4">
                                <input class="form-control input-sm" type="text" name="nombre"/>
                                <div class="callout callout-danger" id="errornombre" hidden></div>
                            </div>
                            <div>
                                <button class="btn btn-primary cambiar">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <p>Email:</p>
                    <div class="formularios">
                        <div>
                            <div class="col-xs-4">
                                <input class="form-control input-sm" type="text" name="email" />
                                <div class="callout callout-danger" id="erroremail" hidden></div>
                            </div>
                            <div>
                                <button class="btn btn-primary cambiar">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <p>Contraseña:</p>
                    <div class="formularios">
                        <div>
                            <div class="col-xs-4">
                                <input id="pw1" class="form-control input-sm" type="password" name="pw" />
                                <input id="pw2" class="form-control input-sm" type="password"/>
                                <div class="callout callout-danger" id="errorpw" hidden></div>
                            </div>
                            <div>
                                <button class="btn btn-primary cambiar-pw">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="guardar sub btn btn-primary">Guardar cambios</button>
                <span id="errguardar"></span>
            {{ csrf_field() }}
        </form>
    </div>
@stop