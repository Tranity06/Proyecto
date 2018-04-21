@extends('admin.home')

@section('js')
    <script src={{ asset('js/jquery-3.3.1.js') }}></script>
    <script>
        $(document).ready(function(){

            $('#buscar').on('click', function(){
                var $titulo = $('#titulo').val().trim();

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "https://api.themoviedb.org/3/search/movie?api_key=0e46a63ca778de097560700378c1c185&query="+$titulo,
                    "method": "GET",
                    "headers": {},
                    "data": "{}"
                }

                $.ajax(settings).done(function (response) {
                    console.log(response);
                    if ( response['total_results'] > 20 ){
                        $('#resultado').text("Hay demasiados resultados con ese nombre. Especifica un poco mas.")
                    } else {
                        resultados = response['results'];
                        var $formulario = $('<form action"#" method="POST"></form>')
                        var $lista = $('<div class="form-group"></div>');
                        for ( var i=0 ; i<resultados.length ; i++ ){
                            var idtmdb = resultados[i]['id'];
                            var titulo = resultados[i]['title'];

                            var $label = $('<label></label>');
                            var $input = $('<input type="radio" name="idtmdb" class="minimal" value="'+idtmdb+'"/>');
                            $label.append($input);
                            $label.append(titulo);
                            $lista.append($label);
                        }
                        $formulario.append($lista);
                        $('#resultado').append($formulario);
                    }
                });
            });
        });
    </script>
@stop

@section('admin', $admin )

@section('migas')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"></i> Home</a></li>
        <li class="active">Registrar nueva película</li>
    </ol>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Registrar nueva película</h3>
        </div>
        <div class="box-body">
            <p>Peli nueva</p>
            <input type="text" id="titulo"/>
            <input type="button" id="buscar" value="Buscar"/>
            <div id="resultado">
            </div>
        </div>
    </div>
@stop