@extends('templates.default')

@section('content')
<section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-narrow">
                <form method="post" action="{{ route('auth.login') }}">
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
                          <button class="button is-link">Submit</button>
                        </div>
                      </div>
                      {{ csrf_field() }}
                      </form>
                </div>
                <div class="column">
                    <h1 class="is-size-3">No tienes Cuenta?</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus officia nostrum dignissimos obcaecati iusto! Ex quasi alias id, error nesciunt accusantium eum ipsum ut reprehenderit,</p>
                    <a href="{{ route('auth.signup') }}">Registrarse</a>
                </div>
            </div>
        </div>
    </section>
@stop
