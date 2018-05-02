@extends('templates.default')

@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')
    <div class="container">
        <div id="app">
            <entrada-component></entrada-component>
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{ mix('js/app.js') }}"></script>
@stop