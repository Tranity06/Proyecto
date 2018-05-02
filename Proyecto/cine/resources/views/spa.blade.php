@extends('templates.default')

@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')
    <div id="app">
        <app></app>
    </div>
@stop

@section('javascript')
    <script src="{{ mix('js/app.js') }}"></script>
@stop