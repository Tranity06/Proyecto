<template>
    <div class="navbar-item" style="margin-right: 45px;">
        <img src="/uploads/productos/fanta.png" alt="" width="200px" height="200px">
        <div class="infoproducto">
            <span class="tituloproducto">Perrito Caliente</span>
            <div class="cantidad">
                <button>+</button>
                <span>2</span>
                <button>-</button>
            </div>
        </div>
        <span class="precioproducto">1.00€</span>
        <a class="delete"></a>
    </div>
</template>

<script>
    export default {
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