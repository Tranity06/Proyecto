<template>
    <div>
        <section class="hero is-dark">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">
                        Hero title
                    </h1>
                    <h2 class="subtitle">
                        Hero subtitle
                    </h2>
                </div>
            </div>
            <div class="hero-foot">
                <nav class="tabs is-boxed is-fullwidth">
                    <div class="container">
                        <ul>
                            <li class="is-active">
                                <a>
                                    <span class="icon is-small"><i class="fas fa-cog" aria-hidden="true"></i></span>
                                    <span class="is-hidden-mobile">CATEGORIA</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span class="icon is-small"><i class="fas fa-ticket-alt" aria-hidden="true"></i></span>
                                    <span class="is-hidden-mobile">CATEGORIA</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span class="icon is-small"><i class="far fa-comment" aria-hidden="true"></i></span>
                                    <span class="is-hidden-mobile">CATEGORIA</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span class="icon is-small"><i class="far fa-star" aria-hidden="true"></i></span>
                                    <span class="is-hidden-mobile">CATEGORIA</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </section>
        <div class="section">
            <div class="container">
                <div class="flexcontainer">
                    <div class="tarjeta">
                        <div class="titulo is-size-5">
                            Nombre
                        </div>
                        <div class="imagen">
                        </div>
                        <div class="botones-debajo">
                            <div class="alergenos">
                                iconos al..
                            </div>
                            <button class="button is-warning is-rounded is-small">Comprar</button>
                        </div>
                    </div>
                    <div class="tarjeta">
                        <div class="titulo is-size-5">
                            Nombre
                        </div>
                        <div class="imagen">
                        </div>
                        <div class="botones-debajo">
                            <div class="alergenos">
                                iconos al..
                            </div>
                            <button class="button is-warning is-rounded is-small">Comprar</button>
                        </div>
                    </div>
                    <div class="tarjeta">
                        <div class="titulo is-size-5">
                            Nombre
                        </div>
                        <div class="imagen">
                        </div>
                        <div class="botones-debajo">
                            <div class="alergenos">
                                iconos al..
                            </div>
                            <button class="button is-warning is-rounded is-small">Comprar</button>
                        </div>
                    </div>
                    <div class="tarjeta">
                        <div class="titulo is-size-5">
                            Nombre
                        </div>
                        <div class="imagen">
                        </div>
                        <div class="botones-debajo">
                            <div class="alergenos">
                                iconos al..
                            </div>
                            <button class="button is-warning is-rounded is-small">Comprar</button>
                        </div>
                    </div>
                    <div class="tarjeta">
                        <div class="titulo is-size-5">
                            Nombre
                        </div>
                        <div class="imagen">
                        </div>
                        <div class="botones-debajo">
                            <div class="alergenos">
                                iconos al..
                            </div>
                            <button class="button is-warning is-rounded is-small">Comprar</button>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "restaurante"
    }
</script>

<style scoped>


    .flexcontainer {
        display: flex;
        align-items: center;
        justify-content: center;
        /* You can set flex-wrap and
           flex-direction individually */
        flex-direction: row;
        flex-wrap: wrap;
        /* Or do it all in one line
          with flex flow */
        flex-flow: row wrap;
        /* tweak where items line
           up on the row
           valid values are: flex-start,
           flex-end, space-between,
           space-around, stretch */
        align-content: flex-end;
    }

    .tarjeta{
        display: flex;
        flex-direction: column;
        align-items: center;

        width: 250px;
        height: auto;
        margin: .5rem .5rem;

        box-shadow: 0 0 25px rgba(0,0,0,0.08);
        background-color: #fff;
        border-radius: 8px;
        transition: box-shadow 0.5s;
    }

    .tarjeta:hover {
        box-shadow: 0 0 25px rgba(0,0,0,0.18);
        transition: box-shadow 0.5s;
    }

    .tarjeta > .titulo{
        color: grey;
        padding: .2rem;
    }

    .tarjeta > .imagen{
        background: url("https://galicine.es/images/iconos-premios/Premio02.png");
        width: 200px;
        height: 200px;
    }

    .tarjeta > .botones-debajo{
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 1rem;
    }

    .botones-debajo > .comprar {

    }

</style>