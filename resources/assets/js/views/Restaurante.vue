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
                            <li  :class="{'is-active': this.tab===1}">
                                <a @click="selectTab(1)">
                                    <img src="/icons/bebida.svg" alt="Bebidas">
                                    <span class="is-hidden-mobile">{{this.categorias[0].nombre}}</span>
                                </a>
                            </li>
                            <li :class="{'is-active': this.tab===2}">
                                <a @click="selectTab(2)">
                                    <img src="/icons/patatas.svg" alt="Patatas">
                                    <span class="is-hidden-mobile">{{this.categorias[1].nombre}}</span>
                                </a>
                            </li>
                            <li :class="{'is-active': this.tab===3}">
                                <a @click="selectTab(3)">
                                    <img src="/icons/popcorn.svg" alt="Comida">
                                    <span class="is-hidden-mobile">{{this.categorias[2].nombre}}</span>
                                </a>
                            </li>
                            <li :class="{'is-active': this.tab===4}">
                                <a @click="selectTab(4)">
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
                <div class="flexcontainer" v-if="this.tab === 1">
                    <div class="tarjeta" v-for="producto in bebidas">
                        <div class="titulo is-size-5">
                            {{producto.nombre}}
                        </div>
                        <img :src="producto.imagen" alt="" width="200px" height="200px">
                        <div class="botones-debajo">
                            <div class="alergenos">
                              {{producto.precio }}€
                            </div>
                            <button class="button is-warning is-rounded is-small" @click="addProductToCart(producto)">Añadir</button>
                            <div class="select is-rounded is-small">
                                <select>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="flexcontainer" v-if="this.tab === 2">
                    <div class="tarjeta" v-for="producto in derivados">
                        <div class="titulo is-size-5">
                            {{producto.nombre}}
                        </div>
                        <img :src="producto.imagen" alt="" width="200px" height="200px">
                        <div class="botones-debajo">
                            <div class="alergenos">
                                {{producto.precio }}€
                            </div>
                            <button class="button is-warning is-rounded is-small" @click="addProductToCart(producto)">Añadir</button>
                            <div class="select is-rounded is-small">
                                <select>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="flexcontainer" v-if="this.tab === 4">
                    <div class="tarjeta" v-for="producto in comidaCaliente">
                        <div class="titulo is-size-5">
                            {{producto.nombre}}
                        </div>
                        <img :src="producto.imagen" alt="" width="200px" height="200px">
                        <div class="botones-debajo">
                            <div class="alergenos">
                                {{producto.precio }}€
                            </div>
                            <button class="button is-warning is-rounded is-small" @click="addProductToCart(producto)">Añadir</button>
                            <div class="select is-rounded is-small">
                                <select>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="flexcontainer" v-if="this.tab === 3">
                    <div class="tarjeta" v-for="producto in lacteos">
                        <div class="titulo is-size-5">
                            {{producto.nombre}}
                        </div>
                        <img :src="producto.imagen" alt="" width="200px" height="200px">
                        <div class="botones-debajo">
                            <div class="alergenos">
                                {{producto.precio }}€
                            </div>
                            <button class="button is-warning is-rounded is-small" @click="addProductToCart(producto)">Añadir</button>
                            <div class="select is-rounded is-small">
                                <select>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
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

    import store from '../store';

    const getProductos = (callback) => {

        axios
            .get('/api/producto/')
            .then(response => {
                callback(null, response.data);
            }).catch(error => {
            callback(error, error.response.data);
        });
    };

    export default {
        name: "restaurante",
        data() {
            return {
                categorias: [],
                productos: [],
                bebidas: [],
                derivados: [],
                comidaCaliente: [],
                lacteos: [],
                cantidad: 1,
                tab: 1,
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

/*            axios.get('/api/producto')
                .then(response => {
                    this.productos = response.data;
                })
                .catch(error => {
                    console.log(error);
                })*/
        },
        beforeRouteEnter (to, from, next) {
            getProductos((err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        methods: {
            setData(err, productos) {
                if (err) {
                    this.error = err.toString();
                } else {
                    this.bebidas = productos.filter(producto => producto.categoria_id === 1);
                    this.derivados = productos.filter(producto => producto.categoria_id === 2);
                    this.comidaCaliente = productos.filter(producto => producto.categoria_id === 3);
                    this.lacteos = productos.filter(producto => producto.categoria_id === 4);
                }
            },
            addProductToCart(producto){
                console.log(producto);
                store.commit('addCartItem',producto);
            },
            selectTab(selectedTab) {
                switch (selectedTab){
                    case 1:
                        this.tab = 1;
                        console.log(this.tab);
                        break;
                    case 2:
                        this.tab = 2;
                        console.log(this.tab);
                        break;
                    case 3:
                        this.tab = 3;
                        break;
                    case 4:
                        this.tab = 4;
                        break;
                }
            }
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