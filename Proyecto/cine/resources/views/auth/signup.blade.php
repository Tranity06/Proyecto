@extends('templates.default')

@section('content')
<section class="section">
        <div class="container">
            <div class="columns">
                <div class="column">
                    <h1 class="is-size-3">No tienes Cuenta?</h1>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus officia nostrum dignissimos obcaecati iusto! Ex quasi alias id, error nesciunt accusantium eum ipsum ut reprehenderit, voluptatibus exercitationem dolorem doloremque aperiam.
                </div>

                <div class="column">
                    <form method="post" action="{{ route('auth.signup') }}">
                      <div class="field">
                        <label class="label">Introduce tu nombre</label>
                        <div class="control has-icons-left has-icons-right">
                          <input class="input{{ $errors->has('nombre') ? ' is-danger' : '' }}" type="text" placeholder="Escribe tu nombre" name="nombre"
                                 value="{{ Request::old('nombre') ?:'' }}">
                          <span class="icon is-small is-left">
                            <i class="fas fa-user"></i>
                          </span>
                        </div>
                        @if($errors->has('nombre'))
                          <p class="help is-danger">{{ $errors ->first('nombre') }}</p>
                        @endif
                      </div>
                      
                      <div class="field">
                        <label class="label">Email</label>
                        <div class="control has-icons-left has-icons-right">
                          <input class="input{{ $errors->has('email') ? ' is-danger' : '' }}" type="email" placeholder="Escribe tu email" name="email"
                                 value="{{ Request::old('email') ?:'' }}">
                          <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                          </span>
                        </div>
                        @if($errors->has('email'))
                          <p class="help is-danger">{{ $errors ->first('email') }}</p>
                        @endif
                      </div>

                      <div class="field">
                        <label class="label">Teléfono</label>
                        <div class="control has-icons-left has-icons-right">
                          <input class="input{{ $errors->has('tlf') ? ' is-danger' : '' }}" type="text" placeholder="Escribe tu teléfono" name="tlf"
                                 value="{{ Request::old('tlf') ?:'' }}">
                          <span class="icon is-small is-left">
                            <i class="fas fa-phone"></i>
                          </span>
                        </div>
                        @if($errors->has('tlf'))
                          <p class="help is-danger">{{ $errors ->first('tlf') }}</p>
                        @endif
                      </div>
                      
                      <div class="field">
                        <label class="label">Contraseña</label>
                        <div class="control has-icons-left">
                          <input class="input{{ $errors->has('clave') ? ' is-danger' : '' }}" type="password" placeholder="Password" name="clave">
                          <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                          </span>
                        </div>
                        @if($errors->has('clave'))
                          <p class="help is-danger">{{ $errors ->first('clave') }}</p>
                        @endif
                      </div>

                      <div class="field">
                          <label class="label">Repite la contraseña</label>
                          <div class="control has-icons-left">
                            <input class="input{{ $errors->has('clave') ? ' is-danger' : '' }}" type="password" placeholder="Password" name="clave_confirmation">
                            <span class="icon is-small is-left">
                              <i class="fas fa-lock"></i>
                            </span>
                          </div>
                      </div>
                      
                      <div class="field">
                        <div class="control">
                          <label class="checkbox">
                            <input type="checkbox">
                            I agree to the <a href="#">terms and conditions</a>
                          </label>
                        </div>
                      </div>
                      
                      <div class="control">
                          <button class="button is-primary">Submit</button>
                      </div>
                      {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop