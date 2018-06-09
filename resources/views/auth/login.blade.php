@extends('templates.default')

@section('estilos')
    <link href="{{ asset('css/utilidades.css') }}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')
<section class="section" style="height: 100vh">
        <div class="container">
            <div class="columns">
                <div class="column is-narrow">
                <form method="post" action="{{ route('auth.login') }}" class="box-form">
                    <h1 class="title has-text-weight-bold"><span>INICIAR SESIÓN</span></h1>
                      <div class="field">
                        <label class="label">Introduce tu email</label>
                        <div class="control has-icons-left has-icons-right">
                          <input class="input{{ $errors->has('email') ? ' is-danger' : '' }}" type="text" placeholder="Escribe tu email" name="email"
                                 value="{{ Request::old('email') ?:'' }}">
                          <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                          </span>
                          @if($errors->has('email'))
                          <p class="help is-danger">El email no existe</p>
                          @endif
                        </div>
                      </div>
                      <!-- Username -->
                      
                      <div class="field">
                        <label class="label">Contraseña</label>
                        <div class="control has-icons-left has-icons-right">
                          <input class="input" type="password" placeholder="Escribe tu contraseña" name="password">
                          <span class="icon is-small is-left">
                              <i class="fas fa-lock"></i>
                            </span>
                        </div>
                      </div>
                      <!-- Password -->
                      
                      <div class="field">
                        <div class="control">
                          <label class="checkbox">
                            <input type="checkbox" name="remember">
                                Recordar usuario
                          </label>
                        </div>
                      </div>
                      
                      <div class="field is-grouped">
                        <div class="control">
                          <button class="button is-link">Entrar</button>
                        </div>
                      </div>
                    <a href="recuperar">¿Has olvidado tu contraseña?</a>
                    {{ csrf_field() }}
                      </form>
                </div>
                <div class="column is-half">
                    <h1 class="title has-text-weight-bold">CREAR UNA CUENTA</h1>
                    <p>Crea tu cuenta de Palomitas time:</p>
                    <p><i class="fas fa-check" style="color: green;"></i> Acumula puntos y consigue promociones, Si veis esto modificarlo ;D no estoy inspirado ahora</p>
                    <p><i class="fas fa-check" style="color: green;"></i> Escribir reseñas y puntuar peliculas, Si veis esto modificarlo ;D no estoy inspirado ahora</p>
                    <p><i class="fas fa-check" style="color: green;"></i> Recibir ofertas, Si veis esto modificarlo ;D no estoy inspirado ahora </p>
                    <p><i class="fas fa-check" style="color: green;"></i> Realiza tu pedido más rápido guardando tus datos de envío y tu forma de pago, Si veis esto modificarlo ;D no estoy inspirado ahora </p>
                    <p><i class="fas fa-check" style="color: green;"></i> Accede a tu historial de pedidos, Si veis esto modificarlo ;D no estoy inspirado ahora </p>
                    <p><i class="fas fa-check" style="color: green;"></i> Crea y guarda tus menus preferidos, menus lleva tilde verdad?. Si veis esto modificarlo ;D no estoy inspirado ahora ;D no estoy inspirado ahora </p>
                    <a href="{{ route('auth.signup') }}" class="button is-info is-medium">Registrarse</a>
                </div>
            </div>
        </div>
    </section>
@stop
