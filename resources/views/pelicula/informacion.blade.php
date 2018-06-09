@extends('templates.default')

@section('header')
    <link href="{{ asset('css/pelicula.css') }}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')
        <section class="hero is-primary is-medium">
              
                <!-- Hero content: will be in the middle -->
                <div class="hero-body">
                  <div class="container">
                      <div class="columns is-hidden-mobile">
                        <div class="column is-one-fifth-desktop is-hidden-touch">
                              <img src="https://www.dvdsreleasedates.com/posters/300/J/Jumanji-Welcome-to-the-Jungle-2017.jpg" alt="Poster-pelicula"
                                width="196px"
                                height="266px"
                                class="pelicula-poster"
                              >
                        </div>
                        <div class="column">
                            <div class="pelicula-header">
                                <h1 class="title">
                                  Jumanji
                                  <span class="tag is-light">PE-7</span>
                                </h1>
                                <h2 class="subtitle">
                                  Drama / Accion / Comedia 115min
                                </h2>
                                <h1 class="is-size-4">
                                    Sinopsis
                                </h1>
                                <p>
                                    El misterioso y letal juego Jumanji reaparece más de veinte años después. Es la época actual, y cuatro adolescentes se introducen en esta nueva aventura, ahora a partir de un videojuego que sirve como un portal a través del espacio-tiempo. Absorbidos por el mundo de Jumanji, un juego que no se puede abandonar hasta que acaba la partida, los jóvenes se enfrentarán a rinocerontes, mambas negras y una infinita variedad de trampas de la selva. En este juego, el tímido Spencer será un conquistador musculoso, el deportista Fridge será un diminuto Einstein, la chica de moda Bethany será un profesor sabelotodo, y la torpe Martha, una guerrera amazona. Juntos tendrán que 'jugar' para volver al planeta Tierra y seguir con sus vidas. ¿Cómo? Pensando distinto.
                                </p>
    
                            </div>
                        </div>

                      </div>
                      <div class="is-hidden-tablet has-text-centered">
                          <i class="fa fa-play-circle fa-3x" style="color: white" aria-hidden="true"></i>
                          <h1 class="title">
                            Jumanji
                            <span class="tag is-light">PE-7</span>
                          </h1>
                          <h2 class="subtitle">
                            Drama / Accion / Comedia 115min
                          </h2>
                      </div>
                  </div>
                </div>
              
                <!-- Hero footer: will stick at the bottom -->
                <div class="hero-foot sombra">
                    <div class="field is-grouped es-posicionado">
                        <p class="control">
                          <a class="button is-link">
                            Save changes
                          </a>
                        </p>
                        <p class="control">
                          <a class="button">
                            Comprar Entrada
                          </a>
                        </p>
                        <p class="control">
                            <div class="centeredIcon">
                                <div class="icon fas fa-lg fa-heart" style="color:Tomato"></div>
                              </div>  
                          </p>

                      </div>
                </div>
              </section>
              <!-- Hero -->
              <section class="section is-hidden-tablet">
                  <div class="container has-text-justified">
                    <h1 class="title">Sinopsis</h1>
                    <p>
                        El misterioso y letal juego Jumanji reaparece más de veinte años después. Es la época actual, y cuatro adolescentes se introducen en esta nueva aventura, ahora a partir de un videojuego que sirve como un portal a través del espacio-tiempo. Absorbidos por el mundo de Jumanji, un juego que no se puede abandonar hasta que acaba la partida, los jóvenes se enfrentarán a rinocerontes, mambas negras y una infinita variedad de trampas de la selva. En este juego, el tímido Spencer será un conquistador musculoso, el deportista Fridge será un diminuto Einstein, la chica de moda Bethany será un profesor sabelotodo, y la torpe Martha, una guerrera amazona. Juntos tendrán que 'jugar' para volver al planeta Tierra y seguir con sus vidas. ¿Cómo? Pensando distinto.
                    </p>
                  </div>
                </section>
                <!-- Sinopsis -->

                <div class="section">
                  <div class="container">
                    <div class="actores-list">
                      <div class="actor-item">
                        <img class="actor-foto" src="https://image.tmdb.org/t/p/w138_and_h175_face/9nhqKVGA09DLeZqsvWVoNeTRlRQ.jpg" alt="Imagen del actor." width="138px" height="175px">
                        <div class="actor-detalles">
                          <span class="actor-nombre">Viola Davis</span>
                          <span class="papel-nombre">Amanda Waller</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <section class="section">
                  <div class="container">
                    <article class="media">
                      <figure class="media-left">
                        <p class="image is-64x64">
                          <img src="https://bulma.io/images/placeholders/128x128.png">
                        </p>
                      </figure>
                      <div class="media-content">
                        <div class="field">
                          <p class="control">
                            <textarea class="textarea" placeholder="Add a comment..."></textarea>
                          </p>
                        </div>
                        <nav class="level">
                          <div class="level-left">
                            <div class="level-item">
                              <a class="button is-info">Submit</a>
                            </div>
                          </div>
                          <div class="level-right">
                            <div class="level-item">
                              <label class="checkbox">
                                <input type="checkbox"> Press enter to submit
                              </label>
                            </div>
                          </div>
                        </nav>
                      </div>
                    </article>
                    <!-- Escribir-reseña -->
                    <article class="media">
                      <figure class="media-left">
                        <p class="image is-64x64">
                          <img src="https://bulma.io/images/placeholders/128x128.png">
                        </p>
                      </figure>
                      <div class="media-content">
                        <div class="content">
                          <p>
                            <strong>John Smith</strong> <small>@johnsmith</small> <small>31m</small>
                            <br>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare magna eros, eu pellentesque tortor vestibulum ut. Maecenas non massa sem. Etiam finibus odio quis feugiat facilisis.
                          </p>
                        </div>
                        <nav class="level is-mobile">
                          <div class="level-left">
                            <a class="level-item">
                              <span class="icon is-small"><i class="fas fa-reply"></i></span>
                            </a>
                            <a class="level-item">
                              <span class="icon is-small"><i class="fas fa-retweet"></i></span>
                            </a>
                            <a class="level-item">
                              <span class="icon is-small"><i class="fas fa-heart"></i></span>
                            </a>
                          </div>
                        </nav>
                      </div>
                      <div class="media-right">
                        <button class="delete"></button>
                      </div>
                    </article>
                    <!-- Reseñas de otros -->
                  </div>
                </section>
                <!-- Reseñas -->
@stop