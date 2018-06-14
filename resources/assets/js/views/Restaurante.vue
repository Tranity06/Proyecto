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
                            <li :class="{'is-active': this.tab===1}">
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
                    <producto-component v-for="(producto,index) in bebidas" :key="index" :producto="producto"></producto-component>
                </div>
                <div class="flexcontainer" v-if="this.tab === 2">
                    <producto-component v-for="(producto,index) in derivados" :key="index" :producto="producto"></producto-component>
                </div>
                <div class="flexcontainer" v-if="this.tab === 4">
                    <producto-component v-for="(producto,index) in comidaCaliente" :key="index" :producto="producto"></producto-component>
                </div>
                <div class="flexcontainer" v-if="this.tab === 3">
                    <producto-component v-for="(producto,index) in lacteos" :key="index" :producto="producto"></producto-component>
                </div>

            </div>
        </div>
        <modal
                v-show="isModalActive"
                @close="closeModal"
        >
            <span slot="header">{{contentModal.titulo}}</span>
            <span slot="body">{{contentModal.cuerpo}}</span>
        </modal>
    </div>
</template>

<script>

    import store from '../store';
    import modal from '../components/modal'

    import ProductoComponent from "../components/ProductoComponent";

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
        components: {ProductoComponent,modal},
        data() {
            return {
                categorias: [],
                productos: [],
                bebidas: [],
                derivados: [],
                comidaCaliente: [],
                lacteos: [],
                tab: 1,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        mounted() {
            axios.get('/api/categoria')
                .then(response => {
                    this.categorias = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        beforeRouteEnter(to, from, next) {
            getProductos((err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        computed: {
          isModalActive(){
             return store.getters.modalActive;
          },
          contentModal(){
                return store.getters.contenidoModal;
            },
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
            selectTab(selectedTab) {
                switch (selectedTab) {
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
            },
            closeModal(){
                store.commit('closeModal');
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

</style>