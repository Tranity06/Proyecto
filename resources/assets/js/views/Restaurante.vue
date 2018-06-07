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
                                    <img src="/icons/bebida.svg" alt="Bebidas">
                                    <span class="is-hidden-mobile">{{this.categorias[0].nombre}}</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <img src="/icons/patatas.svg" alt="Patatas">
                                    <span class="is-hidden-mobile">{{this.categorias[1].nombre}}</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <img src="/icons/popcorn.svg" alt="Comida">
                                    <span class="is-hidden-mobile">{{this.categorias[2].nombre}}</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <img src="/icons/chocolate.svg" alt="Chocolate">
                                    <span class="is-hidden-mobile">{{this.categorias[3].nombre}}</span>
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
                    <div class="tarjeta" v-for="producto in productos">
                        <div class="titulo is-size-5">
                            {{producto.nombre}}
                        </div>
                        <img :src="producto.imagen" alt="" width="200px" height="200px">
                        <div class="botones-debajo">
                            <div class="alergenos">
                              {{producto.precio}}€
                            </div>
                            <button class="button is-warning is-rounded is-small">Añadir</button>
                            <div class="select is-rounded is-small">
                                <select>
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "restaurante",
        data() {
            return {
                categorias: [],
                productos: [],
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        mounted(){
            axios.get('/api/categoria')
                .then(response => {
                    this.categorias = response.data;
                })
                .catch(error => {
                    console.log(error);
                });

            axios.get('/api/producto')
                .then(response => {
                    this.productos = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
        }
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