<template>
    <div class="tarjeta">
        <div class="titulo is-size-5">
            {{producto.nombre}}
        </div>
        <img :src="producto.imagen" alt="" width="200px" height="200px">
        <div class="botones-debajo">
            <div class="alergenos">
                {{producto.precio }}€
            </div>
            <button class="button is-warning is-rounded is-small" @click="addProductToCart(producto)">
                Añadir
            </button>
            <div class="select is-rounded is-small">
                <select v-model.number="cantidad">
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
</template>

<script>


    import store from '../store';

    export default {
        props: ['producto'],
        name: "ProductoComponent",
        data(){
            return {
                cantidad: 1,
            }
        },
        methods: {
            addProductToCart(producto) {
                const productoManipulado = {
                    producto: producto,
                    cantidad: this.cantidad
                };
                store.commit('addCartItem', productoManipulado);
                this.cantidad = 1;
            },
        }
    }
</script>

<style scoped>

    .tarjeta {
        display: flex;
        flex-direction: column;
        align-items: center;

        width: 250px;
        height: auto;
        margin: .5rem .5rem;

        box-shadow: 0 0 25px rgba(0, 0, 0, 0.08);
        background-color: #fff;
        border-radius: 8px;
        transition: box-shadow 0.5s;
    }

    .tarjeta:hover {
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.18);
        transition: box-shadow 0.5s;
    }

    .tarjeta > .titulo {
        color: grey;
        padding: .2rem;
    }

    .tarjeta > .imagen {
        width: 200px;
        height: 200px;
    }

    .tarjeta > .botones-debajo {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 1rem;
    }

    .botones-debajo > .comprar {

    }
</style>