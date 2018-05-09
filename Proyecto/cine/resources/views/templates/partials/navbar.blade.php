<nav class="navbar is-fixed-top">
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ route('home') }}">
                <div class="logo-container">
                    <img src="{{ asset('48px.png') }}" alt="Logo">
                    <span>Palomitas time</span>
                </div>
            </a>
            <span class="navbar-burger burger" data-target="navbarMenuHeroA">
                <span></span>
                <span></span>
                <span></span>
              </span>
        </div>
        <div id="navbarMenuHeroA" class="navbar-menu">
            <div class="navbar-end">
                <a class="navbar-item is-active">
                    Películas
                </a>
                <a class="navbar-item">
                    Restaurante
                </a>
                <a class="navbar-item">
                    Acerca de
                </a>
                <span class="navbar-item navbar-item-end">
                  @if(Auth::check())
                        <div class="user-login">
                      <i class="fas fa-shopping-cart fa-sm carta"></i>
                      <div class="dropdown is-hoverable">
                          <div class="dropdown-trigger">
                              <img class="avatar"
                                   src="/uploads/avatars/{{ Auth::user()->avatar }}"
                                   aria-haspopup="true" aria-controls="dropdown-menu">
                          </div>
                          <div class="dropdown-menu" id="dropdown-menu" role="menu">
                            <div class="dropdown-content">
                              <a href="{{ url('/profile') }}" class="dropdown-item">Perfil</a>
                              <a class="dropdown-item">No se que mas</a>
                              <hr class="dropdown-divider">
                              <a href="{{ route('auth.logout') }}" class="dropdown-item">
                                 Salir
                              </a>
                            </div>
                          </div>
                        </div>
                  </div>
                    @else
                        <a class="button is-primary" href="{{ route('auth.login') }}">
                    <span>Entrar</span>
                        </a>
                        <a href="http://www.facebook.com" class="centeredIcon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif
                </span>
            </div>
        </div>
    </div>
</nav>