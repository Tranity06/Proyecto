@extends('admin.home')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/theme.blue.css') }}" rel="stylesheet">
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

@section('js')
    <script src={{ asset('js/jquery-3.3.1.js') }}></script>
    <script src={{ asset('js/jquery.tablesorter.js') }}></script>
    <script src={{ asset('js/jquery.tablesorter.widgets-filter-formatter.min.js') }}></script>
    <script>
        $(document).ready(function(){
            $(function() {
                $(".table").tablesorter({
                    theme: 'blue',
                    widgets: ['zebra']
                });
            });

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $('.table').on('click', '.borrar', function(){
                var $boton = $(this);
                var $id= $boton.next().val();
                var $nombreAdmin = $boton.closest('tr').children('td').eq(1).text();
                if (confirm("¿Seguro que quieres eliminar al administrador"+$nombreAdmin+"?")){
                    $.ajax({
                        url: '/admin/borrar',
                        type: 'POST',
                        data: 'id='+$id,
                        statusCode:{
                            204: function (){
                                $boton.closest('tr')
                                .children('td')
                                .animate({ 
                                    padding: 0
                                })
                                .wrapInner('<div/>')
                                .children().slideUp(function () {
                                    $(this).closest('tr').remove();
                                });
                            },
                            403: function (){
                                //console.log("Error");
                            }
                        },
                        async: true,
                    });
                }
            });

            $('.table').on('click','.mostrarForm', function(){
                if ($(this).closest('tr').next().attr('class') == "filaAnadida" ){
                    $('.filaAnadida').each(function(){
                        $(this).children().first().children().slideUp(function () {
                            $(this).closest('tr').remove();
                        });
                    })

                } else {
                    $filaFormulario = $('.formDiv').last().clone();
                    $('.filaAnadida').each(function(){
                        $(this).children().first().children().slideUp(function () {
                            $(this).closest('tr').remove();
                        });
                    })
                    $(this).closest('tr').after('<tr class="filaAnadida"><td colspan="5"></td></tr>').next().children().first().append($filaFormulario);
                    $filaFormulario.slideDown();
                    $(this).closest('tr').next().children().find('#nombre').focus();
                }
            });

            $('.table').on('click', '.cambiar', function(e){
                e.preventDefault();
                var $input = $(this).parent().prev().children().first();
                var $texto = $input.val().trim();

                $input.removeClass('errores');
                $input.removeClass('ok');
                
                if ( $texto != '') {
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

            // Comprueba que las dos contraseñas introducidas son iguales.
            // Si no lo son muestra un error
            $('.table').on('click','.cambiar-pw', function(e){
                e.preventDefault();
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

            $('.table').on('click', '.guardar', function(e){
                e.preventDefault();
                $('#errguardar').text();
                if ( $('#errorpw').text()=='' && $('#errornombre').text()=='' && $('#erroremail').text()=='' ){
                    $formulario = $(this).parents('form').first();
                    $id = $(this).closest('tr').prev().find('input').first().val();
                    $formulario.find('#id').val($id);
                    $formulario.submit();
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
        <li class="active">Lista de usuarios</li>
    </ol>
@endsection

@section('content')
    @if( isset($errors) && sizeof($errors)>0 )<p>{{$errors}}
        <div class="callout callout-danger">El formato del valor introducido no es correcto, no se han guardado los cambios.</div>
    @endif
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Administradores registrados</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover tablesorter">
                <thead>
                    <tr>
                        @if( isset($sumerAdmin)  )
                            <th>ID</th>
                        @endif
                        <th>Nombre</th>
                        <th>Email</th>
                        @if( isset($sumerAdmin) )
                            <td><b>Modificar</b></td>
                            <td><b>Borrar</b></td>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($administradores as $administrador)
                        <div class="fila">
                            <tr>
                                @if( isset($sumerAdmin) )
                                    <td> {{ $administrador->id}} </td>
                                @endif
                                <td> {{ $administrador->name}} </td>
                                <td> {{ $administrador->email}} </td>
                                @if( isset($sumerAdmin) )
                                    @unless( $administrador->id == 1)
                                        <td>
                                            <button class="mostrarForm"><i class="glyphicon glyphicon-pencil"></i></button>
                                        </td>
                                        <td>
                                            <button class="borrar"><i class="fa fa-fw fa-trash-o"></i></button>
                                            <input type="hidden" name="id" value="{{ $administrador->id }}"/>
                                        </td>
                                    @else
                                        <td></td>
                                        <td></td>
                                    @endunless
                                @endif
                            </tr>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="formDiv" hidden>
        <form class="form" action="{{ route('admin.modificarPerfil') }}" method="post">
            <input type="hidden" name="token" value="1"/>
            <input type="hidden" name="id" id="id"/>
                <div>
                    <p>Nombre:</p>
                    <div class="formularios">
                        <div>
                            <div class="col-xs-4">
                                <input class="form-control input-sm" type="text" name="name"/>
                                <div class="callout callout-danger" id="errornombre" hidden></div>
                            </div>
                            <div>
                                <button class="btn btn-primary cambiar">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <p>Email:</p>
                    <div class="formularios">
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
                    <p>Contraseña:</p>
                    <div class="formularios">
                        <div>
                            <div class="col-xs-4">
                                <input id="pw1" class="form-control input-sm" type="password" name="password" />
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
            {{ csrf_field() }}
        </form>
    </div>
@stop