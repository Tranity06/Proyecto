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
            <h3 class="box-title">Acceso denegado</h3>
        </div>
        <div class="box-body">
            <div>
                <p>Sólo el administrador principal puede crear nuevas cuentas de administrador.</p>
            </div>
        </div>
    </div>
@stop