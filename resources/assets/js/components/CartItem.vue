<template>
    <div class="navbar-item">
        <div class="parteuno">
            <img :src="item.producto.imagen" alt="" width="60px" height="40px">
            <div class="infoproducto">
                <span class="tituloproducto">{{ item.producto.nombre }}</span>
                <div class="cantidad">
                    <button @click="increment(item.producto.id)">+</button>
                    <span>{{item.cantidad}}</span>
                    <button @click="decrement(item.producto.id)">-</button>
                </div>
            </div>
        </div>
        <div>
            <span class="precioproducto">{{(item.producto.precio * item.cantidad).toFixed(2) }}€</span>
            <a class="delete" @click="eliminarItem(item)"></a>
        </div>
    </div>
</template>

<script>

    import store from '../store';

    export default {
        props: ['item'],
        name: "CartItem",
        methods: {
            increment(productoId){
                store.commit('incrementCantidad',productoId);
            },
            decrement(productoId){
                store.commit('decrementCantidad',productoId);
            },
            eliminarItem(productoId){
                store.commit('removeCartItem',productoId);
            }
        }
    }
</script>

<style scoped>

    .infoproducto{
        flex-direction: column;
        margin-right: 25px;
        min-width: 175px;
    }

    .precioproducto{
        margin-right: 15px;
    }

    .parteuno{
        display: flex;
    }

    .parteuno > img {
        margin-right: 5px;
    }

    .navbar-item img {
        max-height: 2.5rem;
    }
</style>