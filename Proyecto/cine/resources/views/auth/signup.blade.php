@extends('templates.default')

@section('content')
<section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-narrow">
                <form method="post" action="#">
                      <div class="field">
                        <label class="label">Introduce tu email</label>
                        <div class="control has-icons-left has-icons-right">
                          <input class="input is-danger" type="text" placeholder="Text input" value="bulma">
                          <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                          </span>
                          <span class="icon is-small is-right">
                            <i class="fas fa-exclamation-triangle"></i>
                          </span>
                        </div>
                        <p class="help is-danger">This email is invalid</p>
                      </div>
                      <!-- Username -->
                      
                      <div class="field">
                        <label class="label">Contraseña</label>
                        <div class="control has-icons-left has-icons-right">
                          <input class="input is-danger" type="email" placeholder="Email input" value="hello@">
                          <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                          </span>
                          <span class="icon is-small is-right">
                            <i class="fas fa-exclamation-triangle"></i>
                          </span>
                        </div>
                        <p class="help is-danger">This email is invalid</p>
                      </div>
                      <!-- Password -->
                      
                      <div class="field">
                        <div class="control">
                          <label class="checkbox">
                            <input type="checkbox">
                                Recordar usuario
                          </label>
                        </div>
                      </div>
                      
                      <div class="field is-grouped">
                        <div class="control">
                          <button class="button is-link">Submit</button>
                        </div>
                      </div>
                      </form>
                </div>
                <div class="column">
                    <h1 class="is-size-3">No tienes Cuenta?</h1>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus officia nostrum dignissimos obcaecati iusto! Ex quasi alias id, error nesciunt accusantium eum ipsum ut reprehenderit, voluptatibus exercitationem dolorem doloremque aperiam.
                </div>

                <div class="column">
                    <form method="post" action="#">
                      <div class="field">
                        <label class="label">Introduce tu nombre</label>
                        <div class="control has-icons-left has-icons-right">
                          <input class="input is-success" type="text" placeholder="Text input" value="bulma">
                          <span class="icon is-small is-left">
                            <i class="fas fa-user"></i>
                          </span>
                          <span class="icon is-small is-right">
                            <i class="fas fa-check"></i>
                          </span>
                        </div>
                        <p class="help is-success">This username is available</p>
                      </div>
                      
                      <div class="field">
                        <label class="label">Email</label>
                        <div class="control has-icons-left has-icons-right">
                          <input class="input is-danger" type="email" placeholder="Email input" value="hello@">
                          <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                          </span>
                          <span class="icon is-small is-right">
                            <i class="fas fa-exclamation-triangle"></i>
                          </span>
                        </div>
                        <p class="help is-danger">This email is invalid</p>
                      </div>

                      <div class="field">
                        <label class="label">Teléfono</label>
                        <div class="control has-icons-left has-icons-right">
                          <input class="input" type="text" placeholder="Email input" value="hello@">
                          <span class="icon is-small is-left">
                            <i class="fas fa-phone"></i>
                          </span>
                        </div>
                      </div>
                      
                      <div class="field">
                        <label class="label">Contraseña</label>
                        <div class="control has-icons-left">
                          <input class="input" type="password" placeholder="Password">
                          <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                          </span>
                        </div>
                      </div>

                      <div class="field">
                          <label class="label">Repite la contraseña</label>
                          <div class="control has-icons-left">
                            <input class="input" type="password" placeholder="Password">
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
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop