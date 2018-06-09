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
        <li><a href="{{ route('admin.dashboard') }}"></i> Home</a></li>
        <li class="active">Crear nuevo usuario</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Usuario creado</h3>
        </div>
        <div class="box-body">
            <div>
                <p>Nombre: {{$nuevo_admin->name}}</p>
            </div>
            <div>
                <p>Email: {{$nuevo_admin->email}} </p>
            </div>
            <a href="{{ route('admin.crearAdmin.get') }}"><button class="btn btn-primary">Crear otro usuario</button></a>
            <a href="{{ route('admin.listarAdmin') }}"><button class="btn btn-primary">Ver usuarios registrados</button></a>
        </div>
    </div>
@stop