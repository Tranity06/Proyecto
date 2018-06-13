<template>
    <div class="navbar-item" style="margin-right: 45px;">
        <img :src="item.producto.imagen" alt="" width="200px" height="200px">
        <div class="infoproducto">
            <span class="tituloproducto">{{ item.producto.nombre }}</span>
            <div class="cantidad">
                <button>+</button>
                <span>{{item.cantidad}}</span>
                <button>-</button>
            </div>
        </div>
        <span class="precioproducto">{{ item.producto.precio * item.cantidad }}€</span>
        <a class="delete"></a>
    </div>
</template>

<script>
    export default {
        props: ['item'],
        name: "CartItem"
    }
</script>

<style scoped>

    .infoproducto{
        flex-direction: column;
        margin-right: 25px;
    }

    .precioproducto{
        margin-right: 15px;
    }

    .navbar-item img {
        max-height: 2.5rem;
    }
</style>