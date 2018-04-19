@extends('admin.home')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

@section('admin', $admin )

@section('migas')
    <ol class="breadcrumb">
        <li><a href="\admin"></i> Home</a></li>
        <li class="active">Crear nuevo usuario</li>
    </ol>
@endsection

@section('content')
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title">Crear nuevo usuario</h3>
        </div>
        <div class="box-body">
            <form name="infoform" action="/admin/crearadministrador" method="POST">
                {{ csrf_field() }}
                <div>
                    <p>Nombre:</p>
                    <div class="formularios">
                        <div>
                            <div class="col-xs-4">
                                <input class="form-control input-sm" type="text" name="nombre"/>
                                <div class="callout callout-danger" id="errornombre" hidden></div>
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
                        </div>
                    </div>
                </div>
                <button class="guardar sub btn btn-primary">Guardar cambios</button>
                <span id="errguardar"></span>
            </form>
        </div>
    </div>
@stop