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
            color: green;
        }

        .no-ok {
            color: red;
        }
    </style>
@stop

@section('js')
    <script src={{ asset('js/jquery-3.3.1.js') }}></script>
    <script>
        $(document).ready(function(){

            // Oculta los formularios abiertos y muestra el seleccionado
            $(".mostrarForm").on('click', function() {
                $(".formularios").not($(this).parent().next()).slideUp();
                $(this).parent().next().slideToggle("slow");
                $(this).parent().next().children().first().children().first().children().first().focus();
            });

            // Si el dato introducido no existe en la bbdd muestra el nombre introducido y oculta el formulario.
            // Si existe devuelve el focus al input y lo marca en rojo.
            // La consulta se hace vía ajax.
            $(".cambiar").on('click', function(e){
                e.preventDefault();
                var $input = $(this).parent().prev().children().first();
                var $form = $(this).parent().parent().parent()
                var $cambio = $(this).parent().parent().parent().prev().children().first()
                var $texto = $input.val().trim();

                $input.removeClass('errores');
                $cambio.removeClass('ok');
                $cambio.removeClass('no-ok')
                
                if ( $texto != '') {
                    $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                    $.ajax({
                        url: '/admin/comprobar',
                        type: 'POST',
                        data: 'valor='+$texto+'&token=0',
                        statusCode:{
                            201: function (){
                                $cambio.text($texto);
                                $cambio.addClass('ok');
                                $form.slideToggle("slow");
                                $input.next().slideUp("slow");
                                $input.next().text('');
                            },
                            204: function (){
                                $input.addClass('errores');
                                $cambio.addClass('no-ok')
                                $input.next().text("El valor introducido ya existe.");
                                $input.next().slideDown("slow");
                            }
                        },
                        async: true,
                    });
                }                
                
            });

            // Comprueba que las dos contraseñas introducidas son iguales.
            // Si no lo son muestra un error
            $(".cambiar-pw").on('click', function(e){
                e.preventDefault();
                var $pw1 = $('#pw1');
                var $pw2 = $('#pw2');

                $pw2.removeClass('errores');
                
                if ( $pw1.val() == $pw2.val() ){
                    $(this).parent().parent().parent().prev().children().first().text('Contraseña modificada');
                    $(this).parent().parent().parent().slideToggle("slow");
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
                    infoform.submit();
                } else {
                    $('#errguardar').text('Comprueba que todos los campos son correctos.');
                }
            });
        });
    </script>
@stop

@section('admin', $admin )

@section('migas')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"></i> Home</a></li>
        <li class="active">Perfil</li>
    </ol>
@endsection

@section('content')
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title">Datos de la cuenta</h3>
        </div>
        <div class="box-body">

            @if ( isset($correcto) )
                <div class="callout callout-success">
                    <p>Tus datos se han modificado correctamente.</p>
                </div>
            @endif

            <form name="infoform" action="{{ route('admin.modificarPerfil') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="1"/>
                <div>
                    <p>Nombre: <span>{{$datos->name}}</span> <span class="glyphicon glyphicon-pencil mostrarForm"></span></p>
                    <div class="formularios" hidden>
                        <div>
                            <div class="col-xs-4">
                                <input class="form-control input-sm" type="text" name="nombre"/>
                                <div class="callout callout-danger" id="errornombre" hidden></div>
                            </div>
                            <div>
                                <button class="btn btn-primary cambiar">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <p>Email: <span>{{$datos->email}}</span> <span class="glyphicon glyphicon-pencil mostrarForm"></span></p>
                    <div class="formularios" hidden>
                        <div>
                            <div class="col-xs-4">
                                <input class="form-control input-sm" type="text" name="email" />
                                <div class="callout callout-danger" id="erroremail" hidden></div>
                            </div>
                            <div>
                                <button class="btn btn-primary cambiar">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <p>Contraseña: <span>**********</span> <span class="glyphicon glyphicon-pencil mostrarForm"></span></p>
                    <div class="formularios" hidden>
                        <div>
                            <div class="col-xs-4">
                                <input id="pw1" class="form-control input-sm" type="password" name="pw" />
                                <input id="pw2" class="form-control input-sm" type="password"/>
                                <div class="callout callout-danger" id="errorpw" hidden></div>
                            </div>
                            <div>
                                <button class="btn btn-primary cambiar-pw">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="guardar sub btn btn-primary">Guardar cambios</button>
                <span id="errguardar"></span>
            </form>
        </div>
    </div>
@stop