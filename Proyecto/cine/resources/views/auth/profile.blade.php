@extends('templates.default')

@section('estilos')
    <link href="{{ asset('css/utilidades.css') }}" media="all" rel="stylesheet" type="text/css"/>
@stop

@section('content')
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-10-tablet is-offset-2-tablet">
                    <img src="/uploads/avatars/{{ $user->avatar }}"
                         style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
                    <h2>{{ $user->nombre }} Perfil</h2>
                    <form enctype="multipart/form-data" action="{{ route('auth.profile') }}" method="POST">
                        <label>Cambiar avatar</label>
                        <input type="file" name="avatar">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="button" value="Guardar">
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop
