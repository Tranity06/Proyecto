@extends('admin.home')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="{{ asset('css/theme.blue.css') }}" rel="stylesheet">
    <style>
        
    </style>
@stop

@section('js')
    <script src={{ asset('js/jquery-3.3.1.js') }}></script>
    <script src={{ asset('js/jquery.tablesorter.js') }}></script>
    <script src={{ asset('js/jquery.tablesorter.widgets-filter-formatter.min.js') }}></script>
    <script>
        $(document).ready(function(){
            
        });
    </script>
@stop

@section('admin', $admin )

@section('migas')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"></i> Home</a></li>
        <li><a href="{{ route('plantillas.mostrar') }}"></i> Lista de plantillas</a></li>
        <li class="active">Detalle plantilla {{$plantilla->nombre}}</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Detalle plantilla {{$plantilla->nombre}}</h3>
        </div>
        <div class="box-body">
        </div>
    </div>
@stop