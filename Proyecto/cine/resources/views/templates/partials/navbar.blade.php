<nav class="navbar">
          <div class="container">
            <div class="navbar-brand">
              <a class="navbar-item">
                <img src="https://bulma.io/images/bulma-logo.png" alt="Logo">
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
                  <a class="button is-primary" href="{{ route('auth.signup') }}">
                    <span class="icon">
                      <i class="fab fa-github"></i>
                    </span>
                    <span>Entrar</span>
                  </a>
                </span>
              </div>
            </div>
          </div>
        </nav>