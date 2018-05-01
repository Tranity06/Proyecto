@extends('templates.default')

@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')
    <div id="app">
        <entrada-component></entrada-component>
    </div>
@stop

@section('javascript')
    <script src="js/app.js"></script>
@stop