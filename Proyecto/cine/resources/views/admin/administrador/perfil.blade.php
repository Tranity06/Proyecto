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

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){

            // Oculta los formularios abiertos y muestra el seleccionado
            $(".mostrarForm").on('click', function() {
                $(".formularios").slideUp();
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
                var $texto = ($input.val()).trim();

                $input.next().text('');
                $input.removeClass('errores');
                

                if ( $texto != '') {
                    $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                    $.ajax({
                        url: '/admin/comprobar',
                        type: 'POST',
                        data: 'valor='+$texto,
                        success: function(e){
                            if ( e === 'existe'){
                                $input.addClass('errores');
                                $input.next().text("El valor introducido ya existe.");
                            } else {
                                $cambio.text($texto);
                                $form.slideToggle("slow");
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

                $('#errorpw').text('');
                $pw2.removeClass('errores');
                
                if ( $pw1.val() == $pw2.val() ){
                    $(this).parent().parent().parent().prev().children().first().text('Contraseña modificada');
                    $(this).parent().parent().parent().slideToggle("slow");
                } else {
                    $pw2.addClass('errores');
                    $('#errorpw').text('Las contraseñas deben coincidir.');
                }
            });

            $('.guardar').on('click', function(e){
                e.preventDefault();
                $('#errguardar').text();
                if ( $('#errorpw').text()=='' && $('#errornombre').text()=='' && $('#erroremail').text()=='' ){
                    console.log("Todo ok");
                    infoform.submit();
                } else {
                    $('#errguardar').text('Comprueba que todos los campos son correctos.');
                }
            });
        });
    </script>
@stop

@section('migas')
    <ol class="breadcrumb">
        <li><a href="\admin"></i> Home</a></li>
        <li class="active">Perfil</li>
    </ol>
@endsection

@section('content')
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title">Datos de la cuenta</h3>
        </div>
        <div class="box-body">
            <form name="infoform" action="#" method="POST">
                <div>
                    <p>Nombre: <span>{{$datos->name}}</span> <span class="glyphicon glyphicon-pencil mostrarForm"></span></p>
                    <div class="formularios" hidden>
                        <div>
                            <div class="col-xs-4">
                                <input class="form-control input-sm" type="text" name="nombre"/>
                                <span id="errornombre"></span>
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
                                <span id="erroremail"></span>
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
                                <span id="errorpw"></span>
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