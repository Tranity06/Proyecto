@extends('adminlte::page')

@section('title', 'PalomitasT')

@section('content_header')
    <h1><small>Conectado como</small> {{$admin}}</h1>
    
    @section('migas')
        <ol class="breadcrumb">
            <li class="active">Home</li>
        </ol>
    @show
    
@stop

@section('content')
    <p>Panel de administración.</p>
    <p>Desde aquí puedes gestionar todos los productos y servicios que se pueden ver en la aplicación web.</p>
@stop