@extends('admin.home')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="{{ asset('css/theme.blue.css') }}" rel="stylesheet">
    <style>
        p {
            margin-bottom: 0em;
            margin-top: 1em;
        }
        table {
            margin-top: .5em;
        }
    </style>
@stop

@section('js')
    <script src={{ asset('js/jquery-3.3.1.js') }}></script>
    <script src={{ asset('js/jquery.tablesorter.js') }}></script>
    <script src={{ asset('js/jquery.tablesorter.widgets-filter-formatter.min.js') }}></script>
    <script src={{ asset('js/select2.full.min.js') }}></script>
    <script>
        $(document).ready(function(){
            $('.select2').select2();
            $('#form-bloquear').hide()

            $(function() {
                $(".table").tablesorter({
                    theme: 'blue',
                    widgets: ['zebra']
                });
            });

            $('.mostrar').on('click', function(){
                var $tabla = $(this).parent().find('.slide').first();
                $tabla.slideToggle();

                var $texto = $(this).val();
                if ($texto == 'Mostrar'){
                    $(this).val('Ocultar');
                } else {
                    $(this).val('Mostrar');
                }
            });

            $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });

            $('.table').on('click', '.borrar', function(){console.log("Borras?");
                var $boton = $(this);
                var $idButacaBloqueada= $boton.next().val()
                var $fila = $boton.closest('tr').children('td').eq(0).text().trim();
                var $butaca = $boton.closest('tr').children('td').eq(1).text().trim();
                var butaca = 'F'+$fila+'-B'+$butaca;

                var $callout = $('.callout-butaca').first();
                $callout.slideUp();
                $callout.text('');
                $callout.removeClass('callout-danger');

                if (confirm("¿Seguro que quieres desbloquear la butaca "+butaca+"?")){
                    $.ajax({
                        url: '/butaca/desbloquear',
                        type: 'POST',
                        data: 'idButaca='+$idButacaBloqueada,
                        statusCode:{
                            201: function (){ console.log("Borrando");
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
                            403: function (e){console.log(e.responseJSON);
                                $callout.text(e.responseJSON);
                                $callout.addClass('callout-danger').slideDown();
                            }
                        },
                        async: true,
                    });
                }
            });

            $('.mostrar-bloquear').on('click', function(){
                $('#form-bloquear').slideToggle();
            });

            $('#completa').on('click', function(){
                if ( $('#completa').is(':checked') ) {
                    $('#butacas').attr('disabled', 'disabled');
                } else {
                    $('#butacas').removeAttr('disabled'); 
                }
            });

            $('.bloquear').on('click', function(){
                $sala = 'idSala='+$('#idSala').val();
                $fila = 'fila='+$('#fila').val();
                if ( $('#completa').is(':checked')){
                    $butacas = 'all=true';
                } else {
                    $butacas = 'butacas='+$('#butacas').val();console.log($butacas);
                }
                datos = $sala+'&'+$fila+'&'+$butacas; 
                $.ajax({
                    url: '/butaca/bloquear',
                    type: 'POST',
                    data: datos,
                    statusCode:{
                        201: function (e){
                            console.log(e.responseJSON);
                        },
                        403: function (e){console.log(e.responseJSON);
                            /* $callout.text(e.responseJSON);
                            $callout.addClass('callout-danger').slideDown(); */
                        }
                    },
                    async: true,
                });
                
            });
        });
    </script>
@stop

@section('admin', $admin )

@section('migas')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"></i> Home</a></li>
        <li><a href="{{ route('salas.mostrar') }}"></i> Lista de salas</a></li>
        <li class="active">Detalle sala {{$sala->numero}}</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Detalle sala {{$sala->numero}}</h3>
        </div>
        <div class="box-body">
            <p><label>Nº Sala:</label> <span>{{$sala->numero}}</span></p>
            <p><label>Aforo:</label> <span> {{$sala->aforo}}</span></p>
            <p><label>Butacas bloqueadas:</label> <span>{{ sizeof($butacas_bloqueadas) }}</span>
                <button class="mostrar-bloquear"><i class="glyphicon glyphicon-pencil"></i></button></p>
            <div id="form-bloquear" class="box-body">
                <input type="hidden" id="idSala" name="idSala" value="{{$sala->id}}"
                <div class="form-group"><label for="fila">Fila:</label>
                    <select name="fila" id="fila">
                        @for ( $fila=1 ; $fila<= $sala->filas ; $fila++ )
                            <option value="{{$fila}}">{{$fila}}</option>
                        @endfor
                    </select><br/>
                    <label>
                        <input type="checkbox" id="completa" name="completa" value="completa">
                        Toda la fila
                    </label>
                    <select name="butacas" id="butacas" class="form-control select2" multiple="multiple" data-placeholder="Selecciona butacas">
                        @for ( $butaca=1 ; $butaca<= $sala->butacas ; $butaca++ )
                            <option value="{{$butaca}}">{{$butaca}}</option>
                        @endfor
                    </select>
                    <input type="button" class="bloquear sub btn btn-primary" value="Bloquear"/>
                </div>
            </div>
            <div>
                <input type="button" class="mostrar sub btn btn-primary" value="Mostrar"/>
                <div class="slide" hidden>
                <div class="callout-butaca" hidden>
                </div>
                <table class="table table-bordered table-hover tablesorter">
                    <thead>
                        <tr>
                            <th>Fila</th>
                            <th>Butaca</th>
                            <th>Desbloquear</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($butacas_bloqueadas as $butaca)
                            <div class="fila">
                                <tr>
                                    <td> {{ $butaca->fila}} </td>
                                    <td> {{ $butaca->numero}} </td>
                                    <td>
                                        <button class="borrar"><i class="fa fa-fw fa-trash-o"></i></button>
                                        <input type="hidden" name="id" value="{{ $butaca->id }}"/>
                                    </td>
                                </tr>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <p><label>Sesiones:</label> <span>{{ sizeof($sesiones) }}</span></p>
            <div>
                <input type="button" class="mostrar sub btn btn-primary" value="Mostrar"/>
                <div class="slide" hidden>
                <table class="table table-bordered table-hover tablesorter">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sesiones as $sesion)
                            <div class="fila">
                                <tr>
                                    <td> {{ $sesion->fecha}} </td>
                                    <td> {{ $sesion->hora}} </td>
                                </tr>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
@stop