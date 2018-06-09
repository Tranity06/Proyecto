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

        .ok {
            border-color: green;
        }
    </style>
@stop

@section('admin', $admin )

@section('js')
    <script src={{ asset('js/jquery-3.3.1.js') }}></script>
    <script>
        $(document).ready(function(){
            $('input').eq(1).focus();

            $('.comprobar').blur(function(){
                $input = $(this);
                $input.removeClass('errores').removeClass('ok');
                $texto = $input.val().trim();
                if ( $texto != '') {
                    $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                    $.ajax({
                        url: '/admin/comprobar',
                        type: 'POST',
                        data: 'valor='+$texto,
                        statusCode:{
                            204: function (){
                                $input.addClass('errores');
                                $input.next().text("El valor introducido ya existe.");
                                $input.next().slideDown("slow");
                            },
                            201: function (){
                                $input.addClass('ok');
                                $input.next().slideUp("slow");
                                $input.next().text('');
                            }
                        },
                        async: true,
                    });
                }
            });

            $(".comprobar-pw").blur(function(){
                var $pw1 = $('#pw1');
                var $pw2 = $('#pw2');

                $pw2.removeClass('errores');
                $pw1.removeClass('ok');
                $pw2.removeClass('ok');
                
                if ( $pw1.val() == $pw2.val() ){
                    $pw1.addClass('ok');
                    $pw2.addClass('ok');
                    $('#errorpw').text('');
                    $('#errorpw').slideUp("slow");
                } else {
                    $pw2.addClass('errores');
                    $('#errorpw').text('Las contraseñas deben coincidir.');
                    $('#errorpw').slideDown("slow");
                }
            });

            $('.guardar').on('click', function(e){
                e.preventDefault();
                $('#errguardar').text();
                if ( $('#errorpw').text()=='' && $('#errornombre').text()=='' && $('#erroremail').text()=='' ){
                    if ( $('#nombre').val().trim()=='' ){
                        $('#nombre').focus();
                    } else if ( $('#email').val().trim()=='' ) {
                        $('#email').focus();
                    } else if ( $('#pw1').val().trim()=='' ) {
                        $('#pw1').focus();
                    } else {
                        infoform.submit();
                    }
                    $('#errguardar').text('Debes rellenar todos los campos.');
                } else {
                    $('#errguardar').text('Comprueba que todos los campos son correctos.');
                }
            });

        });
    </script>
@stop

@section('migas')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"></i> Home</a></li>
        <li class="active">Crear nuevo usuario</li>
    </ol>
@endsection

@section('content')
    @if( isset($errors) && sizeof($errors)>0 )
    <p>{{$errors}}</p>
        <div class="callout callout-danger">Ha ocurrido un error durante la validación de los datos, no se ha registrado un nuevo administrador.</div>
    @endif
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Crear nuevo usuario</h3>
        </div>
        <div class="box-body">
            <form name="infoform" action="{{ route('admin.crearAdmin.post') }}" method="POST">
                <div>
                    <p>Nombre:</p>
                    <div class="formularios">
                        <div>
                            <div class="col-xs-4">
                                <input class="form-control input-sm comprobar" type="text" id="nombre" name="name"/>
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
                                <input class="form-control input-sm comprobar" type="text" id="email" name="email" />
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
                                <input id="pw1" class="form-control input-sm" type="password" name="password" />
                                <input id="pw2" class="form-control input-sm comprobar-pw" type="password"/>
                                <div class="callout callout-danger" id="errorpw" hidden></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
                <button class="guardar sub btn btn-primary">Guardar</button>
                <span id="errguardar"></span>
            </form>
        </div>
    </div>
@stop