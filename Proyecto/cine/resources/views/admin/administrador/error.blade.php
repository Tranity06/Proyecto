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
        <li class="active">Error</li>
    </ol>
@stop

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">{{$tipoError}}</h3>
        </div>
        <div class="box-body">
            <div>
                <p>{{$mensajeError}}</p>
            </div>
        </div>
    </div>
@stop